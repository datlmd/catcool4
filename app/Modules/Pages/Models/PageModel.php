<?php namespace App\Modules\Pages\Models;

use App\Models\MyModel;

class PageModel extends MyModel
{
    protected $table      = 'page';
    protected $primaryKey = 'page_id';

    protected $table_lang = 'page_lang';
    protected $with       = ['page_lang'];

    protected $allowedFields = [
        'page_id',
        'body_class',
        'layout',
        'sort_order',
        'published',
        'deleted',
        'ctime',
        'mtime',
    ];

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    const PAGE_CACHE_NAME      = 'page_list';
    const ARTICLE_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.page_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));

        if (!empty($filter["page_id"])) {
            $this->whereIn("$this->table.page_id", (!is_array($filter["page_id"]) ? explode(',', $filter["page_id"]) : $filter["page_id"]));
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
            ->join($this->table_lang, "$this->table_lang.page_id = $this->table.page_id")
            ->orderBy($sort, $order);

        return $result;
    }

    public function getListPublished($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::PAGE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'DESC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return false;
            }

            $language_id = get_lang_id(true);
            foreach ($result as $key => $value) {
                $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::PAGE_CACHE_NAME, $result, self::ARTICLE_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::PAGE_CACHE_NAME);
        return true;
    }
}
