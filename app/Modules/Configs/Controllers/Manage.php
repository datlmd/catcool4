<?php namespace App\Modules\Configs\Controllers;

use App\Controllers\AdminController;
use App\Modules\Configs\Models\ConfigModel;
use App\Modules\Configs\Models\GroupModel;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'configs/manage';
    CONST MANAGE_URL  = 'configs/manage';

    protected $model;
    protected $group_model;

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new ConfigModel();
        $this->group_model = new GroupModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('ConfigAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

    public function index()
    {
        $sort  = $this->request->getGet('sort');
        $order = $this->request->getGet('order');

        $data = [
            'breadcrumb'      => $this->breadcrumb->render(),
            'list'            => $this->model->getAllByFilter(null, $sort, $order),
            'sort'            => empty($sort) ? 'id' : $sort,
            'order'           => ($order == 'ASC') ? 'DESC' : 'ASC',
            'groups'          => $this->group_model->findAll(),
            'config_group_id' => session('tab_group_id'),
        ];

        add_meta(['title' => lang("ConfigAdmin.heading_title")], $this->themes);
        $this->themes::load('list', $data);
    }

    public function write()
    {
        if ($this->model->writeFile()) {
            set_alert(lang('ConfigAdmin.created_setting_success'), ALERT_SUCCESS, ALERT_POPUP);
        } else {
            set_alert(lang('Admin.error'), ALERT_ERROR,ALERT_POPUP);
        }

        return redirect()->to(site_url(self::MANAGE_URL));
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

        if (!empty(config_item('app_timezone'))) {
            date_default_timezone_set(config_item('app_timezone'));//'Asia/Saigon'
        } else {
            date_default_timezone_set('Asia/Saigon');
        }

        return $timezone_list;
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'config_key'   => $this->request->getPost('config_key'),
                'config_value' => $this->request->getPost('config_value'),
                'description'  => $this->request->getPost('description'),
                'user_id'      => $this->getUserId(),
                'group_id'     => $this->request->getPost('group_id'),
                'published'    => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                'ctime'        => get_date(),
            ];

            if (!$this->model->insert($add_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $this->_getForm();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('id')) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'config_key'   => $this->request->getPost('config_key'),
                'config_value' => $this->request->getPost('config_value'),
                'description'  => $this->request->getPost('description'),
                'user_id'      => $this->getUserId(),
                'group_id'     => $this->request->getPost('group_id'),
                'published'    => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();

        }

        $this->_getForm($id);
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
        $group_list     = $this->group_model->findAll();
        $data['groups'] = format_dropdown($group_list);
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('ConfigAdmin.text_edit');

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('ConfigAdmin.text_add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        if (!empty($this->request->getGet('tab_group_id'))) {
            session()->set('tab_group_id', $this->request->getGet('tab_group_id'));
        } elseif (empty(session('tab_group_id'))) {
            session()->set('tab_group_id', 0);
        }

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('config_key', lang('ConfigAdmin.text_config_key'), 'required');

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        //check slug
        if (!empty($this->request->getPost('config_key'))) {
            if (!empty($this->request->getPost('id'))) {
                $key_list = $this->model->where('config_key', $this->request->getPost('config_key'))->whereNotIn('id', (array)$this->request->getPost('id'))->findAll();
            } else {
                $key_list = $this->model->where('config_key', $this->request->getPost('config_key'))->findAll();
            }

            if (!empty($key_list)) {
                $this->errors['config_key'] = lang('ConfigAdmin.error_config_key_exists');
            }
        }

        if (!empty($this->errors)) {
            return FALSE;
        }

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

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')]);
    }
}
