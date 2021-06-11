<?php namespace App\Modules\UsersAdmin\Controllers;

use App\Controllers\AdminController;
use App\Modules\Permissions\Models\PermissionModel;
use App\Modules\Users\Models\AuthModel;
use App\Modules\UsersAdmin\Models\GroupModel;
use App\Modules\UsersAdmin\Models\UserGroupModel;
use App\Modules\UsersAdmin\Models\UserModel;
use App\Modules\UsersAdmin\Models\UserPermissionModel;
use App\Modules\UsersAdmin\Models\UserTokenModel;

class Manage extends AdminController
{
    public $errors = [];

    CONST MANAGE_ROOT = 'users_admin/manage';
    CONST MANAGE_URL  = 'users_admin/manage';

    protected $group_model;
    protected $user_group_model;
    protected $permission_model;
    protected $user_permission_model;
    protected $auth_model;

    const DOB_DEFAULT = '1900-01-01';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model                 = new UserModel();
        $this->group_model           = new GroupModel();
        $this->user_group_model      = new UserGroupModel();
        $this->permission_model      = new PermissionModel();
        $this->user_permission_model = new UserPermissionModel();
        $this->auth_model            = new AuthModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('UserAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $id    = $this->request->getGet('id');
        $name  = $this->request->getGet('name');
        $limit = $this->request->getGet('limit');
        $sort  = $this->request->getGet('sort');
        $order = $this->request->getGet('order');

        $filter = [
            'active' => count(array_filter($this->request->getGet(['id', 'name', 'limit']))) > 0,
            'id'     => $id ?? "",
            'name'   => $name ?? "",
            'limit'  => $limit,
        ];

        $list = $this->model->getAllByFilter($filter, $sort, $order);

        $url = "";
        if (!empty($id)) {
            $url .= '&id=' . $id;
        }
        if (!empty($name)) {
            $url .= '&name=' . urlencode(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
        }
        if (!empty($limit)) {
            $url .= '&limit=' . $limit;
        }

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => $list->paginate($limit, 'users'),
            'pager'      => $list->pager,
            'filter'     => $filter,
            'sort'       => empty($sort) ? 'id' : $sort,
            'order'      => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'        => $url,
        ];

        add_meta(['title' => lang("UserAdmin.heading_title")], $this->themes);
        $this->themes::load('list', $data);
    }

