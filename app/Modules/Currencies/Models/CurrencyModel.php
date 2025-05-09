<?php

namespace App\Modules\Currencies\Models;

use App\Models\MyModel;

class CurrencyModel extends MyModel
{
    protected $table = 'currency';
    protected $primaryKey = 'currency_id';

    protected $allowedFields = [
        'currency_id',
        'name',
        'code',
        'symbol_left',
        'symbol_right',
        'decimal_place',
        'value',
        'published',
        'created_at',
        'updated_at',
    ];

    public const CURRENCY_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'currency_list';
    public const CURRENCY_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = empty($sort) ? 'currency_id' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter['id'])) {
            $this->whereIn('currency_id', (is_array($filter['id']) ? implode(',', $filter['id']) : $filter['id']));
        }

        if (!empty($filter['name'])) {
            $this->like('name', $filter['name']);
        }

        return $this->orderBy($sort, $order)->findAll();
    }

    public function getListPublished($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CURRENCY_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::CURRENCY_CACHE_NAME, $result, self::CURRENCY_CACHE_EXPIRE);
            }
        }

        $list = [];
        foreach ($result as $value) {
            $list[$value['code']] = $value;
        }

        return $list;
    }

    public function getCurrency($code = null)
    {
        if (empty($code)) {
            $code = config_item('currency');
        }

        $list = $this->getListPublished();
        if (empty($list[$code])) {
            return [];
        }

        return $list[$code];
    }

    public function deleteCache(): bool
    {
        cache()->delete(self::CURRENCY_CACHE_NAME);

        return true;
    }

    /**
     * updateCurrency.
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public function updateCurrency()
    {
        $curl = curl_init();

        //&symbols = USD,AUD,CAD,PLN,MXN
        curl_setopt($curl, CURLOPT_URL, 'http://data.fixer.io/api/latest?access_key='.config_item('fixer_io_access_key'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);

        curl_close($curl);

        $response_info = json_decode($response, true);

        if (is_array($response_info) && isset($response_info['rates'])) {
            // Compile all the rates into an array
            $currencies = [];

            $default = config_item('currency');
            $currencies['EUR'] = 1.0000;

            foreach ($response_info['rates'] as $key => $value) {
                $currencies[$key] = $value;
            }

            $results = $this->getListPublished();
            foreach ($results as $result) {
                if (isset($currencies[$result['code']])) {
                    $from = $currencies['EUR'];

                    $to = $currencies[$result['code']];

                    $result['value'] = 1 / ($currencies[$default] * ($from / $to));
                    $this->update($result['currency_id'], $result);
                }
            }
        } else {
            return false;
        }

        $this->deleteCache();

        return true;
    }
}
