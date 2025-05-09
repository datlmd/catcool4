<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;
use CodeIgniter\Database\RawSql;

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
        'rating',
        'is_comment',
        'created_at',
        'updated_at',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'product_lang';

    public const CATEGORY_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'product_list';
    public const CATEGORY_CACHE_EXPIRE = YEAR;

    private $_queries = [

    ];

    public function __construct()
    {
        parent::__construct();

        // Storing some sub queries so that we are not typing them out multiple times.
        $this->_queries['discount'] = "(SELECT `pd2`.`price` FROM `" . $this->db->getPrefix() . "product_discount` `pd2` WHERE `pd2`.`product_id` = `p`.`product_id` AND `pd2`.`customer_group_id` = '" . (int)config_customer_group_id() . "'AND `pd2`.`quantity` = '1' AND ((`pd2`.`date_start` = '0000-00-00' OR `pd2`.`date_start` < NOW()) AND (`pd2`.`date_end` = '0000-00-00' OR `pd2`.`date_end` > NOW())) ORDER BY `pd2`.`priority` ASC, `pd2`.`price` ASC LIMIT 1) AS `discount`";
        $this->_queries['special'] = "(SELECT `ps`.`price` FROM `" . $this->db->getPrefix() . "product_special` `ps` WHERE `ps`.`product_id` = `p`.`product_id` AND `ps`.`customer_group_id` = '" . (int)config_customer_group_id() . "' AND ((`ps`.`date_start` = '0000-00-00' OR `ps`.`date_start` < NOW()) AND (`ps`.`date_end` = '0000-00-00' OR `ps`.`date_end` > NOW())) ORDER BY `ps`.`priority` ASC, `ps`.`price` ASC LIMIT 1) AS `special`";
        $this->_queries['reward'] = "(SELECT `pr`.`points` FROM `" . $this->db->getPrefix() . "product_reward` `pr` WHERE `pr`.`product_id` = `p`.`product_id` AND `pr`.`customer_group_id` = '" . (int)config_customer_group_id() . "') AS `reward`";
        $this->_queries['review'] = "(SELECT COUNT(*) FROM `" . $this->db->getPrefix() . "review` `r` WHERE `r`.`product_id` = `p`.`product_id` AND `r`.`status` = '1' GROUP BY `r`.`product_id`) AS `reviews`";
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

    // ************* Frontend *************

    /**
     * @param array $data
     *
     * @return array
     */
    public function getProducts(array $data = [], int $language_id, ?bool $is_cache = false): array
    {
        $select = "`p`.*, `pl`.*, " . $this->_queries['discount'] . ", " . $this->_queries['special'] . ", " . $this->_queries['reward'];
        $where = "`p`.`published` = '1' AND `p`.`date_available` <= NOW()";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $implode = [];

                $category_ids = is_array($data['filter_category_id']) ? $data['filter_category_id'] : explode(',', $data['filter_category_id']);

                foreach ($category_ids as $category_id) {
                    $implode[] = (int)$category_id;
                }

                $where .= " AND `pc`.`category_id` IN (" . implode(',', $implode) . ")";
            } else {
                $where .= " AND `pc`.`category_id` = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = [];

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $where .= " AND `pf`.`filter_id` IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_search']) || !empty($data['filter_tag'])) {
            $where .= " AND (";

            if (!empty($data['filter_search'])) {
                $implode = [];

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_search'])));

                foreach ($words as $word) {
                    $implode[] = "`pl`.`name` LIKE '" . $this->db->escape('%' . $word . '%') . "'";
                }

                if ($implode) {
                    $where .= " (" . implode(" OR ", $implode) . ")";
                }

                if (!empty($data['filter_description'])) {
                    $where .= " OR `pl`.`description` LIKE '" . $this->db->escape('%' . (string)$data['filter_search'] . '%') . "'";
                }
            }

            if (!empty($data['filter_search']) && !empty($data['filter_tag'])) {
                $where .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $implode = [];

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

                foreach ($words as $word) {
                    $implode[] = "`pl`.`tag` LIKE '" . $this->db->escape('%' . $word . '%') . "'";
                }

                if ($implode) {
                    $where .= " (" . implode(" OR ", $implode) . ")";
                }
            }

            if (!empty($data['filter_search'])) {
                $where .= " OR LCASE(`p`.`model`) = '" . $this->db->escape(strtolower($data['filter_search'])) . "'";
                $where .= " OR LCASE(`p`.`sku`) = '" . $this->db->escape(strtolower($data['filter_search'])) . "'";
                $where .= " OR LCASE(`p`.`upc`) = '" . $this->db->escape(strtolower($data['filter_search'])) . "'";
                $where .= " OR LCASE(`p`.`ean`) = '" . $this->db->escape(strtolower($data['filter_search'])) . "'";
                $where .= " OR LCASE(`p`.`jan`) = '" . $this->db->escape(strtolower($data['filter_search'])) . "'";
                $where .= " OR LCASE(`p`.`isbn`) = '" . $this->db->escape(strtolower($data['filter_search'])) . "'";
                $where .= " OR LCASE(`p`.`mpn`) = '" . $this->db->escape(strtolower($data['filter_search'])) . "'";
            }

            $where .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $where .= " AND `p`.`manufacturer_id` = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $sort = "";
        $sort_data = [
            '`pd`.name',
            '`p`.model',
            '`p`.quantity',
            '`p`.price',
            'rating',
            '`p`.sort_order',
            '`p`.date_added'
        ];

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == '`pd`.name' || $data['sort'] == '`p`.model') {
                $sort .= "LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == '`p`.price') {
                $sort .= "(CASE WHEN `special` IS NOT NULL THEN `special` WHEN `discount` IS NOT NULL THEN `discount` ELSE `p`.`price` END)";
            } else {
                $sort .= $data['sort'];
            }
        } else {
            $sort .= "`p`.`sort_order`";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sort .= " DESC, LCASE(`pl`.`name`) DESC";
        } else {
            $sort .= " ASC, LCASE(`pl`.`name`) ASC";
        }

        $this->from([], true)->from('`product` `p`')->join("`product_lang` `pl`", "`pl`.`product_id` = `p`.`product_id`");
        if (!empty($data['filter_category_id'])) {
            $this->join("`product_categories` `pc`", "`pc`.`product_id` = `p`.`product_id`", 'LEFT');

            if (!empty($data['filter_filter'])) {
                $this->join("`product_filter` `pf`", "`pf`.`product_id` = `p`.`product_id`", 'LEFT');
            }
        }
        $result = $this->select($select)->where($where)->orderBy($sort);

        $limit = PAGINATION_DEFAULF_LIMIT;
        if (!empty($data['limit']) && $data['limit'] > 1) {
            $limit = (int)$data['limit'];
        }

        $list = $result->paginate($limit);
        if (empty($list)) {
            return [[],[]];
        }

        return [$list, $result->pager];
    }

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
}
