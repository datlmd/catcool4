<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductModel extends MyModel
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'master_id',
        'model',
        'sku',
        'upc',
        'ean',
        'jan',
        'isbn',
        'mpn',
        'location',
        'variant',
        'override',
        'quantity',
        'minimum',
        'subtract',
        'stock_status_id',
        'image',
        'manufacturer_id',
        'shipping',
        'price',
        'points',
        'tax_class_id',
        'date_available',
        'weight',
        'weight_class_id',
        'length',
        'length_class_id',
        'width',
        'height',
        'sort_order',
        'published',
        'viewed',
        'is_comment',
        'created_at',
        'updated_at',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'product_lang';

    const CATEGORY_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'product_list';
    const CATEGORY_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.product_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['product_id'])) {
            $this->whereIn("$this->table.product_id", (!is_array($filter['product_id']) ? explode(',', $filter['product_id']) : $filter['product_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.product_id = $this->table.product_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getProductsByIds(array $product_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $product_ids)
                ->findAll();

        return $result;
    }

    public function findRelated($related, $language_id, $id = null, $limit = 20)
    {
        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->orderBy("$this->table.product_id", 'DESC')
            ->groupStart()
            ->like("$this->table_lang.name", trim($related))
            ->orLike("$this->table_lang.tag", trim($related))
            ->groupEnd();
            //->where("$this->table_lang.language_id", $language_id);

        if (!empty($id)) {
            $this->where("$this->table.product_id !=", $id);
        }

        $result = $this->findAll($limit);

        if (empty($result)) {
            return [];
        }

        foreach ($result as $key => $value) {
            if ($value['language_id'] != $language_id) {
                unset($result[$key]);
            }
        }

        return $result;
    }

    public function getListByRelatedIds($related_ids, $language_id, $limit = 10)
    {
        if (empty($related_ids)) {
            return [];
        }

        $related_ids = is_array($related_ids) ? $related_ids : explode(',', $related_ids);

        $result = $this
                ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy("$this->table.product_id", 'DESC')
                //->where(['published' => STATUS_ON])
                ->whereIn("$this->table.product_id", $related_ids)
                ->where("$this->table_lang.language_id", $language_id)
                ->findAll($limit);

        return $result;
    }
}
