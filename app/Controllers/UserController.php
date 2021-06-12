<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function isSuperAdmin()
    {
        $super_admin = session('admin.super_admin');
        if (!empty($super_admin) && $super_admin === TRUE) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * User ID
     *
     * @return \CodeIgniter\Session\Session|mixed|null
     */
    public function getUserId()
    {
        if (!empty(session('user.user_id'))) {
            return session('user.user_id');
        }

        return NULL;
    }

    /**
     * User ID Admin
     *
     * @return \CodeIgniter\Session\Session|mixed|null
     */
    public function getUserIdAdmin()
    {
        if (!empty(session('admin.user_id'))) {
            return session('admin.user_id');
        }

        return NULL;
    }
}
