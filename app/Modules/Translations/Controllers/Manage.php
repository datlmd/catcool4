<?php namespace App\Modules\Translations\Controllers;

use App\Controllers\AdminController;
use App\Modules\Modules\Models\ModuleModel;
use App\Modules\Languages\Models\LanguageModel;
use App\Modules\Translations\Models\TranslationModel;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'translations/manage';
    CONST MANAGE_URL  = 'translations/manage';

    const FILTER_DEFAULT_FRONTEND = 44;

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new TranslationModel();

        helper('filesystem');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('TranslationAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $module_model = new ModuleModel();
        $language_model = new LanguageModel();

        $module_id   = $this->request->getGet('module_id') ?? self::FILTER_DEFAULT_FRONTEND;
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['module_id', 'key', 'value'];

        $filter = $this->request->getGet($filter_keys);
        $filter['module_id'] = $module_id;

        $list          = $this->model->getAllByFilter($filter, $sort, $order);
        $module_list   = $module_model->getListPublished();
        $language_list = $language_model->getListPublished();
        $module        = (!empty($module_list[$module_id])) ? $module_list[$module_id] : null;

        //check permissions
        $file_list = [];
        if (!empty($module)) {
            foreach ($language_list as $lang) {
                $key_file = 'Language/' . $lang['code'] . '/' . $this->model->formatFileName($module['module'], $module['sub_module']) . '.php';
                if (is_file(APPPATH . $key_file)) {
                    $file_list[$key_file] = octal_permissions(fileperms(APPPATH . $key_file));
                } else {
                    $file_list[$key_file] = "File not found!";
                }
            }
        }

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list,
            'sort'          => empty($sort) ? 'id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
            'language_list' => $language_list,
            'module_list'   => $module_list,
            'module'        => $module,
            'file_list'     => $file_list,
        ];

        add_meta(['title' => lang("TranslationAdmin.heading_title")], $this->themes);
        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('list', $data);
    }

    public function add()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $language_model = new LanguageModel();
        $token          = csrf_hash();

        if (!isset($_POST) || empty($_POST)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $key       = $this->request->getPost('add_key');
        $values    = $this->request->getPost('add_value');
        $module_id = $this->request->getPost('module_id');
        if (empty($key)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => sprintf(lang('Admin.text_manage_validation'), lang('TranslationAdmin.text_key'))]);
        }
        if (empty($module_id)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => sprintf(lang('Admin.text_manage_validation'), lang('TranslationAdmin.text_module'))]);
        }

        $translates = $this->model->where(['module_id' => $module_id, 'lang_key' => $key])->findAll();
        if (!empty($translates)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_exist')]);
        }

        //list lang
        $language_list = $language_model->getListPublished();
        foreach ($language_list as $lang) {
            if (empty($values[$lang['id']])) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => sprintf(lang('Admin.text_manage_validation'), $lang['name'])]);
            }
        }

        foreach ($language_list as $lang) {
            $data_add = [
                'lang_key'   => $key,
                'lang_value' => str_replace('"', "'", $values[$lang['id']]),
                'lang_id'    => $lang['id'],
                'module_id'  => $module_id,
                'user_id'    => $this->getUserIdAdmin(),
                'ctime'      => get_date(),
            ];
            $this->model->insert($data_add);
        }

        $this->model->writeFile($module_id);

        set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_add_success')]);
    }

    public function edit()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $language_model = new LanguageModel();
        $token          = csrf_hash();

        if (!isset($_POST) || empty($_POST)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $key_new       = $this->request->getPost('edit_key');
        $key_old       = $this->request->getPost('edit_key_old');
        $values        = $this->request->getPost('edit_value');
        $module_id     = $this->request->getPost('module_id');
        $module_id_old = $this->request->getPost('module_id_old');

        if (empty($key_new)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => sprintf(lang('Admin.text_manage_validation'), lang('TranslationAdmin.text_key'))]);
        }
        if (empty($module_id)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => sprintf(lang('Admin.text_manage_validation'), lang('TranslationAdmin.text_module'))]);
        }

        $translates = $this->model->getAllByFilter(['module_id' => $module_id_old, 'lang_key' => $key_old]);
        if (empty($translates)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        //list lang
        $language_list = $language_model->getListPublished();
        foreach ($language_list as $lang) {
            if (empty($values[$lang['id']])) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => sprintf(lang('Admin.text_manage_validation'), $lang['name'])]);
            }
        }

        foreach ($language_list as $lang) {
            if (empty($translates[$key_old]['list'][$lang['id']])) {
                $data_add = [
                    'lang_key'   => $key_new,
                    'lang_value' => str_replace('"', "'", $values[$lang['id']]),
                    'lang_id'    => $lang['id'],
                    'module_id'  => $module_id,
                    'user_id'    => $this->getUserIdAdmin(),
                    'ctime'      => get_date(),
                ];

                //add
                $this->model->insert($data_add);
            } else {
                $data_edit               = $translates[$key_old]['list'][$lang['id']];
                $data_edit['lang_value'] = str_replace('"', "'", $values[$lang['id']]);
                $data_edit['lang_key']   = $key_new;
                $data_edit['module_id']  = $module_id;
                $data_edit['user_id']    = $this->getUserIdAdmin();

                //update
                $this->model->update($data_edit['id'], $data_edit);
            }
        }

        $this->model->writeFile($module_id);

        set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_edit_success')]);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $language_model = new LanguageModel();
        $token          = csrf_hash();

        if (!isset($_POST) || empty($_POST)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $translates = $this->request->getPost('translate');
        $module_id  = $this->request->getPost('module_id');

        if (empty($translates) || empty($module_id)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        //list lang
        $language_list    = $language_model->getListPublished();
        $translation_list = $this->model->getAllByFilter(['module_id' => $module_id]);

        foreach ($translates as $translation_key => $value) {
            foreach ($language_list as $lang) {
                if (empty($value[$lang['id']])) {
                    continue;
                }

                if (empty($translation_list[$translation_key]['list'][$lang['id']])) {
                    $data_add = [
                        'lang_key'   => $translation_key,
                        'lang_value' => str_replace('"', "'", $value[$lang['id']]),
                        'lang_id'    => $lang['id'],
                        'module_id'  => $module_id,
                        'user_id'    => $this->getUserIdAdmin(),
                        'ctime'      => get_date(),
                    ];

                    //add
                    $this->model->insert($data_add);
                } else {
                    $data_edit               = $translation_list[$translation_key]['list'][$lang['id']];
                    $data_edit['lang_value'] = str_replace('"', "'", $value[$lang['id']]);
                    $data_edit['user_id']    = $this->getUserIdAdmin();

                    //update
                    $this->model->update($data_edit['id'], $data_edit);
                }
            }
        }

        $this->model->writeFile($module_id);

        set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_edit_success')]);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        try {
            $key       = $this->request->getPost('key');
            $module_id = $this->request->getPost('module_id');

            $translates = $this->model->where(['module_id' => $module_id, 'lang_key' => $key])->findAll();
            if (empty($translates)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            foreach ($translates as $translate) {
                $this->model->delete($translate['id'], true);
            }

            $this->model->writeFile($module_id);
        } catch (Exception $ex) {
            set_alert($ex->getMessage(), ALERT_ERROR, ALERT_POPUP);
            json_output(['token' => $token, 'status' => 'ng', 'msg' => $ex->getMessage()]);
        }

        set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_delete_success')]);
    }

    public function write()
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        if (!$this->model->writeFile($this->request->getPost('module_id'))) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_write_success')]);
    }
}
