<?php

namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class WardModel extends MyModel
{
    protected $table      = 'country_ward';
    protected $primaryKey = 'ward_id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'ward_id',
        'district_id',
        'name',
        'type',
        'lati_long_tude',
        'sort_order',
        'published',
    ];

    public const COUNTRY_WARD_CACHE_NAME   = PREFIX_CACHE_NAME_MYSQL.'country_ward_list';
    public const COUNTRY_WARD_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sorts = [
            'district' => '`d`.`name`',
            'name' => '`w`.`name`',
            'ward_id' => '`w`.`ward_id`',
            'sort_order' => '`w`.`sort_order`',
            'type' => '`w`.`type`',
            'lati_long_tude' => '`w`.`lati_long_tude`',
        ];

        $sort  = !empty($sorts[$sort]) ? $sorts[$sort] : '`w`.`ward_id`';
        $order = !empty($order) ? $order : 'DESC';

        if (!empty($filter["name"])) {
            $this->like('`w`.`name`', $filter["name"]);
        }

        if (!empty($filter["district"])) {
            $this->like('`d`.`name`', $filter["district"]);
        }

        $this->from([], true)->from("`$this->table` `w`")
        ->select('`w`.*, `d`.`name` `district`, `z`.`name` `zone`')
        ->join('`country_district` `d`', '`d`.`district_id` = `w`.`district_id`', 'LEFT')
        ->join('`country_zone` `z`', '`z`.`zone_id` = `d`.`zone_id`', 'LEFT');

        return $this->orderBy($sort, $order);
    }

    public function getWards($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::COUNTRY_WARD_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'ASC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::COUNTRY_WARD_CACHE_NAME, $result, self::COUNTRY_WARD_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::COUNTRY_WARD_CACHE_NAME);
        return true;
    }

    public function getWardsByDistrict($district_id = null)
    {
        $ward_list = [];

        $return = $this->getWards();
        if (empty($return)) {
            return $ward_list;
        }

        foreach ($return as $value) {
            if (!empty($district_id) && $value['district_id'] != $district_id) {
                continue;
            }
            $ward_list[$value['ward_id']] = $value['type'] . ' ' . $value['name'];
        }

        if (empty($ward_list)) {
            return $ward_list;
        }

        return $ward_list;
    }
}
