<?php

namespace App\Modules\Users\Controllers;

use App\Controllers\AdminController;
use App\Modules\Permissions\Models\PermissionModel;
use App\Modules\Users\Models\AuthModel;
use App\Modules\Users\Models\GroupModel;
use App\Modules\Users\Models\LoginAttemptModel;
use App\Modules\Users\Models\UserGroupModel;
use App\Modules\Users\Models\UserIpModel;
use App\Modules\Users\Models\UserModel;
use App\Modules\Users\Models\UserPermissionModel;
use App\Modules\Users\Models\UserTokenModel;
use Exception;

class Manage extends AdminController
{
    public $errors = [];

    const MANAGE_ROOT = 'users/manage';
    const MANAGE_URL = 'users/manage';

    protected $group_model;
    protected $user_group_model;
    protected $permission_model;
    protected $user_permission_model;
    protected $auth_model;

    const DOB_DEFAULT = '1970-01-01';

    const FOLDER_UPLOAD = 'users/';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new UserModel();
        $this->group_model = new GroupModel();
        $this->user_group_model = new UserGroupModel();
        $this->permission_model = new PermissionModel();
        $this->user_permission_model = new UserPermissionModel();
        $this->auth_model = new AuthModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //set supper admin
        $this->smarty->assign('is_super_admin', $this->user->getSuperAdmin());

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('UserAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $limit = $this->request->getGet('limit');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $filter_keys = ['user_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list' => $list->paginate($limit),
            'pager' => $list->pager,
            'sort' => empty($sort) ? 'user_id' : $sort,
            'order' => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url' => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        add_meta(['title' => lang('UserAdmin.heading_title')], $this->themes);
        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('list', $data);
    }

    public function add()
    {
        if (!$this->user->getSuperAdmin()) {
            set_alert(lang('Admin.error_permission_super_admin'), ALERT_ERROR, ALERT_POPUP);

            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);

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
                // create folder
                if (!is_dir(get_upload_path().self::FOLDER_UPLOAD)) {
                    mkdir(get_upload_path().self::FOLDER_UPLOAD, 0777, true);
                }

                $avatar_name = self::FOLDER_UPLOAD.$username.'.jpg'; //pathinfo($avatar, PATHINFO_EXTENSION);

                $width = !empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH;
                $height = !empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT;

                $image_tool = new \App\Libraries\ImageTool();
                $image_tool->thumbFit($avatar, $avatar_name, $width, $height);

                $avatar = $avatar_name;
            }

            $add_data = [
                'username' => $username,
                'email' => strtolower($this->request->getPost('email')),
                'password' => $this->auth_model->hashPassword($this->request->getPost('password')),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'company' => $this->request->getPost('company'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'dob' => $dob,
                'gender' => $this->request->getPost('gender'),
                'image' => $avatar,
                'active' => !empty($this->request->getPost('active')) ? STATUS_ON : STATUS_OFF,
                'ip' => $this->request->getIPAddress(),
            ];

            if ($this->user->getSuperAdmin()) {
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

            /*
            $permission_ids = $this->request->getPost('permissions');
            if (!empty($permission_ids)) {
                $list_permission = $this->permission_model->where(['published', STATUS_ON])->find($permission_ids);
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->user_permission_model->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }
            */

            set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);

            return redirect()->to(site_url(self::MANAGE_URL));
        }

