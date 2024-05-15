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

    const NEWS_CACHE_EXPIRE = 10 * MINUTE; //10 phut
    const NEWS_CACHE_DETAIL = 'news_detail_id_%s_%s';
    const NEWS_CACHE_CATEGORY_HOME = 'news_category_home_list';
    const NEWS_CACHE_SLIDE_HOME = 'news_slide_home_list';
    const NEWS_CACHE_COUNTER_LIST = 'news_counter_list';
    const NEWS_CACHE_HOT_LIST = 'news_hot_list';
    const NEWS_CACHE_NEW_LIST = 'news_new_list';

    const FORMAT_NEWS_ID = '%sc%s';
    const SOURCE_TYPE_ROBOT = 1;
    const POST_FORMAT_NORMAL = 1;

    const NEWS_DETAIL_FORMAT = "%s-post%s.html";

    private $_news_date_from = "3";

    private $_queries = [
        'create_table' => "
            CREATE TABLE `TABLE_NAME` (
              `news_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL DEFAULT '',
              `slug` varchar(255) DEFAULT '',
              `description` varchar(255) DEFAULT NULL,
              `content` text NOT NULL,
              `meta_title` varchar(255) DEFAULT NULL,
              `meta_description` text,
              `meta_keyword` text,
              `category_ids` varchar(100) DEFAULT NULL,
              `related_ids` varchar(255) DEFAULT NULL,
              `publish_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `is_comment` tinyint(1) NOT NULL DEFAULT '1',
              `images` text,
              `tags` varchar(255) DEFAULT NULL,
              `author` varchar(100) DEFAULT NULL,
              `source_type` tinyint(1) DEFAULT '1',
              `source` varchar(255) DEFAULT NULL,
              `tracking_code` varchar(255) DEFAULT NULL,
              `post_format` tinyint(1) DEFAULT '1',
              `is_ads` tinyint(1) DEFAULT '0',
              `is_fb_ia` tinyint(1) DEFAULT '0',
              `is_hot` tinyint(1) DEFAULT '0',
              `is_homepage` tinyint(1) DEFAULT '0',
              `is_disable_follow` tinyint(1) DEFAULT '0',
              `is_disable_robot` tinyint(1) DEFAULT '0',
              `sort_order` int(3) DEFAULT '0',
              `user_id` int(11) NOT NULL DEFAULT '0',
              `ip` varchar(40) DEFAULT '0.0.0.0',
              `counter_view` int(11) DEFAULT '0',
              `counter_comment` int(11) DEFAULT '0',
              `counter_like` int(11) DEFAULT '0',
              `published` tinyint(1) NOT NULL DEFAULT '1',
              `deleted` datetime DEFAULT NULL,
              `language_id` int(11) DEFAULT NULL,
              `ctime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `mtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`news_id`),
              KEY `publish_date` (`publish_date`,`ctime`),
              KEY `published` (`published`,`deleted`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ",
    ];

    function __construct()
    {
        parent::__construct();

        $this->setTableNameYear();

        if (ENVIRONMENT == 'development') {
            $this->_news_date_from = "120"; // so ngay
        }
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : "news_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        if (!empty($filter["ctime"])) {
            $this->setTableNameYear($filter["ctime"]);
        }

        if (!empty($filter["news_id"])) {
            if (strpos($filter["news_id"], 'c') !== FALSE) {
                list($news_id, $ctime) = $this->getFormatNewsId($filter["news_id"]);
            } else {
                $news_id = $filter["news_id"];
            }
            if (!empty($ctime)) {
                $this->setTableNameYear($ctime);
            }

            $this->whereIn("news_id", (!is_array($news_id) ? explode(',', $news_id) : $news_id));
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

        $result = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'is_hot', 'is_homepage', 'publish_date', 'published', 'counter_view', 'images', 'ctime'])
            ->orderBy($sort, $order);

        return $result;
    }

    public function getNewsInfo($news_id, $ctime = null, $is_preview = false, $is_cache = true)
    {
        if (empty($news_id)) {
            return [];
        }

        if (strpos($news_id, 'c') !== FALSE) {
            list($news_id, $ctime) = $this->getFormatNewsId($news_id);
        }

        $cache_year = !empty($ctime) ? date("Y", $ctime) : date("Y", time());

        $cache_name = sprintf(self::NEWS_CACHE_DETAIL, $cache_year, $news_id);

        $result = $is_cache ? cache()->get($cache_name) : null;
        if (empty($result)) {

            $this->setTableNameYear($ctime);

            $where = [
                'news_id'         => $news_id,
                'published'       => STATUS_ON,
                'publish_date <=' => get_date(),
            ];
            if ($is_preview) {
                $where = [
                    'news_id'   => $news_id,
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
                cache()->save($cache_name, $result, self::NEWS_CACHE_EXPIRE);
            }
        } else {
            //get couter view
            $this->setTableNameYear($ctime);
            $counter = $this->select('counter_view')->where('news_id', $news_id)->first();
            if (!empty($counter)) {
                $result['counter_view'] = $counter['counter_view'];
            }
        }

        return $result;
    }

    /**
     * Su dung admin
     *
     * @param $news_id
     * @param null $ctime
     * @return array|bool|null|object
     */
    public function getInfo($news_id, $ctime = null)
    {
        if (empty($news_id)) {
            return false;
        }

        if (strpos($news_id, 'c') !== FALSE) {
            list($news_id, $ctime) = $this->getFormatNewsId($news_id);
        }

        $this->setTableNameYear($ctime);

        return $this->find($news_id);
    }

    public function deleteInfo($news_id, $ctime = null, $is_trash = false)
    {
        if (empty($news_id)) {
            return false;
        }

        if (strpos($news_id, 'c') !== FALSE) {
            list($news_id, $ctime) = $this->getFormatNewsId($news_id);
        }

        $this->setTableNameYear($ctime);

        return $this->delete($news_id, $is_trash);
    }

    public function updateInfo($data, $news_id, $ctime = null)
    {
        if (empty($news_id) || empty($data)) {
            return false;
        }

        if (strpos($news_id, 'c') !== FALSE) {
            list($news_id, $ctime) = $this->getFormatNewsId($news_id);
        }

        $this->setTableNameYear($ctime);

        return $this->update($news_id, $data);
    }

    public function updateView($news_id, $ctime = null)
    {
        if (empty($news_id)) {
            return false;
        }

        if (strpos($news_id, 'c') !== FALSE) {
            list($news_id, $ctime) = $this->getFormatNewsId($news_id);
        }

        $this->setTableNameYear($ctime);

        return $this->set('counter_view', 'counter_view + 1', false)->update($news_id);
    }

    public function deleteCache($news_id = null)
    {
        if (!empty($news_id)) {
            if (strpos($news_id, 'c') !== FALSE) {
                list($news_id, $ctime) = $this->getFormatNewsId($news_id);
            }

            $ctime = !empty($ctime) ? date("Y", $ctime) : date("Y", time());

            cache()->delete(sprintf(self::NEWS_CACHE_DETAIL, $ctime, $news_id));
        }

        cache()->delete(self::NEWS_CACHE_CATEGORY_HOME);
        cache()->delete(self::NEWS_CACHE_SLIDE_HOME);
        cache()->delete(self::NEWS_CACHE_COUNTER_LIST);
        cache()->delete(self::NEWS_CACHE_HOT_LIST);
        cache()->delete(self::NEWS_CACHE_NEW_LIST);

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

        if (is_numeric($news_id)) {
            return [$news_id, date("Y", time())];
        }

        $ids = explode("c", $news_id);
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
            $images       = $data['images'] ?? null;
            $category_ids = $data['category_ids'] ?? null;
            $related_ids  = $data['related_ids'] ?? null;

            $data['images'] = json_decode($images, true);
            $data['images'] = $this->formatImageList($data['images']);

            $data['category_ids'] = json_decode($category_ids, true);
            $data['related_ids']  = json_decode($related_ids, true);
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

        $data['news_id'] = $this->setFormatNewsId($data['news_id'], $data['ctime']);
        $data['detail_url'] = sprintf(self::NEWS_DETAIL_FORMAT, $data['slug'], $data['news_id']);

        return $this->formatJsonDecode($data);
    }

    public function robotSave($data, $status = STATUS_ON, $is_save_image = false)
    {
        helper('catcool');

        if (empty($data)) {
            return [];
        }

        $db = db_connect();
        $db->reconnect();

        //reset table
        $this->setTableNameYear();

        //lay danh sach tin lien quan, hien tai lay tat ca roi check relate
        $related_list = [];
        $related_result = cache()->get('news_robot_related_list');
        if (empty($related_result)) {
            $related_result = $this->select(['news_id', 'name', 'tags', 'slug', 'ctime'])
                ->orderBy('publish_date', 'DESC')
                ->where(['published' => STATUS_ON])
                ->findAll(1500);
            if (!empty($related_result)) {
                foreach ($related_result as $key_news => $value) {
                    $related_list[] = $this->formatDetail($value);
                }
            }
            cache()->save('news_robot_related_list', $related_result, 30 * MINUTE);
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

            $is_homepage = STATUS_OFF;
            if (!empty($image) && (strpos($image, 'http://') !== false || strpos($image, 'https://') !== false)) {
                $image_data = getimagesize($image);
                if (!empty($image_data[0]) && !empty($image_data[1])
                    && $image_data[0] >= 460 && $image_data[1] > 300
                    && isset($value['category_id']) && empty(array_diff($value['category_id'], [1, 7, 4, 3]))
                ) {
                    $is_homepage = STATUS_ON;
                }
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
                            $related_ids[] = $related['news_id'];
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
                'is_homepage'       => $is_homepage,
                'is_disable_follow' => STATUS_OFF,
                'is_disable_robot'  => STATUS_OFF,
                'ip'                => service('request')->getIPAddress(), //\CodeIgniter\HTTP\Request::getIPAddress()
                'user_id'           => 0,//session('user_info.user_id'),
                'is_comment'        => COMMENT_STATUS_ON,
                'published'         => $status,
                'sort_order'        => 0,
                'language_id'       => language_id_admin(),
            ];
        }

        if (!empty($insert_list)) {
            $this->insertBatch($insert_list);
        }

        return $insert_list;
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
            //check create table
            $this->createTable();

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

    public function robotDetail($url, $is_insert = true, $status = STATUS_ON)
    {
        if (empty($url)) {
            return [];
        }

        $robot = service('robot');

        $data = [];

        $domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
        $domain = strtolower($domain);

        $attribute_meta = [
            'title' => '/title>(.*?)<\/title/',
            'title_fb' => '/property=\"og:title\" content=\"(.*?)\"/',
            'description' => '/name=\"description\" content=\"(.*?)\"/',
            'description_fb' => '/property=\"og:description\" content=\"(.*?)\"/',
            'keywords' => '/name=\"keywords\" content=\"(.*?)\"/',
            'image_fb' => '/property=\"og:image\" content=\"(.*?)\"/',
        ];

        $attribute_detail['attribute_detail'] = [];

        switch ($domain) {
            case 'ngoisao.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.ct-content';
                break;
            case 'kenh14.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.knc-content';
                break;
            case 'zingnews.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.the-article-body';
                break;
            case 'vnexpress.net':
                $attribute_detail['attribute_detail']['content'] = 'article.fck_detail';
                break;
            case 'ngoisao.net':
                $attribute_detail['attribute_detail']['content'] = 'article.fck_detail';
                break;
            case '2sao.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.main-detail-content';
                break;
            case 'molistar.com':
                $attribute_detail['attribute_detail']['content'] = 'div.article-content';
                break;
            case 'thanhnien.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.details__content';
                break;
            case 'tuoitre.vn':
                $attribute_detail['attribute_detail']['content'] = 'div#main-detail-body';
                break;
            case '24h.com.vn':
                $attribute_detail['attribute_detail']['content'] = 'article#article_body';
                break;
            case 'dantri.com.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.dt-news__content';
                break;
            case 'eva.vn':
                $attribute_detail['attribute_detail']['content'] = 'div#baiviet-container';
                break;
            case 'vietnamnet.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.ArticleContent';
                break;
            case 'suckhoedoisong.vn':
                $attribute_detail['attribute_detail']['content'] = 'div#detail__contenent-main';
                break;
            case 'phapluatbandoc.giadinh.net.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.detail__content';
                break;
            case 'talkbeauty.vn':
                $attribute_detail['attribute_detail']['content'] = 'div.contentDetailWrap';
                break;
            case 'dulichchat.com':
                $attribute_detail['attribute_detail']['content'] = 'div.entry-content';
                break;
        }

        try {
            $meta = $robot->getMeta($attribute_meta, $url);
        } catch (\Exception $e) {
            $meta = [];
        }
        try {
            $detail = $robot->getDetail($attribute_detail, $url, $domain);
        } catch (\Exception $e) {
            $detail = [];
        }
        
        $content = !empty($detail['content']) ? $detail['content'] : "";

        //check image
        $content = $robot->convertImageData($content);

        //check video
        $content = $robot->convertVideoData($content);

        $name = !empty($meta['title']) ? $meta['title'] : (!empty($meta['title_fb']) ? $meta['title_fb'] : "");
        $description = !empty($meta['description']) ? $meta['description'] : (!empty($meta['description_fb']) ? $meta['description_fb'] : "");
        $keyword = !empty($meta['keywords']) ? $meta['keywords'] : "";

        $data = [
            'name'             => html_entity_decode($name),
            'description'      => html_entity_decode($description),
            'meta_title'       => html_entity_decode($name),
            'meta_description' => html_entity_decode($description),
            'meta_keyword'     => html_entity_decode($keyword),
            'tags'             => html_entity_decode($keyword),
            'url_image_fb'     => !empty($meta['image_fb']) ? $meta['image_fb'] : "",
            'content'          => html_entity_decode($content),
            'source_type'      => 2,
            'source'           => $url
        ];

        return $data;
    }

    public function getListHome($limit = 200, $is_cache = true)
    {
        $category_model = new CategoryModel();
        $category_list = $category_model->getNewsCategories(language_id());
        
        $list = $is_cache ? cache()->get(self::NEWS_CACHE_CATEGORY_HOME) : null;
        if (empty($list)) {

            $from_date = date('Y-m-d H:i:s', strtotime('-' . $this->_news_date_from . ' day', time()));

            $where = [
                'published'       => STATUS_ON,
                'publish_date <=' => get_date(),
                'publish_date >=' => $from_date,
            ];

            $list = $this->select(['news_id', 'name', 'slug', 'description', 'publish_date', 'images', 'category_ids', 'ctime'])
                ->orderBy('publish_date', 'DESC')
                ->where($where)
                ->findAll($limit);

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::NEWS_CACHE_CATEGORY_HOME, $list, self::NEWS_CACHE_EXPIRE);
            }
        }

        foreach ($category_list as $key => $category) {
            foreach ($list as $key_news => $value) {
                $value = $this->formatDetail($value);

                if (in_array($category['category_id'], $value['category_ids'])) {
                    $category_list[$key]['list'][] = $value;
                    if (count($category_list[$key]['list']) >= 5) {
                        break;
                    }
                }
            }
        }

        return $category_list;
    }

    public function getSlideHome($limit = 5, $is_cache = true)
    {
        $slides = $is_cache ? cache()->get(self::NEWS_CACHE_SLIDE_HOME) : null;
        if (empty($slides)) {
            $from_date = date('Y-m-d H:i:s', strtotime('-' . $this->_news_date_from . ' day', time()));
            $where = [
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
                'publish_date >=' => $from_date,
                'is_homepage' => STATUS_ON
            ];

            $list = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
                ->orderBy('publish_date', 'DESC')->where($where)->findAll($limit);
            if (empty($list)) {
                return [];
            }

            foreach ($list as $key_news => $value) {
                $slides[] = $this->formatDetail($value);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::NEWS_CACHE_SLIDE_HOME, $slides, self::NEWS_CACHE_EXPIRE);
            }
        }

        return $slides;
    }

    public function getListCounter($limit = 20, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::NEWS_CACHE_COUNTER_LIST) : null;
        if (empty($result)) {
            $from_date = date('Y-m-d H:i:s', strtotime('-' . $this->_news_date_from . ' day', time()));

            $where = [
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
                'publish_date >=' => $from_date,
            ];

            $list = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
                ->orderBy('counter_view', 'DESC')->where($where)->findAll($limit);
            if (empty($list)) {
                return [];
            }

            foreach ($list as $key_news => $value) {
                $result[] = $this->formatDetail($value);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::NEWS_CACHE_COUNTER_LIST, $result, self::NEWS_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function getListHot($limit = 20, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::NEWS_CACHE_HOT_LIST) : null;
        if (empty($result)) {

            $from_date = date('Y-m-d H:i:s', strtotime('-' . $this->_news_date_from .' day', time()));

            $where = [
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
                'publish_date >=' => $from_date,
                'is_hot' => STATUS_ON,
            ];

            $list = $this->select(['news_id', 'name', 'slug', 'description', 'content', 'category_ids', 'publish_date', 'images', 'ctime'])
                ->orderBy('publish_date', 'DESC')->where($where)->findAll($limit);
            if (empty($list)) {
                return [];
            }

            foreach ($list as $key_news => $value) {
                $result[] = $this->formatDetail($value);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::NEWS_CACHE_HOT_LIST, $result, self::NEWS_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function getListNew($limit = 20, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::NEWS_CACHE_NEW_LIST) : null;
        if (empty($result)) {
            $from_date = date('Y-m-d H:i:s', strtotime('-' . $this->_news_date_from . ' day', time()));

            $where = [
                'published' => STATUS_ON,
                'publish_date <=' => get_date(),
                'publish_date >=' => $from_date,
            ];

            $list = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
                ->orderBy('publish_date', 'DESC')->where($where)->findAll($limit);
            if (empty($list)) {
                return [];
            }

            foreach ($list as $key_news => $value) {
                $result[] = $this->formatDetail($value);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::NEWS_CACHE_NEW_LIST, $result, self::NEWS_CACHE_EXPIRE);
            }
        }

        return $result;
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

        $result = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
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

    public function getListByTag($tag = null, $limit = PAGINATION_DEFAULF_LIMIT)
    {
        if (empty($tag)) {
            return [[],[]];
        }

        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
        ];

        $result = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
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
        $result = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
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

    public function getListByRelatedIds($related_ids, $limit = 10)
    {
        if (empty($related_ids)) {
            return null;
        }

        $related_ids = is_array($related_ids) ? $related_ids : explode(',', $related_ids);

        $ctime = null;
        $news_ids = [];
        foreach($related_ids as $value) {
            list($news_id, $ctime) = $this->getFormatNewsId($value);
            $news_ids[] = $news_id;
        }

        $result = $this->select(['news_id', 'name', 'slug', 'description', 'category_ids', 'publish_date', 'images', 'ctime'])
            ->orderBy('publish_date', 'DESC')
            ->where(['published' => STATUS_ON])
            ->whereIn("news_id", $news_ids)
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

    public function createTable()
    {
        $db = db_connect();

        $prefix = $db->getPrefix();
        $tables = $db->listTables();

        $news_year  = date('Y', time());
        $table_name = sprintf('%snews_%s', $prefix, $news_year);

        if (in_array($table_name, $tables)) {
            return false;
        }

        try {
            $sql = str_ireplace('TABLE_NAME', $table_name, $this->_queries['create_table']);
            $db->query($sql);
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            return false;
        }

        return true;
    }
}
