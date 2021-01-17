<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function is_super_admin()
    {
        $super_admin = session('super_admin');
        if (!empty($super_admin) && $super_admin === TRUE) {
            return TRUE;
        }

        return FALSE;
    }

    public function get_user_id()
    {
        $user_id = session('user_id');
        if (!empty($user_id)) {
            return $user_id;
        }

        return NULL;
    }
}
