<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_group_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'user_group_relationship';
        $this->primary_key = 'user_id';

        $this->fillable = [
            'user_id',
            'group_id',
        ];
    }

    /**
     * Kiem tra user co quyen admin khong
     *
     * @param $user_id
     * @return bool
     */
    public function is_admin_user_group($user_id)
    {
        if (empty($user_id) || !is_numeric($user_id)) {
            return FALSE;
        }

        $this->load->model("users/User_group", 'Group');

        $group_info = $this->Group->get(['name' => config_item('admin_group')]);
        if (empty($group_info)) {
            return FALSE;
        }

        $check_admin = $this->get(['user_id' => $user_id, 'group_id' => $group_info['id']]);
        if(empty($check_admin)) {
            return FALSE;
        }

        return TRUE;
    }
}
