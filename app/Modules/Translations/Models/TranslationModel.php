<?php namespace App\Modules\Translations\Models;

use App\Models\MyModel;

class TranslationModel extends MyModel
{
    protected $table      = 'translation';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'lang_key',
        'lang_value',
        'lang_id',
        'module_id',
        'user_id',
        'published',
        'ctime',
        'mtime',
    ];

    const TRANSLATION_CACHE_NAME   = 'translation_list';
    const TRANSLATION_CACHE_EXPIRE = 30*MINUTE;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'lang_key' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["module_id"])) {
            $this->where('module_id', $filter["module_id"]);
        }

        if (!empty($filter["key"])) {
            $this->like('lang_key', $filter["key"]);
        }

        if (!empty($filter["value"])) {
            $this->like('lang_value', $filter["value"]);
        }

        $this->orderBy($sort, $order);

        $result = $this->orderBy($sort, $order)->findAll();
        if (empty($result)) {
            return null;
        }

        $list = [];
        foreach ($result as $value) {
            $list[$value['lang_key']][$value['lang_id']] = $value;
        }

        return $list;
    }

    public function getListPublished($is_cache = false)
    {
        $result = $is_cache ? cache()->get(self::TRANSLATION_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::TRANSLATION_CACHE_NAME, $result, self::TRANSLATION_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::TRANSLATION_CACHE_NAME);
        return true;
    }

    public function formatFileName($module = null, $sub_module = null)
    {
        $language_name = "";
        if (empty($module) && empty($sub_module)) {
            return null;
        }

        $module     = explode('_', $module);
        $sub_module = explode('_', $sub_module);

        $module = array_merge($module, $sub_module);

        foreach ($module as $key => $value) {
            $module[$key] = singular($value);
        }

        $language_name = pascalize(implode('_', $module));
        if ($language_name == "CommonFilemanager") {
            $language_name = "FileManager";
        } else {
            $language_name = str_ireplace(["Manage", "Menus"], ["Admin", "Menu"], $language_name);
        }

        return $language_name;
    }
}
