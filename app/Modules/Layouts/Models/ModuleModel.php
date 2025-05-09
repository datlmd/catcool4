<?php

namespace App\Modules\Layouts\Models;

use App\Models\MyModel;

class ModuleModel extends MyModel
{
    protected $table = 'layout_module';
    protected $primaryKey = 'layout_module_id';

    protected $allowedFields = [
        'layout_id',
        'layout_action_id',
        'position',
        'sort_order',
    ];

    public const CACHE_NAME_LIST = PREFIX_CACHE_NAME_MYSQL.'layout_module_list';
    public const CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getModules($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CACHE_NAME_LIST) : null;
        if (empty($result)) {
            $result = $this->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                cache()->save(self::CACHE_NAME_LIST, $result, self::CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function getModulesByLayoutId($layout_id, $is_cache = true)
    {
        $list = $this->getModules($is_cache);
        if (empty($list)) {
            return [];
        }

        $layouts = [];
        foreach ($list as $value) {
            if ($value['layout_id'] != $layout_id) {
                continue;
            }
            $layouts[] = $value;
        }

        return $layouts;
    }

    public function deleteCache()
    {
        cache()->delete(self::CACHE_NAME_LIST);

        return true;
    }
}
