<?php namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class  DistrictModel extends MyModel
{
    protected $table      = 'country_district';
    protected $primaryKey = 'district_id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    protected $allowedFields = [
        'district_id',
        'province_id',
        'name',
        'type',
        'lati_long_tude',
        'sort_order',
        'published',
        'deleted',
    ];

    const COUNTRY_DISTRICT_CACHE_NAME   = 'country_district_list';
    const COUNTRY_DISTRICT_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'district_id';
        $order = $order ?? 'DESC';

        if (!empty($filter["province_id"])) {
            $this->whereIn('province_id', (is_array($filter["province_id"])) ? $filter["province_id"] : explode(',', $filter["province_id"]));
        }

        if (!empty($filter["name"])) {
            $this->Like('name', $filter["name"]);
        }

        return $this->orderBy($sort, $order);
    }

    public function getListPublished($is_cache = true)
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

    public function getListDisplay($province_id = null)
    {
        $return = $this->getListPublished();
        if (empty($return)) {
            return false;
        }

        $province_id = (int) str_ireplace('"', "", $province_id);

        $district_list[0] = lang('Country.text_select');
        foreach ($return as $value) {
            if (!empty($province_id) && $value['province_id'] != (int)$province_id) {
                continue;
            }
            $key = sprintf('"%s"', $value['district_id']);
            $district_list[$key] = $value['type'] . ' ' . $value['name'];
        }

        return $district_list;
    }
}
