<?php namespace App\Modules\Permissions\Models;

use App\Models\MyModel;
use App\Modules\Users\Models\UserPermissionModel;

class PermissionModel extends MyModel
{
    protected $table      = 'permission';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'description',
        'published',
    ];

    const PERMISSION_CACHE_NAME   = 'permission_list';
    const PERMISSION_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["id"])) {
            $this->whereIn('id', (!is_array($filter["id"]) ? explode(',', $filter["id"]) : $filter["id"]));
        }

        if (!empty($filter["name"])) {
            $this->like('name', $filter["name"]);
            $this->like('description', $filter["name"]);
        }

        $this->orderBy($sort, $order);

        return $this;
    }

    public function getListPublished($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::PERMISSION_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::PERMISSION_CACHE_NAME, $result, self::PERMISSION_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::PERMISSION_CACHE_NAME);
        return true;
    }

    public function getTextPermission($permission = null)
    {
        helper(['cookie', 'catcool']);
        \Config\Services::language()->setLocale(get_lang(true));

        $text_permission = lang('PermissionAdmin.not_permission');
        $permission      = (!empty($permission)) ? $permission : uri_string();

        if (strpos($permission, 'add') !== false) {
            $text_permission = lang('Admin.error_permission_add');
        } elseif (strpos($permission, 'edit') !== false || strpos($permission, 'publish') !== false) {
            $text_permission = lang('Admin.error_permission_edit');
        } elseif (strpos($permission, 'delete') !== false) {
            $text_permission = lang('Admin.error_permission_delete');
        } elseif (strpos($permission, 'execute') !== false || strpos($permission, 'write') !== false) {
            $text_permission = lang('Admin.error_permission_execute');
        } elseif (strpos($permission, 'super') !== false) {
            $text_permission = lang('Admin.error_permission_super_admin');
        } elseif (strpos($permission, 'index') !== false) {
            $text_permission = lang('Admin.error_permission_read');
        } elseif (!empty($permission)) {
            $permission = explode('/', $permission);
            if (!empty($permission[1]) && $permission[1] == 'manage') {
                $text_permission = lang('Admin.error_permission_read');
            }
        }

        return $text_permission;
    }

    public function checkPermission($permission_name = null)
    {
        if (empty(session('is_admin')) || empty(session('user_id'))) {
            return false;
        }

        $is_super_admin = session('super_admin');
        if (!empty($is_super_admin) && $is_super_admin === TRUE) {
            return true;
        }

        $user_permission_model = new UserPermissionModel();
        $user_id               = session('user_id');
        $permission            = [];
        $permission_name       = (!empty($permission_name)) ? $permission_name : uri_string();
        $permission_name       = explode('/', $permission_name);

        $permission_tmp = [];
        foreach ($permission_name as $val) {
            if (is_numeric($val)) {
                continue;
            }
            $permission_tmp[] = $val;
        }
        $permission_name = implode('/', $permission_tmp);

        $permissions = $this->getListPublished();
        if (empty($permissions)) {
            return false;
        }

        foreach ($permissions as $value) {
            if (!empty($value['name']) && $permission_name == $value['name']) {
                $permission = $value;
                break;
            }
        }

        $relationships = $user_permission_model->getListPermissionByUserId($user_id);
        if (empty($permission) || empty($relationships)
            || !in_array($permission['id'], array_column($relationships, 'permission_id'))) {
            return false;
        }

        return true;
    }

    public function formatListPublished($permissions)
    {
        if (empty($permissions)) {
            return $permissions;
        }

        $list = [];
        foreach ($permissions as $value) {
            $action = explode('/', $value['name']);
            if (empty($action)) {
                continue;
            }
            $list[$action[0]][] = $value;
        }

        return $list;
    }
}
