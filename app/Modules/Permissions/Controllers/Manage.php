<?php namespace App\Modules\Permissions\Controllers;

use App\Controllers\AdminController;
use App\Modules\Permissions\Models\PermissionModel;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'permissions/manage';
    CONST MANAGE_URL  = 'permissions/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new PermissionModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('PermissionAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("PermissionAdmin.heading_title")], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('list', $data);
    }

    public function add()
    {

        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'name'        => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'published'   => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->insert($add_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            //reset cache
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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('id')) {
            if (!$this->_validateForm($id)) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'description' => $this->request->getPost('description'),
                'name'        => $this->request->getPost('name'),
                'published'   => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            }

            //reset cache
            $this->model->deleteCache();

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        return $this->_getForm($id);
    }

    public function checkModule()
    {
        helper('filesystem');

        $module_methods = [];
        $module = $this->request->getPost('module');

        $except = [
            '__construct',
            'initController',
            'trackingLogAccess',
            'pageNotFound',
            'clearCacheAuto',
            'forceHTTPS',
            'cachePage',
            'loadHelpers',
            'validate',
            'isSuperAdmin',
            'getUserId',
        ];

        if (!empty($module)) {

            $module = ucfirst($module);

            if (!is_dir(APPPATH . 'Modules/' . $module)) {
                set_alert(lang("Admin.error_module"), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $permission_arr = $this->model->findAll();

            $permission_list = [];
            foreach ($permission_arr as $value) {
                $permission_list[$value['name']] = $value;
            }

            $controllers = get_filenames(APPPATH . 'Modules/' . $module . '/Controllers/');
            foreach ($controllers as $key => $value) {
                if( strpos( $value, '.php' ) === FALSE) {
                    unset($controllers[$key]);
                }

                foreach ($controllers as $controller) {

                    if (strpos(strtolower($controller), 'manage') === false) {
                        continue;
                    }

                    $controller = str_replace('.php', '', $controller);
                    $controller_tmp = "\\App\\Modules\\$module\\Controllers\\$controller";

                    $controller_tmp = new $controller_tmp();
                    $methods = get_class_methods($controller_tmp);

                    foreach ($methods as $method) {
                        if (in_array($method, $except)) {
                            continue;
                        }

                        $action_tmp = str_ireplace("manage", "", strtolower($controller));
                        if (!empty($action_tmp)) {
                            $action_tmp = implode("_", array_merge([$action_tmp], ['manage']));
                        } else {
                            $action_tmp = "manage";
                        }

                        preg_match('/[A-Z]/', $method, $match);
                        if (!empty($match[0])) {
                            $method = explode($match[0], $method);
                            $method = implode("_$match[0]", $method);
                        }

                        $method = sprintf("%s/%s/%s", strtolower($module), $action_tmp, strtolower($method));
                        $method = str_ireplace("/index", "", $method);
                        $module_methods[$controller][$method] = !empty($permission_list[$method]) ? $permission_list[$method] : null;
                    }
                }
            }
        }

        $module_model = new \App\Modules\Modules\Models\ModuleModel();
        $module_list  = $module_model->where('sub_module', "")->findAll();

        $this->breadcrumb->reset();
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('PermissionAdmin.heading_title'), base_url(self::MANAGE_URL));
        $this->breadcrumb->add("Check Module", base_url(self::MANAGE_URL));

        $data = [
            'module_list'    => $module_list,
            'manage_url'     => self::MANAGE_URL,
            'module'         => $module,
            'module_methods' => $module_methods,
            'breadcrumb'     => $this->breadcrumb->render(),
        ];

        add_meta(['title' => "Check Module"], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('check_module', $data);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids')))
        {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->find($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }
            $this->model->delete($ids);

            //reset cache
            $this->model->deleteCache();

            set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            json_output(['token' => $token, 'status' => 'redirect', 'url' => site_url(self::MANAGE_URL)]);
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

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    public function notPermission()
    {
        $this->data['title'] = $this->lang->line('not_permission_heading');

        $this->theme->layout('empty')->load('manage/not_permission', $this->data);
    }

    private function _getForm($id = null)
    {
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('PermissionAdmin.text_edit');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('PermissionAdmin.text_add');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/add");
        }

        if (empty($id) && empty($data['edit_data']) && !empty($this->request->getGet())) {
            $data['edit_data']['name'] = $this->request->getGet('name');
            $data['edit_data']['description'] = $this->request->getGet('description');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('form', $data);
    }

    private function _validateForm($id = null)
    {
        if (empty($id)) {
            $this->validator->setRule('name', lang('PermissionAdmin.text_name'), 'required|is_unique[permission.name]');
        } else {
            $this->validator->setRule('name', lang('PermissionAdmin.text_name'), 'required|is_unique[permission.name,id,' . $id . ']');
        }


        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        return $is_validation;
    }

    public function publish()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $id        = $this->request->getPost('id');
        $item_edit = $this->model->find($id);
        if (empty($item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $item_edit['published'] = !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF;
        if (!$this->model->update($id, $item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        //reset cache
        $this->model->deleteCache();

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')]);
    }

    public function notAllowed()
    {
        add_meta(['title' => lang("PermissionAdmin.heading_title")], $this->themes);

        $data = [
            'action' => $this->request->getGet('p'),
            'permission_text' => $this->model->getTextPermission($this->request->getGet('p'))
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('not_allowed', $data);
    }
}
