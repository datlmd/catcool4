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
        switch ($this->request->getPost('tab_type')) {
            case 'tab_page':
                $this->validator->setRule('site_name', lang('ConfigAdmin.text_site_name'), 'required');
                $this->validator->setRule('site_description', lang('ConfigAdmin.text_site_description'), 'required');
                $this->validator->setRule('site_keywords', lang('ConfigAdmin.text_site_keywords'), 'required');
                $this->validator->setRule('pagination_limit', lang('ConfigAdmin.text_pagination_limit'), 'required|is_natural_no_zero');
                $this->validator->setRule('pagination_limit_admin', lang('ConfigAdmin.text_pagination_limit_admin'), 'required|is_natural_no_zero');
                break;
            case 'tab_image':
                $this->validator->setRule('file_max_size', lang('ConfigAdmin.text_file_max_size'), 'required|is_natural');
                $this->validator->setRule('file_ext_allowed', lang('ConfigAdmin.text_file_ext_allowed'), 'required');
                $this->validator->setRule('file_max_width', lang('ConfigAdmin.text_file_max_width'), 'required|is_natural');
                $this->validator->setRule('file_max_height', lang('ConfigAdmin.text_file_max_height'), 'required|is_natural');
                break;
            case 'tab_local':
                $this->validator->setRule('language', lang('ConfigAdmin.text_language'), 'required');
                $this->validator->setRule('language_admin', lang('ConfigAdmin.text_language_admin'), 'required');
                break;
            case 'tab_server':
                $this->validator->setRule('enable_ssl', lang('ConfigAdmin.text_enable_ssl'), 'required');
                $this->validator->setRule('encryption_key', lang('ConfigAdmin.text_encryption_key'), 'required');
                break;
            default:
                break;
        }

        if (!empty($this->request->getPost())) {
            if (!$this->validator->withRequest($this->request)->run()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $data_settings = $this->request->getPost();
            switch ($this->request->getPost('tab_type')) {
                case 'tab_page':
                    $data_settings['enable_scroll_menu_admin'] = $this->request->getPost('enable_scroll_menu_admin') ?? false;
                    $data_settings['enable_icon_menu_admin']   = $this->request->getPost('enable_icon_menu_admin') ?? false;
                    $data_settings['enable_dark_mode']         = $this->request->getPost('enable_dark_mode') ?? false;
                    break;
                case 'tab_image':
                    $data_settings['file_ext_allowed']    = preg_replace('/\s+/', '|', trim($_POST['file_ext_allowed']));
                    $data_settings['file_mime_allowed']   = preg_replace('/\s+/', '|', trim($_POST['file_mime_allowed']));
                    $data_settings['file_encrypt_name']   = $this->request->getPost('file_encrypt_name') ?? false;
                    $data_settings['enable_resize_image'] = $this->request->getPost('enable_resize_image') ?? false;
                    break;
                case 'tab_server':
                    $data_settings['maintenance'] = $this->request->getPost('maintenance') ?? false;
                    $data_settings['seo_url']     = $this->request->getPost('seo_url') ?? false;
                    $data_settings['enable_ssl']  = $this->request->getPost('enable_ssl') ?? false;
                    $data_settings['robots']      = preg_replace('/\s+/', '|', trim($_POST['robots']));
                    break;
                case 'tab_local':
                default:
                    break;
            }

            $list_config = $this->model->findAll();
            if (!empty($list_config)) {
                foreach ($list_config as $key => $value) {
                    $list_config[$value['config_key']] = $value;
                    unset($list_config[$key]);
                }
            }

            $data_edit = [];
            foreach($data_settings as $key => $val) {
                if (empty($list_config[$key])) {
                    continue;
                }
                $data_edit[] = [
                    'id'           => $list_config[$key]['id'],
                    'config_value' => $val,
                    'user_id'      => $this->getUserId(),
                ];
            }
            $this->model->updateBatch($data_edit, 'id');

            $this->model->writeFile();

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL) . '/settings/' . $this->request->getPost('tab_type'));
        }

        $this->themes->addJS('common/js/country/load');
        $this->themes->addCSS('common/plugin/bootstrap-colorpicker/claviska/jquery-minicolors/jquery.minicolors');
        $this->themes->addJS('common/plugin/bootstrap-colorpicker/claviska/jquery-minicolors/jquery.minicolors.min');
        $this->themes->addJS('common/js/admin/filemanager');

        $setings     = [];
        $list_config = $this->model->findAll();
        if (!empty($list_config)) {
            foreach ($list_config as $value) {
                $setings[$value['config_key']] = $value['config_value'];
            }
        }

        $tab_type = !empty($tab_type) ? $tab_type : (!empty($this->request->getGetPost('tab_type')) ? $this->request->getGetPost('tab_type') : 'tab_page');

        $data['tab_type'] = $tab_type;
        $data['settings'] = $setings;

        $watermark_list = [
            ""             => lang('Admin.text_none'),
            'top-left'     => lang('ConfigAdmin.text_top_left'),
            'top'          => lang('ConfigAdmin.text_top_center'),
            'top-right'    => lang('ConfigAdmin.text_top_right'),
            'left'         => lang('ConfigAdmin.text_middle_left'),
            'center'       => lang('ConfigAdmin.text_center_center'),
            'right'        => lang('ConfigAdmin.text_middle_right'),
            'bottom-left'  => lang('ConfigAdmin.text_bottom_left'),
            'bottom'       => lang('ConfigAdmin.text_bottom_center'),
            'bottom-right' => lang('ConfigAdmin.text_bottom_right'),
        ];
        $data['watermark_list'] = $watermark_list;

        $image_tool = new \App\Libraries\ImageTool();
        $data['watermark_bg'] = $image_tool->watermarkDemo();

        $country_model  = new \App\Modules\Countries\Models\CountryModel();
        $province_model = new \App\Modules\Countries\Models\ProvinceModel();
        $currency_model = new \App\Modules\Currencies\Models\CurrencyModel();

        $data['country_list']  = $country_model->getListDisplay();
        $data['province_list'] = $province_model->getListDisplay();

//        $this->load->model("products/Length_class", "Length_class");
//        $data['length_class_list'] = format_dropdown($this->Length_class->get_list(), 'length_class_id');
//
//        $this->load->model("products/Weight_class", "Weight_class");
//        $data['weight_class_list'] = format_dropdown($this->Weight_class->get_list(), 'weight_class_id');

        $data['timezone_list'] = $this->_getListTimezone();
        $data['currency_list'] = format_dropdown($currency_model->getListPublished(), 'code');

        add_meta(['title' => lang("Admin.text_settings")], $this->themes);

        $this->smarty->assign('manage_url', self::MANAGE_URL . '/settings');
        $this->breadcrumb->reset();
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang("Admin.text_settings"), site_url(CATCOOL_DASHBOARD . '/settings'));

        theme_load('setting', $data);
    }

    private function _getListTimezone()
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
