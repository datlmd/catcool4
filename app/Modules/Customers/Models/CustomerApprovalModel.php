<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class CustomerApprovalModel extends MyModel
{
    protected $table      = 'customer_approval';
    protected $primaryKey = 'customer_approval_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'customer_approval_id',
        'customer_id',
        'type',
        "ctime",
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
