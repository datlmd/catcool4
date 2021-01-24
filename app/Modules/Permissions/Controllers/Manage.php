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

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new PermissionModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('GeneralManage.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('PermissionsManage.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("PermissionsManage.heading_title")], $this->themes);

        $filter = [
            'active' => !empty($this->request->getGet(['filter_id','filter_name','filter_limit'])) ? true : false,
            'id'     => (string)$this->request->getGetPost('filter_id'),
            'name'   => (string)$this->request->getGetPost('filter_name'),
            'limit'  => (string)$this->request->getGetPost('filter_limit'),
        ];

        $list = $this->model->getAllByFilter($filter, $this->request->getGet('sort'), $this->request->getGet('order'));

        $url = '';
        if (!empty($this->request->getGet('filter_id'))) {
            $url .= '&filter_id=' . $this->request->getGet('filter_id');
        }

        if (!empty($this->request->getGet('filter_name'))) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->getGet('filter_name'), ENT_QUOTES, 'UTF-8'));
        }

        if (!empty($this->request->getGet('filter_limit'))) {
            $url .= '&filter_limit=' . $this->request->getGet('filter_limit');
        }

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => $list->paginate($this->request->getGetPost('filter_limit'), 'permissions'),
            'pager'      => $list->pager,
            'filter'     => $filter,
            'sort'       => empty($this->request->getGet('sort')) ? 'id' : $this->request->getGet('sort'),
            'order'      => ($this->request->getGet('order') == 'ASC') ? 'DESC' : 'ASC',
            'url'        => $url,
        ];

        set_last_url();

        $this->themes::load('list', $data);
    }

    public function add()
    {

        if (!empty($this->request->getPost()))
        {
            if (!$this->validate_form()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'name'        => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'published'   => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->insert($add_data)) {
                set_alert(lang('GeneralManage.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            set_alert(lang('GeneralManage.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $this->get_form();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('GeneralManage.error_empty'), ALERT_ERROR);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()))
        {
            if (!$this->validate_form()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            if (valid_token() === FALSE || $id != $this->request->getPost('id')) {
                set_alert(lang('GeneralManage.error_token'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'description' => $this->request->getPost('description'),
                'name'        => $this->request->getPost('name'),
                'published'   => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if ($this->model->update($id, $edit_data)) {
                set_alert(lang('GeneralManage.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            } else {
                set_alert(lang('GeneralManage.error'), ALERT_ERROR, ALERT_POPUP);
            }

            return redirect()->back();
        }

        $this->get_form($id);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids')))
        {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->find($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_empty')]);
            }
            $this->model->delete($ids);

            set_alert(lang('GeneralManage.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            json_output(['status' => 'redirect', 'url' => site_url(self::MANAGE_URL)]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->find($delete_ids);
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => $this->themes::view('delete', $data)]);
    }

    public function not_permission()
    {
        $this->data['title'] = $this->lang->line('not_permission_heading');

        $this->theme->layout('empty')->load('manage/not_permission', $this->data);
    }

    protected function get_form($id = null)
    {
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('PermissionsManage.text_edit');
            $data['text_submit'] = lang('GeneralManage.button_save');

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('GeneralManage.error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('PermissionsManage.text_add');
            $data['text_submit'] = lang('GeneralManage.button_add');
        }

        $data['text_cancel']   = lang('GeneralManage.text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes::load('form', $data);
    }

    protected function validate_form()
    {
        $this->validator->setRule('name', lang('PermissionsManage.text_name'), 'required|is_unique[permission.name]');

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        return $is_validation;
    }

    public function publish()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_json')]);
        }

        $id        = $this->request->getPost('id');
        $item_edit = $this->model->find($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->model->update($id, $item_edit)) {
            $data = ['status' => 'ng', 'msg' => lang('GeneralManage.error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('GeneralManage.text_published_success')];
        }

        json_output($data);
    }
}
