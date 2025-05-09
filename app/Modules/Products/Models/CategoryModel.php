<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class CategoryModel extends MyModel
{
    protected $table = 'product_category';
    protected $primaryKey = 'category_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'category_id',
        'image',
        'parent_id',
        'top',
        'column',
        'sort_order',
        'published',
        'created_at',
        'updated_at',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'product_category_lang';

    public const CATEGORY_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'product_category_list';
    public const CATEGORY_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.category_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['category_id'])) {
            $this->whereIn("$this->table.category_id", (!is_array($filter['category_id']) ? explode(',', $filter['category_id']) : $filter['category_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.category_id = $this->table.category_id")
            ->orderBy($sort, $order)->findAll();

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    public function getProductCategoriesByIds(array $category_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $category_ids)
                ->findAll();

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::CATEGORY_CACHE_NAME);

        return true;
    }

    /** -------- Fronted -------- */
    public function getProductCategories($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CATEGORY_CACHE_NAME) : null;

        if (empty($result)) {
            $result = $this->select("$this->table.category_id, name, $this->table_lang.description, slug, image, meta_title, meta_description, meta_keyword, sort_order, language_id, parent_id")
                ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->where(['published' => STATUS_ON])
                ->orderBy('sort_order', 'DESC')
                //->orderBy("LCASE($this->table_lang.name)", 'ASC')
                ->findAll();

            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::CATEGORY_CACHE_NAME, $result, self::CATEGORY_CACHE_EXPIRE);
            }
        }

        return $this->formatDataLanguage($result, $language_id);
    }

    /**
     * format default: product/category/id - name-pc3(.html)
     * format slug: seo-title(.html)
     */
    public function getUrl($category): string
    {
        if (empty($category['category_id'])) {
            return "";
        }

        $href = site_url("product/category/{$category['category_id']}");
        if (!empty(config_item('seo_url'))) {
            try {
                $route_url = url_to('\App\Modules\Products\Controllers\Category::index/' . $category['category_id']);
            } catch (\Exception $ex) {
                $route_url = "";
            }

            $href = $category['name'] . "-{$category['category_id']}" . SEO_PRODUCT_CATEGORY_ID;
            if (!empty($category['slug']) && clear_seo_extension($category['slug']) == clear_seo_extension($route_url)) {
                $href = $category['slug'];
            }
            //url_to('\App\Modules\Products\Controllers\Category::index/' . $category_id);
            $href = get_seo_extension(clear_seo_extension($href));

            $href = site_url($href);
        }

        return $href;
    }

    public function getChildrenQuantity($list, $data_tree)
    {
        if (empty($data_tree)) {
            return $list;
        }

        foreach ($data_tree as $key => $value) {
            if (empty($value['subs'])) {
                $list[$key]['count'] = 0;
                continue;
            }

            $quantity = count($value['subs']);

            $list = $this->getChildrenQuantity($list, $value['subs']);
            foreach ($value['subs'] as $key_sub => $value_sub) {
                $quantity += $list[$key_sub]['count'];
            }

            $list[$key]['subs'] = $value['subs'];
            $list[$key]['count'] = $quantity;
        }

        return $list;
    }
}
