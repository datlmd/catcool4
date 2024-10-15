<?php namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class  DistrictModel extends MyModel
{
    protected $table      = 'country_district';
    protected $primaryKey = 'district_id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';

    protected $allowedFields = [
        'district_id',
        'zone_id',
        'name',
        'type',
        'lati_long_tude',
        'sort_order',
        'published',
        'deleted_at',
    ];

    const COUNTRY_DISTRICT_CACHE_NAME   = PREFIX_CACHE_NAME_MYSQL.'country_district_list';
    const COUNTRY_DISTRICT_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'district_id';
        $order = $order ?? 'DESC';

        if (!empty($filter["zone_id"])) {
            $this->whereIn('zone_id', (is_array($filter["zone_id"])) ? $filter["zone_id"] : explode(',', $filter["zone_id"]));
        }

        if (!empty($filter["name"])) {
            $this->Like('name', $filter["name"]);
        }

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

    public function getDistrictsDropdown($zone_id = null)
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

        $district_list[0] = lang('Country.text_select');

        return $district_list;
    }
}
