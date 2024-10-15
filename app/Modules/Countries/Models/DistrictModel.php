<?php namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class  DistrictModel extends MyModel
{
    protected $table      = 'country_district';
    protected $primaryKey = 'district_id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'district_id',
        'zone_id',
        'name',
        'type',
        'lati_long_tude',
        'sort_order',
        'published',
    ];

    const COUNTRY_DISTRICT_CACHE_NAME   = PREFIX_CACHE_NAME_MYSQL.'country_district_list';
    const COUNTRY_DISTRICT_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sorts =[
            'zone' => '`z`.`name`',
            'name' => '`d`.`name`',
            'district_id' => '`d`.`zone_id`',
            'sort_order' => '`d`.`sort_order`',
            'type' => '`d`.`type`',
            'lati_long_tude' => '`d`.`lati_long_tude`',
        ];

        $sort  = !empty($sorts[$sort]) ? $sorts[$sort] : '`d`.`district_id`';
        $order = !empty($order) ? $order : 'DESC';

        if (!empty($filter["zone"])) {
            $this->Like('`z`.`name`', $filter["zone"]);
        }

        if (!empty($filter["name"])) {
            $this->Like('`d`.`name`', $filter["name"]);
        }

        $this->from([], true)->from("`$this->table` `d`")
        ->select('`d`.*, `z`.`name` `zone`, `c`.`name` `country`')
        ->join('`country_zone` `z`', '`z`.`zone_id` = `d`.`zone_id`', 'LEFT')
        ->join('`country` `c`', '`c`.`country_id` = `z`.`country_id`', 'LEFT');

        return $this->orderBy($sort, $order);
    }

    public function getDistricts($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::COUNTRY_DISTRICT_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'ASC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::COUNTRY_DISTRICT_CACHE_NAME, $result, self::COUNTRY_DISTRICT_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::COUNTRY_DISTRICT_CACHE_NAME);
        return true;
    }

    public function getDistrictsByZone($zone_id = null)
    {
        $district_list = [];

        $return = $this->getDistricts();
        if (empty($return)) {
            return $district_list;
        }

        foreach ($return as $value) {
            if (!empty($zone_id) && $value['zone_id'] != $zone_id) {
                continue;
            }
            $district_list[$value['district_id']] = $value['type'] . ' ' . $value['name'];
        }

        if (empty($district_list)) {
            return $district_list;
        }

        //$district_list[0] = lang('Country.text_select');

        return $district_list;
    }
}
