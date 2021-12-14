<?php namespace App\Modules\Products\Controllers;

use App\Controllers\AdminController;
use App\Modules\Products\Models\WeightClassModel;
use App\Modules\Products\Models\WeightClassLangModel;

class WeightClassesManage extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    CONST MANAGE_ROOT = 'products/weight_classes_manage';
    CONST MANAGE_URL  = 'products/weight_classes_manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new WeightClassModel();
        $this->model_lang = new WeightClassLangModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
    }

	public function index()
	{
        add_meta(['title' => lang('ProductWeightClassAdmin.heading_title')], $this->themes);

        $weight_class_id = $this->request->getGet('weight_class_id');
        $name     = $this->request->getGet('name');
        $limit    = $this->request->getGet('limit');
        $sort     = $this->request->getGet('sort');
        $order    = $this->request->getGet('order');

        $filter = [
            'active'   => count(array_filter($this->request->getGet(['weight_class_id', 'name', 'limit']))) > 0,
            'weight_class_id' => $weight_class_id ?? "",
            'name'     => $name ?? "",
            'limit'    => $limit,
        ];

        $list = $this->model->getAllByFilter($filter, $sort, $this->request->getGet('order'));

        $url = "";
        if (!empty($weight_class_id)) {
            $url .= '&weight_class_id=' . $weight_class_id;
        }
        if (!empty($name)) {
            $url .= '&name=' . urlencode(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
        }
        if (!empty($limit)) {
            $url .= '&limit=' . $limit;
        }

        $this->breadcrumb->add(lang('ProductAdmin.heading_title'), site_url('products/manage'));
        $this->breadcrumb->add(lang('ProductWeightClassAdmin.heading_title'), site_url(self::MANAGE_URL));

	    $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => $list->paginate($limit),
            'pager'      => $list->pager,
            'filter'     => $filter,
            'sort'       => empty($sort) ? 'weight_class_id' : $sort,
            'order'      => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'        => $url,
        ];

        $this->themes::load('weight_classes/list', $data);
	}

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'value' => $this->request->getPost('value'),
            ];
            $id = $this->model->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('Admin.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data_lang = $this->request->getPost('lang');
            foreach (get_list_lang(true) as $language) {
                $add_data_lang[$language['id']]['language_id']     = $language['id'];
                $add_data_lang[$language['id']]['weight_class_id'] = $id;
                $this->model_lang->insert($add_data_lang[$language['id']]);
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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('weight_class_id')) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data_lang = $this->request->getPost('lang');
            foreach (get_list_lang(true) as $language) {
                $edit_data_lang[$language['id']]['language_id']     = $language['id'];
                $edit_data_lang[$language['id']]['weight_class_id'] = $id;

                if (!empty($this->model_lang->where(['weight_class_id' => $id, 'language_id' => $language['id']])->find())) {
                    $this->model_lang->where('language_id', $language['id'])->update($id,$edit_data_lang[$language['id']]);
                } else {
                    $this->model_lang->insert($edit_data_lang[$language['id']]);
                }
            }

            $edit_data = [
                'weight_class_id' => $id,
                'value'           => $this->request->getPost('value'),
            ];

            if (!$this->model->save($edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back();
            }

            $this->model->deleteCache();

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);

            return redirect()->back();
        }

        return $this->_getForm($id);
    }

    private function _getForm($id = null)
    {
        $data['language_list'] = get_list_lang(true);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('Admin.text_edit');

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('Admin.text_add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add(lang('ProductWeightClassAdmin.heading_title'), site_url(self::MANAGE_URL));
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes::load('weight_classes/form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('value', lang('ProductWeightClassAdmin.text_value'), 'required|numeric');
        foreach(get_list_lang(true) as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('Admin.text_name') . ' (' . $value['name']  . ')', 'required');
            $this->validator->setRule(sprintf('lang.%s.unit', $value['id']), lang('ProductWeightClassAdmin.text_unit') . ' (' . $value['name']  . ')', 'required');
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
        $list_delete = $this->model->getListDetail($delete_ids, get_lang_id(true));
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['token' => $token, 'data' => $this->themes::view('weight_classes/delete', $data)]);
    }
}
