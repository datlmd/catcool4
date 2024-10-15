<?php namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class  ZoneModel extends MyModel
{
    protected $table      = 'country_zone';
    protected $primaryKey = 'zone_id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'zone_id',
        'country_id',
        'name',
        'code',
        'telephone_code',
        'published',
    ];

    const COUNTRY_ZONE_CACHE_NAME   = PREFIX_CACHE_NAME_MYSQL.'country_zone_list';
    const COUNTRY_ZONE_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sorts =[
            'c.name' => '`c`.`name`',
            'z.name' => '`z`.`name`',
            'zone_id' => '`z`.`zone_id`',
            'code' => '`z`.`code`',
            'telephone_code' => '`z`.`telephone_code`',
        ];
        $sort  = !empty($sorts[$sort]) ? $sorts[$sort] : '`z`.`zone_id`';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["zone"])) {
            $this->like('`z`.`name`', $filter["zone"]);
        }

        if (!empty($filter["country"])) {
            $this->like('`c`.`name`', $filter["country"]);
        }

        if (!empty($filter["code"])) {
            $this->like('`z`.`code`', $filter["code"]);
        }

        $this->from([], true)->from("`$this->table` `z`")
        ->select('`z`.*, `c`.`name` `country`')
        ->join('`country` `c`', '`c`.`country_id` = `z`.`country_id`');

        return $this->orderBy($sort, $order);
    }

    public function getZones($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::COUNTRY_ZONE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('name', 'ASC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::COUNTRY_ZONE_CACHE_NAME, $result, self::COUNTRY_ZONE_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::COUNTRY_ZONE_CACHE_NAME);
        return true;
    }

    public function getZonesDropdown($country_id = null)
    {
        $zones_list = [];

        $return = $this->getZones();
        if (empty($return)) {
            return $zones_list;
        }

        foreach ($return as $value) {
            if (!empty($country_id) && $value['country_id'] != $country_id) {
                continue;
            }
            $zones_list[$value['zone_id']] = $value['name'];
        }

        if (empty($zones_list)) {
            return $zones_list;
        }

        $zones_list[0] = lang('Country.text_select');

        return $zones_list;
    }
}
