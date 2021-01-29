<?php namespace App\Modules\Users\Controllers;

use App\Controllers\AdminController;
use App\Modules\Users\Models\UserModel;

class Manage extends AdminController
{
    public $errors = [];

    CONST MANAGE_ROOT = 'users/manage';
    CONST MANAGE_URL  = 'users/manage';

    protected $model_group;
    protected $model_group_relationship;
    protected $model_permission;
    protected $model_permission_relationship;
    protected $model_auth;
    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new UserModel();

        //load model manage
        $this->load->model("users/User", 'User');
        $this->load->model("users/User_group", 'Group');
        $this->load->model("users/User_group_relationship", 'User_group_relationship');
        $this->load->model("users/User_permission_relationship", 'User_permission_relationship');
        $this->load->model("users/Auth", 'Auth');
        $this->load->model("permissions/Permission", 'Permission');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Users.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $this->theme->title(lang('heading_title'));

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $limit              = empty($this->input->get('filter_limit', true)) ? get_pagination_limit(true) : $this->input->get('filter_limit', true);
        $start_index        = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $total) = $this->User->get_all_by_filter($filter, $limit, $start_index);

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $limit, $this->input->get('page'));

        set_last_url();

        theme_load('list', $data);
    }

    private function _load_asset()
    {
        //add datetimepicker
        add_style(css_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/moment', 'common'));

        //add dropdrap
        add_style(css_url('js/dropzone/dropdrap', 'common'));
        $this->theme->add_js(js_url('js/dropzone/dropdrap', 'common'));

        add_style(css_url('vendor/bootstrap-select/css/bootstrap-select', 'common'));
        prepend_script(js_url('vendor/bootstrap-select/js/bootstrap-select', 'common'));
    }

    public function add()
    {
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permissin_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            $dob = $this->input->post('dob', true);
            if (!empty($dob)) {
                $dob = standar_date($dob);
            } else {
                $dob = '1990-01-01';
            }

            $username = strtolower($this->input->post('username', true));
            $avatar   = $this->input->post('avatar', true);
            if (!empty($avatar)) {
                $avatar_name = 'users/' . $username . '_ad.jpg'; //pathinfo($avatar, PATHINFO_EXTENSION);
                $avatar      = move_file_tmp($avatar, $avatar_name);
            }

            $add_data = [
                'username'   => $username,
                'email'      => strtolower($this->input->post('email', true)),
                'password'   => $this->Auth->hash_password($this->input->post('password')),
                'first_name' => $this->input->post('first_name', true),
                'company'    => $this->input->post('company', true),
                'phone'      => $this->input->post('phone', true),
                'address'    => $this->input->post('address', true),
                'dob'        => $dob,
                'gender'     => $this->input->post('gender', true),
                'image'      => $avatar,
                'active'     => isset($_POST['active']) ? true : false,
                'user_ip'    => get_client_ip(),
                'ctime'      => get_date(),
            ];

            if ($this->is_super_admin()) {
                $add_data['super_admin'] = (isset($_POST['super_admin'])) ? true : false;
            }

            $id = $this->User->insert($add_data);
            if (empty($id)) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $group_ids = $this->input->post('groups', true);
            if (!empty($group_ids)) {
                $list_group = $this->Group->where('id', $group_ids)->get_all();
                if (!empty($list_group)) {
                    foreach ($list_group as $group) {
                        $this->User_group_relationship->insert(['user_id' => $id, 'group_id' => $group['id']]);
                    }
                }
            }

            $permission_ids = $this->input->post('permissions', true);
            if (!empty($permission_ids)) {
                $list_permission = $this->Permission->where([['id', $permission_ids], ['published', STATUS_ON]])->get_all();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->User_permission_relationship->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }

            set_alert(lang('account_creation_successful'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL);
        }

        $this->get_form();
    }

    protected function get_form($id = null)
    {
        $this->_load_asset();

        $data['list_lang'] = get_list_lang();

        list($list_group, $total)      = $this->Group->get_all_by_filter();
        $list_permission = $this->Permission->get_list_published();

        $data['groups']      = array_column($list_group, null, 'id');
        $data['permissions'] = $list_permission;

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->User->where(['is_delete' => STATUS_OFF])->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $data_form = format_data_lang_id($data_form);

            $data['user_groups']      = $this->User_group_relationship->get_all(['user_id' => $id]);
            $data['user_permissions'] = $this->User_permission_relationship->get_all(['user_id' => $id]);

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('text_add');
            $data['text_submit'] = lang('button_add');
        }

        $data['text_cancel']   = lang('text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        $data['is_super_admin'] = $this->is_super_admin();

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        $this->theme->title($data['text_form']);

        theme_load('form', $data);
    }

    protected function validate_form($id = null)
    {
        $this->form_validation->set_rules('first_name', lang('text_full_name'), 'required');
        $this->form_validation->set_rules('email', lang('text_email'), 'required');

        if (empty($id)) {
            $this->form_validation->set_rules('username', lang('text_username'), 'trim|required|is_unique[user.username]');
            $this->form_validation->set_rules('password', lang('text_password'), 'required|min_length[' . config_item('min_password_length') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', lang('text_password_confirm'), 'required');
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        if (!empty($this->input->post('email'))) {
            if (!empty($this->input->post('id'))) {
                $email = $this->User->where(['email' => $this->input->post('email'), 'id !=' => $this->input->post('id')])->get_all();
            } else {
                $email = $this->User->where('email', $this->input->post('email'))->get_all();
            }
            if (!empty($email)) {
                $this->errors['email'] = lang('account_creation_duplicate_email');
            }
        }

        if (!empty($this->errors)) {
            return FALSE;
        }

        return $is_validation;
    }

    public function edit($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form($id) === TRUE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $item_edit = $this->User->where(['is_delete' => STATUS_OFF])->get($id);
            if (empty($item_edit)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $dob = $this->input->post('dob', true);
            if (!empty($dob)) {
                $dob = standar_date($dob);
            } else {
                $dob = '1990-01-01';
            }

            $avatar = $this->input->post('avatar', true);
            if (!empty($avatar)) {
                $avatar_name = 'users/' . $item_edit['username'] . '_ad.jpg';
                $avatar      = move_file_tmp($avatar, $avatar_name);
            } else {
                $avatar = $this->input->post('avatar_root', true);
            }

            $edit_data = [
                'email'      => strtolower($this->input->post('email', true)),
                'first_name' => $this->input->post('first_name', true),
                'company'    => $this->input->post('company', true),
                'phone'      => $this->input->post('phone', true),
                'address'    => $this->input->post('address', true),
                'dob'        => $dob,
                'gender'     => $this->input->post('gender', true),
                'image'      => $avatar,
                'user_ip'    => get_client_ip(),
                'mtime'      => get_date(),
            ];

            if ($id != $this->get_user_id()) {
                $edit_data['active'] =isset($_POST['active']) ? true : false;
            }
            if ($this->is_super_admin()) {
                $edit_data['super_admin'] = (isset($_POST['super_admin'])) ? true : false;
            }

            if ($this->User->update($edit_data, $id) === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/edit/' . $id);
            }

            $this->User_group_relationship->force_delete(['user_id' => $id]);

            $group_ids  = $this->input->post('groups', true);
            if (!empty($group_ids)) {
                $list_group = $this->Group->where('id', $group_ids)->get_all();
                if (!empty($list_group)) {
                    foreach ($list_group as $group) {
                        $this->User_group_relationship->insert(['user_id' => $id, 'group_id' => $group['id']]);
                    }
                }
            }

            $this->User_permission_relationship->force_delete(['user_id' => $id]);

            $permission_ids  = $this->input->post('permissions', true);
            if (!empty($permission_ids)) {
                $list_permission = $this->Permission->where([['id', $permission_ids], ['published', STATUS_ON]])->get_all();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->User_permission_relationship->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }

            set_alert(lang('update_successful'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        $this->get_form($id);
    }

    public function change_password($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $data_form = $this->User->where(['is_delete' => STATUS_OFF])->get($id);
        if (empty($data_form)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $this->breadcrumb->add(lang('text_change_password'), base_url(self::MANAGE_URL));
        $this->theme->title(lang('text_change_password'));

        $this->form_validation->set_rules('id', lang('text_username'), 'trim|required');
        $this->form_validation->set_rules('password_old', lang('text_password_old'), 'trim|required');
        $this->form_validation->set_rules('password_new', lang('text_password_new'), 'trim|required|min_length[' . config_item('min_password_length') . ']|matches[password_confirm_new]');
        $this->form_validation->set_rules('password_confirm_new', lang('text_confirm_password_new'), 'required');

        if (isset($_POST) && !empty($_POST) && $this->form_validation->run() === TRUE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            if ($this->Auth->check_password($this->input->post('password_old'), $data_form['password']) === FALSE) {
                set_alert(lang('error_password_old'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/change_password/' . $id);
            }

            $edit_data = [
                'password' => $this->Auth->hash_password($this->input->post('password_new')),
                'mtime'    => get_date(),
            ];
            if ($this->User->update($edit_data, $id) === FALSE) {
                set_alert(lang('error_password_change_unsuccessful'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/change_password/' . $id);
            }

            set_alert(lang('password_change_successful'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL . '/change_password/' . $id);
        }

        $data['csrf']      = create_token();
        $data['edit_data'] = $data_form;

        theme_load('change_password', $data);
    }

    public function permission($id = null)
    {
        $this->theme->title(lang('text_permission_select'));
        $this->breadcrumb->add(lang('text_permission_select'), base_url(self::MANAGE_URL));

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $item_edit = $this->User->where(['is_delete' => STATUS_OFF])->get($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $this->User_permission_relationship->force_delete(['user_id' => $id]);

            $permission_ids = $this->input->post('permissions', true);
            if (!empty($permission_ids)) {
                $list_permission = $this->Permission->where([['id', $permission_ids], ['published', STATUS_ON]])->get_all();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->User_permission_relationship->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }

            set_alert(lang('update_permission_successful'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL . '/permission/' . $id);
        }

        $data['csrf']             = create_token();
        $data['item_edit']        = $item_edit;
        $data['permissions']      = $this->Permission->get_list_published();
        $data['user_permissions'] = $this->User_permission_relationship->get_all($id);

        theme_load('permission', $data);
    }

    public function delete($id = null)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
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

            $list_delete = $this->User->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    if ((!empty($value['super_admin']) && empty($this->is_super_admin())) || $value['id'] == $this->get_user_id()) {
                        continue;
                    }
                    $this->User->update(['is_delete' => STATUS_ON], $value['id']);
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
        $list_delete = $this->User->where('id', $delete_ids)->get_all();
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $list_undelete = [];
        foreach ($list_delete as $key => $value) {
            if ((!empty($value['super_admin']) && empty($this->is_super_admin())) || $value['id'] == $this->get_user_id()) {
                $list_undelete[] = $value;
                unset($list_delete[$key]);
            }
        }

        $data['csrf']          = create_token();
        $data['list_delete']   = $list_delete;
        $data['list_undelete'] = $list_undelete;
        $data['ids']           = $delete_ids;

        json_output(['data' => theme_view('delete', $data, true)]);
    }

    public function publish()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        $id = $this->input->post('id');
        if ($id == $this->get_user_id()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_owner')]);
        }

        $item_edit = $this->User->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['active'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->User->update($item_edit, $id)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        if (!empty($_POST['published'])) {
            $data = ['status' => 'ok', 'msg' => lang('activate_successful')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('deactivate_successful')];
        }

        json_output($data);
    }

    public function login()
    {
        $this->theme->title(lang('login_heading'));

        if (!empty($this->session->userdata('user_id'))) {
            redirect(get_last_url(CATCOOL_DASHBOARD));
        } else {
            //neu da logout thi check auto login
            $recheck = $this->User->login_remembered_user();
            if ($recheck !== FALSE) {
                redirect(get_last_url(CATCOOL_DASHBOARD), 'refresh');
            }
        }

        // validate form input
        $this->form_validation->set_rules('username', str_replace(':', '', lang('text_username')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', lang('text_password')), 'required');
        $this->form_validation->set_rules('captcha', str_replace(':', '', lang('text_captcha')), 'required');

        if (isset($_POST) && !empty($_POST) && $this->form_validation->run() === TRUE)
        {
            if(!check_captcha($this->input->post('captcha'))) {
                $data['errors'] = lang('error_captcha');
            } else {
                $remember = (bool)$this->input->post('remember');
                if ($this->User->login($this->input->post('username'), $this->input->post('password'), $remember, true)) {
                    set_alert(lang('text_login_successful'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL);
                }

                $data['errors'] = empty($this->User->errors()) ? lang('text_login_unsuccessful') : $this->User->errors();
            }
        }

        if ($this->form_validation->error_array()) {
            $data['errors'] = $this->form_validation->error_array();
        }

        $data['image_captcha'] = print_captcha();
        $this->theme->layout('empty')->load('login', $data);
    }

    public function logout()
    {
        $this->theme->title('Logout');

        // log the user out
        $this->User->logout();

        // redirect them to the login page
        set_alert(lang('text_logout_successful'), ALERT_SUCCESS);
        redirect(self::MANAGE_URL . '/login');
    }

    public function forgot_password()
    {
        $this->theme->title(lang('forgot_password_heading'));

        $data = [];

        $this->form_validation->set_rules('email', lang('text_forgot_password_input'), 'required');
        if (isset($_POST) && !empty($_POST) && $this->form_validation->run() === TRUE) {
            // Generate code
            $user_info = $this->User->forgot_password($this->input->post('email'));
            if (!empty($user_info)) {
                $data = [
                    'username' => $user_info['username'],
                    'forgotten_password_code' => $user_info['user_code']
                ];

                $message       = theme_view('email/forgot_password', $data, TRUE);
                $subject_title = config_item('email_subject_title');
                $subject       = lang('email_forgotten_password_subject');

                $send_email = send_email($user_info['email'], config_item('email_from'), $subject_title, $subject, $message);
                if (!$send_email) {
                    $data['errors'] = lang('forgot_password_unsuccessful');
                } else {
                    $data['success'] = lang('forgot_password_successful');
                }
            } else {
                $data['errors'] = empty($this->User->errors()) ? lang('forgot_password_unsuccessful') : $this->User->errors();
            }
        }

        if ($this->form_validation->error_array()) {
            $data['errors'] = $this->form_validation->error_array();
        } elseif ($this->session->flashdata('errors')) {
            $data['errors'] = $this->session->flashdata('errors');
        }

        $this->theme->layout('empty')->load('forgot_password', $data);
    }

    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $this->theme->title(lang('reset_password_heading'));

        $user = $this->User->forgotten_password_check($code);
        if (empty($user)) {
            $this->session->set_flashdata('errors', $this->User->errors());
            redirect(self::MANAGE_URL . "/forgot_password");
        }

        $this->form_validation->set_rules('new_password', lang('text_reset_password'), 'required|min_length[' . config_item('min_password_length') . ']|matches[new_password_confirm]');
        $this->form_validation->set_rules('new_password_confirm', lang('text_reset_password_confirm'), 'required');

        if (isset($_POST) && !empty($_POST) && $this->form_validation->run() === TRUE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $user['id'] != $this->input->post('id')) {
                // something fishy might be up
                $this->User->clear_forgotten_password_code($user['username']);
                $this->session->set_flashdata('errors', lang('error_token'));
            } else {
                // finally change the password
                // When setting a new password, invalidate any other token
                $data = [
                    'password'                    => $this->Auth->hash_password($this->input->post('new_password')),
                    'forgotten_password_selector' => NULL,
                    'forgotten_password_code'     => NULL,
                    'forgotten_password_time'     => NULL
                ];

                $change = $this->User->update($data, $user['id']);
                if (!$change) {
                    $this->session->set_flashdata('errors', lang('error_password_change_unsuccessful'));
                    redirect(self::MANAGE_URL . '/reset_password' . $code);
                }

                $this->load->model("users/User_token", 'User_token');
                $this->User_token->delete(['user_id' => $user['id']]);

                // if the password was successfully changed
                set_alert(lang('password_change_successful'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL . "/login");
            }
        }

        // set the flash data error message if there is one
        $data['errors'] = ($this->form_validation->error_array()) ? $this->form_validation->error_array() : $this->session->flashdata('errors');

        $data['min_password_length'] = config_item('min_password_length');
        $data['user'] = $user;
        $data['csrf'] = create_token();
        $data['code'] = $code;

        $this->theme->layout('empty')->load('reset_password', $data);
    }
}
