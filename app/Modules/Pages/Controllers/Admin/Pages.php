<?php

namespace App\Modules\Pages\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\Pages\Models\PageLangModel;
use App\Modules\Pages\Models\PageModel;
use App\Modules\Routes\Models\RouteModel;

class Pages extends AdminController
{
    protected $errors = [];

    protected $model_lang;
    protected $model_route;

    public const MANAGE_ROOT = 'manage/pages';
    public const MANAGE_URL = 'manage/pages';

    public const SEO_URL_MODULE = 'pages';
    public const SEO_URL_RESOURCE = 'Pages::Detail/%s';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new PageModel();
        $this->model_lang = new PageLangModel();
        $this->model_route = new RouteModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('PageAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang('PageAdmin.heading_title')], $this->themes);

        $limit = $this->request->getGet('limit');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $filter_keys = ['page_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list' => $list->paginate($limit),
            'pager' => $list->pager,
            'sort' => empty($sort) ? 'page_id' : $sort,
            'order' => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url' => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);

                return redirect()->back()->withInput()->with('errors', $this->errors);
            }

            $add_data = [
                'body_class' => $this->request->getPost('body_class'),
                'layout' => $this->request->getPost('layout'),
                'sort_order' => $this->request->getPost('sort_order'),
                'published' => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            $id = $this->model->insert($add_data);
            if ($id === false) {
                set_alert(lang('Admin.error'), ALERT_ERROR);

                return redirect()->back()->withInput();
            }

            //save route url
            $seo_urls = $this->request->getPost('seo_urls');
            $this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            $add_data_lang = $this->request->getPost('lang');
            foreach (list_language_admin() as $value) {
                $add_data_lang[$value['id']]['language_id'] = $value['id'];
                $add_data_lang[$value['id']]['page_id'] = $id;
                $add_data_lang[$value['id']]['slug'] = !empty($seo_urls[$value['id']]['route']) ? get_seo_extension($seo_urls[$value['id']]['route']) : '';

                $this->model_lang->insert($add_data_lang[$value['id']]);
            }

            //reset cache
            $this->model->deleteCache($id);

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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('page_id')) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);

                return redirect()->back()->withInput();
            }
            try {
                //save route url
                $seo_urls = $this->request->getPost('seo_urls');
                $this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

                $edit_data_lang = $this->request->getPost('lang');
                foreach (list_language_admin() as $value) {
                    $edit_data_lang[$value['id']]['language_id'] = $value['id'];
                    $edit_data_lang[$value['id']]['page_id'] = $id;
                    $edit_data_lang[$value['id']]['slug'] = !empty($seo_urls[$value['id']]['route']) ? get_seo_extension($seo_urls[$value['id']]['route']) : '';

                    if (!empty($this->model_lang->where(['page_id' => $id, 'language_id' => $value['id']])->find())) {
                        $this->model_lang->where('language_id', $value['id'])->update($id, $edit_data_lang[$value['id']]);
                    } else {
                        $this->model_lang->insert($edit_data_lang[$value['id']]);
                    }
                }

                $edit_data = [
                    'body_class' => $this->request->getPost('body_class'),
                    'layout' => $this->request->getPost('layout'),
                    'sort_order' => $this->request->getPost('sort_order'),
                    'published' => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                ];

                if (!$this->model->update($id, $edit_data)) {
                    set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);

                    return redirect()->back()->withInput();
                }

                //reset cache
                $this->model->deleteCache($id);

                set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);

                return redirect()->back();
            } catch (\Exception $ex) {
                set_alert($ex->getMessage(), ALERT_ERROR, ALERT_POPUP);

                return redirect()->back()->withInput();
            }
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

            $list_delete = $this->model->getPagesByIds($ids, $this->language_id);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids);

            //xoa slug ra khoi route
            foreach ($list_delete as $value) {
                $this->model_route->deleteByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $value['page_id']));

                //reset cache
                $this->model->deleteCache($value['page_id']);
            }

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

        $delete_ids = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->getPagesByIds($delete_ids, $this->language_id);
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids'] = implode(',', $delete_ids);

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    private function _getForm($id = null)
    {
        $this->themes->addJS('common/js/tinymce/tinymce.min');
        $this->themes->addJS('common/js/admin/tiny_content');
        $this->themes->addJS('common/js/admin/articles/articles');

        //add tags
        $this->themes->addCSS('common/js/tags/tagsinput');
        $this->themes->addJS('common/js/tags/tagsinput');

        $data['language_list'] = list_language_admin();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('PageAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL."/edit/$id");

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);

                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data_languages = $this->model_lang->where('page_id', $id)->findAll();
            foreach ($data_languages as $value) {
                $data_form['lang'][$value['language_id']] = $value;
            }

            //lay danh sach seo url tu route
            $data['seo_urls'] = $this->model_route->getListByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('PageAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL.'/add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        foreach (list_language_admin() as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('PageAdmin.text_name').' ('.$value['name'].')', 'required');
            $this->validator->setRule(sprintf('lang.%s.content', $value['id']), lang('PageAdmin.text_content').' ('.$value['name'].')', 'required');
            $this->validator->setRule(
                sprintf('seo_urls.%s.route', $value['id']),
                sprintf('%s (%s)', lang('Admin.text_slug'), $value['name']),
                sprintf('checkRoute[%s,%s,%s,%s]', $this->request->getPost('seo_urls['.$value['id'].'][route]'), $this->request->getPost('seo_urls['.$value['id'].'][route_old]'), $value['id'], $value['name'])
            );
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors = $this->validator->getErrors();

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

        $this->model->deleteCache($id);
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }
}
