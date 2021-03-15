<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT       = 'configs/manage';
    CONST MANAGE_URL        = 'configs/manage';
    CONST MANAGE_PAGE_LIMIT = 0;

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->lang->load('configs_manage', $this->_site_lang);

        //load model manage
        $this->load->model("configs/Config", 'Config');
        $this->load->model("configs/Config_group", 'Group');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $this->theme->title(lang("heading_title"));

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $limit              = empty($this->input->get('filter_limit', true)) ? self::MANAGE_PAGE_LIMIT : $this->input->get('filter_limit', true);
        $start_index        = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $total) = $this->Config->get_all_by_filter($filter, $limit, $start_index);

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $limit, $this->input->get('page'));

        list($list_group) = $this->Group->get_all_by_filter();
        $data['groups']   = $list_group;

        $data['ses_config_group_id'] = $this->session->tab_group_id;

        set_last_url();

        theme_load('list', $data);
    }

    public function write()
    {
        //phai full quyen
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_execute'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        // lib
        $this->load->helper('file');

        try {
            $this->Config->write_file();
            set_alert(lang('created_setting_success'), ALERT_SUCCESS);
        } catch (Exception $e) {
            set_alert(lang('error'), ALERT_ERROR);
        }

        redirect(self::MANAGE_URL);
    }

    public function settings($tab_type = null)
    {
        prepend_script(js_url('js/country/load', 'common'));

        add_style(css_url('vendor/bootstrap-colorpicker/%40claviska/jquery-minicolors/jquery.minicolors', 'common'));
        prepend_script(js_url('vendor/bootstrap-colorpicker/%40claviska/jquery-minicolors/jquery.minicolors.min', 'common'));

        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (!empty($this->input->post('tab_type')) && $this->input->post('tab_type') == 'tab_page') {
            $this->form_validation->set_rules('pagination_limit', lang('text_pagination_limit'), 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('pagination_limit_admin', lang('text_pagination_limit_admin'), 'trim|required|is_natural_no_zero');
        } else if (!empty($this->input->post('tab_type')) && $this->input->post('tab_type') == 'tab_image') {
            $this->form_validation->set_rules('file_max_size', lang('text_file_max_size'), 'trim|required|is_natural');
            $this->form_validation->set_rules('file_ext_allowed', lang('text_file_ext_allowed'), 'trim|required');
            $this->form_validation->set_rules('file_max_width', lang('text_file_max_width'), 'trim|required|is_natural');
            $this->form_validation->set_rules('file_max_height', lang('text_file_max_height'), 'trim|required|is_natural');
        } else if (!empty($this->input->post('tab_type')) && $this->input->post('tab_type') == 'tab_local') {
            $this->form_validation->set_rules('language', lang('text_language'), 'trim|required');
            $this->form_validation->set_rules('language_admin', lang('text_language_admin'), 'trim|required');
        } else if (!empty($this->input->post('tab_type')) && $this->input->post('tab_type') == 'tab_server') {
            $this->form_validation->set_rules('enable_ssl', lang('text_enable_ssl'), 'trim|required');
            $this->form_validation->set_rules('encryption_key', lang('text_encryption_key'), 'trim|required');
        }

        if (isset($_POST) && !empty($_POST) && $this->form_validation->run()) {
            if (valid_token() === FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/settings/' . $this->input->post('tab_type'));
            }

            if (!empty($this->input->post('tab_type')) && $this->input->post('tab_type') == 'tab_page') {
                $_POST['enable_scroll_menu_admin'] = isset($_POST['enable_scroll_menu_admin']) ? 'TRUE' : 'FALSE';
                $_POST['enable_icon_menu_admin'] = isset($_POST['enable_icon_menu_admin']) ? 'TRUE' : 'FALSE';
                $_POST['enable_dark_mode'] = isset($_POST['enable_dark_mode']) ? 'TRUE' : 'FALSE';
            } else if (!empty($this->input->post('tab_type')) && $this->input->post('tab_type') == 'tab_image') {

                $_POST['file_ext_allowed'] = preg_replace('/\s+/', '|', trim($_POST['file_ext_allowed']));
                $_POST['file_mime_allowed'] = preg_replace('/\s+/', '|', trim($_POST['file_mime_allowed']));
                $_POST['file_encrypt_name'] = isset($_POST['file_encrypt_name']) ? 'TRUE' : 'FALSE';
                $_POST['enable_resize_image'] = isset($_POST['enable_resize_image']) ? 'TRUE' : 'FALSE';
            } else if (!empty($this->input->post('tab_type')) && $this->input->post('tab_type') == 'tab_server') {
                $_POST['maintenance'] = isset($_POST['maintenance']) ? 'TRUE' : 'FALSE';
                $_POST['seo_url'] = isset($_POST['seo_url']) ? 'TRUE' : 'FALSE';
                $_POST['enable_ssl'] = isset($_POST['enable_ssl']) ? 'TRUE' : 'FALSE';
                $_POST['robots'] = preg_replace('/\s+/', '|', trim($_POST['robots']));
            }

            foreach($this->input->post() as $key => $val) {
                $data_setting = $this->Config->get(['config_key' => $key]);
                if (empty($data_setting)) {
                    continue;
                }

                $data_setting['config_value'] = $val;
                $data_setting['user_id']   = $this->get_user_id();
                $this->Config->update($data_setting, $data_setting['id']);
            }
            $this->Config->write_file();

            set_alert(lang('text_edit_success'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL . '/settings/' . $this->input->post('tab_type'));
        }

        $this->theme->add_js(js_url('js/admin/filemanager', 'common'));

        list($list_config) = $this->Config->get_all_by_filter();

        $setings = [];
        foreach ($list_config as $value) {
            $setings[$value['config_key']] = $value['config_value'];
        }

        $tab_type = !empty($tab_type) ? $tab_type : (!empty($this->input->get_post('tab_type')) ? $this->input->get_post('tab_type') : 'tab_page');

        $data['csrf']     = create_token();
        $data['tab_type'] = $tab_type;
        $data['settings'] = $setings;

        $watermark_list = [
            ""              => lang('text_none'),
            'top_left'      => lang('text_top_left'),
            'top_center'    => lang('text_top_center'),
            'top_right'     => lang('text_top_right'),
            'middle_left'   => lang('text_middle_left'),
            'middle_center' => lang('text_center_center'),
            'middle_right'  => lang('text_middle_right'),
            'bottom_left'   => lang('text_bottom_left'),
            'bottom_center' => lang('text_bottom_center'),
            'bottom_right'  => lang('text_bottom_right'),
        ];
        $data['watermark_list'] = $watermark_list;

        $image_quality_list = [
            100 => 100,
            90 => 90,
            80 => 80,
            70 => 70,
            60 => 60,
            50 => 50,
        ];
        $data['image_quality_list'] = $image_quality_list;

        $this->load->model('images/image_tool', 'image_tool');
        $data['watermark_bg'] = $this->image_tool->watermark_demo();

        $this->load->model("countries/Country", "Country");
        $data['country_list'] = $this->Country->get_list_display();
        $this->load->model("countries/Province", "Province");
        $data['province_list'] = $this->Province->get_list_display();

        $this->load->model("products/Length_class", "Length_class");
        $data['length_class_list'] = format_dropdown($this->Length_class->get_list(), 'length_class_id');

        $this->load->model("products/Weight_class", "Weight_class");
        $data['weight_class_list'] = format_dropdown($this->Weight_class->get_list(), 'weight_class_id');

        $data['timezone_list'] = $this->_get_list_timezone();

        $this->load->model("currencies/Currency", "Currency");
        $data['currency_list'] = format_dropdown($this->Currency->get_list_by_publish(), 'code');

        $this->theme->title('Settings');

        $this->smarty->assign('manage_url', self::MANAGE_URL . '/settings');
        $this->breadcrumb->reset();
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add('Settings', base_url(CATCOOL_DASHBOARD . '/settings'));

        theme_load('setting', $data);
    }

    private function _get_list_timezone()
    {
        $timezone_list = [];
        $timestamp = time();

        $timezones = timezone_identifiers_list();

        foreach($timezones as $timezone) {
            date_default_timezone_set($timezone);

            $hour = ' (' . date('P', $timestamp) . ')';

            $timezone_list[$timezone] = $timezone . $hour;
        }

        if (!empty(config_item('timezone'))) {
            date_default_timezone_set(config_item('timezone'));//'Asia/Saigon'
        } else {
            date_default_timezone_set('Asia/Saigon');
        }

        return $timezone_list;
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() !== FALSE) {

            $additional_data['description']  = $this->input->post('description', true);
            $additional_data['config_key']   = $this->input->post('config_key', true);
            $additional_data['config_value'] = $this->input->post('config_value', true);
            $additional_data['user_id']      = $this->get_user_id();
            $additional_data['group_id']     = $this->input->post('group_id', true);
            $additional_data['published']    = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;
            $additional_data['ctime']        = get_date();

            $id = $this->Config->insert($additional_data);
            if ($id !== FALSE) {
                set_alert(lang('text_add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }
        }

        $this->get_form();
    }

    public function edit($id = null)
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

        if (isset($_POST) && !empty($_POST) && $this->validate_form() !== FALSE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            if ($this->form_validation->run() === TRUE) {
                $edit_data['description']  = $this->input->post('description', true);
                $edit_data['config_key']   = $this->input->post('config_key', true);
                $edit_data['config_value'] = $this->input->post('config_value', true);
                $edit_data['user_id']      = $this->get_user_id();
                $edit_data['group_id']     = $this->input->post('group_id', true);
                $edit_data['published']    = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;

                if ($this->Config->update($edit_data, $id) !== FALSE) {
                    set_alert(lang('text_edit_success'), ALERT_SUCCESS);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                }

                $this->session->set_userdata('tab_group_id', $this->input->post('group_id'));

                redirect(self::MANAGE_URL . '/edit/' . $id);
            }
        }

        $this->get_form($id);
    }

    public function delete($id = null)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
        }

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                json_output(['status' => 'ng', 'msg' => lang('error_token')]);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Config->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    $this->Config->delete($value['id']);
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
        $list_delete = $this->Config->where('id', $delete_ids)->get_all();
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('delete', $data, true)]);
    }

    protected function get_form($id = null)
    {
        list($list_group) = $this->Group->get_all_by_filter();
        $data['groups']   = format_dropdown($list_group);
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Config->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

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

        $this->theme->title($data['text_form']);
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        if (isset($_GET['tab_group_id'])) {
            $this->session->set_userdata('tab_group_id', $_GET['tab_group_id']);
        } elseif (empty($this->session->tab_group_id)) {
            $this->session->set_userdata('tab_group_id', 0);
        }

        theme_load('form', $data);
    }

    protected function validate_form()
    {
        $this->form_validation->set_rules('config_key', lang('text_config_key'), 'trim|required');
        //$this->form_validation->set_rules('config_value', lang('text_config_value'), 'trim|required');

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        //check slug
        if (!empty($this->input->post('config_key'))) {
            if (!empty($this->input->post('id'))) {
                $slug = $this->Config->where(['config_key' => $this->input->post('config_key'), 'id !=' => $this->input->post('id')])->get_all();
            } else {
                $slug = $this->Config->where('config_key', $this->input->post('config_key'))->get_all();
            }

            if (!empty($slug)) {
                $this->errors['config_key'] = lang('error_config_key_exists');
            }
        }

        if (!empty($this->errors)) {
            return FALSE;
        }

        return $is_validation;
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

        $id        = $this->input->post('id');
        $item_edit = $this->Config->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Config->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }
}
