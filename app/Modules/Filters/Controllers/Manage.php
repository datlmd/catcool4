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

    CONST MANAGE_ROOT = 'options/manage';
    CONST MANAGE_URL  = 'options/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new OptionModel();
        $this->model_lang = new OptionLangModel();
        $this->model_value = new OptionValueModel();
        $this->model_value_lang = new OptionValueLangModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('OptionAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        add_meta(['title' => lang('OptionAdmin.heading_title')], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['option_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

	    $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'option_id' : $sort,
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
            ::load('option', $data);
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

        $type = $this->request->getPost('type');
        if (($type == 'select' || $type == 'radio' || $type == 'checkbox') && empty($this->request->getPost('option_value'))) {
            $json['error']['warning'] = lang('OptionAdmin.error_type');
        }

        //@todo check product co su dung option_id & option_value_id khong

        $json['token'] = csrf_hash();

        if (!empty($json['error'])) {
            json_output($json);
        }

        $option_id   = $this->request->getPost('option_id');
        $data_option = [
            'type'       => $this->request->getPost('type'),
            'sort_order' => $this->request->getPost('sort_order'),

        ];

        if (empty($option_id)) {
            //Them moi
            $option_id = $this->model->insert($data_option);
            if (empty($option_id)) {
                $json['error'] = lang('Admin.error');
            }
        } else {
            //cap nhat
            $data_option['option_id'] = $option_id;
            if (!$this->model->save($data_option)) {
                $json['error'] = lang('Admin.error');
            }
        }

        if (!empty($json['error'])) {
            json_output($json);
        }

        if (!empty($this->request->getPost('option_id'))) {
            $this->model_lang->where(['option_id' => $option_id])->delete();
        }

        $edit_data_lang = $this->request->getPost('lang');
        foreach (get_list_lang(true) as $language) {
            $edit_data_lang[$language['id']]['language_id'] = $language['id'];
            $edit_data_lang[$language['id']]['option_id']   = $option_id;

            $this->model_lang->insert($edit_data_lang[$language['id']]);
        }

        //option value
        if (!empty($this->request->getPost('option_id'))) {
            $this->model_value->where(['option_id' => $option_id])->delete();
        }

        if (($type == 'select' || $type == 'radio' || $type == 'checkbox') && !empty($this->request->getPost('option_value'))) {
            $option_value = $this->request->getPost('option_value');
            foreach ($option_value as $value) {

                $data_option_value = [
                    'option_id'  => $option_id,
                    'image'      => $value['image'],
                    'sort_order' => $value['sort_order'],
                ];

                if (!empty($value['option_value_id'])) {
                    $data_option_value['option_value_id'] = $value['option_value_id'];
                }

                $option_value_id = $this->model_value->insert($data_option_value);

                $data_option_value_lang = $value['lang'];
                foreach (get_list_lang(true) as $language) {
                    $data_option_value_lang[$language['id']]['language_id']     = $language['id'];
                    $data_option_value_lang[$language['id']]['option_value_id'] = $option_value_id;
                    $data_option_value_lang[$language['id']]['option_id']       = $option_id;

                    $this->model_value_lang->insert($data_option_value_lang[$language['id']]);
                }
            }
        }

        $json['option_id'] = $option_id;

        $json['success'] = lang('Admin.text_add_success');
        if (!empty($this->request->getPost('option_id'))) {
            $json['success'] = lang('Admin.text_edit_success');
        }

        json_output($json);
    }

    private function _getForm($id = null)
    {
        $data['language_list'] = get_list_lang(true);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('Admin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data_form['option_value'] = $this->model_value->getListByOptionId($id);

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
        foreach(get_list_lang(true) as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('OptionAdmin.text_option_name') . ' (' . $value['name']  . ')', 'required');
        }

        if (!empty($this->request->getPost('option_value'))) {
            foreach ($this->request->getPost('option_value') as $key => $value) {
                $this->validator->setRule(sprintf('option_value.%s.sort_order', $key), lang('Admin.text_sort_order'), 'is_natural');

                if (empty($value['lang'])) {
                    continue;
                }
                foreach(get_list_lang(true) as $lang_value) {
                    $this->validator->setRule(sprintf('option_value.%s.lang.%s.name', $key, $lang_value['id']), lang('OptionAdmin.text_option_value_name') . ' (' . $lang_value['name']  . ')', 'required');
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

            //@todo check product co su dung option_id & option_value_id khong

            $this->model->delete($ids);
            $this->model_value->whereIn('option_id', $ids)->delete();

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
        $data['ids']         = $delete_ids;

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }
}
