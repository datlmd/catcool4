<?php namespace App\Modules\Dummy\Controllers;

use App\Controllers\AdminController;
use App\Modules\Dummy\Models\DummyModel;

class Manage extends AdminController
{
    CONST MANAGE_ROOT = 'dummy/manage';
    CONST MANAGE_URL  = 'dummy/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new DummyModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('GeneralManage.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Dummy.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        $filter = [
            'id'    => (string)$this->request->getGetPost('filter_id'),
            'name'  => (string)$this->request->getGetPost('filter_name'),
            'limit' => (string)$this->request->getGetPost('filter_limit'),
        ];

        $list = $this->model->getAllByFilter($filter);

	    $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => $list->paginate($this->request->getGetPost('filter_limit'), 'dummy'),
            'pager'      => $list->pager,
            'filter'     => $filter,
        ];

        $this->themes::load('manage/list', $data);
	}

    public function add()
    {
        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            $add_data = [
                'sort_order' => $this->input->post('sort_order', true),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
                //ADD_DUMMY_ROOT
            ];
            $id = $this->Dummy->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $add_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['dummy_id']    = $id;
            }
            $this->Dummy_description->insert($add_data_description);

            set_alert(lang('text_add_success'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL);
        }

        $this->get_form();
    }

    public function edit($id = null)
    {


        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('dummy_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['dummy_id']    = $id;

                if (!empty($this->Dummy_description->get(['dummy_id' => $id, 'language_id' => $key]))) {
                    $this->Dummy_description->where('dummy_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Dummy_description->insert($edit_data_description[$key]);
                }
            }

            $edit_data = [
                'sort_order' => $this->input->post('sort_order', true),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'mtime'      => get_date(),
                //ADD_DUMMY_ROOT
            ];
            if ($this->Dummy->update($edit_data, $id) !== FALSE) {
                set_alert(lang('text_edit_success'), ALERT_SUCCESS);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }
            redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        $this->get_form($id);
    }

    protected function get_form($id = null)
    {
        $data['list_lang'] = get_list_lang();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Dummy->with_details()->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $data_form = format_data_lang_id($data_form);

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('text_add');
            $data['text_submit'] = lang('button_add');
        }

        $data['text_cancel']   = lang('text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        $this->theme->title($data['text_form']);
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        theme_load('manage/form', $data);
    }

    protected function validate_form()
    {
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), lang('text_name') . ' (' . $value['name']  . ')', 'trim|required');
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        return $is_validation;
    }

    public function delete($id = null)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
        }

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                json_output(['status' => 'ng', 'msg' => lang('error_token')]);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Dummy->get_list_full_detail($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }
            try {
                foreach($list_delete as $value){
                    $this->Dummy_description->delete($value['dummy_id']);
                    $this->Dummy->delete($value['dummy_id']);
                }
                set_alert(lang('text_delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }
            json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }
        if (empty($delete_ids)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->Dummy->get_list_full_detail($delete_ids);
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('manage/delete', $data, true)]);
    }

    public function publish()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Dummy->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Dummy->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }

	//--------------------------------------------------------------------

}
