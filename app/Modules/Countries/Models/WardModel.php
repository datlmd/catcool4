<?php namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class  WardModel extends MyModel
{
    protected $table      = 'country_ward';
    protected $primaryKey = 'ward_id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';

    protected $allowedFields = [
        'ward_id',
        'district_id',
        'name',
        'type',
        'lati_long_tude',
        'sort_order',
        'published',
        'deleted_at',
    ];

    const COUNTRY_WARD_CACHE_NAME   = PREFIX_CACHE_NAME_MYSQL.'country_ward_list';
    const COUNTRY_WARD_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'ward_id';
        $order = $order ?? 'DESC';

        if (!empty($filter["ward_id"])) {
            $this->whereIn('ward_id', (is_array($filter["ward_id"])) ? $filter["ward_id"] : explode(',', $filter["ward_id"]));
        }

        if (!empty($filter["name"])) {
            $this->Like('name', $filter["name"]);
        }

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

    public function getWardsDropdown($district_id = null)
    {
        $return = $this->getWards();
        if (empty($return)) {
            return false;
        }

        $ward_list[0] = lang('Country.text_select');
        foreach ($return as $value) {
            if (!empty($district_id) && $value['district_id'] != $district_id) {
                continue;
            }
            $ward_list[$value['ward_id']] = $value['type'] . ' ' . $value['name'];
        }

        return $ward_list;
    }
}
