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
        'images',
        'categories',
        'tags',
        'author',
        'source',
        'sort_order',
        'user_id',
        'user_ip',
        'counter_view',
        'counter_comment',
        'counter_like',
        'published',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    const ARTICLE_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'article_list';
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
}
