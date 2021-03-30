<?php namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class  ProvinceModel extends MyModel
{
    protected $table      = 'country_province';
    protected $primaryKey = 'province_id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    protected $allowedFields = [
        'province_id',
        'country_id',
        'name',
        'type',
        'telephone_code',
        'zip_code',
        'country_code',
        'sort_order',
        'published',
        'deleted',
    ];

    const COUNTRY_PROVINCE_CACHE_NAME   = 'country_province_list';
    const COUNTRY_PROVINCE_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'province_id';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["country_id"])) {
            $this->whereIn('country_id', (is_array($filter["country_id"])) ? $filter["country_id"] : explode(',', $filter["country_id"]));
        }

        if (!empty($filter["name"])) {
            $this->groupStart();
            $this->Like('name', $filter["name"]);
            $this->orLike('telephone_code', $filter["name"]);
            $this->orLike('country_code', $filter["name"]);
            $this->groupEnd();
        }

        return $this->orderBy($sort, $order);
    }

    public function getListPublished($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::COUNTRY_PROVINCE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'ASC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::COUNTRY_PROVINCE_CACHE_NAME, $result, self::COUNTRY_PROVINCE_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::COUNTRY_PROVINCE_CACHE_NAME);
        return true;
    }

    public function getListDisplay($country_id = null)
    {
        $return = $this->getListPublished();
        if (empty($return)) {
            return false;
        }

        $province_list[0] = lang('Country.text_select');
        foreach ($return as $value) {
            if (!empty($country_id) && $value['country_id'] != $country_id) {
                continue;
            }
            $key = sprintf('"%s"', $value['province_id']);
            $province_list[$key] = $value['type'] . ' ' . $value['name'];
        }

        return $province_list;
    }
}
