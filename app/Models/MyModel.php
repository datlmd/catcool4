<?php namespace App\Models;

use CodeIgniter\Model;

class MyModel extends Model
{
    use \Tatter\Relations\Traits\ModelTrait;

    public function __construct()
    {
        parent::__construct();
    }
}
