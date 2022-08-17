<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductRewardModel extends MyModel
{
    protected $table      = 'product_reward';
    protected $primaryKey = 'product_reward_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_reward_id',
        'product_id',
        'customer_group_id',
        'points',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
