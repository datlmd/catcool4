<?php namespace App\Modules\Posts\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\Posts\Models\PostModel;
use App\Modules\Posts\Models\CategoryModel;

class Posts extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'manage/posts';
    CONST MANAGE_URL  = 'manage/posts';

    CONST SEO_URL_MODULE   = 'posts';
    CONST SEO_URL_RESOURCE = 'Posts::Detail/%s';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new PostModel();
        $this->model_category = new CategoryModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('PostAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("PostAdmin.heading_title")], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $is_trash    = $this->request->getGet('is_trash');
        $filter_keys = ['post_id', 'name', 'category_id', 'limit'];

        $tpl_name = "list";
        if (!empty($is_trash) && $is_trash == 1) {
            $tpl_name = "list_trash";
            $list = $this->model->onlyDeleted()->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);
        } else {
            $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);
        }

        $category_list = $this->model_category->getPostCategories($this->language_id);

        $post_list = $list->paginate($limit);
        foreach ($post_list as $key_news => $value) {
            $value = $this->model->formatDetail($value);

            $value['preview_url'] = $value['detail_url'];
            if (empty($value['published'])) {
                $value['preview_url'] = str_ireplace(get_seo_extension(), '.preview', $value['detail_url']);
            }

            $post_list[$key_news] = $value;
        }

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $post_list,
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'post_id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter(array_merge($filter_keys, ['is_trash'])),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
            'is_trash'      => $is_trash,
            'count_trash'   => $this->model->onlyDeleted()->countAllResults(),
            'category_list' => format_tree(['data' => $category_list, 'key_id' => 'category_id']),
            'kenh14_list'   => Config('Robot')->pageKenh14Post,
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load($tpl_name, $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);
                return redirect()->back()->withInput()->with("errors", $this->errors);
            }

            $category_ids = $this->request->getPost('category_ids');
            if (!empty($category_ids)) {
                $category_ids   = (is_array($category_ids)) ? $category_ids : explode(",", $category_ids);
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
                $publish_date      = $publish_date . ' ' . $publish_date_hour;
                $publish_date      = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
            }

            $category_ids = $this->request->getPost('category_ids');
            if (!empty($category_ids)) {
                //check parent id and save it
                $category_list = $this->model_category->getPostCategories($this->language_id);
                $parent_ids = [];
                foreach ($category_ids as $value) {
                    if (empty($category_list[$value])) {
                        continue;
                    }

                    $parent_ids = array_merge($parent_ids, get_parent_id($category_list, $value, 'category_id'));
                }

                if (!empty($parent_ids)) {
                    $category_ids = [];
                    foreach ($parent_ids as $value) {
                        $category_ids[$value] = $value;
                    }
                }
            }
            
            $add_data = [
                'name'              => $this->request->getPost('name'),
                'slug'              => !empty($this->request->getPost('slug')) ? slugify($this->request->getPost('slug')) : slugify($this->request->getPost('name')),
                'description'       => $this->request->getPost('description'),
                'content'           => $this->request->getPost('content'),
                'meta_title'        => $this->request->getPost('meta_title'),
                'meta_description'  => $this->request->getPost('meta_description'),
                'meta_keyword'      => $this->request->getPost('meta_keyword'),
                'publish_date'      => $publish_date,
                'sort_order'        => $this->request->getPost('sort_order'),
                'images'            => json_encode($this->request->getPost('images'), JSON_FORCE_OBJECT),
                'tags'              => $this->request->getPost('tags'),
                'author'            => $this->request->getPost('author'),
                'category_ids'      => json_encode($category_ids, JSON_FORCE_OBJECT),
                'related_ids'       => json_encode($this->request->getPost('related_ids'), JSON_FORCE_OBJECT),
                'source_type'       => $this->request->getPost('source_type'),
                'source'            => $this->request->getPost('source'),
                'tracking_code'     => $this->request->getPost('tracking_code'),
                'post_format'       => $this->request->getPost('post_format'),
                'is_ads'            => !empty($this->request->getPost('is_ads')) ? STATUS_ON : STATUS_OFF,
                'is_fb_ia'          => !empty($this->request->getPost('is_fb_ia')) ? STATUS_ON : STATUS_OFF,
                'is_hot'            => !empty($this->request->getPost('is_hot')) ? STATUS_ON : STATUS_OFF,
                'is_homepage'       => !empty($this->request->getPost('is_homepage')) ? STATUS_ON : STATUS_OFF,
                'is_disable_follow' => !empty($this->request->getPost('is_disable_follow')) ? STATUS_ON : STATUS_OFF,
                'is_disable_robot'  => !empty($this->request->getPost('is_disable_robot')) ? STATUS_ON : STATUS_OFF,
                'ip'                => $this->request->getIPAddress(),
                'user_id'           => $this->user->getId(),
                'is_comment'        => $this->request->getPost('is_comment'),
                'published'         => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                'language_id'       => $this->language_id,
            ];

            $id = $this->model->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('Admin.error'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

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

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('post_id')) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);
                return redirect()->back()->withInput();
            }
            try {
                $category_ids = $this->request->getPost('category_ids');
                if (!empty($category_ids)) {
                    $category_ids   = (is_array($category_ids)) ? $category_ids : explode(",", $category_ids);
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

                $category_ids = $this->request->getPost('category_ids');
                if (!empty($category_ids)) {
                    //check parent id and save it
                    $category_list = $this->model_category->getPostCategories($this->language_id);
                    $parent_ids = [];
                    foreach ($category_ids as $value) {
                        if (empty($category_list[$value])) {
                            continue;
                        }

                        $parent_ids = array_merge($parent_ids, get_parent_id($category_list, $value, 'category_id'));
                    }

                    if (!empty($parent_ids)) {
                        $category_ids = [];
                        foreach ($parent_ids as $value) {
                            $category_ids[$value] = $value;
                        }
                    }
                }

                $edit_data = [
                    'name'              => $this->request->getPost('name'),
                    'slug'              => !empty($this->request->getPost('slug')) ? slugify($this->request->getPost('slug')) : slugify($this->request->getPost('name')),
                    'description'       => $this->request->getPost('description'),
                    'content'           => $this->request->getPost('content'),
                    'meta_title'        => $this->request->getPost('meta_title'),
                    'meta_description'  => $this->request->getPost('meta_description'),
                    'meta_keyword'      => $this->request->getPost('meta_keyword'),
                    'publish_date'      => $publish_date,
                    'sort_order'        => $this->request->getPost('sort_order'),
                    'images'            => json_encode($this->request->getPost('images'), JSON_FORCE_OBJECT),
                    'tags'              => $this->request->getPost('tags'),
                    'author'            => $this->request->getPost('author'),
                    'category_ids'      => json_encode($category_ids, JSON_FORCE_OBJECT),
                    'related_ids'       => json_encode($this->request->getPost('related_ids'), JSON_FORCE_OBJECT),
                    'source_type'       => $this->request->getPost('source_type'),
                    'source'            => $this->request->getPost('source'),
                    'tracking_code'     => $this->request->getPost('tracking_code'),
                    'post_format'       => $this->request->getPost('post_format'),
                    'is_ads'            => !empty($this->request->getPost('is_ads')) ? STATUS_ON : STATUS_OFF,
                    'is_fb_ia'          => !empty($this->request->getPost('is_fb_ia')) ? STATUS_ON : STATUS_OFF,
                    'is_hot'            => !empty($this->request->getPost('is_hot')) ? STATUS_ON : STATUS_OFF,
                    'is_homepage'       => !empty($this->request->getPost('is_homepage')) ? STATUS_ON : STATUS_OFF,
                    'is_disable_follow' => !empty($this->request->getPost('is_disable_follow')) ? STATUS_ON : STATUS_OFF,
                    'is_disable_robot'  => !empty($this->request->getPost('is_disable_robot')) ? STATUS_ON : STATUS_OFF,
                    'ip'                => $this->request->getIPAddress(),
                    'user_id'           => $this->user->getId(),
                    'is_comment'        => $this->request->getPost('is_comment'),
                    'published'         => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
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

        $is_trash = $this->request->getGetPost('is_trash');

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            foreach ($ids as $id) {
                if (!empty($is_trash) && $is_trash == 1) {
                    $info = $this->model->find($id);
                } else {
                    $info = $this->model->onlyDeleted()->find($id);
                }

                if (empty($info)) {
                    json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
                }

                if (!empty($is_trash) && $is_trash == 1) {
                    $this->model->delete($id);
                } else {
                    $this->model->delete($id, true);
                }

                $this->model->deleteCache($id);
            }

            $message = lang('Admin.text_delete_success');
            if (!empty($is_trash) && $is_trash == 1) {
                $message = lang('Admin.text_trashed');
            }

            json_output(['token' => $token, 'status' => 'ok', 'ids' => $ids, 'msg' => $message]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $list_delete = [];
        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        foreach ($delete_ids as $id) {
            if (!empty($is_trash) && $is_trash == 1) {
                $list_delete[] = $this->model->find($id);
            } else {
                $list_delete[] = $this->model->onlyDeleted()->find($id);
            }
        }
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data = [
            'list_delete' => $list_delete,
            'ids'         => $this->request->getPost('delete_ids'),
            'is_trash'    => $is_trash
        ];

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
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

        $category_list = $this->model_category->getPostCategories($this->language_id);
        $data['categories_tree'] = format_tree(['data' => $category_list, 'key_id' => 'category_id']);

        //edit
        if (!empty($id)) {
            $data_form = $this->model->withDeleted()->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data_form = $this->model->formatDetail($data_form);

            if (!empty($data_form['related_ids'])) {
                $related_list = $this->model->getListByRelatedIds($data_form['related_ids']);
                if (!empty($related_list)) {
                    $data_form['related_list_html'] = $this->themes::view('related_list', ['related_list' => $related_list, 'is_checked' => true], true);
                }
            }

            $data['text_form'] = lang('Admin.text_edit');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/edit/$id");

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {

            if ($this->request->getGet('url')) {
                $scan_model = new \App\Modules\Scan\Models\ScanModel();
                $scan_content = $scan_model->getUrlData($this->request->getGet('url'));
                //cc_debug($scan_content);
                $data['edit_data'] = [
                    'name' => html_entity_decode($scan_content['title'] ?? ""),
                    'description' => html_entity_decode($scan_content['meta']['description']['value'] ?? ""),
                    'meta_title' => html_entity_decode($scan_content['title'] ?? ""),
                    'meta_description' => html_entity_decode($scan_content['meta']['description']['value'] ?? ""),
                    'meta_keyword' => html_entity_decode(($scan_content['meta']['keywords']['value'] ?? "") . ($scan_content['meta']['news_keywords']['value'] ?? "")),
                    'tags' => html_entity_decode(($scan_content['meta']['keywords']['value'] ?? "") . ($scan_content['meta']['news_keywords']['value'] ?? "")),
                    'url_image_fb' => $scan_content['meta']['image']['value'] ?? '',
                    'content' => html_entity_decode($scan_content['content'] ?? ""),
                    'source_type' => 2,
                    'source' => $this->request->getGet('url'),
                ];
                $data['url'] = $this->request->getGet('url');
            }

            $data['text_form'] = lang('Admin.text_add');
            $breadcrumb_url    = site_url(self::MANAGE_URL . "/add");
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        $this->validator->setRule('name', lang('NewsAdmin.text_name'), 'required');
        $this->validator->setRule('content', lang('NewsAdmin.text_content'), 'required');
        $this->validator->setRule('category_ids', lang('Admin.text_category'), 'required');

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

        $this->model->deleteCache($id);
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }

    public function status()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $id     = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $type   = $this->request->getPost('type');

        $item_edit = $this->model->find($id);
        if (empty($item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        if ($type == 'is_hot') {
            $item_edit['is_hot'] = !empty($status) ? STATUS_ON : STATUS_OFF;
        } else {
            //is_homepage
            $item_edit['is_homepage'] = !empty($status) ? STATUS_ON : STATUS_OFF;
        }


        if (!$this->model->update($id, $item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $this->model->deleteCache($id);
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }

    public function related()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($this->request->getPost())) {
            json_output(['status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $data = [
            'status' => 'ok',
            'view' => $this->themes::view('related_list', ['related_list' => $this->model->findRelated($this->request->getPost('related'))], true)
        ];

        json_output($data);
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

    public function robot()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $robot = Config('Robot');

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $list       = [];
        $robot_type = $this->request->getPost('robot_type');
        $robot_href = $this->request->getPost('robot_href');

        switch ($robot_type) {
            case 'kenh14':
                $kenh14 = $robot->pageKenh14Post;
                if (!empty($robot_href)) {
                    foreach ($kenh14['attribute_menu'] as $key => $value) {
                        if (!in_array($value['href'], $robot_href)) {
                            unset($kenh14['attribute_menu'][$key]);
                        }
                    }
                }
                $list = $this->model->robotGetNews($kenh14);
                break;
            default:
                break;
        }

        $total = 0;
        foreach ($list as $value) {
            if (empty($value['list_news'])) {
                continue;
            }
            $total += count($value['list_news']);
        }

        set_alert(lang('NewsAdmin.text_scanned', [$total]), ALERT_SUCCESS, ALERT_POPUP);
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('NewsAdmin.text_scanned', [$total])];

        json_output($data);
    }
}
