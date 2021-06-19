<?php namespace App\Modules\News\Models;

use App\Models\FarmModel;

class NewsModel extends FarmModel
{
    protected $table      = 'news';
    protected $primaryKey = 'news_id';

    protected $allowedFields = [
        'news_id',
        'name',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'language_id',
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
        'ctime',
        'mtime',
    ];

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    const NEWS_CACHE_NAME   = 'news_detail_id_';
    const NEWS_CACHE_EXPIRE = HOUR;

    const FORMAT_NEWS_ID = '%sC%s';

    function __construct()
    {
        parent::__construct();

        $this->setTableNameYear();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : "news_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        if (!empty($filter["ctime"])) {
            $this->setTableNameYear($filter["ctime"]);
        }

        if (!empty($filter["news_id"])) {
            $this->whereIn("news_id", (!is_array($filter["news_id"]) ? explode(',', $filter["news_id"]) : $filter["news_id"]));
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

        $result = $this->orderBy($sort, $order);

        return $result;
    }

    public function getNewsInfo($news_id, $ctime = null, $is_preview = false, $is_cache = true)
    {
        if (empty($news_id)) {
            return [];
        }

        if (strpos($news_id, 'C') !== FALSE) {
            list($news_id, $ctime) = $this->getFormatNewsId($news_id);
        }

        $result = $is_cache ? cache()->get(self::NEWS_CACHE_NAME . $news_id) : null;
        if (empty($result)) {

            $this->setTableNameYear($ctime);

            $where = [
                'news_id'         => $news_id,
                'published'       => STATUS_ON,
                'publish_date <=' => time(),
            ];
            if ($is_preview) {
                $where = [
                    'news_id' => $news_id,
                ];
            }
            $result = $this->where($where)->first();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::NEWS_CACHE_NAME . $news_id, $result, self::NEWS_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache($news_id)
    {
        if (strpos($news_id, 'C') !== FALSE) {
            list($news_id) = $this->getFormatNewsId($news_id);
        }

        cache()->delete(self::NEWS_CACHE_NAME . $news_id);
        return true;
    }

    public function setFormatNewsId($news_id, $ctime)
    {
        if (empty($news_id) || empty($ctime)) {
            return false;
        }

        return sprintf(self::FORMAT_NEWS_ID, $news_id, strtotime($ctime));
    }

    public function getFormatNewsId($news_id)
    {
        if (empty($news_id)) {
            return false;
        }

        $ids = explode("C", $news_id);
        if (count($ids) != 2) {
            return false;
        }

        return $ids;
    }

    public function formatImageList($image_robot = null, $image_fb = null, $image_thumb = null, $image_large = null)
    {
        return [
            'thumb'       => $image_thumb, //duong dan hinh tren server thumb small
            'thumb_large' => $image_large,
            'fb'          => $image_fb,
            'robot'       => $image_robot,
        ];
    }

    public function formatJsonDecode($data)
    {
        if (empty($data)) {
            return $data;
        }

        if (isset($data['images']) || isset($data['category_ids']) || isset($data['related_ids'])) {
            $data['images']       = json_decode($data['images'], true);
            $data['category_ids'] = json_decode($data['category_ids'], true);
            $data['related_ids']  = json_decode($data['related_ids'], true);
        } else {
            foreach ($data as $key => $value) {
                if (isset($value['images'])) {
                    $data[$key]['images'] = json_decode($value['images'], true);
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
}
