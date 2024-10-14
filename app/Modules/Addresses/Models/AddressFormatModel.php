<?php

namespace App\Modules\Addresses\Models;

use App\Models\MyModel;

class AddressFormatModel extends MyModel
{
    protected $table = 'address_format';
    protected $primaryKey = 'address_format_id';

    protected $allowedFields = [
        'address_format_id',
        'name',
        'address_format',
    ];

    const ADDRESS_FORMAT_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'address_format_list';
    const ADDRESS_FORMAT_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = empty($sort) ? 'address_format_id' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter['id'])) {
            $this->whereIn('address_format_id', (is_array($filter['id']) ? implode(',', $filter['id']) : $filter['id']));
        }

        if (!empty($filter['name'])) {
            $this->like('name', $filter['name']);
        }

        return $this->orderBy($sort, $order)->findAll();
    }

    public function getAddressFormats($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::ADDRESS_FORMAT_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::ADDRESS_FORMAT_CACHE_NAME, $result, self::ADDRESS_FORMAT_EXPIRE);
            }
        }

        $list = [];
        foreach ($result as $value) {
            $list[$value['address_format_id']] = $value;
        }

        return $list;
    }


    public function deleteCache(): bool
    {
        cache()->delete(self::ADDRESS_FORMAT_CACHE_NAME);

        return true;
    }
}
