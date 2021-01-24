<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_login_attempt extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'user_login_attempt';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'user_id',
            'login',
            'time'
        ];
    }
}
