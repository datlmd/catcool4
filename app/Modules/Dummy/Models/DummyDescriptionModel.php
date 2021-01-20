<?php namespace App\Models;

use CodeIgniter\Model;

class DummyDescriptionModel extends Model
{
    protected $table      = 'dummy_description';
    protected $primaryKey = 'dummy_id';

    protected $allowedFields = ['dummy_id', 'language_id', 'name', 'description'];

    public function __construct()
    {
        parent::__construct();
    }
}
