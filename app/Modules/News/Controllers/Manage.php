<?php namespace App\Modules\News\Controllers;

use App\Controllers\AdminController;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'news/manage';
    CONST MANAGE_URL  = 'news/manage';

    CONST SEO_URL_MODULE   = 'news';
    CONST SEO_URL_RESOURCE = 'News::Detail/%s';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new NewsModel();
        $this->model_category = new CategoryModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('NewsAdmin.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang("NewsAdmin.heading_title")], $this->themes);

        $news_id     = $this->request->getGet('news_id');
        $name        = $this->request->getGet('name');
        $category_id = $this->request->getGet('category_id');
        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');

        $filter = [
            'active'      => count(array_filter($this->request->getGet(['news_id', 'name', 'category_id', 'limit']))) > 0,
            'news_id'     => $news_id ?? "",
            'name'        => $name ?? "",
            'category_id' => $category_id ?? "",
            'limit'       => $limit,
        ];

        $list = $this->model->getAllByFilter($filter, $sort, $this->request->getGet('order'));

        $url = "";
        if (!empty($news_id)) {
            $url .= '&news_id=' . $news_id;
        }
        if (!empty($name)) {
            $url .= '&name=' . urlencode(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
        }
        if (!empty($category_id)) {
            $url .= '&category_id=' . $category_id;
        }
        if (!empty($limit)) {
            $url .= '&limit=' . $limit;
        }

        $category_list = $this->model_category->getListPublished();

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $this->model->formatJsonDecode($list->paginate($limit, 'news')),
            'pager'         => $list->pager,
            'filter'        => $filter,
            'sort'          => empty($sort) ? 'news_id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $url,
            'category_list' => format_tree(['data' => $category_list, 'key_id' => 'category_id']),
            'kenh14_list'   => Config('Robot')->pageKenh14,
        ];

        $this->themes::load('list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
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
                'category_ids'      => json_encode($this->request->getPost('category_ids'), JSON_FORCE_OBJECT),
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
                'user_id'           => $this->getUserIdAdmin(),
                'is_comment'        => $this->request->getPost('is_comment'),
                'published'         => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
                'language_id'       => get_lang_id(true),
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

        $this->_getForm();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('news_id')) {
            if (!$this->_validateForm()) {
                set_alert($this->errors, ALERT_ERROR);
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
                    'category_ids'      => json_encode($this->request->getPost('category_ids'), JSON_FORCE_OBJECT),
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
                    'user_id'           => $this->getUserIdAdmin(),
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

            $list_delete = $this->model->find($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids);

            //xoa slug ra khoi route
            foreach($list_delete as $value) {
                $this->model->deleteCache($value['news_id']);
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
        $this->themes->addJS('common/js/tinymce/tinymce.min');
        $this->themes->addJS('common/js/admin/tiny_content');
        $this->themes->addJS('common/js/admin/articles/articles');

        //add datetimepicker
        $this->themes->addCSS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (get_lang(true) == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        $this->themes->addJS('common/js/admin/filemanager');

        //add tags
        $this->themes->addCSS('common/js/tags/tagsinput');
        $this->themes->addJS('common/js/tags/tagsinput');

        $this->themes->addCSS('common/plugin/multi-select/css/bootstrap-multiselect.min');
        $this->themes->addJS('common/plugin/multi-select/js/bootstrap-multiselect.min');

        $data['language_list'] = get_list_lang(true);

        $category_list = $this->model_category->getListPublished();
        $data['categories_tree'] = format_tree(['data' => $category_list, 'key_id' => 'category_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('NewsAdmin.text_edit');

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data_form = $this->model->formatJsonDecode($data_form);

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('NewsAdmin.text_add');
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
        $this->validator->setRule('name', lang('NewsAdmin.text_name'), 'required');
        $this->validator->setRule('content', lang('NewsAdmin.text_content'), 'required');

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
                $kenh14 = $robot->pageKenh14;
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
