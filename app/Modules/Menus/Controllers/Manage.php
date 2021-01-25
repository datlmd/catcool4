<?php namespace App\Modules\Menus\Controllers;

use App\Controllers\AdminController;
use App\Modules\Menus\Models\MenuModel;
use App\Modules\Menus\Models\MenuLangModel;

class Manage extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    CONST MANAGE_ROOT = 'menus/manage';
    CONST MANAGE_URL  = 'menus/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new MenuModel();
        $this->model_lang = new MenuLangModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('GeneralManage.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('MenusManage.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("MenusManage.heading_title")], $this->themes);

        $this->themes->addJS('common/plugin/shortable-nestable/jquery.nestable.js');
        $this->themes->addJS('common/js/admin/category.js');

        if (isset($_GET['is_admin'])) {
            session()->set('is_menu_admin', $_GET['is_admin']);
        } elseif (!session()->has('is_menu_admin')) {
            session()->set('is_menu_admin', 0);
        }
        $list = $this->model->getAllByFilter(['is_admin' => session('is_menu_admin')]);

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => $list,
            'is_admin'   => session('is_menu_admin'),
        ];

        $this->themes::load('list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'context'    => $this->request->getPost('context'),
                'icon'       => $this->request->getPost('icon'),
                'image'      => $this->request->getPost('image'),
                'nav_key'    => $this->request->getPost('nav_key'),
                'label'      => $this->request->getPost('label'),
                'attributes' => $this->request->getPost('attributes'),
                'selected'   => $this->request->getPost('selected'),
                'user_id'    => $this->get_user_id(),
                'parent_id'  => $this->request->getPost('parent_id'),
                'sort_order' => $this->request->getPost('sort_order'),
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                'is_admin'   => !empty(session('is_menu_admin')) ? STATUS_ON : STATUS_OFF,
                'hidden'     => !empty($this->request->getPost('hidden')) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
            ];

            $id = $this->model->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('GeneralManage.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data_lang = format_lang_form($this->request->getPost());
            foreach (get_list_lang() as $key => $value) {
                $add_data_lang[$key]['language_id'] = $key;
                $add_data_lang[$key]['menu_id']     = $id;
                $this->model_lang->insert($add_data_lang);
            }

            //reset cache
            $this->model->delete_cache();

            set_alert(lang('GeneralManage.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        $this->getForm();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('GeneralManage.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost())) {
            if (!$this->validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->request->getPost('menu_id')) {
                set_alert(lang('GeneralManage.error_token'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data_lang = format_lang_form($this->request->getPost());
            foreach (get_list_lang() as $key => $value) {
                $edit_data_lang[$key]['language_id'] = $key;
                $edit_data_lang[$key]['menu_id']     = $id;

                if (!empty($this->model_lang->where(['menu_id' => $id, 'language_id' => $key])->find())) {
                    $this->model_lang->where('language_id', $key)->update($id, $edit_data_lang[$key]);
                } else {
                    $this->model_lang->insert($edit_data_lang[$key]);
                }
            }

            $edit_data = [
                'context'    => $this->request->getPost('context'),
                'icon'       => $this->request->getPost('icon'),
                'image'      => $this->request->getPost('image'),
                'nav_key'    => $this->request->getPost('nav_key'),
                'label'      => $this->request->getPost('label'),
                'attributes' => $this->request->getPost('attributes'),
                'selected'   => $this->request->getPost('selected'),
                'user_id'    => $this->get_user_id(),
                'parent_id'  => $this->request->getPost('parent_id'),
                'sort_order' => $this->request->getPost('sort_order'),
                'is_admin'   => !empty(session('is_menu_admin')) ? STATUS_ON : STATUS_OFF,
                'hidden'     => !empty($this->request->getPost('hidden')) ? STATUS_ON : STATUS_OFF,
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                'mtime'      => get_date(),
            ];

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('GeneralManage.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            //reset cache
            $this->model->delete_cache();

            set_alert(lang('GeneralManage.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        $this->getForm($id);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->getListDetail($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_empty')]);
            }

            $this->model_lang->delete($ids);
            $this->model->delete($ids);

            //reset cache
            $this->model->delete_cache();

            set_alert(lang('GeneralManage.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            json_output(['status' => 'redirect', 'url' => site_url(self::MANAGE_URL)]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->getListDetail($delete_ids, get_lang_id());
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('GeneralManage.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => $this->themes::view('manage/delete', $data)]);
    }

    protected function getForm($id = null)
    {
        $this->themes->addCSS('common/js/iconpicker/iconpicker');
        //  $this->themes->addJS('common/js/iconpicker/iconpicker');
        $this->themes->addJS('common/js/admin/filemanager');

        $data['list_lang'] = get_list_lang();

        $list_all = $this->model->getAllByFilter(['is_admin' => session('is_menu_admin')]);
        $data['list_patent'] = format_tree(['data' => $list_all, 'key_id' => 'menu_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('MenusManage.text_edit') . (!empty(session('is_menu_admin')) ? ' (Admin)' : '');
            $data['text_submit'] = lang('GeneralManage.button_save');

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('GeneralManage.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('MenusManage.text_add') . (!empty(session('is_menu_admin')) ? ' (Admin)' : '');
            $data['text_submit'] = lang('GeneralManage.button_add');
        }

        $data['text_cancel']   = lang('GeneralManage.text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes::load('form', $data);
    }

    protected function validateForm()
    {
        $this->validator->setRule('sort_order', lang('GeneralManage.text_sort_order'), 'is_natural');
        foreach(get_list_lang() as $key => $value) {
            $this->validator->setRule(sprintf('lang_%s_name', $key), lang('GeneralManage.text_name') . ' (' . $value['name']  . ')', 'required');
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

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

        $id        = $this->request->getPost('id');
        $item_edit = $this->Menu->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Menu->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            //reset cache
            $this->Menu->delete_cache();

            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }

    public function update_sort()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
        }

        if (isset($_POST['ids']) && !empty($_POST['ids'])) {

            $data_sort = filter_sort_array(json_decode($_POST['ids'], true), 0 , "menu_id");

            if (!$this->Menu->update($data_sort, "menu_id")) {
                json_output(['status' => 'ng', 'msg' => lang('error_json')]);
            }

            //reset cache
            $this->Menu->delete_cache();

            json_output(['status' => 'ok', 'msg' => lang('text_sort_success')]);
        }

        json_output(['status' => 'ng', 'msg' => lang('error_json')]);
    }
}
