<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class AddressModel extends MyModel
{
    protected $table      = 'address';
    protected $primaryKey = 'address_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'address_id',
        'customer_id',
        'firstname',
        'lastname',
        'company',
        'address_1',
        'address_2',
        'city',
        'postcode',
        'country_id',
        'province_id',
        'district_id',
        'ward_id',
        'custom_field',
        'default',
        'type',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getListByCustomerId(int $customer_id): array
    {
        if (empty($customer_id)) {
            return [];
        }

        $result = $this->where(['customer_id' => $customer_id])->findAll();
        if (empty($result)) {
            return [];
        }

        return $result;
    }
}
