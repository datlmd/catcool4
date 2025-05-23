<?php

namespace App\Modules\Articles\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\Articles\Models\ArticleLangModel;
use App\Modules\Articles\Models\ArticleModel;
use App\Modules\Articles\Models\CategoriesModel;
use App\Modules\Articles\Models\CategoryModel;
use App\Modules\Routes\Models\RouteModel;

class Articles extends AdminController
{
    protected $errors = [];

    protected $model_lang;
    protected $model_route;
    protected $model_category;
    protected $model_categories;

    public const MANAGE_ROOT = 'manage/articles';
    public const MANAGE_URL = 'manage/articles';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new ArticleModel();
        $this->model_lang = new ArticleLangModel();
        $this->model_route = new RouteModel();
        $this->model_category = new CategoryModel();
        $this->model_categories = new CategoriesModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('ArticleAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang('ArticleAdmin.heading_title')], $this->themes);

        $limit = $this->request->getGet('limit');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $filter_keys = ['article_id', 'name', 'category', 'limit'];
        $is_trash = $this->request->getGet('is_trash');

        if (!empty($is_trash) && $is_trash == 1) {
            $result = $this->model->onlyDeleted()->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);
        } else {
            $result = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);
        }

        $list = $result->paginate($limit);
        foreach ($list as $key => $value) {
            $list[$key]['image'] = image_thumb_url($value['images'], config_item('article_image_thumb_width'), config_item('article_image_thumb_height'));
        }

        $category_list = $this->model_category->getArticleCategories($this->language_id);

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list' => $list,
            'pager' => $result->pager,
            'sort' => empty($sort) ? 'article_id' : $sort,
            'order' => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter(array_merge($filter_keys, ['is_trash'])),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
            'category_list' => format_tree(['data' => $category_list, 'key_id' => 'category_id']),
            'is_trash'      => $is_trash,
            'count_trash'   => $this->model->onlyDeleted()->countAllResults(),
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

            $category_ids = $this->request->getPost('category_ids');
            if (!empty($category_ids)) {
                $categorie_list = $this->model_category->find($category_ids);
                if (!empty($category_ids) && empty($categorie_list)) {
                    set_alert(lang('Admin.error_empty'), ALERT_ERROR);

                    return redirect()->back()->withInput();
                }
            }

            $publish_date = $this->request->getPost('publish_date');
            if (empty($publish_date)) {
                $publish_date = get_date();
            } else {
                $publish_date_hour = $this->request->getPost('publish_date_hour');
                $publish_date_hour = empty($publish_date_hour) ? get_date('H:i') : $publish_date_hour;
                $publish_date = $publish_date . ' ' . $publish_date_hour;
                $publish_date = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
            }

            $add_data = [
                'publish_date' => $publish_date,
                'sort_order' => $this->request->getPost('sort_order'),
                'images' => $this->request->getPost('images'),
                'tags' => $this->request->getPost('tags'),
                'category_ids' => json_encode($category_ids, JSON_FORCE_OBJECT),
                'author' => $this->request->getPost('author'),
                'source' => $this->request->getPost('source'),
                'ip' => $this->request->getIPAddress(),
                'user_id' => $this->user->getId(),
                'is_comment' => $this->request->getPost('is_comment'),
                'is_toc' => !empty($this->request->getPost('is_toc')) ? STATUS_ON : STATUS_OFF,
                'published' => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            $id = $this->model->insert($add_data);
            if ($id == false) {
                set_alert(lang('Admin.error'), ALERT_ERROR);

                return redirect()->back()->withInput();
            }

            //save route url
            $seo_urls = $this->request->getPost('seo_urls');
            //$this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            if (!empty($categorie_list)) {
                $relationship_add = [];
                foreach ($categorie_list as $val) {
                    $relationship_add[] = [
                        'article_id' => $id,
                        'category_id' => $val['category_id'],
                    ];
                }
                $this->model_categories->insertBatch($relationship_add);
            }

            $add_data_lang = $this->request->getPost('lang');
            foreach (list_language_admin() as $value) {
                $add_data_lang[$value['id']]['language_id'] = $value['id'];
                $add_data_lang[$value['id']]['article_id'] = $id;
                $add_data_lang[$value['id']]['slug'] = !empty($seo_urls[$value['id']]['route']) ? clear_seo_extension(get_seo_extension($seo_urls[$value['id']]['route'])) : '';

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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('article_id')) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);

                return redirect()->back()->withInput();
            }
            try {
                $category_ids = $this->request->getPost('category_ids');

                if (!empty($category_ids)) {
                    $categorie_list = $this->model_category->find($category_ids);
                    if (!empty($category_ids) && empty($categorie_list)) {
                        set_alert(lang('Admin.error_empty'), ALERT_ERROR);

                        return redirect()->back()->withInput();
                    }
                }

                $publish_date = $this->request->getPost('publish_date');
                if (empty($publish_date)) {
                    $publish_date = get_date();
                } else {
                    $publish_date_hour = $this->request->getPost('publish_date_hour');
                    $publish_date_hour = empty($publish_date_hour) ? get_date('H:i') : $publish_date_hour;
                    $publish_date = $publish_date . ' ' . $publish_date_hour;
                    $publish_date = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
                }

                //save route url
                $seo_urls = $this->request->getPost('seo_urls');
                //$this->model_route->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

                $edit_data_lang = $this->request->getPost('lang');
                foreach (list_language_admin() as $value) {
                    $edit_data_lang[$value['id']]['language_id'] = $value['id'];
                    $edit_data_lang[$value['id']]['article_id'] = $id;
                    $edit_data_lang[$value['id']]['slug'] = !empty($seo_urls[$value['id']]['route']) ? clear_seo_extension(get_seo_extension($seo_urls[$value['id']]['route'])) : '';

                    if (!empty($this->model_lang->where(['article_id' => $id, 'language_id' => $value['id']])->find())) {
                        $this->model_lang->where('language_id', $value['id'])->update($id, $edit_data_lang[$value['id']]);
                    } else {
                        $this->model_lang->insert($edit_data_lang[$value['id']]);
                    }
                }

                if (!empty($categorie_list)) {
                    $this->model_categories->delete($id);

                    $relationship_add = [];
                    foreach ($categorie_list as $val) {
                        $relationship_add[] = [
                            'article_id' => $id,
                            'category_id' => $val['category_id'],
                        ];
                    }
                    $this->model_categories->insertBatch($relationship_add);
                }

                $edit_data = [
                    'publish_date' => $publish_date,
                    'sort_order' => $this->request->getPost('sort_order'),
                    'images' => $this->request->getPost('images'),
                    'tags' => $this->request->getPost('tags'),
                    'author' => $this->request->getPost('author'),
                    'category_ids' => json_encode($category_ids, JSON_FORCE_OBJECT),
                    'source' => $this->request->getPost('source'),
                    'ip' => $this->request->getIPAddress(),
                    'user_id' => $this->user->getId(),
                    'is_comment' => $this->request->getPost('is_comment'),
                    'is_toc' => !empty($this->request->getPost('is_toc')) ? STATUS_ON : STATUS_OFF,
                    'published' => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                ];

                if (!$this->model->update($id, $edit_data)) {
                    set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);

                    return redirect()->back()->withInput();
                }

                //reset cache
                $this->model->deleteCache();

                set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);

                return redirect()->back();
            } catch (\Exception $ex) {
                set_alert($ex->getMessage(), ALERT_ERROR, ALERT_POPUP);

                return redirect()->back()->withInput();
            }
        }

        return $this->_getForm($id);
    }

    private function _getForm($id = null)
    {
        $this->themes->addJS('common/js/tinymce/tinymce.min');
        $this->themes->addJS('common/js/admin/tiny_content');
        $this->themes->addJS('common/js/admin/articles/articles');

        //add datetimepicker
        $this->themes->addCSS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        $this->themes->addJS('common/js/admin/filemanager');

        //add tags
        $this->themes->addCSS('common/js/tags/tagsinput');
        $this->themes->addJS('common/js/tags/tagsinput');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $data['language_list'] = list_language_admin();

        $category_list = $this->model_category->getArticleCategories($this->language_id);
        $data['categories_tree'] = format_tree(['data' => $category_list, 'key_id' => 'category_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('ArticleAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);

                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $article_languages = $this->model_lang->where('article_id', $id)->findAll();
            foreach ($article_languages as $article_language) {
                $data_form['lang'][$article_language['language_id']] = $article_language;

                //get lai thong tin slug cho form_seo
                $seo_urls = [
                    'route' => $article_language['slug'],
                    'language_id' => $article_language['language_id']
                ];
                $data['seo_urls'][$article_language['language_id']] = $seo_urls;
            }

            $categories = $this->model_categories->where('article_id', $id)->findAll();
            if (!empty($categories)) {
                $data_form['categories'] = array_column($categories, 'category_id');
            }

            //lay danh sach seo url tu route
            //$data['seo_urls'] = $this->model_route->getListByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('ArticleAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL . '/add');
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
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('ArticleAdmin.text_name') . ' (' . $value['name'] . ')', 'required');
            $this->validator->setRule(sprintf('lang.%s.content', $value['id']), lang('ArticleAdmin.text_content') . ' (' . $value['name'] . ')', 'required');
            $this->validator->setRule(
                sprintf('seo_urls.%s.route', $value['id']),
                sprintf('%s (%s)', lang('Admin.text_slug'), $value['name']),
                sprintf('checkRoute[%s,%s,%s,%s]', $this->request->getPost('seo_urls[' . $value['id'] . '][route]'), $this->request->getPost('seo_urls[' . $value['id'] . '][route_old]'), $value['id'], $value['name'])
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

        $this->model->deleteCache();
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        $is_trash = $this->request->getGetPost('is_trash');

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(',', $ids);

            if (!empty($is_trash) && $is_trash == 1) {
                $list_delete = $this->model->onlyDeleted()->getArticlesByIds($ids, $this->language_id);
            } else {
                $list_delete = $this->model->getArticlesByIds($ids, $this->language_id);
            }

            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids, $is_trash);

            //xoa slug ra khoi route
            // foreach ($list_delete as $value) {
            //     $this->model_route->deleteByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $value['article_id']));
            // }

            //reset cache
            $this->model->deleteCache();

            json_output(['token' => $token, 'status' => 'ok', 'ids' => $ids, 'msg' => lang('Admin.text_delete_success')]);

            // set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            // json_output(['status' => 'redirect', 'url' => site_url(self::MANAGE_URL)]);
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
        if (!empty($is_trash) && $is_trash == 1) {
            $list_delete = $this->model->onlyDeleted()->getArticlesByIds($delete_ids, $this->language_id);

        } else {
            $list_delete = $this->model->getArticlesByIds($delete_ids, $this->language_id);
        }

        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids'] = implode(',', $delete_ids);
        $data['is_trash'] = $is_trash;

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    public function restore($id = null)
    {
        try {
            $data_form = $this->model->onlyDeleted()->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back();
            }

            if (!$this->model->update($id, ['deleted_at' => null])) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            //reset cache
            $this->model->deleteCache($id);

            set_alert(lang('Admin.text_restore_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();

        } catch (\Exception $ex) {
            set_alert($ex->getMessage(), ALERT_ERROR, ALERT_POPUP);
            return redirect()->back();
        }
    }

    public function emptyTrash()
    {
        try {
            $this->model->purgeDeleted();

            set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        } catch (\Exception $ex) {
            set_alert($ex->getMessage(), ALERT_ERROR, ALERT_POPUP);
            return redirect()->back();
        }
    }
}