    public function add()
    {
        if (!$this->isSuperAdmin()) {
            set_alert(lang('Admin.error_permission_super_admin'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }
            
            $dob = $this->request->getPost('dob');
            if (!empty($dob)) {
                $dob = standar_date($dob);
            } else {
                $dob = self::DOB_DEFAULT;
            }

            $username = strtolower($this->request->getPost('username'));

            //avatar la hinh sau khi chon input file, avatar_root la hinh goc da luu
            $avatar = $this->request->getPost('avatar');
            if (!empty($avatar)) {
                $avatar_name = 'users/' . $username . '_ad.jpg'; //pathinfo($avatar, PATHINFO_EXTENSION);
                $avatar      = move_file_tmp($avatar, $avatar_name);
            }

            $add_data = [
                'username'   => $username,
                'email'      => strtolower($this->request->getPost('email')),
                'password'   => $this->auth_model->hashPassword($this->request->getPost('password')),
                'first_name' => $this->request->getPost('first_name'),
                'company'    => $this->request->getPost('company'),
                'phone'      => $this->request->getPost('phone'),
                'address'    => $this->request->getPost('address'),
                'dob'        => $dob,
                'gender'     => $this->request->getPost('gender'),
                'image'      => $avatar,
                'active'     => !empty($this->request->getPost('active')) ? STATUS_ON : STATUS_OFF,
                'user_ip'    => $this->request->getIPAddress(),
                'ctime'      => get_date(),
            ];

            if ($this->isSuperAdmin()) {
                $add_data['super_admin'] = !empty($this->request->getPost('super_admin')) ? STATUS_ON : STATUS_OFF;
            }

            $id = $this->model->insert($add_data);
            if (empty($id)) {
                set_alert(lang('error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $group_ids = $this->request->getPost('groups');
            if (!empty($group_ids)) {
                $list_group = $this->group_model->find($group_ids);
                if (!empty($list_group)) {
                    foreach ($list_group as $group) {
                        $this->user_group_model->insert(['user_id' => $id, 'group_id' => $group['id']]);
                    }
                }
            }

            $permission_ids = $this->request->getPost('permissions');
            if (!empty($permission_ids)) {
                $list_permission = $this->permission_model->where(['published', STATUS_ON])->find($permission_ids);
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->user_permission_model->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }

            set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $this->_getForm();
    }

    private function _getForm($id = null)
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

        $group_list      = $this->group_model->findAll();
        $permission_list = $this->permission_model->getListPublished();
        $permission_list = $this->permission_model->formatListPublished($permission_list);


        $data['groups']      = array_column($group_list, null, 'id');
        $data['permissions'] = $permission_list;

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('UserAdmin.text_edit');

            $data_form = $this->model->getUserInfo($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data['user_groups']      = $this->user_group_model->where('user_id', $id)->findAll();
            $data['user_permissions'] = $this->user_permission_model->where('user_id', $id)->findAll();
            
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('UserAdmin.text_add');
        }

        $data['errors'] = $this->errors;
        $data['is_super_admin'] = $this->isSuperAdmin();

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes::load('form', $data);
    }

    private function _validateForm($id = null)
    {
        $this->validator->setRule('first_name', lang('Admin.text_full_name'), 'required');
        $this->validator->setRule('email', lang('Admin.text_email'), 'required');

        if (empty($id)) {
            $this->validator->setRule('username', lang('Admin.text_username'), 'required|is_unique[user.username]');
            $this->validator->setRule('password', lang('Admin.text_password'), 'required|min_length[' . config_item('minPasswordLength') . ']|matches[password_confirm]');
            $this->validator->setRule('password_confirm', lang('Admin.text_confirm_password'), 'required');
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        if (!empty($this->request->getPost('avatar'))) {
            old('avatar', $this->request->getPost('avatar'));
        }

        if (!empty($this->request->getPost('email'))) {
            if (!empty($this->request->getPost('id'))) {
                $email = $this->model->where(['email' => $this->request->getPost('email'), 'id !=' => $this->request->getPost('id')])->findAll();
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

    public function edit($id = null)
    {
        if (!$this->isSuperAdmin()) {
            set_alert(lang('Admin.error_permission_super_admin'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('id')) {
            if (!$this->_validateForm($id)) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $item_edit = $this->model->getUserInfo($id);
            if (empty($item_edit)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $dob = $this->request->getPost('dob');
            if (!empty($dob)) {
                $dob = standar_date($dob);
            } else {
                $dob = self::DOB_DEFAULT;
            }

            //avatar la hinh sau khi chon input file, avatar_root la hinh goc da luu
            $avatar = $this->request->getPost('avatar');
            if (!empty($avatar)) {
                $avatar_name = 'users/' . $item_edit['username'] . '_ad.jpg';
                $avatar      = move_file_tmp($avatar, $avatar_name);
            } else {
                $avatar = $this->request->getPost('avatar_root');
            }

            $edit_data = [
                'email'      => strtolower($this->request->getPost('email')),
                'first_name' => $this->request->getPost('first_name'),
                'company'    => $this->request->getPost('company'),
                'phone'      => $this->request->getPost('phone'),
                'address'    => $this->request->getPost('address'),
                'dob'        => $dob,
                'gender'     => $this->request->getPost('gender'),
                'image'      => $avatar,
                'user_ip'    => $this->request->getIPAddress(),
                'mtime'      => get_date(),
            ];

            if ($id != $this->getUserId()) {
                $edit_data['active'] = !empty($this->request->getPost('active')) ? STATUS_ON : STATUS_OFF;
            }
            if ($this->isSuperAdmin()) {
                $edit_data['super_admin'] = !empty($this->request->getPost('super_admin')) ? STATUS_ON : STATUS_OFF;
            }

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $this->user_group_model->delete(['user_id' => $id]);

            $group_ids = $this->request->getPost('groups');
            if (!empty($group_ids)) {
                $list_group = $this->group_model->find($group_ids);
                if (!empty($list_group)) {
                    foreach ($list_group as $group) {
                        $this->user_group_model->insert(['user_id' => $id, 'group_id' => $group['id']]);
                    }
                }
            }

            $this->user_permission_model->delete(['user_id' => $id]);

            $permission_ids = $this->request->getPost('permissions');
            if (!empty($permission_ids)) {
                $list_permission = $this->permission_model->whereIn('id', $permission_ids)->where(['published' => STATUS_ON])->findAll();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->user_permission_model->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }

                //reset cache
                $this->user_permission_model->deleteCache($id);
            }

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        $this->_getForm($id);
    }

    public function changePassword($id = null)
    {
        if (empty($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $data_form = $this->model->getUserInfo($id);
        if (empty($data_form)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $this->validator->setRules([
            'id' => ['label' => lang('Admin.text_username'), 'rules' => 'required'],
            'password_old' => ['label' => lang('UserAdmin.text_password_old'), 'rules' => 'required'],
            'password_new' => ['label' => lang('UserAdmin.text_password_new'), 'rules' => 'required|min_length[' . config_item('minPasswordLength') . ']|matches[password_confirm_new]'],
            'password_confirm_new' => ['label' => lang('UserAdmin.text_confirm_password_new'), 'rules' => 'required'],
        ]);

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('id') && $this->validator->withRequest($this->request)->run()) {

            if ($this->auth_model->checkPassword($this->request->getPost('password_old'), $data_form['password']) === FALSE) {
                set_alert(lang('UserAdmin.error_password_old'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'password' => $this->auth_model->hashPassword($this->request->getPost('password_new')),
                'mtime'    => get_date(),
            ];
            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('UserAdmin.error_password_change_unsuccessful'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            set_alert(lang('UserAdmin.password_change_successful'), ALERT_SUCCESS);
            return redirect()->back();
        }

        if (!empty($this->validator->getErrors())) {
            $data['errors'] = $this->validator->getErrors();
        }

        $data['edit_data'] = $data_form;

        $this->breadcrumb->add(lang('UserAdmin.text_change_password'), base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => lang('UserAdmin.text_change_password')], $this->themes);

        $this->themes::load('change_password', $data);
    }

    public function permission($id = null)
    {
        if (empty($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $item_edit = $this->model->getUserInfo($id);
        if (empty($item_edit)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!$this->isSuperAdmin()) {
            set_alert(lang('Admin.error_permission_super_admin'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('id')) {
            $this->user_permission_model->delete(['user_id' => $id]);

            $permission_ids = $this->request->getPost('permissions');
            if (!empty($permission_ids)) {
                $list_permission = $this->permission_model->whereIn('id', $permission_ids)->where(['published' => STATUS_ON])->findAll();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->user_permission_model->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }

                //reset cache
                $this->user_permission_model->deleteCache($id);
            }

            set_alert(lang('UserAdmin.update_permission_successful'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        $permission_list = $this->permission_model->getListPublished();
        $permission_list = $this->permission_model->formatListPublished($permission_list);

        $data['item_edit']        = $item_edit;
        $data['permissions']      = $permission_list;
        $data['user_permissions'] = $this->user_permission_model->where('user_id', $id)->findAll();

        $this->breadcrumb->add(lang('UserAdmin.text_permission_select'), base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => lang('UserAdmin.text_permission_select')], $this->themes);

        $this->themes::load('permission', $data);
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

            $list_delete = $this->model->whereIn('id', $ids)->findAll();
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    if ((!empty($value['super_admin']) && empty($this->isSuperAdmin())) || $value['id'] == $this->getUserId()) {
                        continue;
                    }
                    $this->model->update($value['id'], ['is_deleted' => STATUS_ON]);
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
        $list_delete = $this->model->whereIn('id', $delete_ids)->findAll();

        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $list_undelete = [];
        foreach ($list_delete as $key => $value) {
            if ((!empty($value['super_admin']) && empty($this->isSuperAdmin())) || $value['id'] == $this->getUserId()) {
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

        $id = $this->request->getPost('id');
        if ($id == $this->getUserId()) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('UserAdmin.error_permission_owner')]);
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

    public function login()
    {
        helper('reCaptcha');

        $data     = [];
        $redirect = empty($this->request->getGetPost('redirect')) ? site_url(CATCOOL_DASHBOARD) : $this->request->getGetPost('redirect');
        $redirect = urldecode($redirect);

        if (!empty(session('user_id'))) {
            return redirect()->to($redirect);
        } else {
            //neu da logout thi check auto login
            $recheck = $this->model->loginRememberedUser();
            if ($recheck) {
                return redirect()->to($redirect);
            }
        }

        // validate form input
        $this->validator->setRules([
            'username' => ['label' => str_replace(':', '', lang('Admin.text_username')), 'rules' => 'required'],
            'password' => ['label' => str_replace(':', '', lang('Admin.text_password')), 'rules' => 'required'],
            'captcha' => 'required|reCaptcha3[loginRootForm,0.9]'
        ]);

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run()) {

            $remember = (bool)$this->request->getPost('remember');
            if ($this->model->login($this->request->getPost('username'), $this->request->getPost('password'), $remember, true)) {
                set_alert(lang('User.text_login_successful'), ALERT_SUCCESS, ALERT_POPUP);
                return redirect()->to($redirect);
            }

            $data['errors'] = (empty($this->model->getErrors())) ? lang('User.text_login_unsuccessful') : $this->model->getErrors();
        }

        $data['username'] = $this->request->getPost('username');
        $data['remember'] = $this->request->getPost('remember');
        $data['redirect'] = $redirect;

        if (!empty($this->validator->getErrors())) {
            $data['errors'] = $this->validator->getErrors();
        }

        add_meta(['title' => lang("UserAdmin.login_heading")], $this->themes);

        $this->themes->setLayout('empty')::load('login', $data);
    }

    public function logout()
    {
        add_meta(['title' => 'Logout'], $this->themes);


        // log the user out
        $this->model->logout();

        // redirect them to the login page
        set_alert(lang('Admin.text_logout_successful'), ALERT_SUCCESS, ALERT_POPUP);
        return redirect()->to(site_url(self::MANAGE_URL . '/login'));
    }

    public function forgotPassword()
    {
        $data = [];

        $this->validator->setRules([
            'email' => ['label' => str_replace(':', '', lang('UserAdmin.text_forgot_password_input')), 'rules' => 'required'],
        ]);

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run()) {
            // Generate code
            $user_info = $this->model->forgotPassword($this->request->getPost('email'));
            if (!empty($user_info)) {
                $data = [
                    'username' => $user_info['username'],
                    'forgotten_password_code' => $user_info['user_code']
                ];

                $message       = $this->themes::view('email/forgot_password', $data);
                $subject_title = config_item('email_subject_title');
                $subject       = lang('UserAdmin.email_forgotten_password_subject');

                $send_email = send_email($user_info['email'], config_item('email_from'), $subject_title, $subject, $message);
                if (!$send_email) {
                    $data['errors'] = lang('UserAdmin.error_forgot_password_unsuccessful');
                } else {
                    $data['success'] = lang('UserAdmin.forgot_password_successful');
                }
            } else {
                $data['errors'] = empty($this->model->getErrors()) ? lang('UserAdmin.error_forgot_password_unsuccessful') : $this->model->getErrors();
            }

        }

        if (!empty($this->validator->getErrors())) {
            $data['errors'] = $this->validator->getErrors();
        }

        add_meta(['title' => lang('UserAdmin.forgot_password_heading')], $this->themes);

        $this->themes->setLayout('empty')::load('forgot_password', $data);
    }

    public function resetPassword($code = NULL)
    {
        if (!$code) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $user = $this->model->checkForgottenPassword($code);
        if (empty($user)) {
            set_alert($this->model->getErrors(), ALERT_ERROR);
            return redirect()->to(site_url(self::MANAGE_URL . "/forgot_password"));
        }

        $this->validator->setRules([
            'new_password' => ['label' => lang('UserAdmin.text_reset_password'), 'rules' => 'required|min_length[' . config_item('minPasswordLength') . ']|matches[new_password_confirm]'],
            'new_password_confirm' => ['label' => lang('UserAdmin.text_reset_password_confirm'), 'rules' => 'required'],
        ]);

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run()) {
            // do we have a valid request?
            if ($user['id'] != $this->request->getPost('id')) {
                // something fishy might be up
                $this->model->clearForgottenPasswordCode($user['id']);
                set_alert(lang('Admin.error_token'), ALERT_ERROR);
            } else {
                // finally change the password
                // When setting a new password, invalidate any other token
                $data = [
                    'password'                    => $this->auth_model->hashPassword($this->request->getPost('new_password')),
                    'forgotten_password_selector' => NULL,
                    'forgotten_password_code'     => NULL,
                    'forgotten_password_time'     => NULL
                ];

                $change = $this->model->update($user['id'], $data);
                if (!$change) {
                    set_alert(lang('UserAdmin.error_password_change_unsuccessful'), ALERT_ERROR);
                    return redirect()->to( site_url(self::MANAGE_URL . '/reset_password' . $code));
                }

                $user_token_model = new UserTokenModel();
                $user_token_model->delete(['user_id' => $user['id']]);

                // if the password was successfully changed
                set_alert(lang('UserAdmin.password_change_successful'), ALERT_SUCCESS);
                return redirect()->to(site_url(self::MANAGE_URL . "/login"));
            }
        }

        // set the flash data error message if there is one
        if (!empty($this->validator->getErrors())) {
            $data['errors'] = $this->validator->getErrors();
        }

        $data['min_password_length'] = config_item('minPasswordLength');
        $data['user'] = $user;
        $data['code'] = $code;

        add_meta(['title' => lang('UserAdmin.reset_password_heading')], $this->themes);

        $this->themes->setLayout('empty')::load('reset_password', $data);
    }
}
