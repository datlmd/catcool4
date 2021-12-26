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

    const POST_CACHE_EXPIRE = HOUR;
    const POST_CACHE_DETAIL = 'post_detail_id_%s';

    const FORMAT_post_id = '%sc%s';
    const SOURCE_TYPE_ROBOT = 1;
    const POST_FORMAT_NORMAL = 1;

    const POST_DETAIL_FORMAT = "%s-post%s.html";

    private $_post_date_from = "3";

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

        $result = $this->select(['post_id', 'name', 'slug', 'description', 'category_ids', 'is_hot', 'is_homepage', 'publish_date', 'published', 'images', 'ctime'])
            ->orderBy($sort, $order);

        return $result;
    }

    public function getNewsInfo($post_id, $is_preview = false, $is_cache = true)
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

//        cache()->delete(self::NEWS_CACHE_CATEGORY_HOME);
//        cache()->delete(self::NEWS_CACHE_SLIDE_HOME);
//        cache()->delete(self::NEWS_CACHE_COUNTER_LIST);
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
}
