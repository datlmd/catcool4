<?php namespace App\Modules\Routes\Controllers;

use App\Controllers\AdminController;
use App\Modules\Routes\Models\RouteModel;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'routes/manage';
    CONST MANAGE_URL  = 'routes/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new RouteModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('RouteAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("RouteAdmin.heading_title")], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['route', 'module', 'resource', 'limit'];


        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'ctime' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
            'languages'     => get_list_lang(true),
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('list', $data);
    }

    public function write()
    {
        if ($this->model->writeFile()) {
            set_alert(lang('RouteAdmin.created_routes_success'), ALERT_SUCCESS, ALERT_POPUP);
        } else {
            set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
        }

        return redirect()->to(site_url(self::MANAGE_URL));
    }

    public function add()
    {
        if (!empty($this->request->getPost()))
        {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'module'      => $this->request->getPost('module'),
                'resource'    => $this->request->getPost('resource'),
                'language_id' => $this->request->getPost('language_id'),
                'route'       => $this->request->getPost('route'),
                'user_id'     => $this->getUserIdAdmin(),
                'published'   => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->insert($add_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        return $this->_getForm();
    }

    public function edit($route = null, $language_id = null)
    {
        if (is_null($route) || is_null($language_id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm($route, $language_id)) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'module'      => $this->request->getPost('module'),
                'resource'    => $this->request->getPost('resource'),
                'language_id' => $this->request->getPost('language_id'),
                'route'       => $this->request->getPost('route'),
                'user_id'     => $this->getUserIdAdmin(),
                'published'   => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->update(['route' => $this->request->getPost('route'), 'language_id' => $this->request->getPost('language_id')], $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            }

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        return $this->_getForm($route, $language_id);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        $data_delete = $this->request->getPost('data');

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('route'))) {
            $route = $this->request->getPost('route');
            $language_id = $this->request->getPost('language_id');

            $item_info = $this->model->where(['route' => $route, 'language_id' => $language_id])->first();
            if (empty($item_info)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }
            $this->model->where(['route' => $route, 'language_id' => $language_id])->delete();

            json_output(['token' => $token, 'status' => 'ok', 'ids' => ["$route" . "$language_id"], 'msg' => lang('Admin.text_delete_success')]);
        }

        if (empty($data_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $item_info = $this->model->where(['route' => $data_delete['route'], 'language_id' => $data_delete['language_id']])->first();
        if (empty($item_info)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['item_info'] = $item_info;
        $data['languages'] = format_dropdown(get_list_lang(true));

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    private function _getForm($route = null, $language_id = null)
    {
        //edit
        if (!empty($route) && !empty($language_id)) {
            $data['text_form'] = lang('RouteAdmin.text_edit');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/edit/$route/$language_id");

            $data_form = $this->model->where(['route' => $route, 'language_id' => $language_id])->first();
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('RouteAdmin.text_add');
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
            ::load('form', $data);
    }

    private function _validateForm($route = null, $language_id = null)
    {
        $this->validator->setRule('module', lang('RouteAdmin.text_module'), 'required');
        $this->validator->setRule('resource', lang('RouteAdmin.text_resource'), 'required');

        if (is_null($route) && is_null($language_id)) {
            $this->validator->setRule('route', lang('RouteAdmin.text_route'), 'required|is_unique[route.route]');
        } else {
            $this->validator->setRule('route', lang('RouteAdmin.text_route'), 'required|is_unique[route.route,language_id,' . $language_id . ']');
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

        if (empty($this->request->getPost('data'))) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $data = $this->request->getPost('data');

        $item_edit = $this->model->where(['route' => $data['route'], 'language_id' => $data['language_id']])->first();
        if (empty($item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $item_edit['published'] = !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF;

        if (!$this->model->where(['route' => $data['route'], 'language_id' => $data['language_id']])->save($item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')]);
    }
}
