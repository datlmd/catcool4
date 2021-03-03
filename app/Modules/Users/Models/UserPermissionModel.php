<?php namespace App\Modules\Users\Models;

use App\Models\MyModel;

class UserPermissionModel extends MyModel
{
    protected $table      = 'user_permissions';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'user_id',
        'permission_id',
    ];

    const USER_PERMISSION_CACHE_NAME   = 'user_permission_%';
    const USER_PERMISSION_CACHE_EXPIRE = HOUR;

    function __construct()
    {
        parent::__construct();
    }

    public function getListPermissionByUserId($user_id, $is_cache = true)
    {
        if (empty($user_id)) {
            return false;
        }

        $cache_name = printf(self::PERMISSION_CACHE_NAME, $user_id);

        $result = $is_cache ? cache()->get($cache_name) : null;
        if (empty($result)) {
            $result = $this->where(['user_id' => $user_id])->findAll();
            if (empty($result)) {
                return null;
            }
            // Save into the cache for $expire_time 1 year
            cache()->save($cache_name, $result, self::PERMISSION_CACHE_EXPIRE);
        }

        return $result;
    }

    public function deleteCache($user_id)
    {
        if (empty($user_id)) {
            return false;
        }
        $cache_name = printf(self::PERMISSION_CACHE_NAME, $user_id);
        cache()->delete($cache_name);
        return true;
    }
}