        return $this->_getForm();
    }

    private function _getForm($id = null)
    {
        $this->themes->addCSS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        $this->themes->addCSS('common/js/dropzone/dropdrap');

        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        $this->themes->addJS('common/js/dropzone/dropdrap');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $data['list_lang'] = list_language_admin();

        $group_list = $this->group_model->findAll();
        $permission_list = $this->permission_model->getListPublished();
        $permission_list = $this->permission_model->formatListPublished($permission_list);

        $data['groups'] = array_column($group_list, null, 'id');
        $data['permissions'] = $permission_list;

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('UserAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL."/edit/$id");

            $data_form = $this->model->getUserInfo($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);

                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data['user_groups'] = $this->user_group_model->where('user_id', $id)->findAll();
            $data['user_permissions'] = $this->user_permission_model->where('user_id', $id)->findAll();

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('UserAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL.'/add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('form', $data);
    }

    private function _validateForm($id = null)
    {
        $this->validator->setRule('first_name', lang('Admin.text_full_name'), 'required');

        if (empty($id)) {
            $this->validator->setRule(
                'email',
                lang('Admin.text_email'),
                'required|valid_email|is_unique[user.email]',
                [
                    'is_unique' => lang('User.account_creation_duplicate_email'),
                ]
            );
            $this->validator->setRule('username', lang('Admin.text_username'), 'required|is_unique[user.username]');
            $this->validator->setRule('password', lang('Admin.text_password'), 'required|min_length['.config_item('minPasswordLength').']|matches[password_confirm]');
            $this->validator->setRule('password_confirm', lang('Admin.text_confirm_password'), 'required');
        } else {
            $this->validator->setRule(
                'email',
                lang('Admin.text_email'),
                "required|valid_email|is_unique[user.email,user_id,$id]",
                [
                    'is_unique' => lang('User.account_creation_duplicate_email'),
                ]
            );
            $this->validator->setRule('username', lang('Admin.text_username'), "required|is_unique[user.username,user_id,$id]");
        }

        if (!empty($this->request->getPost('phone'))) {
            $this->validator->setRule('phone', lang('Admin.text_phone'), "required|min_length[3]|max_length[32]|is_unique[user.phone,user_id,$id]");
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors = $this->validator->getErrors();

        if (!empty($this->request->getPost('avatar'))) {
            old('avatar', $this->request->getPost('avatar'));
        }

        if (!empty($this->errors)) {
            return false;
        }

        return $is_validation;
    }

    public function edit($id = null)
    {
        if (!$this->user->getSuperAdmin()) {
            set_alert(lang('Admin.error_permission_super_admin'), ALERT_ERROR, ALERT_POPUP);

            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);

            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('user_id')) {
            if (!$this->_validateForm($id)) {
                set_alert([ALERT_ERROR => $this->errors]);

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
                // create folder
                if (!is_dir(get_upload_path().self::FOLDER_UPLOAD)) {
                    mkdir(get_upload_path().self::FOLDER_UPLOAD, 0777, true);
                }

                $avatar_name = self::FOLDER_UPLOAD.$item_edit['username'].'.jpg';

                $width = !empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH;
                $height = !empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT;

                $image_tool = new \App\Libraries\ImageTool();
                $image_tool->thumbFit($avatar, $avatar_name, $width, $height);

                $avatar = $avatar_name;
            }
//            else {
//                $avatar = $this->request->getPost('avatar_root');
//            }

            $edit_data = [
                'email' => strtolower($this->request->getPost('email')),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'company' => $this->request->getPost('company'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'dob' => $dob,
                'gender' => $this->request->getPost('gender'),
                'image' => $avatar,
                'ip' => $this->request->getIPAddress(),
            ];

            if ($id != $this->user->getId()) {
                $edit_data['active'] = !empty($this->request->getPost('active')) ? STATUS_ON : STATUS_OFF;
            }
            if ($this->user->getSuperAdmin()) {
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

            /*
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
            */

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);

            return redirect()->back();
        }

        return $this->_getForm($id);
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
            'user_id' => ['label' => lang('Admin.text_username'), 'rules' => 'required'],
            'password_old' => ['label' => lang('UserAdmin.text_password_old'), 'rules' => 'required'],
            'password_new' => ['label' => lang('UserAdmin.text_password_new'), 'rules' => 'required|min_length['.config_item('minPasswordLength').']|matches[password_confirm_new]'],
            'password_confirm_new' => ['label' => lang('UserAdmin.text_confirm_password_new'), 'rules' => 'required'],
        ]);

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('user_id')) {
            if (!$this->validator->withRequest($this->request)->run()) {
                set_alert([ALERT_ERROR => $this->validator->getErrors()]);

                return redirect()->back()->withInput();
            }

            if ($this->auth_model->checkPassword(html_entity_decode($this->request->getPost('password_old'), ENT_QUOTES, 'UTF-8'), html_entity_decode($data_form['password'], ENT_QUOTES, 'UTF-8')) === false) {
                set_alert(lang('UserAdmin.error_password_old'), ALERT_ERROR);

                return redirect()->back()->withInput();
            }

            $edit_data = [
                'password' => $this->auth_model->hashPassword(html_entity_decode($this->request->getPost('password_new'), ENT_QUOTES, 'UTF-8')),
                'updated_at' => get_date(),
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

        $this->themes->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('change_password', $data);
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

        if (!$this->user->getSuperAdmin()) {
            set_alert(lang('Admin.error_permission_super_admin'), ALERT_ERROR, ALERT_POPUP);

            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('user_id')) {
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

        $data['item_edit'] = $item_edit;
        $data['permissions'] = $permission_list;
        $data['user_permissions'] = $this->user_permission_model->where('user_id', $id)->findAll();

        $this->breadcrumb->add(lang('UserAdmin.text_permission_select'), base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => lang('UserAdmin.text_permission_select')], $this->themes);

        $this->themes->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('permission', $data);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        if (!$this->user->getSuperAdmin()) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_permission_super_admin')]);
        }

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(',', $ids);

            $list_delete = $this->model->whereIn('user_id', $ids)->findAll();
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            try {
                $user_token_model = new UserTokenModel();
                $user_login_attempt_model = new LoginAttemptModel();
                $user_ip_model = new UserIpModel();

                foreach ($list_delete as $value) {
                    if ((!empty($value['super_admin']) && empty($this->user->getSuperAdmin())) || $value['user_id'] == $this->user->getId()) {
                        continue;
                    }
                    $this->model->delete($value['user_id']);

                    $this->user_permission_model->where(['user_id' => $value['user_id']])->delete();
                    $this->user_group_model->where(['user_id' => $value['user_id']])->delete();
                    $user_token_model->where(['user_id' => $value['user_id']])->delete();
                    $user_login_attempt_model->where(['user_id' => $value['user_id']])->delete();
                    $user_ip_model->where(['user_id' => $value['user_id']])->delete();
                }

                json_output(['token' => $token, 'status' => 'ok', 'ids' => $ids, 'msg' => lang('Admin.text_delete_success')]);
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
        $list_delete = $this->model->whereIn('user_id', $delete_ids)->findAll();

        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $list_undelete = [];
        foreach ($list_delete as $key => $value) {
            if ((!empty($value['super_admin']) && empty($this->user->getSuperAdmin())) || $value['user_id'] == $this->user->getId()) {
                $list_undelete[] = $value;
                unset($list_delete[$key]);
            }
        }

        $data['list_delete'] = $list_delete;
        $data['list_undelete'] = $list_undelete;
        $data['ids'] = $this->request->getPost('delete_ids');

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
        if ($id == $this->user->getId()) {
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
        //helper('reCaptcha');

        $data = [];
        $redirect = empty($this->request->getGetPost('redirect')) ? site_url(CATCOOL_DASHBOARD) : $this->request->getGetPost('redirect');
        $redirect = urldecode($redirect);

        if ($this->user->isLogged()) {
            return redirect()->to($redirect);
        } else {
            //neu da logout thi check auto login
            if ($this->user->loginRememberedUser()) {
                return redirect()->to($redirect);
            }
        }

        session()->set('login_token', substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26));

        $data = [
            'redirect' => $redirect,
            'login' => site_url('users/manage/api_login').'?login_token='.session('login_token'),
        ];

//        if (!empty($this->validator->getErrors())) {
//            $data['errors'] = $this->validator->getErrors();
//        }

        add_meta(['title' => lang('UserAdmin.login_heading')], $this->themes);

        $this->themes->setLayout('empty')::load('login', $data);
    }

    public function apiLogin()
    {
        //helper('reCaptcha');

        $redirect = empty($this->request->getPost('redirect')) ? site_url(CATCOOL_DASHBOARD) : $this->request->getPost('redirect');
        $redirect = urldecode($redirect);

        if (empty($this->request->getGet('login_token')) || empty(session('login_token')) || $this->request->getGet('login_token') != session('login_token')) {
            set_alert(lang('User.text_login_unsuccessful'), ALERT_ERROR);
            json_output([
                'error66' => lang('User.text_login_unsuccessful'),
                'redirect' => site_url('users/manage/login')."?redirect=$redirect",
            ]);
        }

        if ($this->user->isLogged()) {
            json_output([
                'redirect' => $redirect,
            ]);
        }

        if (empty($this->request->getPost())) {
            json_output([
                'alert' => print_alert(lang('User.text_login_unsuccessful'), 'danger'),
            ]);
        }

        // validate form input
        $this->validator->setRules([
            'username' => ['label' => str_replace(':', '', lang('Admin.text_username')), 'rules' => 'required'],
            'password' => ['label' => str_replace(':', '', lang('Admin.text_password')), 'rules' => 'required'],
            //'captcha' => 'required|reCaptcha3[loginRootForm,0.9]'
        ]);

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        $remember = (bool) $this->request->getPost('remember');
        if (!$this->user->login($this->request->getPost('username'), html_entity_decode($this->request->getPost('password'), ENT_QUOTES, 'UTF-8'), $remember, true)) {
            $errors = (empty($this->user->getErrors())) ? lang('User.text_login_unsuccessful') : $this->user->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        session()->remove('login_token');

        $user_ip_model = new \App\Modules\Users\Models\UserIpModel();
        $user_ip_model->addLogin($this->user->getId());

        set_alert(lang('User.text_login_successful'), ALERT_SUCCESS, ALERT_POPUP);

        json_output([
            'success' => lang('User.text_login_successful'),
            'redirect' => $redirect,
        ]);
    }

    public function logout()
    {
        add_meta(['title' => 'Logout'], $this->themes);

        // log the user out
        $this->model->logout();

        // redirect them to the login page
        set_alert(lang('Admin.text_logout_successful'), ALERT_SUCCESS, ALERT_POPUP);

        return redirect()->to(site_url(self::MANAGE_URL.'/login?redirect='.urlencode(previous_url())));
    }

    public function forgotPassword()
    {
        $data = [];

        $this->validator->setRules([
            'email' => ['label' => str_replace(':', '', lang('UserAdmin.text_forgot_password_input')), 'rules' => 'required'],
        ]);

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run()) {
            if (empty($this->request->getGet('forgot_token')) || empty(session('forgot_token')) || $this->request->getGet('forgot_token') != session('forgot_token')) {
                set_alert(lang('UserAdmin.error_forgot_password_unsuccessful'), ALERT_ERROR);

                return redirect()->to(site_url('users/manage/forgot_password'));
            }

            // Generate code
            $user_info = $this->model->forgotPassword($this->request->getPost('email'));
            if (!empty($user_info)) {
                $language_code = $user_info['language_id'] ? list_language()[$user_info['language_id']]['code'] : language_code();
                $data = [
                    'full_name' => full_name($user_info['first_name'], $user_info['last_name']),
                    'username' => $user_info['username'],
                    'forgotten_password_code' => $user_info['user_code'],
                    'language' => $language_code,
                ];

                $message = $this->themes::view('email/admin/forgot_password', $data);
                $subject_title = config_item('email_subject_title');
                $subject = lang('Email.forgot_password_subject', [$user_info['username']], $language_code);

                $send_email = send_email($user_info['email'], config_item('email_from'), $subject, $message, $subject_title);
                if (!$send_email) {
                    $data['errors'] = lang('UserAdmin.error_forgot_password_unsuccessful');
                } else {
                    session()->remove('forgot_token');

                    $data['success'] = lang('UserAdmin.forgot_password_successful');
                }
            } else {
                $data['errors'] = empty($this->model->getErrors()) ? lang('UserAdmin.error_forgot_password_unsuccessful') : $this->model->getErrors();
            }
        }

        session()->set('forgot_token', substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26));

        $data['forgot_password'] = site_url('users/manage/forgot_password').'?forgot_token='.session('forgot_token');

        if (!empty($this->validator->getErrors())) {
            $data['errors'] = $this->validator->getErrors();
        }

        add_meta(['title' => lang('UserAdmin.forgot_password_heading')], $this->themes);

        $this->themes->setLayout('empty')::load('forgot_password', $data);
    }

    public function resetPassword($code = null)
    {
        if (!$code) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $code = html_entity_decode($code, ENT_QUOTES, 'UTF-8');

        $user = $this->model->checkForgottenPassword($code);
        if (empty($user)) {
            set_alert($this->model->getErrors(), ALERT_ERROR);

            return redirect()->to(site_url(self::MANAGE_URL.'/forgot_password'));
        }

        $this->validator->setRules([
            'new_password' => ['label' => lang('UserAdmin.text_reset_password'), 'rules' => 'required|min_length['.config_item('minPasswordLength').']|matches[new_password_confirm]'],
            'new_password_confirm' => ['label' => lang('UserAdmin.text_reset_password_confirm'), 'rules' => 'required'],
        ]);

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run()) {
            if (empty($this->request->getGet('reset_token')) || empty(session('reset_token')) || $this->request->getGet('reset_token') != session('reset_token')) {
                set_alert(lang('Admin.error_token'), ALERT_ERROR);

                return redirect()->to(site_url("users/manage/reset_password/$code"));
            }

            // do we have a valid request?
            if ($user['user_id'] != $this->request->getPost('user_id')) {
                // something fishy might be up
                $this->model->clearForgottenPasswordCode($user['user_id']);
                set_alert(lang('Admin.error_token'), ALERT_ERROR);
            } else {
                // finally change the password
                // When setting a new password, invalidate any other token
                $data = [
                    'password' => $this->auth_model->hashPassword($this->request->getPost('new_password')),
                    'forgotten_password_selector' => null,
                    'forgotten_password_code' => null,
                    'forgotten_password_time' => null,
                ];

                $change = $this->model->update($user['user_id'], $data);
                if (!$change) {
                    set_alert(lang('UserAdmin.error_password_change_unsuccessful'), ALERT_ERROR);

                    return redirect()->to(site_url(self::MANAGE_URL.'/reset_password/'.$code));
                }

                session()->remove('reset_token');

                $user_token_model = new UserTokenModel();
                $user_token_model->delete(['user_id' => $user['user_id']]);

                // if the password was successfully changed
                set_alert(lang('UserAdmin.password_change_successful'), ALERT_SUCCESS);

                return redirect()->to(site_url(self::MANAGE_URL.'/login'));
            }
        }

        // set the flash data error message if there is one
        if (!empty($this->validator->getErrors())) {
            $data['errors'] = $this->validator->getErrors();
        }

        session()->set('reset_token', substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26));

        $data['reset_password'] = site_url("users/manage/reset_password/$code").'?reset_token='.session('reset_token');
        $data['min_password_length'] = config_item('minPasswordLength');
        $data['user'] = $user;
        $data['code'] = $code;

        add_meta(['title' => lang('UserAdmin.text_reset_password_heading')], $this->themes);

        $this->themes->setLayout('empty')::load('reset_password', $data);
    }

    public function userIpList($user_id)
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $limit = 10;

        $pager = service('pager');
        $pager->setPath('users/manage/user_ip_list/'.$user_id, 'user_ip');

        $user_ip_model = new \App\Modules\Users\Models\UserIpModel();

        $data['user_ips'] = $user_ip_model->where(['user_id' => $user_id])->orderBy('created_at', 'DESC')->paginate($limit, 'user_ip');
        $data['user_ip_pager'] = $user_ip_model->pager;

        return $this->themes::view('ip_list', $data);
    }

    public function tokenList($user_id)
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $limit = 10;

        $pager = service('pager');
        $pager->setPath('users/manage/token_list/'.$user_id, 'token');

        $user_token_model = new UserTokenModel();

        $data['user_tokens'] = $user_token_model->where(['user_id' => $user_id])->orderBy('created_at', 'DESC')->paginate($limit, 'token');
        $data['user_token_pager'] = $user_token_model->pager;

        return $this->themes::view('token_list', $data);
    }

    public function deleteToken()
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output([
                'token' => $token,
                'error' => lang('Admin.error_json'),
                'alert' => print_alert(lang('Admin.error_json')),
            ]);
        }

        $user_token_model = new UserTokenModel();
        $user_id = $this->request->getPost('user_id');
        $remember_selector = $this->request->getPost('remember_selector');

        $user_tokens = $user_token_model->where(['user_id' => $user_id, 'remember_selector' => $remember_selector])->first();
        if (empty($user_tokens)) {
            json_output([
                'token' => $token,
                'error' => lang('Admin.error_empty'),
                'alert' => print_alert(lang('Admin.error_empty')),
            ]);
        }

        try {
            $user_token_model->where(['user_id' => $user_id, 'remember_selector' => $remember_selector])->delete();
        } catch (Exception $e) {
            json_output([
                'token' => $token,
                'error' => $e->getMessage(),
            ]);
        }

        json_output([
            'token' => $token,
            'success' => lang('Admin.text_delete_success'),
            'alert' => print_alert(lang('Admin.text_delete_success')),
        ]);
    }
}
