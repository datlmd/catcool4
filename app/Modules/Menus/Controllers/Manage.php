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
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('MenuAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("MenuAdmin.heading_title")], $this->themes);

        $this->themes->addJS('common/plugin/shortable-nestable/jquery.nestable.js');
        $this->themes->addJS('common/js/admin/category.js');

        if (!is_null($this->request->getGet('is_admin'))) {
            session()->set('is_menu_admin', $_GET['is_admin']);
        } elseif (!session()->has('is_menu_admin')) {
            session()->set('is_menu_admin', 0);
        }
        $list = $this->model->getAllByFilter(['is_admin' => session('is_menu_admin')]);

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => format_tree(['data' => $list, 'key_id' => 'menu_id']),
            'is_admin'   => session('is_menu_admin'),
        ];

        $this->themes::load('list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
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
                'user_id'    => $this->getUserIdAdmin(),
                'sort_order' => $this->request->getPost('sort_order'),
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                'is_admin'   => !empty(session('is_menu_admin')) ? STATUS_ON : STATUS_OFF,
                'hidden'     => !empty($this->request->getPost('hidden')) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
            ];

            if (!empty($this->request->getPost('parent_id'))) {
                $add_data['parent_id'] = $this->request->getPost('parent_id');
            }

            $id = $this->model->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('Admin.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $add_data_lang = $this->request->getPost('lang');
            foreach (get_list_lang(true) as $language) {
                $add_data_lang[$language['id']]['language_id'] = $language['id'];
                $add_data_lang[$language['id']]['menu_id']     = $id;
                $this->model_lang->insert($add_data_lang[$language['id']]);
            }

            //reset cache
            $this->model->deleteCache(session('is_menu_admin'));

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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('menu_id')) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $edit_data_lang = $this->request->getPost('lang');
            foreach (get_list_lang(true) as $language) {
                $edit_data_lang[$language['id']]['language_id'] = $language['id'];
                $edit_data_lang[$language['id']]['menu_id']     = $id;

                if (!empty($this->model_lang->where(['menu_id' => $id, 'language_id' => $language['id']])->find())) {
                    $this->model_lang->where('language_id', $language['id'])->update($id, $edit_data_lang[$language['id']]);
                } else {
                    $this->model_lang->insert($edit_data_lang[$language['id']]);
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
                'user_id'    => $this->getUserIdAdmin(),
                'sort_order' => $this->request->getPost('sort_order'),
                'is_admin'   => !empty(session('is_menu_admin')) ? STATUS_ON : STATUS_OFF,
                'hidden'     => !empty($this->request->getPost('hidden')) ? STATUS_ON : STATUS_OFF,
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!empty($this->request->getPost('parent_id'))) {
                $edit_data['parent_id'] = $this->request->getPost('parent_id');
            }

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            //reset cache
            $this->model->deleteCache(session('is_menu_admin'));

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
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->getListDetail($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids);

            //reset cache
            $this->model->deleteCache(session('is_menu_admin'));

            set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
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
        $list_delete = $this->model->getListDetail($delete_ids, get_lang_id(true));
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    private function _getForm($id = null)
    {
        $this->themes->addCSS('common/js/iconpicker/iconpicker');
        $this->themes->addJS('common/js/iconpicker/iconpicker');
        $this->themes->addJS('common/js/admin/filemanager');

        $data['language_list'] = get_list_lang(true);

        $list_all = $this->model->getAllByFilter(['is_admin' => session('is_menu_admin')]);
        $data['patent_list'] = format_tree(['data' => $list_all, 'key_id' => 'menu_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('MenuAdmin.text_edit') . (!empty(session('is_menu_admin')) ? ' (Admin)' : '');

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('MenuAdmin.text_add') . (!empty(session('is_menu_admin')) ? ' (Admin)' : '');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        foreach(get_list_lang(true) as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('Admin.text_name') . ' (' . $value['name']  . ')', 'required');
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

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

        $this->model->deleteCache(session('is_menu_admin'));
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }

    public function updateSort()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $data_sort = filter_sort_array(json_decode($this->request->getPost('ids'), true), 0 , "menu_id");
        if (!$this->model->updateBatch($data_sort, 'menu_id')) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        //reset cache
        $this->model->deleteCache(session('is_menu_admin'));

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_sort_success')]);
    }
}
