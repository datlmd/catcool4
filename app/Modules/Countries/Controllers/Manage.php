<?php namespace App\Modules\Countries\Controllers;

use App\Controllers\AdminController;
use App\Modules\Countries\Models\CountryModel;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'countries/manage';
    CONST MANAGE_URL  = 'countries/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new CountryModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('CountryAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

    public function index()
    {
        $sort       = $this->request->getGet('sort');
        $order      = $this->request->getGet('order');
        $country_id = $this->request->getGet('country_id');
        $name       = $this->request->getGet('name');
        $limit      = $this->request->getGet('limit');

        $filter = [
            'active'     => count(array_filter($this->request->getGet(['country_id', 'name', 'limit']))) > 0,
            'country_id' => $country_id ?? "",
            'name'       => $name ?? "",
            'limit'      => $limit,
        ];

        $list = $this->model->getAllByFilter($filter, $sort, $order);

        $url = "";
        if (!empty($country_id)) {
            $url .= '&country_id=' . $country_id;
        }
        if (!empty($name)) {
            $url .= '&name=' . urlencode(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
        }
        if (!empty($limit)) {
            $url .= '&limit=' . $limit;
        }

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => $list->paginate($limit),
            'pager'      => $list->pager,
            'total'      => $list->pager->getPerPage(),
            'filter'     => $filter,
            'sort'       => $sort ?? 'country_id',
            'order'      => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'        => $url,
        ];

        add_meta(['title' => lang("CountryAdmin.heading_title")], $this->themes);
        $this->themes::load('list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'name'                  => $this->request->getPost('name'),
                'formal_name'           => $this->request->getPost('formal_name'),
                'country_code'          => $this->request->getPost('country_code'),
                'country_code3'         => $this->request->getPost('country_code3'),
                'country_type'          => $this->request->getPost('country_type'),
                'country_sub_type'      => $this->request->getPost('country_sub_type'),
                'sovereignty'           => $this->request->getPost('sovereignty'),
                'capital'               => $this->request->getPost('capital'),
                'currency_code'         => $this->request->getPost('currency_code'),
                'currency_name'         => $this->request->getPost('currency_name'),
                'telephone_code'        => $this->request->getPost('telephone_code'),
                'country_number'        => $this->request->getPost('country_number'),
                'internet_country_code' => $this->request->getPost('internet_country_code'),
                'sort_order'            => $this->request->getPost('sort_order'),
                'flags'                 => $this->request->getPost('flags'),
                'published'             => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
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

        $this->_getForm();
    }

    public function edit($id = null)
    {
        if (empty($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('country_id')) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'name'                  => $this->request->getPost('name'),
                'formal_name'           => $this->request->getPost('formal_name'),
                'country_code'          => $this->request->getPost('country_code'),
                'country_code3'         => $this->request->getPost('country_code3'),
                'country_type'          => $this->request->getPost('country_type'),
                'country_sub_type'      => $this->request->getPost('country_sub_type'),
                'sovereignty'           => $this->request->getPost('sovereignty'),
                'capital'               => $this->request->getPost('capital'),
                'currency_code'         => $this->request->getPost('currency_code'),
                'currency_name'         => $this->request->getPost('currency_name'),
                'telephone_code'        => $this->request->getPost('telephone_code'),
                'country_number'        => $this->request->getPost('country_number'),
                'internet_country_code' => $this->request->getPost('internet_country_code'),
                'sort_order'            => $this->request->getPost('sort_order'),
                'flags'                 => $this->request->getPost('flags'),
                'published'             => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
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

    private function _getForm($id = null)
    {
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('CountryAdmin.text_edit');
            $data['text_submit'] = lang('CountryAdmin.button_save');

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('CountryAdmin.text_add');
            $data['text_submit'] = lang('CountryAdmin.button_add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        $this->validator->setRule('name', lang('Admin.text_name'), 'required');

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

        $this->model->deleteCache();
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }
}
