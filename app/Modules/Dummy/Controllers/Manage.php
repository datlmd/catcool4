<?php namespace App\Modules\Dummy\Controllers;

use App\Controllers\AdminController;
use App\Modules\Dummy\Models\DummyModel;
use App\Modules\Dummy\Models\DummyLangModel;

class Manage extends AdminController
{
    protected $errors = [];

    protected $model_lang;

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
        $this->model_lang = new DummyLangModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('GeneralManage.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Dummy.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        add_meta(['name' => lang("Dummy.heading_title")], $this->themes);

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
                'sort_order' => $this->request->getPost('sort_order'),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
                //ADD_DUMMY_ROOT
            ];
            $id = $this->model->save($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $add_data_description = $this->request->getPost('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['dummy_id']    = $id;
            }
            $this->model_lang->save($add_data_description);

            set_alert(lang('text_add_success'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL);
        }

        $this->get_form();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            return redirect()->to(site_url(self::MANAGE_URL)); //with('error', $this->model->errors());
        }

        if (!empty($this->request->getPost()) && $this->validate_form()) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->request->getPost('dummy_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $edit_data_lang = $this->request->getPost('manager_lang');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_lang[$key]['language_id'] = $key;
                $edit_data_lang[$key]['dummy_id']    = $id;

                if (!empty($this->model_lang->where(['dummy_id' => $id, 'language_id' => $key])->find())) {
                    $this->model_lang->where('language_id='.$key)->update($id,$edit_data_lang[$key]);
                } else {
                    $this->model_lang->insert($edit_data_lang[$key]);
                }

                //$this->model_lang->save($edit_data_lang[$key]);
            }

            $edit_data = [
                'dummy_id'   => $id,
                'sort_order' => $this->request->getPost('sort_order'),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'mtime'      => get_date(),
                //ADD_DUMMY_ROOT
            ];
            if ($this->model->save($edit_data) !== FALSE) {
                set_alert(lang('text_edit_success'), ALERT_SUCCESS);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }

            return redirect()->back();//->with('success', 'Email sent');
            //redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        $this->get_form($id);
    }

    protected function get_form($id = null)
    {
        $data['list_lang'] = get_list_lang();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('GeneralManage.text_edit');
            $data['text_submit'] = lang('GeneralManage.button_save');

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('GeneralManage.text_add');
            $data['text_submit'] = lang('GeneralManage.button_add');
        }

        $data['text_cancel']   = lang('GeneralManage.text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        $data['errors'] = $this->errors;

        $this->themes->setPageTitle($data['text_form']);
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        $this->themes::load('manage/form', $data);
    }

    protected function validate_form()
    {
        //$this->validator->setRule('sort_order', lang('GeneralManage.sort_order'), 'is_natural');
        foreach(get_list_lang() as $key => $value) {
            //$this->validator->setRule(sprintf('manager_lang[%s][name]', $key), lang('GeneralManage.text_name') . ' (' . $value['name']  . ')', 'required');
        }

        $is_validation = $this->validator->run();
        $this->errors  = $this->validator->getErrors();

        return true;
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
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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
