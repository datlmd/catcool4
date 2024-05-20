<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\AdminController;
use App\Modules\Customers\Models\CustomerModel;
use App\Modules\Customers\Models\GroupModel;
use App\Modules\Users\Models\AuthModel;

class Manage extends AdminController
{
    public $errors = [];

    const MANAGE_ROOT = 'customers/manage';
    const MANAGE_URL = 'customers/manage';

    protected $group_model;
    protected $auth_model;

    const DOB_DEFAULT = '1970-01-01';
    const FOLDER_UPLOAD = 'customers/';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new CustomerModel();
        $this->group_model = new GroupModel();
        $this->auth_model = new AuthModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('CustomerAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $customer_id = $this->request->getGet('customer_id');
        $name = $this->request->getGet('name');
        $limit = $this->request->getGet('limit');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');

        $filter = [
            'active' => count(array_filter($this->request->getGet(['customer_id', 'name', 'limit']))) > 0,
            'customer_id' => $customer_id ?? '',
            'name' => $name ?? '',
            'limit' => $limit,
        ];

        $list = $this->model->getAllByFilter($filter, $sort, $order);

        $url = '';
        if (!empty($customer_id)) {
            $url .= '&customer_id='.$customer_id;
        }
        if (!empty($name)) {
            $url .= '&name='.urlencode(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
        }
        if (!empty($limit)) {
            $url .= '&limit='.$limit;
        }

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list' => $list->paginate($limit),
            'pager' => $list->pager,
            'filter' => $filter,
            'sort' => empty($sort) ? 'customer_id' : $sort,
            'order' => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url' => $url,
        ];

        add_meta(['title' => lang('CustomerAdmin.heading_title')], $this->themes);

        if ($this->request->isAJAX()) {
            return $this->themes::view('list', $data);
        }

        $this->themes::load('index', $data);
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
            page_not_found();
        }

        $json = [];

        if (!$this->_validateForm()) {
            $json['error'] = $this->errors;
        }

        $json['token'] = csrf_hash();

        if (!empty($json['error'])) {
            json_output($json);
        }

        $customer_id = $this->request->getPost('customer_id');
        $data_customer = [
            'username' => strtolower($this->request->getPost('username')),
            'email' => strtolower($this->request->getPost('email')),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'company' => $this->request->getPost('company'),
            'phone' => $this->request->getPost('phone'),
            'fax' => $this->request->getPost('fax'),
            'customer_group_id' => $this->request->getPost('customer_group_id'),
            'store_id' => $this->request->getPost('store_id'),
            'dob' => !empty($this->request->getPost('dob')) ? standar_date($this->request->getPost('dob')) : self::DOB_DEFAULT,
            'gender' => $this->request->getPost('gender'),
            'newsletter' => $this->request->getPost('newsletter'),
            'active' => !empty($this->request->getPost('active')) ? STATUS_ON : STATUS_OFF,
            'safe' => $this->request->getPost('safe'),
            //'custom_field',
            //'active' => !empty($this->request->getPost('active')) ? STATUS_ON : STATUS_OFF,
            //'address_id',
            //'image',
            //'salt',
            //'cart',
            //'wishlist',
            //'deleted',
            //'language_id',
            //'ip',
            //'created_at'      => get_date(),
        ];

        //avatar la hinh sau khi chon input file, avatar_root la hinh goc da luu
        $avatar = $this->request->getPost('image');
        if (!empty($avatar)) {
            // create folder
            if (!is_dir(get_upload_path().self::FOLDER_UPLOAD)) {
                mkdir(get_upload_path().self::FOLDER_UPLOAD, 0777, true);
            }

            $avatar_name = self::FOLDER_UPLOAD.$data_customer['username'].'.jpg'; //pathinfo($avatar, PATHINFO_EXTENSION);

            $width = !empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH;
            $height = !empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT;

            $image_tool = new \App\Libraries\ImageTool();
            $image_tool->thumbFit($avatar, $avatar_name, $width, $height);

            $data_customer['image'] = $avatar_name;
        } elseif (!empty($this->request->getPost('image_root'))) {
            $data_customer['image'] = $this->request->getPost('image_root');
        }

        if (!empty($this->request->getPost('password'))) {
            $data_customer['password'] = $this->auth_model->hashPassword($this->request->getPost('password'));
        }

        if (empty($customer_id)) {
            //Them moi
            $customer_id = $this->model->insert($data_customer);
            if (empty($customer_id)) {
                $json['error'] = lang('Admin.error');
            }
        } else {
            //cap nhat
            $data_customer['customer_id'] = $customer_id;
            if (!$this->model->save($data_customer)) {
                $json['error'] = lang('Admin.error');
            }
        }

        // address
        $address_model = model('App\Modules\Customers\Models\AddressModel');
        $address_model->where(['customer_id' => $customer_id])->delete();

        $address = $this->request->getPost('address');
        if (!empty($address)) {
            foreach ($address as $key => $value) {
                $value['customer_id'] = $customer_id;
                $value['default'] = ($this->request->getPost('address_default') == $key);
                $address_model->insert($value);
            }
        }

        if (!empty($json['error'])) {
            json_output($json);
        }

        $json['customer_id'] = $customer_id;

        $json['success'] = lang('Admin.text_add_success');
        if (!empty($this->request->getPost('customer_id'))) {
            $json['success'] = lang('Admin.text_edit_success');
        }

