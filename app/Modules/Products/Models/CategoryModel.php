<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class CategoryModel extends MyModel
{
    protected $table      = 'product_category';
    protected $primaryKey = 'category_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'category_id',
        "image",
        "parent_id",
        "top",
        "column",
        'sort_order',
        'published',
        'ctime',
        'mtime',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'product_category_lang';
    protected $with = ['product_category_lang'];

    const CATEGORY_CACHE_NAME   = 'product_category_list';
    const CATEGORY_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.category_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["category_id"])) {
            $this->whereIn("$this->table.category_id", (!is_array($filter["category_id"]) ? explode(',', $filter["category_id"]) : $filter["category_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.category_id = $this->table.category_id")
            ->orderBy($sort, $order)->findAll();

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    public function getListPublished($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CATEGORY_CACHE_NAME) : null;
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
                cache()->save(self::CATEGORY_CACHE_NAME, $result, self::CATEGORY_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::CATEGORY_CACHE_NAME);
        return true;
    }
}
