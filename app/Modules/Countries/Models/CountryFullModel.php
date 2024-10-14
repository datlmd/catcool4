<?php

namespace App\Modules\Countries\Models;

use App\Models\MyModel;

/**
 * backup country old
 */
class CountryFullModel extends MyModel
{
    protected $table = 'country_full';
    protected $primaryKey = 'country_id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    protected $allowedFields = [
        'country_id',
        'name',
        'formal_name',
        'country_code',
        'country_code3',
        'country_type',
        'country_sub_type',
        'sovereignty',
        'capital',
        'currency_code',
        'currency_name',
        'telephone_code',
        'country_number',
        'internet_country_code',
        'sort_order',
        'published',
        'flags',
        'deleted_at',
    ];

    const COUNTRY_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'country_list';
    const COUNTRY_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? $sort : 'country_id';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter['country_id'])) {
            $this->whereIn('country_id', (is_array($filter['country_id'])) ? $filter['country_id'] : explode(',', $filter['country_id']));
        }

        if (!empty($filter['name'])) {
            $this->groupStart();
            $this->Like('name', $filter['name']);
            $this->orLike('formal_name', $filter['name']);
            $this->orLike('country_code', $filter['name']);
            $this->orLike('currency_code', $filter['name']);
            $this->groupEnd();
        }

        return $this->orderBy($sort, $order);
    }

    public function getListPublished($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::COUNTRY_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'ASC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::COUNTRY_CACHE_NAME, $result, self::COUNTRY_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::COUNTRY_CACHE_NAME);

        return true;
    }

    public function getListDisplay()
    {
        $return = $this->getListPublished();
        if (empty($return)) {
            return false;
        }

        $country_list[0] = lang('Country.text_select');
        foreach ($return as $value) {
            $country_list[$value['country_id']] = $value['name'];
        }

        return $country_list;
    }
}
