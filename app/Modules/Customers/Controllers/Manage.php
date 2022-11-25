<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\AdminController;

use App\Modules\Customers\Models\GroupModel;
use App\Modules\Customers\Models\CustomerModel;

use App\Modules\Users\Models\AuthModel;

class Manage extends AdminController
{
    public $errors = [];

    CONST MANAGE_ROOT = 'customers/manage';
    CONST MANAGE_URL  = 'customers/manage';

    protected $group_model;
    protected $auth_model;

    const DOB_DEFAULT = '1900-01-01';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model       = new CustomerModel();
        $this->group_model = new GroupModel();
        $this->auth_model  = new AuthModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('CustomerAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $customer_id    = $this->request->getGet('customer_id');
        $name  = $this->request->getGet('name');
        $limit = $this->request->getGet('limit');
        $sort  = $this->request->getGet('sort');
        $order = $this->request->getGet('order');

        $filter = [
            'active' => count(array_filter($this->request->getGet(['customer_id', 'name', 'limit']))) > 0,
            'customer_id'     => $customer_id ?? "",
            'name'   => $name ?? "",
            'limit'  => $limit,
        ];

        $list = $this->model->getAllByFilter($filter, $sort, $order);

        $url = "";
        if (!empty($customer_id)) {
            $url .= '&customer_id=' . $customer_id;
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
            'filter'     => $filter,
            'sort'       => empty($sort) ? 'customer_id' : $sort,
            'order'      => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'        => $url,
        ];

        add_meta(['title' => lang("CustomerAdmin.heading_title")], $this->themes);

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
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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
            'username'   => strtolower($this->request->getPost('username')),
            'password'   => $this->auth_model->hashPassword($this->request->getPost('password')),
            'email'      => strtolower($this->request->getPost('email')),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'company'    => $this->request->getPost('company'),
            'phone'      => $this->request->getPost('phone'),
            'fax'        => $this->request->getPost('fax'),
            'group_id'   => $this->request->getPost('group_id'),
            'store_id'   => $this->request->getPost('store_id'),
            'dob'        => !empty($this->request->getPost('dob')) ? standar_date($this->request->getPost('dob')) : self::DOB_DEFAULT,
            'gender'     => $this->request->getPost('gender'),
            'newsletter' => !empty($this->request->getPost('newsletter')) ? STATUS_ON : STATUS_OFF,
            'status'     => !empty($this->request->getPost('status')) ? STATUS_ON : STATUS_OFF,
            'safe'       => !empty($this->request->getPost('safe')) ? STATUS_ON : STATUS_OFF,
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
            'ctime'      => get_date(),
        ];

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
        $this->themes->addCSS('common/plugin/multi-select/css/bootstrap-multiselect.min');


        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (get_lang(true) == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        $this->themes->addJS('common/js/dropzone/dropdrap');
        $this->themes->addJS('common/plugin/multi-select/js/bootstrap-multiselect.min');

        $data['list_lang'] = get_list_lang(true);

        $group_list     = $this->group_model->findAll();
        $data['groups'] = array_column($group_list, null, 'customer_group_id');

        //edit
        if (!empty($customer_id) && is_numeric($customer_id)) {
            $data['text_form'] = lang('CustomerAdmin.text_edit');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/edit/$customer_id");

            $data_form = $this->model->getUserInfo($customer_id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }
            
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('CustomerAdmin.text_add');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/add");
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
        $this->validator->setRule('email', lang('Admin.text_email'), 'required');

        if (empty($this->request->getPost('customer_id'))) {
            $this->validator->setRule('username', lang('Admin.text_username'), 'required|is_unique[user.username]');
            $this->validator->setRule('password', lang('Admin.text_password'), 'required|min_length[' . config_item('minPasswordLength') . ']|matches[password_confirm]');
            $this->validator->setRule('password_confirm', lang('Admin.text_confirm_password'), 'required');
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        if (!empty($this->request->getPost('email'))) {
            if (!empty($this->request->getPost('customer_id'))) {
                $email = $this->model->where(['email' => $this->request->getPost('email'), 'customer_id !=' => $this->request->getPost('customer_id')])->findAll();
            } else {
                $email = $this->model->where('email', $this->request->getPost('email'))->findAll();
            }
            if (!empty($email)) {
                $this->errors['email'] = lang('User.account_creation_duplicate_email');
            }
        }

        if (!empty($this->errors)) {
            return FALSE;
        }

        return $is_validation;
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        if (!$this->isSuperAdmin()) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_permission_super_admin')]);
        }

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {

            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->whereIn('customer_id', $ids)->findAll();
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    if ((!empty($value['super_admin']) && empty($this->isSuperAdmin())) || $value['customer_id'] == $this->getUserIdAdmin()) {
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

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->whereIn('customer_id', $delete_ids)->findAll();

        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $list_undelete = [];
        foreach ($list_delete as $key => $value) {
            if ((!empty($value['super_admin']) && empty($this->isSuperAdmin())) || $value['customer_id'] == $this->getUserIdAdmin()) {
                $list_undelete[] = $value;
                unset($list_delete[$key]);
            }
        }

        $data['list_delete']   = $list_delete;
        $data['list_undelete'] = $list_undelete;
        $data['ids']           = $delete_ids;

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
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

        $id = $this->request->getPost('customer_id');
        if ($id == $this->getUserIdAdmin()) {
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
            $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('User.activate_successful')];
        } else {
            $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('User.deactivate_successful')];
        }

        json_output($data);
    }
}
