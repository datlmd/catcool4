<?php namespace App\Modules\Posts\Models;

use App\Models\MyModel;

class PostModel extends MyModel
{
    protected $table = 'post';
    protected $primaryKey = 'post_id';

    protected $allowedFields = [
        'post_id',
        'name',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'category_ids',
        'related_ids',
        'publish_date',
        'is_comment',
        'images',
        'tags',
        'author',
        'source_type',
        'source',
        'tracking_code',
        'post_format',
        'is_ads',
        'is_fb_ia',
        'is_hot',
        'is_homepage',
        'is_disable_follow',
        'is_disable_robot',
        'sort_order',
        'user_id',
        'ip',
        'counter_view',
        'counter_comment',
        'counter_like',
        'published',
        'deleted',
        'language_id',
        'ctime',
        'mtime',
    ];

    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted';

    const POST_CACHE_EXPIRE = DAY;
    const POST_CACHE_CATEGORY_HOME = 'post_category_home_list';
    const POST_CACHE_HOT_LIST = 'post_hot_list';
    const POST_CACHE_DETAIL = 'post_detail_id_%s';
    const POST_CACHE_LATEST_LIST = 'post_latest_list';

    const POST_DETAIL_FORMAT = "%s-post%s.html";

    private $_post_date_from = "3";

    const SOURCE_TYPE_ROBOT = 1;
    const POST_FORMAT_NORMAL = 1;

    private $_queries = [
        'post_all' => "SELECT * FROM `TABLE_NAME`",
        ];

