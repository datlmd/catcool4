<?php namespace App\Modules\Posts\Models;

use App\Models\MyModel;
use CodeIgniter\Database\RawSql;

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
        'language_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    const POST_CACHE_EXPIRE = DAY;
    const POST_CACHE_CATEGORY_HOME = PREFIX_CACHE_NAME_MYSQL.'post_category_home_list';
    const POST_CACHE_HOT_LIST = PREFIX_CACHE_NAME_MYSQL.'post_hot_list';
    const POST_CACHE_DETAIL = PREFIX_CACHE_NAME_MYSQL.'post_detail_id_%s';
    const POST_CACHE_LATEST_LIST = PREFIX_CACHE_NAME_MYSQL.'post_latest_list';

    const POST_DETAIL_FORMAT = "%s-post%s.html";

    private $_post_date_from = "3";

    const SOURCE_TYPE_ROBOT = 1;

    const POST_FORMAT_NORMAL = 1;
    const POST_FORMAT_LESSON = 4;

    private $_queries = [
        'post_all' => "SELECT * FROM `TABLE_NAME`",
        ];

    function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT == 'development') {
            $this->_post_date_from = "120"; // so ngay
        }

        $this->_queries['list_post_group_by_category'] = "SELECT `category_id`, `post_id`, `name`, `slug`, `description`, `category_ids`, `publish_date`, `images`, `created_at`, `post_format`, `tags`
            FROM (
                SELECT `c`.`category_id`, `p`.`post_id`, `p`.`name`, `p`.`slug`, `p`.`description`, `p`.`category_ids`, `p`.`publish_date`, `p`.`images`, `p`.`created_at`, `p`.`post_format`, `p`.`tags`, 
                    row_number() OVER (PARTITION BY `c`.`category_id` ORDER BY `p`.`post_id` DESC) AS `row`
                FROM `" . $this->db->prefixTable('post') ."` AS `p` INNER JOIN `" . $this->db->prefixTable('post_categories') . "` AS `c` ON `p`.`post_id` = `c`.`post_id` 
                WHERE `p`.`publish_date` <= ? AND `p`.`published` = 1
                ORDER BY `p`.`publish_date` DESC
            ) AS `POST`
            WHERE `row` <= ?";
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

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'is_hot', 'is_homepage', 'publish_date', 'published', 'counter_view', 'images', 'created_at'])
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

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'created_at'])
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

    /**
     * Goi danh sach bai hoc
     */
    public function getLessons($category_id)
    {
        if (empty($category_id)) {
            return [];
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

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'sort_order'])
            ->where($where)
            ->groupStart()
            ->like('category_ids', $category_id_1)
            ->orLike('category_ids', $category_id_2)
            ->orLike('category_ids', $category_id_3)
            ->orLike('category_ids', $category_id_4)
            ->groupEnd()
            ->orderBy('sort_order')
            ->findAll();
        
        if (empty($result)) {
            return [[]];
        }

        //array_map formatDetail Post & news
        $result = array_map(function($value) {
            return $this->formatDetail($value);
        }, $result);

        $lesons = [];
        foreach ($result as $value) {
            if (empty($value['category_ids'])) {
                continue;
            }
            foreach ($value['category_ids'] as $id) {
                $lesons[$id][] = $value;
            }
        }

        return $lesons;
    }

    public function getLatestPostsHome($limit = PAGINATION_DEFAULF_LIMIT, $post_id = null)
    {
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
            'post_format !=' => self::POST_FORMAT_LESSON,
        ];

        if (!empty($post_id)) {
            $where['post_id <'] = (int) ($post_id ?? 1);
        }

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'tags', 'created_at'])
            ->where($where)
            ->orderBy('publish_date', 'DESC')->findAll($limit);

        if (empty($result)) {
            return [];
        }

        $list = [];
        foreach ($result as $key_news => $value) {
            $list[$key_news] = $this->formatDetail($value);
        }

        return $list;
    }

    public function getListHot($limit = 20, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::POST_CACHE_HOT_LIST) : null;
        if (empty($result)) {

            $where = [
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
                'is_hot' => STATUS_ON,
                'post_format !=' => self::POST_FORMAT_LESSON,
            ];

            $list = $this->select(['post_id', 'name', 'slug', 'description', 'content', 'category_ids', 'publish_date', 'images', 'created_at'])
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

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'created_at'])
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
        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'created_at'])
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
                'post_format !=' => self::POST_FORMAT_LESSON,
            ];

            $list = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'created_at'])
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

    public function getListCounter($limit = 20)
    {
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
            'post_format !=' => self::POST_FORMAT_LESSON,
        ];

        $list = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'created_at'])
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

    public function getPostsGroupByCategory($limit = 5)
    {
        $list = [];
        try {
            $params = [get_date(), $this->db->escape($limit)];
            $result = $this->db->query($this->_queries['list_post_group_by_category'], $params)->getResultArray();
            foreach ($result as $value) {
                $list[$value['category_id']][] = $this->formatDetail($value);
            }
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());

            return $list;
        }

        return $list;
    }
}
