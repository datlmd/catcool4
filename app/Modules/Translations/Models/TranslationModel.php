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

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    const TRANSLATION_CACHE_NAME   = 'translation_list';
    const TRANSLATION_CACHE_EXPIRE = 30*MINUTE;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        if (empty($filter["module_id"]) && empty($filter["key"]) && empty($filter["value"])) {
            return [];
        }

        $sort  = empty($sort) ? 'id' : $sort;
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

        if (is_multi_language() && !empty($filter["value"])) {
            $translation_other = [];
            foreach ($result as $value) {
                $list_other = $this->where(['lang_key' => $value['lang_key'], 'lang_id !=' => $value['lang_id']])->findAll();
                $translation_other = array_merge($translation_other, $list_other);
            }

            $result = array_merge($result, $translation_other);
        }

        $list = [];
        foreach ($result as $value) {
            $list[$value['lang_key']]['list'][$value['lang_id']] = $value;
            $list[$value['lang_key']]['module_id'] = $value['module_id'];
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

    public function writeFile($module_id)
    {
        try {
            $module_model   = new \App\Modules\Modules\Models\ModuleModel();
            $language_model = new \App\Modules\Languages\Models\LanguageModel();

            $module = $module_model->find($module_id);
            if (empty($module)) {
                return false;
            }

            $translate_list = $this->orderBy('lang_key', 'ASC')->where('module_id', $module_id)->findAll();
            if (empty($translate_list)) {
                return false;
            }

            $content_template = "\t\"%s\" => \"%s\",\n";

            //list lang
            $language_list = $language_model->getListPublished();

            foreach ($language_list as $lang) {
                // file content
                $file_content = "<?php\n\nreturn [\n";

                foreach ($translate_list as $translate) {
                    if ($translate['lang_id'] == $lang['id']) {
                        $file_content .= sprintf($content_template, $translate['lang_key'], $translate['lang_value']);
                    }
                }

                $file_content .= "];\n";

                // create module
                if (!is_dir(APPPATH . "Language/" . $lang['code'])) {
                    mkdir(APPPATH . 'Language/' . $lang['code'], 0775, true);
                }

                write_file(APPPATH . 'Language/' . $lang['code'] . '/' . $this->formatFileName($module['module'], $module['sub_module']) . '.php', $file_content);
            }
        } catch (\Exception $ex) {
            die($ex->getMessage());
            return false;
        }

        return true;
    }
}
