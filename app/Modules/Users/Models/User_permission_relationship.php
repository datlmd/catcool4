<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_permission_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'user_permission_relationship';
        $this->primary_key = 'user_id';

        $this->fillable = [
            'user_id',
            'permission_id',
        ];
    }
}
