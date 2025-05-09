<?php

namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class AddressFormatModel extends MyModel
{
    protected $table      = 'address_format';
    protected $primaryKey = 'address_format_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'address_format_id',
        'name',
        'address_format',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