    function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT == 'development') {
            $this->_post_date_from = "120"; // so ngay
        }
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? $sort : "post_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        if (!empty($filter["post_id"])) {
            $post_id = $filter["post_id"];

            $this->whereIn("post_id", (!is_array($post_id) ? explode(',', $post_id) : $post_id));
        }

        if (!empty($filter["name"])) {
            $this->like("name", $filter["name"]);
        }

        if (!empty($filter["category_id"])) {
            $this->like("category_ids", $filter["category_id"]);
        }

        if (!empty($filter["published"])) {
            $this->where("$this->table.published", $filter["published"]);
        }

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'is_hot', 'is_homepage', 'publish_date', 'published', 'counter_view', 'images', 'ctime'])
            ->orderBy($sort, $order);

        return $result;
    }

    public function getPostInfo($post_id, $is_preview = false, $is_cache = true)
    {
        if (empty($post_id)) {
            return [];
        }

        $cache_name = sprintf(self::POST_CACHE_DETAIL, $post_id);

        $result = $is_cache ? cache()->get($cache_name) : null;
        if (empty($result)) {

            $where = [
                'post_id' => $post_id,
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
            ];
            if ($is_preview) {
                $where = [
                    'post_id' => $post_id,
                    'published' => STATUS_OFF,
                ];
            }
            $result = $this->where($where)->first();
            if (empty($result)) {
                return [];
            }

            $result = $this->formatDetail($result);
            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save($cache_name, $result, self::POST_CACHE_EXPIRE);
            }
        } else {
            //get couter view
            $counter = $this->select('counter_view')->where('post_id', $post_id)->first();
            if (!empty($counter)) {
                $result['counter_view'] = $counter['counter_view'];
            }
        }

        return $result;
    }

    public function updateView($post_id)
    {
        if (empty($post_id)) {
            return false;
        }

        return $this->set('counter_view', 'counter_view + 1', false)->update($post_id);
    }

    public function deleteCache($post_id = null)
    {
        if (!empty($post_id)) {
            cache()->delete(sprintf(self::POST_CACHE_DETAIL, $post_id));
        }

        cache()->delete(self::POST_CACHE_LATEST_LIST);
        cache()->delete(self::POST_CACHE_CATEGORY_HOME);
        cache()->delete(self::POST_CACHE_HOT_LIST);
//        cache()->delete(self::NEWS_CACHE_HOT_LIST);
//        cache()->delete(self::NEWS_CACHE_NEW_LIST);

        return true;
    }

    public function formatImageList($images = null)
    {
        return [
            'thumb' => $images['thumb'] ?? null, //duong dan hinh tren server thumb small
            'thumb_large' => $images['thumb_large'] ?? null,
            'fb' => $images['fb'] ?? null,
            'robot' => $images['robot'] ?? null,
            'robot_fb' => $images['robot_fb'] ?? null,
        ];
    }

    public function formatJsonDecode($data)
    {
        if (empty($data)) {
            return $data;
        }

        if (isset($data['images']) || isset($data['category_ids']) || isset($data['related_ids'])) {
            $images = $data['images'] ?? null;
            $category_ids = $data['category_ids'] ?? null;
            $related_ids = $data['related_ids'] ?? null;

            $data['images'] = json_decode($images, true);
            $data['images'] = $this->formatImageList($data['images']);

            $data['category_ids'] = json_decode($category_ids, true);
            $data['related_ids'] = json_decode($related_ids, true);
        } else {
            foreach ($data as $key => $value) {
                if (isset($value['images'])) {
                    $data[$key]['images'] = json_decode($value['images'], true);
                    $data[$key]['images'] = $this->formatImageList($data[$key]['images']);
                }
                if (isset($value['category_ids'])) {
                    $data[$key]['category_ids'] = json_decode($value['category_ids'], true);
                }
                if (isset($value['related_ids'])) {
                    $data[$key]['related_ids'] = json_decode($value['related_ids'], true);
                }
            }
        }

        return $data;
    }

    public function formatDetail($data)
    {
        if (empty($data)) {
            return [];
        }

        $data['post_id'] = $data['post_id'];
        $data['detail_url'] = sprintf(self::POST_DETAIL_FORMAT, $data['slug'], $data['post_id']);

        return $this->formatJsonDecode($data);
    }

    public function getListByRelatedIds($related_ids, $limit = 10)
    {
        if (empty($related_ids)) {
            return null;
        }

        $related_ids = is_array($related_ids) ? $related_ids : explode(',', $related_ids);

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images'])
            ->orderBy('publish_date', 'DESC')
            ->where(['published' => STATUS_ON])
            ->whereIn("post_id", $related_ids)
            ->findAll($limit);


        if (empty($result)) {
            return [];
        }

        $list = [];
        foreach ($result as $key_news => $value) {
            $list[] = $this->formatDetail($value);
        }

        return $list;
    }

    public function getListTheSameCategory($category_ids, $post_id, $limit = 10)
    {
        $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images'])
            ->orderBy('publish_date', 'DESC')
            ->where([
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
                'post_id !=' => $post_id
            ]);

        if (!empty($category_ids)) {

            $this->groupStart();
            foreach ($category_ids as $category_id) {
                //format like: 1 or 10, 11
                // {"0":1} or {"0":1,"1":4}
                $category_id_1 = ":$category_id}";
                $category_id_2 = ":\"$category_id\"}";
                $category_id_3 = ":$category_id,";
                $category_id_4 = ":\"$category_id\",";

                $this->orLike('category_ids', $category_id_1)
                    ->orLike('category_ids', $category_id_2)
                    ->orLike('category_ids', $category_id_3)
                    ->orLike('category_ids', $category_id_4);
            }
            $this->groupEnd();
        }

        $result = $this->findAll($limit);
        if (empty($result)) {
            return [];
        }

        $list = [];
        foreach ($result as $key_news => $value) {
            $list[] = $this->formatDetail($value);
        }

        return $list;
    }

    public function getListByCategory($category_id = null, $limit = PAGINATION_DEFAULF_LIMIT)
    {
        if (empty($category_id)) {
            return [[],[]];
        }

        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
        ];

        //format like: 1 or 10, 11
        // {"0":1} or {"0":1,"1":4}
        $category_id_1 = ":$category_id}";
        $category_id_2 = ":\"$category_id\"}";
        $category_id_3 = ":$category_id,";
        $category_id_4 = ":\"$category_id\",";

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
            ->where($where)
            ->groupStart()
            ->like('category_ids', $category_id_1)
            ->orLike('category_ids', $category_id_2)
            ->orLike('category_ids', $category_id_3)
            ->orLike('category_ids', $category_id_4)
            ->groupEnd()
            ->orderBy('publish_date', 'DESC');

        $list = $result->paginate($limit);
        if (empty($list)) {
            return [[],[]];
        }

        foreach ($list as $key_news => $value) {
            $list[$key_news] = $this->formatDetail($value);
        }

        return [$list, $result->pager];
    }

    public function getListAll($limit = PAGINATION_DEFAULF_LIMIT)
    {
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
        ];

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
            ->where($where)
            ->orderBy('publish_date', 'DESC');

        $list = $result->paginate($limit);
        if (empty($list)) {
            return [[],[]];
        }

        foreach ($list as $key_news => $value) {
            $list[$key_news] = $this->formatDetail($value);
        }

        return [$list, $result->pager];
    }

    public function getListHot($limit = 20, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::POST_CACHE_HOT_LIST) : null;
        if (empty($result)) {

            $where = [
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
                'is_hot' => STATUS_ON,
            ];

            $list = $this->select(['post_id', 'name', 'slug', 'description', 'content', 'category_ids', 'publish_date', 'images', 'ctime'])
                ->orderBy('publish_date', 'DESC')->where($where)->findAll($limit);
            if (empty($list)) {
                return [];
            }

            foreach ($list as $key_news => $value) {
                $result[] = $this->formatDetail($value);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::POST_CACHE_HOT_LIST, $result, self::POST_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function getListByTag($tag = null, $limit = PAGINATION_DEFAULF_LIMIT)
    {
        if (empty($tag)) {
            return [[],[]];
        }

        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
        ];

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
            ->where($where)
            ->like('tags', $tag)
            ->orderBy('publish_date', 'DESC');

        $list = $result->paginate($limit);
        if (empty($list)) {
            return [[],[]];
        }

        foreach ($list as $key_news => $value) {
            $list[$key_news] = $this->formatDetail($value);
        }

        return [$list, $result->pager];
    }

    public function findRelated($related, $limit = 20)
    {
        if (empty($related)) {
            return null;
        }
        $related = trim($related);
        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
            ->orderBy('publish_date', 'DESC')
            ->groupStart()
            ->like("name", $related)
            ->orLike("tags", $related)
            ->groupEnd()
            ->where(['published' => STATUS_ON])
            ->findAll($limit);

        if (empty($result)) {
            return [];
        }

        $list = [];
        foreach ($result as $key_news => $value) {
            $list[] = $this->formatDetail($value);
        }

        return $list;
    }

    public function getListPostLatest($limit = 20, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::POST_CACHE_LATEST_LIST) : null;
        if (empty($result)) {

            $where = [
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
            ];

            $list = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
                ->orderBy('publish_date', 'DESC')->where($where)->findAll($limit);
            if (empty($list)) {
                return [];
            }

            foreach ($list as $key_news => $value) {
                $result[] = $this->formatDetail($value);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::POST_CACHE_LATEST_LIST, $result, self::POST_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function robotGetNews($attribute, $is_insert = true, $status = STATUS_ON, $is_save_image = false)
    {
        $robot = service('robot');

        $domain         = $attribute['domain'];
        $url_domain     = $attribute['url_domain'];
        $domain_id      = $attribute['domain_id'];
        $attribute_cate = $attribute['attribute_cate'];
        $list_menu      = $attribute['attribute_menu'];

        foreach ($list_menu as $key => $menu) {
            if (stripos($menu['href'], "https://") !== false || stripos($menu['href'], "http://") !== false) {
                $url = $menu['href'];
            } else {
                $url = $url_domain . str_replace(md5($url_domain), $url_domain, $menu['href']);
            }

            $list_news = $robot->getListNews($attribute_cate, $url_domain , $menu['title'], $url, $domain, 8);
            if (empty($list_news)) {
                continue;
            }

            foreach ($list_news as $news_key => $news) {
                try {
                    if (stripos($news['href'], "https://") !== false || stripos($news['href'], "http://") !== false) {
                        $url_detail = $news['href'];
                    } else {
                        $url_detail = $url_domain . $news['href'];
                    }

                    $meta = $robot->getMeta($attribute['attribute_meta'], $url_detail);
                    $detail = $robot->getDetail($attribute['attribute_detail'], $url_detail, $url_domain);

                    $content = "";
                    if (!empty($detail['content'])) {
                        $content = $detail['content'];
                        //$content = $this->robot->convert_image_to_base($detail['content']);
                        if (!empty($attribute['attribute_remove'])) {
                            $content = $robot->removeContentHtml($content, $attribute['attribute_remove']);
                        }

                        $content = $robot->convertVideoKenh14($content, $url);
                    }
                    //lay hing dau tien trong noi dung
                    $image_first = $robot->getImageFirst($content);

                    $list_news[$news_key]['content'] = $content;
                    $list_news[$news_key]['note'] = !empty($meta['description']) ? $meta['description'] : '';
                    $list_news[$news_key]['meta_description'] = !empty($meta['description']) ? $meta['description'] : '';
                    $list_news[$news_key]['meta_keyword'] = !empty($meta['keywords']) ? $meta['keywords'] : '';
                    $list_news[$news_key]['image'] = !empty($news['image']) ? $news['image'] : $image_first;
                    $list_news[$news_key]['image_fb'] = !empty($meta['image_fb']) ? $meta['image_fb'] : $image_first;
                    $list_news[$news_key]['category_id'] = $menu['id'];
                    $list_news[$news_key]['href'] = $url_detail;

                    $list_tags = $robot->getTags($attribute['attribute_tags'], $detail['html']);
                    $list_news[$news_key]['tags'] = implode(",", $list_tags);

//                if ($news_key % 10 == 0) {
//                    sleep(1);
//                }
                } catch (\Exception $e) {
                    continue;
                }
            }
            krsort($list_news);
            $list_menu[$key]['list_news'] = $list_news;
        }

        if ($is_insert === true) {
            foreach ($list_menu as $key => $menu) {
                if (!empty($menu['list_news'])) {
                    $menu['list_news'] = $this->robotSave($menu['list_news'], $status, $is_save_image);
                    usleep(500);
                }
            }
            $this->deleteCache();
        }

        return $list_menu;
    }

    public function robotSave($data, $status = STATUS_ON, $is_save_image = false)
    {
        helper('catcool');

        if (empty($data)) {
            return [];
        }

        //lay danh sach tin lien quan, hien tai lay tat ca roi check relate
        $related_list = [];
        $related_result = cache()->get('post_robot_related_list');
        if (empty($related_result)) {
            $related_result = $this->select(['post_id', 'name', 'tags', 'slug', 'ctime'])
                ->orderBy('publish_date', 'DESC')
                ->where(['published' => STATUS_ON])
                ->findAll(1500);
            if (!empty($related_result)) {
                foreach ($related_result as $key_news => $value) {
                    $related_list[] = $this->formatDetail($value);
                }
            }
            cache()->save('post_robot_related_list', $related_result, 30 * MINUTE);
        }

        $date_now = date("Y-m-d H:i:s", strtotime('-40 minutes', time()));

        $insert_list = [];
        foreach ($data as $key => $value) {

            if (empty($value['title']) || empty($value['note']) || empty($value['content'])) {
                continue;
            }

            $check_list = $this->where('source', $value['href'])->findAll();
            if (!empty($check_list)) {
                continue;
            }

            $image = "";
            if (!empty($value['image']) && $is_save_image) {
                $image = save_image_from_url($value['image'], 'news');
            } else {
                $image = $value['image'];
            }
            $image_fb = "";
            if (!empty($value['image_fb']) && $is_save_image) {
                $image_fb = save_image_from_url($value['image_fb'], 'news');
            } else {
                $image_fb = $value['image_fb'];
            }

            if (empty($image) || empty($image_fb)) {
                $status = STATUS_OFF;
            }

            $is_except = false;
            $except_list = ['quiz'];

            $title = html_entity_decode($value['title']);
            foreach ($except_list as $except_text) {
                if (strpos(strtolower($title), $except_text) !== FALSE) {
                    $is_except = true;
                }
            }

            if ($is_except) {
                continue;
            }

            $date_now = date("Y-m-d H:i:s", strtotime('+10 minutes', strtotime($date_now)));

            if (!empty($value['tags'])) {
                $tags = is_array($value['tags']) ? implode(",", $value['tags']) : $value['tags'];
            } else {
                $tags = "";
            }
            $tags = html_entity_decode($tags);

            //check related
            $related_ids = [];
            if (!empty($related_list)) {
                $tags_tmp = explode(",", $tags);
                if (!empty($tags_tmp[0]) && !empty($tags_tmp[1])) {
                    foreach ($related_list as $related) {
                        if (count($related_ids) >= 4) {
                            break;
                        }
                        if (strpos($related['tags'], $tags_tmp[0]) !== false || strpos($related['name'], $tags_tmp[0]) !== false
                            || strpos($related['tags'], $tags_tmp[1]) !== false || strpos($related['name'], $tags_tmp[1]) !== false
                        ) {
                            $related_ids[] = $related['post_id'];
                        }
                    }
                }
            }
            $related_ids = !empty($related_ids) ? json_encode($related_ids, JSON_FORCE_OBJECT) : '';
            //end related

            $insert_list[] = [
                'name'              => !empty($value['title']) ? html_entity_decode($value['title']) : "",
                'slug'              => !empty($value['title']) ? slugify(html_entity_decode($value['title'])) : "",
                'description'       => !empty($value['note']) ? html_entity_decode($value['note']) : "",
                'content'           => !empty($value['content']) ? html_entity_decode($value['content']) : "",
                'meta_title'        => !empty($value['title']) ? html_entity_decode($value['title']) : "",
                'meta_description'  => !empty($value['meta_description']) ? html_entity_decode($value['meta_description']) : "",
                'meta_keyword'      => !empty($value['meta_keyword']) ? html_entity_decode($value['meta_keyword']) : "",
                'related_ids'       => $related_ids,
                'category_ids'      => !empty($value['category_id']) ? json_encode($value['category_id'], JSON_FORCE_OBJECT) : "",
                'publish_date'      => $date_now,
                'images'            => json_encode($this->formatImageList(['robot' => $image, 'robot_fb' => $image_fb]), JSON_FORCE_OBJECT),
                'tags'              => $tags,
                'author'            => !empty($value['author']) ? html_entity_decode($value['author']) : "",
                'source_type'       => self::SOURCE_TYPE_ROBOT,
                'source'            => !empty($value['href']) ? $value['href'] : "",
                'post_format'       => self::POST_FORMAT_NORMAL,
                'is_ads'            => STATUS_ON,
                'is_fb_ia'          => STATUS_ON,
                'is_hot'            => STATUS_OFF,
                'is_homepage'       => STATUS_OFF,
                'is_disable_follow' => STATUS_OFF,
                'is_disable_robot'  => STATUS_OFF,
                'ip'                => get_client_ip(), //\CodeIgniter\HTTP\Request::getIPAddress()
                'user_id'           => session('admin.user_id'),
                'is_comment'        => COMMENT_STATUS_ON,
                'published'         => $status,
                'sort_order'        => 0,
            ];
        }

        if (!empty($insert_list)) {
            $this->insertBatch($insert_list);
        }

        return $insert_list;
    }

    public function getListCounter($limit = 20)
    {
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
        ];

        $list = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
            ->orderBy('counter_view', 'DESC')->where($where)->findAll($limit);
        if (empty($list)) {
            return [];
        }

        $result = [];
        foreach ($list as $key_news => $value) {
            $result[] = $this->formatDetail($value);
        }

        return $result;
    }
}
