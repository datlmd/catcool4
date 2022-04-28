<?php namespace App\Modules\Articles\Controllers;

use App\Controllers\AdminController;
use App\Modules\Articles\Models\CategoryModel;
use App\Modules\Articles\Models\CategoryLangModel;
use App\Modules\Routes\Models\RouteModel;

class CategoriesManage extends AdminController
{
    protected $errors = [];

    protected $model_lang;
    protected $model_route;

    CONST MANAGE_ROOT = 'articles/categories_manage';
    CONST MANAGE_URL  = 'articles/categories_manage';

    CONST SEO_URL_MODULE   = 'articles';
    CONST SEO_URL_RESOURCE = 'categories/detail/%s';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new CategoryModel();
        $this->model_lang = new CategoryLangModel();
        $this->model_route = new RouteModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('CategoryAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("CategoryAdmin.heading_title")], $this->themes);

        $this->themes->addJS('common/plugin/shortable-nestable/jquery.nestable.js');
        $this->themes->addJS('common/js/admin/category.js');

        $list = $this->model->getAllByFilter();

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list'       => format_tree(['data' => $list, 'key_id' => 'category_id']),
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('categories/list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput()->with("errors", $this->errors);
            }

            $add_data = [
                'sort_order' => $this->request->getPost('sort_order'),
                'image'      => $this->request->getPost('image'),
                'context'    => $this->request->getPost('context'),
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!empty($this->request->getPost('parent_id'))) {
                $add_data['parent_id'] = $this->request->getPost('parent_id');
            }

            $id = $this->model->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('Admin.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            //save route url
            $seo_urls = $this->request->getPost('seo_urls');
            $this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            $add_data_lang = $this->request->getPost('lang');
            foreach (get_list_lang(true) as $value) {
                $add_data_lang[$value['id']]['language_id'] = $value['id'];
                $add_data_lang[$value['id']]['category_id'] = $id;
                $add_data_lang[$value['id']]['slug']        = !empty($seo_urls[$value['id']]['route']) ? $seo_urls[$value['id']]['route'] : '';

                $this->model_lang->insert($add_data_lang[$value['id']]);
            }

            //reset cache
            $this->model->deleteCache();

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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('category_id')) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            //save route url
            $seo_urls = $this->request->getPost('seo_urls');
            $this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            $edit_data_lang = $this->request->getPost('lang');
            foreach (get_list_lang(true) as $value) {
                $edit_data_lang[$value['id']]['language_id'] = $value['id'];
                $edit_data_lang[$value['id']]['category_id'] = $id;
                $edit_data_lang[$value['id']]['slug']        = !empty($seo_urls[$value['id']]['route']) ? $seo_urls[$value['id']]['route'] : '';

                if (!empty($this->model_lang->where(['category_id' => $id, 'language_id' => $value['id']])->find())) {
                    $this->model_lang->where('language_id', $value['id'])->update($id, $edit_data_lang[$value['id']]);
                } else {
                    $this->model_lang->insert($edit_data_lang[$value['id']]);
                }
            }

            $edit_data = [
                'sort_order' => $this->request->getPost('sort_order'),
                'image'      => $this->request->getPost('image'),
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
            $this->model->deleteCache();

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
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->getListDetail($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids);

            //xoa slug ra khoi route
            foreach($list_delete as $value) {
                $this->model_route->deleteByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $value['category_id']));
            }

            //reset cache
            $this->model->deleteCache();

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

        json_output(['token' => $token, 'data' => $this->themes::view('categories/delete', $data)]);
    }

    private function _getForm($id = null)
    {
        $this->themes->addJS('common/js/admin/filemanager');

        //add tags
        $this->themes->addCSS('common/js/tags/tagsinput');
        $this->themes->addJS('common/js/tags/tagsinput');

        $data['language_list'] = get_list_lang(true);

        $list_all = $this->model->getAllByFilter();
        $data['patent_list'] = format_tree(['data' => $list_all, 'key_id' => 'category_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('CategoryAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            //lay danh sach seo url tu route
            $data['seo_urls'] = $this->model_route->getListByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('CategoryAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/add");
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('categories/form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        foreach(get_list_lang(true) as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('Admin.text_name') . ' (' . $value['name'] . ')', 'required');
            $this->validator->setRule(sprintf('seo_urls.%s.route', $value['id']), lang('Admin.text_slug'), 'checkRoute[' . ($this->request->getPost('seo_urls[' . $value['id'] . '][id]') ?? "") . ']');
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

        $this->model->deleteCache();
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

        $data_sort = filter_sort_array(json_decode($this->request->getPost('ids'), true), 0 , "category_id");
        if (!$this->model->updateBatch($data_sort, 'category_id')) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        //reset cache
        $this->model->deleteCache();

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_sort_success')]);
    }
}
