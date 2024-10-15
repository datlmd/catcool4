<?php

namespace App\Modules\Configs\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\Configs\Models\ConfigModel;
use App\Modules\Configs\Models\GroupModel;

class Configs extends AdminController
{
    protected $errors = [];

    const MANAGE_ROOT = 'manage/configs';
    const MANAGE_URL = 'manage/configs';

    protected $model;
    protected $group_model;

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

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
        helper('filesystem');

        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');

        //check permissions
        $key_file = 'config/Config.php';
        if (is_file(WRITEPATH.$key_file)) {
            $is_writable = is_writable(WRITEPATH.$key_file) ? 'Writable' : 'Not writable';
            $file_permissions = "$key_file: $is_writable";
        } else {
            $file_permissions = 'File not found!';
        }

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list' => $this->model->getAllByFilter(null, $sort, $order),
            'sort' => empty($sort) ? 'id' : $sort,
            'order' => ($order == 'ASC') ? 'DESC' : 'ASC',
            'groups' => $this->group_model->findAll(),
            'config_group_id' => session('tab_group_id'),
            'file_permissions' => $file_permissions,
        ];

        add_meta(['title' => lang('ConfigAdmin.heading_title')], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('list', $data);
    }

    public function write()
    {
        if ($this->model->writeFile()) {
            set_alert(lang('ConfigAdmin.created_setting_success'), ALERT_SUCCESS, ALERT_POPUP);
        } else {
            set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
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
            case 'tab_store':
                $this->validator->setRule('store_name', lang('ConfigAdmin.text_store_name'), 'required');
                $this->validator->setRule('store_owner', lang('ConfigAdmin.text_store_owner'), 'required|min_length[3]|max_length[64]');
                $this->validator->setRule('store_address', lang('ConfigAdmin.text_store_address'), 'required|min_length[3]|max_length[256]');
                $this->validator->setRule('store_email', lang('ConfigAdmin.text_store_email'), 'required|valid_email');
                $this->validator->setRule('store_phone', lang('ConfigAdmin.text_store_phone'), 'required|min_length[3]|max_length[32]');
                break;
            case 'tab_image':
                $this->validator->setRule('file_max_size', lang('ConfigAdmin.text_file_max_size'), 'required|is_natural');
                $this->validator->setRule('file_ext_allowed', lang('ConfigAdmin.text_file_ext_allowed'), 'required');
                $this->validator->setRule('file_max_width', lang('ConfigAdmin.text_file_max_width'), 'required|is_natural');
                $this->validator->setRule('file_max_height', lang('ConfigAdmin.text_file_max_height'), 'required|is_natural');
                $this->validator->setRule('article_image_thumb_width', lang('ConfigAdmin.text_article_image_thumb'), 'required|is_natural');
                $this->validator->setRule('article_image_thumb_height', lang('ConfigAdmin.text_article_image_thumb'), 'required|is_natural');
                $this->validator->setRule('product_category_image_thumb_width', lang('ConfigAdmin.text_product_category_image_thumb'), 'required|is_natural');
                $this->validator->setRule('product_category_image_thumb_height', lang('ConfigAdmin.text_product_category_image_thumb'), 'required|is_natural');
                $this->validator->setRule('product_image_thumb_width', lang('ConfigAdmin.text_product_image_thumb'), 'required|is_natural');
                $this->validator->setRule('product_image_thumb_height', lang('ConfigAdmin.text_product_image_thumb'), 'required|is_natural');
                $this->validator->setRule('product_image_width', lang('ConfigAdmin.text_product_image'), 'required|is_natural');
                $this->validator->setRule('product_image_height', lang('ConfigAdmin.text_product_image'), 'required|is_natural');
                break;
            case 'tab_local':
                $this->validator->setRule('default_locale', lang('Admin.text_language'), 'required');
                $this->validator->setRule('default_locale_admin', lang('ConfigAdmin.text_language_admin'), 'required');
                break;
            case 'tab_option':
                $this->validator->setRule('attribute_default', lang('ConfigAdmin.text_attribute_default'), 'required');
                $this->validator->setRule('product_description_length', lang('ConfigAdmin.text_product_description_length'), 'required|is_natural_no_zero');
                $this->validator->setRule('product_pagination', lang('ConfigAdmin.text_product_pagination'), 'required|is_natural_no_zero');
                $this->validator->setRule('product_pagination', lang('ConfigAdmin.text_product_pagination'), 'required|is_natural_no_zero');
                $this->validator->setRule('product_pagination_admin', lang('ConfigAdmin.text_product_limit_admin'), 'required|is_natural_no_zero');
                break;
            case 'tab_mail':
                $this->validator->setRule('email_engine', lang('ConfigAdmin.text_email_engine'), 'required');
                // if ($this->request->getPost('mail_alert_email')) {
                //     $this->validator->setRule('mail_alert_email', lang('ConfigAdmin.text_email_alert_email'), 'valid_emails');
                // }
                break;
            case 'tab_server':
                $this->validator->setRule('robots', lang('ConfigAdmin.text_robots'), 'required');
                break;
            default:
                break;
        }

        if (!empty($this->request->getPost())) {
            if (!$this->validator->withRequest($this->request)->run()) {
                set_alert([
                    ALERT_ERROR => $this->validator->getErrors(),
                ]);

                return redirect()->back()->withInput();
            }

            $data_settings = $this->request->getPost();
            switch ($this->request->getPost('tab_type')) {
                case 'tab_image':

                    //clear file upload
                    delete_files(get_upload_path('cache'), true);
                    delete_files(get_upload_path('tmp'), true);

                    $data_settings['file_ext_allowed'] = preg_replace('/\s+/', '|', trim($_POST['file_ext_allowed']));
                    $data_settings['file_mime_allowed'] = preg_replace('/\s+/', '|', trim($_POST['file_mime_allowed']));
                    $data_settings['is_fitting_image'] = !empty($this->request->getPost('is_fitting_image')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['file_encrypt_name'] = !empty($this->request->getPost('file_encrypt_name')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['enable_resize_image'] = !empty($this->request->getPost('enable_resize_image')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['image_watermar_enable'] = !empty($this->request->getPost('image_watermar_enable')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['image_watermark_is_shadow'] = !empty($this->request->getPost('image_watermark_is_shadow')) ? STATUS_ON : STATUS_OFF;
                    break;
                case 'tab_server':
                    $data_settings['robots'] = preg_replace('/\s+/', '|', trim($_POST['robots']));
                    $data_settings['maintenance'] = !empty($this->request->getPost('maintenance')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['seo_url'] = !empty($this->request->getPost('seo_url')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['force_global_secure_requests'] = !empty($this->request->getPost('force_global_secure_requests')) ? STATUS_ON : STATUS_OFF;
                    break;
                case 'tab_store':
                    $data_settings['store_location'] = implode(',', $this->request->getPost('store_location[]'));
                    break;
                case 'tab_local':
                    $data_settings['currency_auto'] = !empty($this->request->getPost('currency_auto')) ? STATUS_ON : STATUS_OFF;
                    break;
                case 'tab_option':
                        $data_settings['customer_online'] = !empty($this->request->getPost('customer_online')) ? STATUS_ON : STATUS_OFF;
                        $data_settings['customer_activity'] = !empty($this->request->getPost('customer_activity')) ? STATUS_ON : STATUS_OFF;
                        $data_settings['customer_price'] = !empty($this->request->getPost('customer_price')) ? STATUS_ON : STATUS_OFF;
                        $data_settings['customer_search'] = !empty($this->request->getPost('customer_search')) ? STATUS_ON : STATUS_OFF;
                        $data_settings['customer_group_display'] = implode(',', $this->request->getPost('customer_group_display[]'));
                        break;
                case 'tab_page':
                    $data_settings['enable_scroll_menu_admin'] = !empty($this->request->getPost('enable_scroll_menu_admin')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['enable_icon_menu_admin'] = !empty($this->request->getPost('enable_icon_menu_admin')) ? STATUS_ON : STATUS_OFF;
                    $data_settings['enable_dark_mode'] = !empty($this->request->getPost('enable_dark_mode')) ? STATUS_ON : STATUS_OFF;
                    break;
                case 'tab_mail':
                    $data_settings['mail_alert_email'] = preg_replace('/\s+/', ',', trim($this->request->getPost('mail_alert_email')));
                    $data_settings['mail_alert'] = $this->request->getPost('mail_alert[]') ? implode(',', $this->request->getPost('mail_alert[]')) : '';
                    break;
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
            foreach ($data_settings as $key => $val) {
                if (empty($list_config[$key])) {
                    continue;
                }
                $data_edit[] = [
                    'id' => $list_config[$key]['id'],
                    'config_value' => $val,
                    'user_id' => $this->user->getId(),
                ];
            }

            try {
                $this->model->updateBatch($data_edit, 'id');
            } catch (\Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);

                return redirect()->back()->withInput();
            }

            $this->model->writeFile();

            //change language admin
            if (!empty($data_settings['default_locale_admin']) && $data_settings['default_locale_admin'] != language_code_admin()) {
                set_language_admin($data_settings['default_locale_admin']);

                $menu_model = new \App\Modules\Menus\Models\MenuModel();
                $menu_model->deleteCache(true);
            }

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);

            return redirect()->to(site_url(self::MANAGE_URL).'/settings/'.$this->request->getPost('tab_type'));
        }

        $this->themes->addJS('common/js/country/load');
        $this->themes->addCSS('common/plugin/bootstrap-colorpicker/claviska/jquery-minicolors/jquery.minicolors');
        $this->themes->addJS('common/plugin/bootstrap-colorpicker/claviska/jquery-minicolors/jquery.minicolors.min');
        $this->themes->addJS('common/js/admin/filemanager');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $settings = [];
        $list_config = $this->model->findAll();
        if (!empty($list_config)) {
            foreach ($list_config as $value) {
                switch ($value['config_key']) {
                    case 'mail_alert_email':
                        $settings[$value['config_key']] = str_replace(',', PHP_EOL, $value['config_value']);
                        break;
                    case 'mail_alert':
                    case 'store_location':
                    case 'customer_group_display':
                        $settings[$value['config_key']] = explode(',', $value['config_value']);
                        break;
                    default:
                        $settings[$value['config_key']] = $value['config_value'];
                        break;
                }
            }
        }

        $tab_type = !empty($tab_type) ? $tab_type : (!empty($this->request->getGetPost('tab_type')) ? $this->request->getGetPost('tab_type') : 'tab_page');

        $data['tab_type'] = $tab_type;
        $data['settings'] = $settings;

        $mail_alert_list = [
            'account' => lang('ConfigAdmin.text_email_alert_account'),
            'affiliate' => lang('ConfigAdmin.text_email_alert_affiliate'),
            'order' => lang('ConfigAdmin.text_email_alert_order'),
            'review' => lang('ConfigAdmin.text_email_alert_review'),
        ];
        $data['mail_alert_list'] = $mail_alert_list;

        $watermark_list = [
            '' => lang('Admin.text_none'),
            'top-left' => lang('ConfigAdmin.text_top_left'),
            'top' => lang('ConfigAdmin.text_top_center'),
            'top-right' => lang('ConfigAdmin.text_top_right'),
            'left' => lang('ConfigAdmin.text_middle_left'),
            'center' => lang('ConfigAdmin.text_center_center'),
            'right' => lang('ConfigAdmin.text_middle_right'),
            'bottom-left' => lang('ConfigAdmin.text_bottom_left'),
            'bottom' => lang('ConfigAdmin.text_bottom_center'),
            'bottom-right' => lang('ConfigAdmin.text_bottom_right'),
        ];
        $data['watermark_list'] = $watermark_list;
        $data['fitting_list'] = $watermark_list;

        $image_tool = new \App\Libraries\ImageTool();
        $data['watermark_bg'] = $image_tool->watermarkDemo();

        $country_model = new \App\Modules\Countries\Models\CountryModel();
        $zone_model = new \App\Modules\Countries\Models\ZoneModel();
        $currency_model = new \App\Modules\Currencies\Models\CurrencyModel();

        $data['country_list'] = $country_model->getCountriesDropdown();
        $data['zone_list'] = $zone_model->getZonesByCountry();
        $data['timezone_list'] = $this->_getListTimezone();
        $data['currency_list'] = format_dropdown($currency_model->getListPublished(), 'code');

        $length_class_model = new \App\Modules\Products\Models\LengthClassModel();
        $data['length_class_list'] = format_dropdown($length_class_model->getLengthClasses($this->language_id), 'length_class_id');

        $weight_class_model = new \App\Modules\Products\Models\WeightClassModel();
        $data['weight_class_list'] = format_dropdown($weight_class_model->getWeightClasses($this->language_id), 'weight_class_id');

        $attribute_group_model = new \App\Modules\Attributes\Models\GroupModel();
        $data['attribute_group_list'] = format_dropdown($attribute_group_model->getAttributeGroups($this->language_id), 'attribute_group_id');

        $location_model = new \App\Modules\Locations\Models\LocationModel();
        $data['location_list'] = $location_model->getLocations();

        $customer_group_model = new \App\Modules\Customers\Models\GroupModel();
        $data['customer_group_list'] = $customer_group_model->getCustomerGroups($this->language_id);

        $page_model = new \App\Modules\Pages\Models\PageModel();
        $data['page_list'] = $page_model->getPages($this->language_id);

        //check permissions
        $key_file = 'config/Config.php';
        if (is_file(WRITEPATH.$key_file)) {
            $is_writable = is_writable(WRITEPATH.$key_file) ? 'Writable' : 'Not writable';
            $data['file_permissions'] = "$key_file: $is_writable";
        } else {
            $data['file_permissions'] = 'File not found!';
        }

        add_meta(['title' => lang('ConfigAdmin.heading_title')], $this->themes);

        $this->smarty->assign('manage_url', self::MANAGE_URL.'/settings');
        $this->breadcrumb->reset();
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('ConfigAdmin.heading_title'), site_url(CATCOOL_DASHBOARD.'/settings'));

        $this->themes
        ->addPartial('header')
        ->addPartial('footer')
        ->addPartial('sidebar');
        theme_load('setting', $data);
    }

    private function _getListTimezone()
    {
        $timezone_list = [];
        $timestamp = time();

        $timezones = timezone_identifiers_list();

        foreach ($timezones as $timezone) {
            date_default_timezone_set($timezone);

            $hour = ' ('.date('P', $timestamp).')';

            $timezone_list[$timezone] = $timezone.$hour;
        }

        if (!empty(config_item('app_timezone'))) {
            date_default_timezone_set(config_item('app_timezone')); //'Asia/Saigon'
        } else {
            date_default_timezone_set('Asia/Saigon');
        }

        return $timezone_list;
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);

                return redirect()->back()->withInput();
            }

            $add_data = [
                'config_key' => $this->request->getPost('config_key'),
                'config_value' => $this->request->getPost('config_value'),
                'description' => $this->request->getPost('description'),
                'user_id' => $this->user->getId(),
                'group_id' => $this->request->getPost('group_id'),
                'published' => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->insert($add_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);

                return redirect()->back()->withInput();
            }

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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('id')) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);

                return redirect()->back()->withInput();
            }

            $edit_data = [
                'config_key' => $this->request->getPost('config_key'),
                'config_value' => $this->request->getPost('config_value'),
                'description' => $this->request->getPost('description'),
                'user_id' => $this->user->getId(),
                'group_id' => $this->request->getPost('group_id'),
                'published' => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }

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
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(',', $ids);

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

        $delete_ids = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->find($delete_ids);
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids'] = implode(',', $delete_ids);

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    private function _getForm($id = null)
    {
        $group_list = $this->group_model->findAll();
        $data['groups'] = format_dropdown($group_list);
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('ConfigAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL."/edit/$id");

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);

                return redirect()->to(site_url(self::MANAGE_URL));
            }

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('ConfigAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL.'/add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        if (!empty($this->request->getGet('tab_group_id'))) {
            session()->set('tab_group_id', $this->request->getGet('tab_group_id'));
        } elseif (empty(session('tab_group_id'))) {
            session()->set('tab_group_id', 0);
        }

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('config_key', lang('ConfigAdmin.text_config_key'), 'required');

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors = $this->validator->getErrors();

        //check slug
        if (!empty($this->request->getPost('config_key'))) {
            if (!empty($this->request->getPost('id'))) {
                $key_list = $this->model->where('config_key', $this->request->getPost('config_key'))->whereNotIn('id', (array) $this->request->getPost('id'))->findAll();
            } else {
                $key_list = $this->model->where('config_key', $this->request->getPost('config_key'))->findAll();
            }

            if (!empty($key_list)) {
                $this->errors['config_key'] = lang('ConfigAdmin.error_config_key_exists');
            }
        }

        if (!empty($this->errors)) {
            return false;
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

        $id = $this->request->getPost('id');
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

    public function config()
    {
        $allow = [
            'dark_mode' => 'enable_dark_mode',
            'collapse_menu' => 'enable_scroll_menu_admin',
            'style_menu' => 'enable_icon_menu_admin',
        ];

        $key = $this->request->getGet('k');
        $value = $this->request->getGet('v');

        if (empty($allow[$key]) || !isset($value)) {
            return redirect()->back();
        }

        $config = $this->model->where('config_key', $allow[$key])->first();
        if (empty($config)) {
            return redirect()->back();
        }

        $config['config_value'] = !empty($value) ? true : false;

        if ($this->model->update($config['id'], $config)) {
            $this->model->writeFile();
        }

        return redirect()->back();
    }
}
