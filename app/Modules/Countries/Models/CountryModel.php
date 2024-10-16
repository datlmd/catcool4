<?php

namespace App\Modules\Countries\Models;

use App\Models\MyModel;

class CountryModel extends MyModel
{
    protected $table = 'country';
    protected $primaryKey = 'country_id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'country_id',
        'name',
        'iso_code_2',
        'iso_code_3',
        'address_format_id',
        'postcode_required',
        'published',
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
            $this->like('name', $filter['name']);
            $this->orLike('iso_code_2', $filter['name']);
            $this->orLike('iso_code_3', $filter['name']);
            $this->groupEnd();
        }

        return $this->orderBy($sort, $order);
    }

    public function getCountries($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::COUNTRY_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->from([], true)->from("$this->table `c`")->select('`c`.*, `af`.`name` `address_name`, `af`.`address_format`')->join('address_format `af`', '`af`.`address_format_id` = `c`.`address_format_id`', 'LEFT')->orderBy('`c`.`name`', 'ASC')->where(['`c`.`published`' => STATUS_ON])->findAll();
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

    public function getCountriesDropdown()
    {
        $return = $this->getCountries();
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
