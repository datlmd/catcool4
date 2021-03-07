<?php namespace App\Modules\Menus\Models;

use App\Models\MyModel;

class MenuModel extends MyModel
{
    protected $table      = 'menu';
    protected $primaryKey = 'menu_id';
    protected $with       = ['menu_lang'];

    protected $allowedFields = [
        'menu_id',
        'icon',
        'context',
        'image',
        'nav_key',
        'label',
        'attributes',
        'selected',
        'language',
        'sort_order',
        'user_id',
        'parent_id',
        'is_admin',
        'hidden',
        'published',
        'ctime',
        'mtime',
    ];

    function __construct()
    {
        parent::__construct();

    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort_data = [
            'menu_id',
            'name',
            'description',
            'sort_order',
        ];

        $sort  = in_array($sort, $sort_data) ? $sort : 'menu_id';
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $where = "menu_lang.language_id=" . get_lang_id(true);

        if (!empty($filter["id"])) {
            $where .= " AND menu.menu_id IN(" . (is_array($filter["id"]) ? implode(',', $filter["id"]) : $filter["id"]) . ")";
        }

        if (isset($filter["is_admin"])) {
            $where .= " AND menu.is_admin=" . $filter["is_admin"];
        }

        if (!empty($filter["name"])) {
            $where .= " AND menu.name LIKE '%" . $filter["name"] . "%'";
        }

        $result = $this->select('menu.*, menu_lang.name AS name, menu_lang.description AS description, menu_lang.slug AS slug')
            ->with(false)
            ->join('menu_lang', 'menu_lang.menu_id = menu.menu_id')
            ->where($where)
            ->orderBy($sort, $order)->findAll();

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    public function getDetail($id, $language_id = null)
    {
        if (empty($id) || !is_numeric($id)) {
            return null;
        }

        $result = $this->find($id);
        if (empty($result)) {
            return null;
        }

        $result = format_data_lang_id($result, 'menu_lang');
        if (!empty($language_id) && !empty($result['menu_lang'][$language_id])) {
            $result['menu_lang'] = $result['menu_lang'][$language_id];
        }

        return $result;
    }

    public function getListDetail($ids, $language_id = null)
    {
        if (empty($ids)) {
            return null;
        }

        $result = $this->find($ids);
        if (empty($result)) {
            return null;
        }

        foreach ($result as $key => $value) {
            $result[$key] = format_data_lang_id($value, 'menu_lang');
            if (!empty($language_id) && !empty($result[$key]['menu_lang'][$language_id])) {
                $result[$key]['menu_lang'] = $result[$key]['menu_lang'][$language_id];
            }
        }

        return $result;
    }

    public function getMenuActive($filter = null, $expire_time = MONTH, $is_cache = true)
    {
        $cache = cache();
        $cache_name = SET_CACHE_NAME_MENU;

        $filter['published'] = isset($filter['published']) ? $filter['published'] : STATUS_ON;
        $filter['is_admin']  = isset($filter['is_admin']) ? $filter['is_admin'] : STATUS_OFF;

        if (!empty($filter['is_admin'])) {
            $cache_name = $cache_name . '_admin' . '_lang_' . get_lang_id(true);
        } else {
            $cache_name = $cache_name . '_frontend';
            $cache_name = (!empty($filter['context'])) ?  $cache_name . '_' . $filter['context'] : $cache_name;
            $cache_name = $cache_name . '_lang_' . get_lang_id();
        }

        $result = $is_cache ? $cache->get($cache_name) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'DESC')->where($filter)->findAll();
            if (empty($result)) {
                return false;
            }

            $language_id = get_lang_id(true);
            foreach ($result as $key => $value) {
                $result[$key] = format_data_lang_id($value, 'menu_lang');
                if (!empty($result[$key]['menu_lang'][$language_id])) {
                    $result[$key]['menu_lang'] = $result[$key]['menu_lang'][$language_id];
                }
            }

            // Save into the cache for $expire_time 1 month
            $cache->save($cache_name, $result, $expire_time);
        }

        return $result;
    }

    public function deleteCache($cache_name = null)
    {
        $cache = cache();
        if (!empty($cache_name) && !empty($this->cache->get($cache_name))) {
            $cache->save($cache_name, [], 0);
            return true;
        }

        //clear cache all
        $list_name = [
            SET_CACHE_NAME_MENU . '_admin' . '_lang_' . get_lang_id(true),
            SET_CACHE_NAME_MENU . '_frontend',
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_MAIN . '_lang_' . get_lang_id(),
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_FOOTER . '_lang_' . get_lang_id(),
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_TOP . '_lang_' . get_lang_id(),
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_BOTTOM . '_lang_' . get_lang_id(),
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_OTHER . '_lang_' . get_lang_id(),
        ];

        foreach ($list_name as $name) {
            $cache->delete($name);
        }

        return true;
    }
}
