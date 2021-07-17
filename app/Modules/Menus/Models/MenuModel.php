<?php namespace App\Modules\Menus\Models;

use App\Models\MyModel;

class MenuModel extends MyModel
{
    protected $table      = 'menu';
    protected $primaryKey = 'menu_id';

    protected $table_lang = 'menu_lang';
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

        $sort  = in_array($sort, $sort_data) ? $sort : 'sort_order';
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));

        if (!empty($filter["id"])) {
            $this->whereIn("$this->table.menu_id", (!is_array($filter["menu_id"]) ? explode(',', $filter["menu_id"]) : $filter["menu_id"]));
        }

        if (isset($filter["is_admin"])) {
            $this->where("$this->table.is_admin", $filter["is_admin"]);
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.menu_id = $this->table.menu_id")
            ->orderBy($sort, $order)->findAll();

        if (empty($result)) {
            return null;
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

            $language_id = !empty($filter['is_admin']) ? get_lang_id(true) : get_lang_id();
            foreach ($result as $key => $value) {
                $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
            }

            foreach ($result as $key => $menu) {
                if (empty($menu['lang'])) {
                    foreach ($menu['lang'] as $key_lang => $lang) {
                        $result[$key]['lang'][$key_lang]['slug'] = $this->_getFullUrl($lang['slug']);
                    }
                }
                if (!empty($menu['slug'])) {
                    $result[$key]['slug'] = $this->_getFullUrl($menu['slug']);
                }
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                $cache->save($cache_name, $result, $expire_time);
            }
        }

        return $result;
    }

    public function deleteCache($is_admin = false, $cache_name = null)
    {
        $cache = cache();
        if (!empty($cache_name) && !empty($this->cache->get($cache_name))) {
            $cache->save($cache_name, [], 0);
            return true;
        }

        if ($is_admin) {
            //clear cache all
            $list_name = [
                SET_CACHE_NAME_MENU . '_admin' . '_lang_' . get_lang_id(true),
            ];
        } else {
            //clear cache all
            $list_name = [
                SET_CACHE_NAME_MENU . '_frontend',
                SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_MAIN . '_lang_' . get_lang_id(),
                SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_FOOTER . '_lang_' . get_lang_id(),
                SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_TOP . '_lang_' . get_lang_id(),
                SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_BOTTOM . '_lang_' . get_lang_id(),
                SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_OTHER . '_lang_' . get_lang_id(),
            ];
        }

        foreach ($list_name as $name) {
            $cache->delete($name);
        }

        return true;
    }

    private function _getFullUrl($slug)
    {
        if (empty($slug)) {
            return null;
        }

        if (strpos(strtolower($slug), "http") !== FALSE || strpos(strtolower($slug), "https") !== FALSE) {
            $url = $slug;
        }

        $url = base_url(trim($slug));

        return $url;
    }
}
