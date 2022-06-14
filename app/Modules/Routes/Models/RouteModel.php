<?php namespace App\Modules\Routes\Models;

use App\Models\MyModel;
use App\Modules\Users\Models\UserPermissionModel;

class RouteModel extends MyModel
{
    protected $table      = 'route';
    protected $primaryKey = 'route';

    protected $allowedFields = [
        'language_id',
        'route',
        'module',
        'resource',
        'user_id',
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
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'ctime';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["route"])) {
            $this->whereIn('route', $filter["route"]);
        }

        if (!empty($filter["module"])) {
            $this->like('module', $filter["module"]);
        }

        if (!empty($filter["resource"])) {
            $this->like('resource', $filter["resource"]);
        }

        $this->orderBy($sort, $order);

        return $this;
    }

    public function getListPublished($published = STATUS_ON)
    {
        $result = $this->where(['published' => $published])->findAll();
        if (empty($result)) {
            return null;
        }

        return $result;
    }

    public function getListByModule($module, $resource)
    {
        if (empty($module) || empty($resource)) {
            return false;
        }

        $data = [
            'module'   => $module,
            'resource' => $resource
        ];

        $result = $this->orderBy('ctime', 'DESC')->where($data)->findAll();
        if (empty($result)) {
            return false;
        }

        $data = [];
        foreach ($result as $value) {
            $data[$value['language_id']] = $value;
        }

        return $data;
    }

    public function getRouteInfo($module, $resource)
    {
        if (empty($module) || empty($resource)) {
            return false;
        }

        $data = [
            'module'   => $module,
            'resource' => $resource
        ];

        $result = $this->where($data)->first();
        if (empty($result)) {
            return false;
        }

        return $result;
    }

    public function deleteByModule($module, $resource)
    {
        if (empty($module) || empty($resource)) {
            return false;
        }

        try {
            $data = [
                'module'   => $module,
                'resource' => $resource
            ];

            $routes = $this->where($data)->findAll();
            if (empty($routes)) {
                return false;
            }

            $ids = array_column($routes, 'id');

            $this->delete($ids);
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            return false;
        }

        $this->writeFile();

        return true;
    }

    public function getListAvailable($where)
    {
        if (empty($where)) {
            return false;
        }

        return $this->where($where)->findAll();
    }

    public function writeFile()
    {
        try {
            helper('filesystem');

            $routers = $this->getListPublished();
            // file content
            $file_content = "<?php \n\nif(!isset(\$routes))\n{\n\t\$routes = \Config\Services::routes(true);\n}\n\n";
            if (!empty($routers)) {
                foreach ($routers as $router) {
                   $file_content .= "\$routes->add('" . $router['route'] . "', '" . ucfirst($router['resource']) . "', ['namespace' => 'App\Modules\\" . ucfirst($router['module']) . "\\Controllers']);\n";
                }
            }

            write_file(WRITEPATH . 'config/Routes.php', $file_content);
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            return false;
        }

        return true;
    }

    public function saveRoute($urls, $module, $resource)
    {
        if (empty($urls) || empty($module) || empty($resource)) {
            return false;
        }

        if (!empty($urls['route'])) {
            $urls['route'] = get_seo_extension($urls['route']);
            if (!empty($urls['language_id'])) {
                $this->where(['language_id' => $urls['language_id'], 'route' => $urls['route']])->update();
            } else {
                $route_data = [
                    'module'      => $module,
                    'resource'    => $resource,
                    'language_id' => get_lang_id(true),
                    'route'       => $urls['route'],
                    'user_id'     => session('admin.user_id'),
                    'published'   => STATUS_ON,
                    'ctime'       => get_date(),
                ];
                $this->insert($route_data);
            }
        } else {
            foreach (get_list_lang(true) as $key => $value) {
                if (!isset($urls[$key]['route'])) {
                    continue;
                }

                $urls[$key]['route'] = get_seo_extension($urls[$key]['route']);

                if (!empty($urls[$key]['language_id'])) {
                    $this->where(['route' => $urls[$key]['route'], 'language_id' => $key])->delete();
                } else {
                    $route_data = [
                        'module'      => $module,
                        'resource'    => $resource,
                        'language_id' => $key,
                        'route'       => $urls[$key]['route'],
                        'user_id'     => session('admin.user_id'),
                        'published'   => STATUS_ON,
                        'ctime'       => get_date(),
                    ];
                    $this->insert($route_data);
                }
            }
        }
        $this->writeFile();

        return true;
    }

}
