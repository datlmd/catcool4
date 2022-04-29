<?php namespace App\Modules\Layouts\Controllers;

use App\Controllers\AdminController;
use App\Modules\Layouts\Models\LayoutModel;
use App\Modules\Layouts\Models\ActionModel;
use App\Modules\Layouts\Models\RouteModel;
use App\Modules\Layouts\Models\ModuleModel;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'layouts/manage';
    CONST MANAGE_URL  = 'layouts/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new LayoutModel();
        $this->route_model = new RouteModel();
        $this->module_model = new ModuleModel();
        $this->model_action = new ActionModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('LayoutAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang('LayoutAdmin.heading_title')], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['layout_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'layout_id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('/list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'name' => $this->request->getPost('name'),
            ];

            $id = $this->model->insert($add_data);
            if (!$id) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            $routes = $this->request->getPost('routes');
            if (!empty($routes)) {
                $data_routes = [];
                foreach ($routes as $route) {
                    $data_routes[] = [
                        'layout_id' => $id,
                        'route'     => $route,
                    ];
                }
                $this->route_model->ignore(true)->insertBatch($data_routes);
            }

            $modules = $this->request->getPost('modules');
            if (!empty($modules)) {
                $actions = $this->model_action->getList();

                $data_modules = [];
                foreach ($modules as $position => $value) {
                    $sort_order = count($value);
                    foreach ($value as $action_id) {
                        if (empty($actions[$action_id])) {
                            continue;
                        }
                        $data_modules[] = [
                            'layout_id'        => $id,
                            'layout_action_id' => $action_id,
                            'position'         => $position,
                            'sort_order'       => $sort_order,
                        ];
                        $sort_order--;
                    }
                }
                $this->module_model->ignore(true)->insertBatch($data_modules);
            }

            $this->model->deleteCache();

            set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        return $this->_getForm();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('layout_id')) {
            if (!$this->_validateForm($id)) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'name' => $this->request->getPost('name'),
            ];

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            }

            $this->route_model->where('layout_id', $id)->delete();
            $routes = $this->request->getPost('routes');
            if (!empty($routes)) {
                $data_routes = [];
                foreach ($routes as $route) {
                    $data_routes[] = [
                        'layout_id' => $id,
                        'route'     => $route,
                    ];
                }
                $this->route_model->ignore(true)->insertBatch($data_routes);
            }

            $this->module_model->where('layout_id', $id)->delete();
            $modules = $this->request->getPost('modules');
            if (!empty($modules)) {
                $actions = $this->model_action->getList();

                $data_modules = [];
                foreach ($modules as $position => $value) {
                    $sort_order = count($value);
                    foreach ($value as $action_id) {
                        if (empty($actions[$action_id])) {
                            continue;
                        }
                        $data_modules[] = [
                            'layout_id'        => $id,
                            'layout_action_id' => $action_id,
                            'position'         => $position,
                            'sort_order'       => $sort_order,
                        ];
                        $sort_order--;
                    }
                }
                $this->module_model->ignore(true)->insertBatch($data_modules);
            }

            $this->model->deleteCache();

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        return $this->_getForm($id);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->find($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }
            $this->model->delete($ids);

            $this->model->deleteCache();

            json_output(['token' => $token, 'status' => 'ok', 'ids' => $ids, 'msg' => lang('Admin.text_delete_success')]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->find($delete_ids);
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['token' => $token, 'data' => $this->themes::view('/delete', $data)]);
    }

    private function _getForm($id = null)
    {
        $data['actions'] = $this->model_action->getList();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('LayoutAdmin.text_edit');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->getInfo($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('LayoutAdmin.text_add');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/add");
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('/form', $data);
    }

    private function _validateForm($id = null)
    {
        $this->validator->setRule('name', lang('Admin.text_name'), 'required');

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        return $is_validation;
    }
}
