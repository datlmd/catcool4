<?php namespace App\Modules\Products\Controllers;

use App\Controllers\AdminController;
use App\Modules\Products\Models\CategoryModel;
use App\Modules\Products\Models\CategoryLangModel;
use App\Modules\Routes\Models\RouteModel;

class CategoriesManage extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    CONST MANAGE_ROOT = 'products/categories_manage';
    CONST MANAGE_URL  = 'products/categories_manage';

    CONST SEO_URL_MODULE   = 'products';
    CONST SEO_URL_RESOURCE = 'Categories::Detail/%s';

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
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('ProductCategoryAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        $this->themes->addJS('common/plugin/shortable-nestable/jquery.nestable.js');
        $this->themes->addJS('common/js/admin/category.js');

        add_meta(['title' => lang('ProductCategoryAdmin.heading_title')], $this->themes);

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
                set_alert([ALERT_ERROR => $this->errors]);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'image'      => $this->request->getPost('image'),
                'parent_id'  => $this->request->getPost('parent_id'),
                'top'        => $this->request->getPost('top'),
                'column'     => $this->request->getPost('column'),
                'sort_order' => $this->request->getPost('sort_order'),
                'published'  => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];
            $id = $this->model->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('Admin.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            //save route url
            $seo_urls = $this->request->getPost('seo_urls');
            $this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            // filters
            $category_filter_model = new \App\Modules\Products\Models\CategoryFilterModel();
            $filter_ids = $this->request->getPost('filter_ids');
            if (!empty($filter_ids)) {
                foreach ($filter_ids as $filter_id) {
                    $category_filter_model->insert(['category_id' => $id, 'filter_id' => $filter_id]);
                }
            }


            $add_data_lang = $this->request->getPost('lang');
            foreach (list_language_admin() as $language) {
                $add_data_lang[$language['id']]['language_id'] = $language['id'];
                $add_data_lang[$language['id']]['category_id'] = $id;
                $add_data_lang[$language['id']]['slug']        = !empty($seo_urls[$language['id']]['route']) ? get_seo_extension($seo_urls[$language['id']]['route']) : '';
                $this->model_lang->insert($add_data_lang[$language['id']]);
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
                set_alert([ALERT_ERROR => $this->errors]);
                return redirect()->back()->withInput();
            }

            //save route url
            $seo_urls = $this->request->getPost('seo_urls');
            $this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            $edit_data_lang = $this->request->getPost('lang');
            foreach (list_language_admin() as $language) {
                $edit_data_lang[$language['id']]['language_id'] = $language['id'];
                $edit_data_lang[$language['id']]['category_id'] = $id;
                $edit_data_lang[$language['id']]['slug']        = !empty($seo_urls[$language['id']]['route']) ? get_seo_extension($seo_urls[$language['id']]['route']) : '';

                if (!empty($this->model_lang->where(['category_id' => $id, 'language_id' => $language['id']])->find())) {
                    $this->model_lang->where('language_id', $language['id'])->update($id,$edit_data_lang[$language['id']]);
                } else {
                    $this->model_lang->insert($edit_data_lang[$language['id']]);
                }
            }

            // filters
            $category_filter_model = new \App\Modules\Products\Models\CategoryFilterModel();
            $category_filter_model->where(['category_id' => $id])->delete();

            $filter_ids = $this->request->getPost('filter_ids');
            if (!empty($filter_ids)) {
                foreach ($filter_ids as $filter_id) {
                    $category_filter_model->insert(['category_id' => $id, 'filter_id' => $filter_id]);
                }
            }

            $edit_data = [
                'category_id' => $id,
                'image'       => $this->request->getPost('image'),
                'parent_id'   => !empty($this->request->getPost('parent_id')) ? $this->request->getPost('parent_id') : null,
                'top'         => $this->request->getPost('top'),
                'column'      => $this->request->getPost('column'),
                'sort_order'  => $this->request->getPost('sort_order'),
                'published'   => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];
            if ($this->model->save($edit_data) !== FALSE) {
                //reset cache
                $this->model->deleteCache();

                set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            } else {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            }

            return redirect()->back();
        }

        return $this->_getForm($id);
    }

    private function _getForm($id = null)
    {
        $this->themes->addJS('common/js/admin/filemanager');

        //add tags
        $this->themes->addCSS('common/js/tags/tagsinput');
        $this->themes->addJS('common/js/tags/tagsinput');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (get_language_admin() == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $data['language_list'] = list_language_admin();

        $list_all = $this->model->getAllByFilter();
        $data['patent_list'] = format_tree(['data' => $list_all, 'key_id' => 'category_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('Admin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            //lay danh sach seo url tu route
            $data['seo_urls'] = $this->model_route->getListByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            // filters
            $category_filter_model  = new \App\Modules\Products\Models\CategoryFilterModel();
            $filter_ids = $category_filter_model->where(['category_id' => $id])->findAll();
            $data_form['filter_ids'] = array_column($filter_ids, 'filter_id');

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('Admin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/add");
        }

        //filter
        $filter_model = new \App\Modules\Filters\Models\FilterModel();
        $data['filter_list'] = $filter_model->getFilters($this->language_id);

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('categories/form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('column', lang('ProductCategoryAdmin.text_column'), 'is_natural|required');
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        foreach(list_language_admin() as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('Admin.text_name') . ' (' . $value['name'] . ')', 'required');
            $this->validator->setRule(
                sprintf('seo_urls.%s.route', $value['id']),
                sprintf("%s (%s)", lang('Admin.text_slug'), $value['name']),
                sprintf('checkRoute[%s,%s,%s,%s]', $this->request->getPost('seo_urls[' . $value['id'] . '][route]'), $this->request->getPost('seo_urls[' . $value['id'] . '][route_old]'), $value['id'], $value['name'])
            );
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        return $is_validation;
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
            $this->model->deleteCache();

            //xoa slug ra khoi route
            foreach($list_delete as $value) {
                $this->model_route->deleteByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $value['category_id']));
            }

            json_output(['token' => $token, 'status' => 'ok', 'ids' => $ids, 'msg' => lang('Admin.text_delete_success')]);
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
        $list_delete = $this->model->getListDetail($delete_ids, $this->language_id);
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $this->request->getPost('delete_ids');

        json_output(['token' => $token, 'data' => $this->themes::view('categories/delete', $data)]);
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

        //reset cache
        $this->model->deleteCache();

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')]);
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
