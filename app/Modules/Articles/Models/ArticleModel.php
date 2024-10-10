<?php

namespace App\Modules\Articles\Models;

use App\Models\MyModel;

class ArticleModel extends MyModel
{
    protected $table = 'article';
    protected $table_lang = 'article_lang';
    protected $primaryKey = 'article_id';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'article_id',
        'publish_date',
        'is_comment',
        'is_toc',
        'images',
        'tags',
        'author',
        'source',
        'sort_order',
        'category_ids',
        'counter_view',
        'counter_comment',
        'counter_like',
        'published',
        'user_id',
        'ip',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    const ARTICLE_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'article_list';
    const ARTICLE_DETAIL_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'article_detail_id_';
    const ARTICLE_CACHE_EXPIRE = HOUR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.article_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());

        if (!empty($filter['article_id'])) {
            $this->whereIn("$this->table.article_id", (!is_array($filter['article_id']) ? explode(',', $filter['article_id']) : $filter['article_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

//        if (!empty($filter["category"])) {
//            $this->like("$this->table_lang.name", $filter["name"]);
//        }

        if (!empty($filter['published'])) {
            $this->where("$this->table.published", $filter['published']);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.article_id = $this->table.article_id")
            ->orderBy($sort, $order);

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::ARTICLE_CACHE_NAME);

        return true;
    }

    public function getArticlesByIds(array $article_ids, ?int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'DESC')
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $article_ids)
                ->findAll();

        return $result;
    }

    public function getArticles($language_id, $limit = PAGINATION_DEFAULF_LIMIT)
    {
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
            "$this->table_lang.language_id" => $language_id
        ];
        
        $result = $this->select("$this->table.article_id, name, description, slug, tags, author, counter_view, counter_comment, category_ids, publish_date, images")
            ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->where($where)
            ->orderBy('sort_order', 'DESC')
            ->orderBy('publish_date', 'DESC');

        $list = $result->paginate($limit);
        if (empty($list)) {
            return [[],[]];
        }

        return [$list, $result->pager];
    }

    public function getArticlesByCategoryId($category_id, $language_id, $limit = PAGINATION_DEFAULF_LIMIT)
    {
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
            "$this->table_lang.language_id" => $language_id
        ];
        
        $result = $this->select("$this->table.article_id, name, description, slug, tags, author, counter_view, counter_comment, category_ids, publish_date, images")
            ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->join("article_categories", "article_categories.article_id = $this->table.$this->primaryKey")
            ->where($where)
            ->where("article_categories.category_id = $category_id")
            ->orderBy('sort_order', 'DESC')
            ->orderBy('publish_date', 'DESC');

        $list = $result->paginate($limit);
        if (empty($list)) {
            return [[],[]];
        }
        
        return [$list, $result->pager];
    }

    public function getArticleInfo($article_id, $language_id, $is_cache = false)
    {
        if (empty($article_id)) {
            return [];
        }

        $where = [
            "$this->table.$this->primaryKey" => $article_id,
            'published' => STATUS_ON, 
            'publish_date <=' => get_date()
        ];

        $result = $is_cache ? cache()->get(self::ARTICLE_DETAIL_CACHE_NAME . $article_id) : null;
        if (empty($result)) {
            $result = $this
                ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->where($where)
                ->findAll();

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::ARTICLE_DETAIL_CACHE_NAME . $article_id, $result, self::ARTICLE_CACHE_EXPIRE);
            }
        }

        $result = $this->formatDataLanguage($result, $language_id);
        if (empty($result[$article_id])) {
            return [];
        }

        return $result[$article_id];
    }

    public function getUrl($article)
    {
        if (empty($article['article_id'])) {
            return "";
        }

        $href = site_url("article/{$article['article_id']}");
        if (!empty(config_item('seo_url'))) {
            $href = !empty($article['slug']) ? $article['slug'] : $article['name'];
            $href = get_seo_extension(clear_seo_extension($href) . "-" . SEO_ARTICLE_ID . $article['article_id']);
            $href = site_url($href);
        }

        return $href;
    }
}
