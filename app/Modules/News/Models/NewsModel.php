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
    protected $deletedField   = 'deleted';

    const NEWS_CACHE_NAME   = 'news_detail_id_';
    const NEWS_CACHE_EXPIRE = HOUR;

    const FORMAT_NEWS_ID = '%sC%s';
    const SOURCE_TYPE_ROBOT = 1;
    const POST_FORMAT_NORMAL = 1;

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

    public function formatImageList($images = null)
    {
        return [
            'thumb'       => $images['thumb'] ?? null, //duong dan hinh tren server thumb small
            'thumb_large' => $images['thumb_large'] ?? null,
            'fb'          => $images['fb'] ?? null,
            'robot'       => $images['robot'] ?? null,
            'robot_fb'    => $images['robot_fb'] ?? null,
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

    public function robotSave($data, $status = STATUS_ON)
    {
        if (empty($data['title']) || empty($data['note']) || empty($data['content'])) {
            return false;
        }

        $db = db_connect();
        $db->reconnect();

        //reset table
        $this->setTableNameYear();

        $check_list = $this->where('source', $data['href'])->findAll();
        if (!empty($check_list)) {
            return false;
        }

        $image = "";
        if (!empty($data['image'])) {
            $image = save_image_from_url($data['image'], 'news');
        }
        $image_fb = "";
        if (!empty($data['image_fb'])) {
            $image_fb = save_image_from_url($data['image_fb'], 'news');
        }

        $date_now = get_date();

        if (!empty($data['tags'])) {
            $tags = is_array($data['tags']) ? implode(",", $data['tags']) : $data['tags'];
        } else {
            $tags = "";
        }

        $add_data = [
            'name'              => !empty($data['title']) ? html_entity_decode($data['title']) : "",
            'slug'              => !empty($data['title']) ? slugify(html_entity_decode($data['title'])) : "",
            'description'       => !empty($data['note']) ? html_entity_decode($data['note']) : "",
            'content'           => !empty($data['content']) ? html_entity_decode($data['content']) : "",
            'meta_title'        => !empty($data['title']) ? html_entity_decode($data['title']) : "",
            'meta_description'  => !empty($data['meta_description']) ? html_entity_decode($data['meta_description']) : "",
            'meta_keyword'      => !empty($data['meta_keyword']) ? html_entity_decode($data['meta_keyword']) : "",
            'related_ids'       => '',
            'category_ids'      => !empty($data['category_id']) ? json_encode($data['category_id'], JSON_FORCE_OBJECT) : "",
            'publish_date'      => $date_now,
            'images'            => json_encode($this->formatImageList(['robot' => $image, 'robot_fb' => $image_fb]), JSON_FORCE_OBJECT),
            'tags'              => html_entity_decode($tags),
            'author'            => !empty($data['author']) ? html_entity_decode($data['author']) : "",
            'source_type'       => self::SOURCE_TYPE_ROBOT,
            'source'            => !empty($data['href']) ? $data['href'] : "",
            'post_format'       => self::POST_FORMAT_NORMAL,
            'is_ads'            => STATUS_ON,
            'is_fb_ia'          => STATUS_ON,
            'is_hot'            => STATUS_OFF,
            'is_homepage'       => STATUS_OFF,
            'is_disable_follow' => STATUS_OFF,
            'is_disable_robot'  => STATUS_OFF,
            'ip'                => get_client_ip(),
            'user_id'           => session('admin.user_id'),
            'is_comment'        => COMMENT_STATUS_ON,
            'published'         => $status,
            'sort_order'        => 0,
            'language_id'       => get_lang_id(true),
        ];

        $id = $this->insert($add_data);

        return $id;
    }

    public function robotGetNews($attribute, $is_insert = true, $status = STATUS_ON)
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
                if (stripos($news['href'], "https://") !== false || stripos($news['href'], "http://") !== false) {
                    $url_detail = $news['href'];
                } else {
                    $url_detail = $url_domain . $news['href'];
                }

                $meta   = $robot->getMeta($attribute['attribute_meta'], $url_detail);
                $detail = $robot->getDetail($attribute['attribute_detail'], $url_detail, $url_domain);

                $content  = "";
                if (!empty($detail['content'])) {
                    $content = $detail['content'];
                    //$content = $this->robot->convert_image_to_base($detail['content']);
                    if (!empty($attribute['attribute_remove'])) {
                        $content = $robot->removeContentHtml($content, $attribute['attribute_remove']);
                    }
                }
                //lay hing dau tien trong noi dung
                $image_first = $robot->getImageFirst($content);

                $list_news[$news_key]['content']          = $content;
                $list_news[$news_key]['meta_description'] = !empty($meta['description']) ? $meta['description'] : '';
                $list_news[$news_key]['meta_keyword']     = !empty($meta['keywords']) ? $meta['keywords'] : '';
                $list_news[$news_key]['image']            = !empty($news['image']) ? $news['image'] : $image_first;
                $list_news[$news_key]['image_fb']         = !empty($meta['image_fb']) ? $meta['image_fb'] : $image_first;
                $list_news[$news_key]['category_id']      = $menu['id'];
                $list_news[$news_key]['href']             = $url_detail;

                $list_tags = $robot->getTags($attribute['attribute_tags'], $detail['html']);
                $list_news[$news_key]['tags'] = implode(",", $list_tags);

                if ($news_key % 10 == 0) {
                    sleep(1);
                }
            }

            $list_menu[$key]['list_news'] = $list_news;
        }

        if ($is_insert === true) {
            krsort($list_news);
            foreach ($list_menu as $key => $menu) {
                foreach ($list_news as $news_key => $news) {
                    $id = $this->robotSave($news, $status);
                    if (empty($id)) {
                        unset($list_menu[$key]);
                    }
                    sleep(1);
                }
            }
        }

        return $list_menu;
    }
}
