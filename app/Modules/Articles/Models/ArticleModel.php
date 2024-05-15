<?php namespace App\Modules\Articles\Models;

use App\Models\MyModel;

class ArticleModel extends MyModel
{
    protected $table      = 'article';
    protected $primaryKey = 'article_id';

    protected $table_lang = 'article_lang';
    protected $with       = ['article_lang', 'article_categories'];

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
        'deleted',
        'ctime',
        'mtime',
    ];

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    const ARTICLE_CACHE_NAME   = 'article_list';
    const ARTICLE_CACHE_EXPIRE = HOUR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.article_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());

        if (!empty($filter["article_id"])) {
            $this->whereIn("$this->table.article_id", (!is_array($filter["article_id"]) ? explode(',', $filter["article_id"]) : $filter["article_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

//        if (!empty($filter["category"])) {
//            $this->like("$this->table_lang.name", $filter["name"]);
//        }

        if (!empty($filter["published"])) {
            $this->where("$this->table.published", $filter["published"]);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.article_id = $this->table.article_id")
            ->orderBy($sort, $order);

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::ARTICLE_CACHE_NAME);
        return true;
    }
}
