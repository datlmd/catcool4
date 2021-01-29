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
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Dummy.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        add_meta(['title' => lang("Dummy.heading_title")], $this->themes);

        $filter_id    = $this->request->getGet('filter_id');
        $filter_name  = $this->request->getGet('filter_name');
        $filter_limit = $this->request->getGet('filter_limit');
        $sort         = $this->request->getGet('sort');
        $order        = $this->request->getGet('order');

        $filter = [
            'active' => count(array_filter(array_filter($this->request->getGet(['filter_id', 'filter_name', 'filter_limit'])))) > 0,
            'id'     => (string)$filter_id,
            'name'   => (string)$filter_name,
            'limit'  => (string)$filter_limit,
        ];

        $list = $this->model->getAllByFilter($filter, $sort, $this->request->getGet('order'));

	    $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => $list->paginate($filter_limit, 'dummy'),
            'pager'      => $list->pager,
            'filter'     => $filter,
            'sort'       => empty($sort) ? 'dummy_id' : $sort,
            'order'      => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'        => $this->getUrlFilter(),
        ];

        $this->themes::load('manage/list', $data);
	}

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'sort_order' => $this->request->getPost('sort_order'),
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
                //ADD_DUMMY_ROOT
            ];
            $id = $this->model->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('Admin.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data_lang = format_lang_form($this->request->getPost());
            foreach (get_list_lang() as $key => $value) {
                $add_data_lang[$key]['language_id'] = $key;
                $add_data_lang[$key]['dummy_id']    = $id;
                $this->model_lang->insert($add_data_lang[$key]);
            }

            set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $this->_getForm();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->request->getPost('dummy_id')) {
                set_alert(lang('Admin.error_token'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data_lang = format_lang_form($this->request->getPost());
            foreach (get_list_lang() as $key => $value) {
                $edit_data_lang[$key]['language_id'] = $key;
                $edit_data_lang[$key]['dummy_id']    = $id;

                if (!empty($this->model_lang->where(['dummy_id' => $id, 'language_id' => $key])->find())) {
                    $this->model_lang->where('language_id', $key)->update($id,$edit_data_lang[$key]);
                } else {
                    $this->model_lang->insert($edit_data_lang[$key]);
                }
            }

            $edit_data = [
                'dummy_id'   => $id,
                'sort_order' => $this->request->getPost('sort_order'),
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                //ADD_DUMMY_ROOT
            ];
            if ($this->model->save($edit_data) !== FALSE) {
                set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            } else {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            }

            return redirect()->back();
        }

        $this->_getForm($id);
    }

    private function _getForm($id = null)
    {
        $data['list_lang'] = get_list_lang();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('Admin.text_edit');
            $data['text_submit'] = lang('Admin.button_save');

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('Admin.text_add');
            $data['text_submit'] = lang('Admin.button_add');
        }

        $data['text_cancel']   = lang('Admin.text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes::load('manage/form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        foreach(get_list_lang() as $key => $value) {
            $this->validator->setRule(sprintf('lang_%s_name', $key), lang('Admin.text_name') . ' (' . $value['name']  . ')', 'required');
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        return $is_validation;
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->getListDetail($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model_lang->delete($ids);
            $this->model->delete($ids);

            set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            json_output(['status' => 'redirect', 'url' => site_url(self::MANAGE_URL)]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->getListDetail($delete_ids, get_lang_id());
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => $this->themes::view('manage/delete', $data)]);
    }

    public function publish()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($this->request->getPost())) {
            json_output(['status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $id        = $this->request->getPost('id');
        $item_edit = $this->model->find($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $item_edit['published'] = !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF;
        if (!$this->model->update($id, $item_edit)) {
            $data = ['status' => 'ng', 'msg' => lang('Admin.error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('Admin.text_published_success')];
        }

        json_output($data);
    }
}
