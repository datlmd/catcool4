<?php namespace App\Modules\Configs\Models;

use App\Models\MyModel;

class ConfigModel extends MyModel
{
    protected $table      = 'config';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'config_key',
        'config_value',
        'description',
        'user_id',
        'group_id',
        'published',
        'ctime',
        'mtime',
    ];

    const CONFIG_CACHE_NAME   = 'config_list';
    const CONFIG_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;
        $where = null;

        if (!empty($filter["id"])) {
            $filter["id"] = (!is_array($filter["id"])) ? explode(',', $filter["id"]) : $filter["id"];
            $this->whereIn($filter["id"]);
        }

        if (!empty($filter["config_key"])) {
            $this->like('config_key', $filter["config_key"]);
        }

        if (!empty($filter["config_value"])) {
            $this->like('config_value', $filter["config_value"]);
        }

        if (!empty($where)) {
            $this->where($where);
        }

        return $this->orderBy($sort, $order)->findAll();
    }

    public function getListPublished($is_cache = false)
    {
        $result = $is_cache ? cache()->get(self::CONFIG_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::CONFIG_CACHE_NAME, $result, self::CONFIG_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function write_file()
    {
        try {

            $this->load->model("languages/Language", 'Language');

            $list_language_config = [];
            $list_language = $this->Language->get_list_by_publish();
            foreach ($list_language as $key => $value) {
                unset($value['ctime']);
                unset($value['mtime']);
                $list_language_config[$value['id']] = $value;

            }

            $settings = $this->get_list_by_publish();

            // file content
            $file_content = "<?php \n\n";
            if (!empty($settings)) {
                foreach ($settings as $setting) {
                    $config_value = $setting['config_value'];
                    if (is_numeric($config_value) || is_bool($config_value) || in_array($config_value, ['true', 'false', 'TRUE', 'FALSE']) || strpos($config_value, '[') !== false) {
                        $config_value = $config_value;
                    } else if ($setting['config_key'] == 'file_mime_allowed') {
                        $config_value = str_replace("'", '"', $config_value);
                        $config_value = sprintf("'%s'", $config_value);
                    } else {
                        $config_value = str_replace('"', "'", $config_value);
                        $config_value = sprintf('"%s"', $config_value);
                    }

                    if (!empty($list_language_config) && $setting['config_key'] == 'list_language_cache') {
                        $config_value = "'" . json_encode($list_language_config) . "'";
                    }

                    if (!empty($setting['description'])) {
                        $file_content .= "//" . $setting['description'] . "\n";
                    }

                    $file_content .= "\$config['" . $setting['config_key'] . "'] = " . $config_value . ";\n\n";
                }
            }

            write_file(CATCOOLPATH . 'media/config/config.php', $file_content);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
