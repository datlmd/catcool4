<?php namespace App\Modules\Filters\Controllers;

use App\Controllers\AdminController;
use App\Modules\Filters\Models\FilterModel;
use App\Modules\Filters\Models\FilterLangModel;
use App\Modules\Filters\Models\FilterGroupModel;
use App\Modules\Filters\Models\FilterGroupLangModel;

class Manage extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    CONST MANAGE_ROOT = 'filters/manage';
    CONST MANAGE_URL  = 'filters/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new FilterGroupModel();
        $this->model_lang = new FilterGroupLangModel();
        $this->model_filter = new FilterModel();
        $this->model_filter_lang = new FilterLangModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('FilterAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        add_meta(['title' => lang('FilterAdmin.heading_title')], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['filter_group_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

	    $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'filter_group_id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        if ($this->request->isAJAX()) {
            return $this->themes::view('list', $data);
        }

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('filter', $data);
	}

    public function add()
    {
        return $this->_getForm();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        return $this->_getForm($id);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $json = [];

        if (!$this->_validateForm()) {
            $json['error'] = $this->errors;
        }

        if (empty($this->request->getPost('filters'))) {
            $json['error']['warning'] = lang('FilterAdmin.error_filter');
        }

        $json['token'] = csrf_hash();

        if (!empty($json['error'])) {
            json_output($json);
        }

        $data_filter['sort_order'] = $this->request->getPost('sort_order');

        $filter_group_id = $this->request->getPost('filter_group_id');
        if (empty($filter_group_id)) {
            //Them moi
            $filter_group_id = $this->model->insert($data_filter);
            if (empty($filter_group_id)) {
                $json['error'] = lang('Admin.error');
            }
        } else {
            //cap nhat
            $data_filter['filter_group_id'] = $filter_group_id;
            if (!$this->model->save($data_filter)) {
                $json['error'] = lang('Admin.error');
            }
        }

        if (!empty($json['error'])) {
            json_output($json);
        }

        if (!empty($this->request->getPost('filter_group_id'))) {
            $this->model_lang->where(['filter_group_id' => $filter_group_id])->delete();
        }

        $edit_data_lang = $this->request->getPost('lang');
        foreach (list_language_admin() as $language) {
            $edit_data_lang[$language['id']]['language_id'] = $language['id'];
            $edit_data_lang[$language['id']]['filter_group_id']   = $filter_group_id;

            $this->model_lang->insert($edit_data_lang[$language['id']]);
        }

        //filter
        if (!empty($this->request->getPost('filter_group_id'))) {
            $this->model_filter->where(['filter_group_id' => $filter_group_id])->delete();
        }

        if (!empty($this->request->getPost('filters'))) {
            $filters = $this->request->getPost('filters');
            foreach ($filters as $value) {

                $data_filter_value = [
                    'filter_group_id' => $filter_group_id,
                    'sort_order' => $value['sort_order'],
                ];

                if (!empty($value['filter_id'])) {
                    $data_filter_value['filter_id'] = $value['filter_id'];
                }

                $filter_id = $this->model_filter->insert($data_filter_value);

                $data_filter_value_lang = $value['lang'];
                foreach (list_language_admin() as $language) {
                    $data_filter_value_lang[$language['id']]['language_id']     = $language['id'];
                    $data_filter_value_lang[$language['id']]['filter_id']       = $filter_id;
                    $data_filter_value_lang[$language['id']]['filter_group_id'] = $filter_group_id;

                    $this->model_filter_lang->insert($data_filter_value_lang[$language['id']]);
                }
            }
        }

        $json['filter_group_id'] = $filter_group_id;

        $json['success'] = lang('Admin.text_add_success');
        if (!empty($this->request->getPost('filter_group_id'))) {
            $json['success'] = lang('Admin.text_edit_success');
        }

        $this->model_filter->deleteCache();

        json_output($json);
    }

    private function _getForm($id = null)
    {
        $data['language_list'] = list_language_admin();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('Admin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data_form['filters'] = $this->model_filter->getListByFilterGroupId($id);

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('Admin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/add");
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        foreach(list_language_admin() as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('FilterAdmin.text_filter_group_name') . ' (' . $value['name']  . ')', 'required');
        }

        if (!empty($this->request->getPost('filters'))) {
            foreach ($this->request->getPost('filters') as $key => $value) {
                $this->validator->setRule(sprintf('filters.%s.sort_order', $key), lang('Admin.text_sort_order'), 'is_natural');

                if (empty($value['lang'])) {
                    continue;
                }
                foreach(list_language_admin() as $lang_value) {
                    $this->validator->setRule(sprintf('filters.%s.lang.%s.name', $key, $lang_value['id']), lang('FilterAdmin.text_filter_name') . ' (' . $lang_value['name']  . ')', 'required');
                }

            }
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

        $token = csrf_hash();

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->getListDetail($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids);
            $this->model_filter->whereIn('filter_group_id', $ids)->delete();

            $this->model_filter->deleteCache();

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
        $list_delete = $this->model->getListDetail($delete_ids, get_lang_id(true));
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $this->request->getPost('delete_ids');

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }
}