        json_output($json);
    }

    private function _getForm($customer_id = null)
    {
        $this->themes->addCSS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        $this->themes->addCSS('common/js/dropzone/dropdrap');

        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        $this->themes->addJS('common/js/dropzone/dropdrap');

        $this->themes->addJS('common/js/country/load');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $data['list_lang'] = list_language_admin();

        $group_list = $this->group_model->getCustomerGroups($this->language_id);
        $data['groups'] = array_column($group_list, null, 'customer_group_id');

        $country_model = model('App\Modules\Countries\Models\CountryModel');
        $province_model = model('App\Modules\Countries\Models\ProvinceModel');
        $district_model = model('App\Modules\Countries\Models\DistrictModel');
        $ward_model = model('App\Modules\Countries\Models\WardModel');

        $data['country_list'] = $country_model->getListDisplay();

        //edit
        if (!empty($customer_id) && is_numeric($customer_id)) {
            $data['text_form'] = lang('CustomerAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL."/edit/$customer_id");

            $data_form = $this->model->getUserInfo($customer_id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);

                return redirect()->to(site_url(self::MANAGE_URL));
            }

            //address
            $address_model = model('App\Modules\Customers\Models\AddressModel');
            $data_form['address_list'] = $address_model->getListByCustomerId($customer_id);
            foreach ($data_form['address_list'] as $key => $value) {
                $data_form['address_list'][$key]['province_list'] = $province_model->getListDisplay($value['country_id']);
                $data_form['address_list'][$key]['district_list'] = $district_model->getListDisplay($value['province_id']);
                $data_form['address_list'][$key]['ward_list'] = $ward_model->getListDisplay($value['district_id']);
            }

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('CustomerAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL.'/add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('first_name', lang('Admin.text_full_name'), 'required');
        $this->validator->setRule('dob', lang('Admin.text_dob'), sprintf('valid_date[%s]', get_date_format(true)));

        if (empty($this->request->getPost('customer_id'))) {
            $this->validator->setRule('username', lang('Admin.text_username'), 'required|is_unique[customer.username]');
            $this->validator->setRule('email', lang('CustomerAdmin.text_email'), 'required|valid_email|is_unique[customer.email]');
        } else {
            $this->validator->setRule('username', lang('Admin.text_username'), sprintf('required|is_unique[customer.username,customer_id,%d]', $this->request->getPost('customer_id')));
            $this->validator->setRule('email', lang('Admin.text_email'), sprintf('required|valid_email|is_unique[customer.email,customer_id,%d]', $this->request->getPost('customer_id')));
        }

        if (!empty($this->request->getPost('password'))) {
            $this->validator->setRule('password', lang('Admin.text_password'), 'required|min_length['.config_item('minPasswordLength').']|matches[password_confirm]');
            $this->validator->setRule('password_confirm', lang('Admin.text_confirm_password'), 'required');
        }

        if (!empty($this->request->getPost('address'))) {
            foreach ($this->request->getPost('address') as $key => $value) {
                $this->validator->setRule(sprintf('address.%s.firstname', $key), lang('Admin.text_first_name'), 'required');
                $this->validator->setRule(sprintf('address.%s.address_1', $key), lang('CustomerAdmin.text_address_1'), 'required');
                $this->validator->setRule(sprintf('address.%s.country_id', $key), lang('CustomerAdmin.text_country'), 'required|is_natural_no_zero');
                $this->validator->setRule(sprintf('address.%s.province_id', $key), lang('CustomerAdmin.text_province'), 'required|is_natural_no_zero');
                $this->validator->setRule(sprintf('address.%s.district_id', $key), lang('CustomerAdmin.text_district'), 'required|is_natural_no_zero');
                $this->validator->setRule(sprintf('address.%s.ward_id', $key), lang('CustomerAdmin.text_ward'), 'required|is_natural_no_zero');
            }
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors = $this->validator->getErrors();

//        if (!empty($this->request->getPost('email'))) {
//            if (!empty($this->request->getPost('customer_id'))) {
//                $email = $this->model->where(['email' => $this->request->getPost('email'), 'customer_id !=' => $this->request->getPost('customer_id')])->findAll();
//            } else {
//                $email = $this->model->where('email', $this->request->getPost('email'))->findAll();
//            }
//            if (!empty($email)) {
//                $this->errors['email'] = lang('CustomerAdmin.account_creation_duplicate_email');
//            }
//        }

        if (!empty($this->errors)) {
            return false;
        }

        return $is_validation;
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $token = csrf_hash();

        if (!$this->user->getSuperAdmin()) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_permission_super_admin')]);
        }

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(',', $ids);

            $list_delete = $this->model->whereIn('customer_id', $ids)->findAll();
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            try {
                foreach ($list_delete as $value) {
                    if ((!empty($value['super_admin']) && empty($this->user->getSuperAdmin())) || $value['customer_id'] == $this->user->getId()) {
                        continue;
                    }
                    $this->model->update($value['customer_id'], ['is_deleted' => STATUS_ON]);
                }

                set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR, ALERT_POPUP);
            }

            json_output(['status' => 'redirect', 'url' => site_url(self::MANAGE_URL)]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $delete_ids = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->whereIn('customer_id', $delete_ids)->findAll();

        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $list_undelete = [];
        foreach ($list_delete as $key => $value) {
            if ((!empty($value['super_admin']) && empty($this->user->getSuperAdmin())) || $value['customer_id'] == $this->user->getId()) {
                $list_undelete[] = $value;
                unset($list_delete[$key]);
            }
        }

        $data['list_delete'] = $list_delete;
        $data['list_undelete'] = $list_undelete;
        $data['ids'] = $delete_ids;

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    public function publish()
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $id = $this->request->getPost('customer_id');
        if ($id == $this->user->getId()) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('CustomerAdmin.error_permission_owner')]);
        }

        $item_edit = $this->model->getUserInfo($id);
        if (empty($item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $item_edit['active'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->model->update($id, $item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        if (!empty($_POST['published'])) {
            $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('CustomerAdmin.activate_successful')];
        } else {
            $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('CustomerAdmin.deactivate_successful')];
        }

        json_output($data);
    }
}
