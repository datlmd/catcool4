<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class WishlistModel extends MyModel
{
    protected $table      = 'customer_wishlist';
    protected $primaryKey = 'customer_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'customer_id',
        'product_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function addWishlist(int $customer_id, int $product_id): void {
        try {
            $data = [
                'customer_id' => $customer_id,
                'product_id' => $product_id,
            ];

            $this->where($data)->delete();

            $this->insert($data);
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
        } 
    }
}
