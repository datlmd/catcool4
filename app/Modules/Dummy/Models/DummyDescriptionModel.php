<?php namespace App\Modules\Dummy\Models;

use CodeIgniter\Model;

class DummyDescriptionModel extends Model
{
    use \Tatter\Relations\Traits\ModelTrait;

    protected $table      = 'dummy_description';
    protected $primaryKey = 'dummy_id';

    protected $returnType = 'object';

    protected $allowedFields = [
        'dummy_id',
        'language_id',
        'name',
        'description'
    ];

    protected $with = ['dummy'];

    public function __construct()
    {
        parent::__construct();
    }
}
