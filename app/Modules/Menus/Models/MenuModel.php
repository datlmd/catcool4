<?php

namespace App\Modules\Menus\Models;

use App\Models\MyModel;

class MenuModel extends MyModel
{
    protected $table = 'menu';
    protected $primaryKey = 'menu_id';
    protected $useAutoIncrement = true;

    protected $table_lang = 'menu_lang';

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
        'created_at',
        'updated_at',
    ];

    public function __construct()
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

        $sort = in_array($sort, $sort_data) ? $sort : 'sort_order';
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());

        if (!empty($filter['id'])) {
            $this->whereIn("$this->table.menu_id", (!is_array($filter['menu_id']) ? explode(',', $filter['menu_id']) : $filter['menu_id']));
        }

        if (isset($filter['is_admin'])) {
            $this->where("$this->table.is_admin", $filter['is_admin']);
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.menu_id = $this->table.menu_id")
            ->orderBy($sort, $order)->findAll();

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    public function getMenusByIds(array $menu_ids, ?int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.menu_id = $this->table.menu_id")
                ->orderBy('sort_order', 'DESC')
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.menu_id", $menu_ids)
                ->findAll();

        return $result;
    }

    public function getMenusActive($filter = null, $expire_time = MONTH, $is_cache = true)
    {
        $cache_name = SET_CACHE_NAME_MENU;

        //get language id
        $language_id = !empty($filter['is_admin']) ? language_id_admin() : language_id();

        if (!empty($filter['is_admin'])) {
            $cache_name = $cache_name.'_admin'.'_lang_'.$language_id;
        } else {
            $cache_name = $cache_name.'_frontend';
            $cache_name = (!empty($filter['context'])) ? $cache_name.'_'.$filter['context'] : $cache_name;
            $cache_name = $cache_name.'_lang_'.$language_id;
        }

        $filter['published'] = isset($filter['published']) ? $filter['published'] : STATUS_ON;
        $filter['is_admin'] = isset($filter['is_admin']) ? $filter['is_admin'] : STATUS_OFF;
        $filter["$this->table_lang.language_id"] = $language_id;

        $result = $is_cache ? cache()->get($cache_name) : null;
        if (empty($result)) {
            $result = $this->join($this->table_lang, "$this->table_lang.menu_id = $this->table.menu_id")
                ->orderBy('sort_order', 'DESC')
                ->where($filter)
                ->findAll();

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save($cache_name, $result, $expire_time);
            }
        }

        if (empty($result)) {
            return false;
        }

        foreach ($result as $key => $menu) {
            if (!empty($menu['slug'])) {
                $result[$key]['slug'] = $this->_getFullUrl($menu['slug']);
            }
        }

        return $result;
    }

    public function deleteCache($is_admin = false, $cache_name = null)
    {
        if (!empty($cache_name) && !empty(cache()->get($cache_name))) {
            cache()->save($cache_name, [], 0);

            return true;
        }

        if ($is_admin) {
            //clear cache all
            cache()->deleteMatching(SET_CACHE_NAME_MENU.'_admin_*');
        } else {
            //clear cache all
            cache()->deleteMatching(SET_CACHE_NAME_MENU.'_frontend_*');
        }

        return true;
    }

    private function _getFullUrl($slug)
    {
        if (empty($slug)) {
            return null;
        }

        if (strpos(strtolower($slug), 'http') !== false || strpos(strtolower($slug), 'https') !== false) {
            $url = $slug;
        }

        $url = base_url(trim($slug));

        return $url;
    }

    public function getMenuByPosition($position = MENU_POSITION_MAIN)
    {
        $menus = $this->getMenusActive(null, 3600 * 30 * 12);
        if (empty($menus)) {
            return false;
        }

        foreach ($menus as $menu_key => $menu) {
            if ($menu['context'] != $position) {
                unset($menus[$menu_key]);
            }
        }

        $menus = format_tree(['data' => $menus, 'key_id' => 'menu_id']);

        $menus = $this->_sortMenu($menus);

        return $menus;
    }

    private function _sortMenu($menus)
    {
        $sort_ids = array_column($menus, "sort_order");
        array_multisort($sort_ids, SORT_DESC, $menus);

        foreach ($menus as $key => $value) {
            if (empty($value['subs'])) {
                continue;
            }
            $menus[$key]['subs'] = $this->_sortMenu($value['subs']);
        }

        return $menus;
    }
}
