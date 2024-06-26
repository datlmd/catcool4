<?php

namespace App\Modules\Routes\Models;

use App\Models\MyModel;

class RouteModel extends MyModel
{
    protected $table = 'route';
    protected $primaryKey = 'route';

    protected $allowedFields = [
        'language_id',
        'route',
        'module',
        'resource',
        'user_id',
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
        $sort = in_array($sort, $this->allowedFields) ? $sort : 'created_at';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter['route'])) {
            $this->like('route', $filter['route']);
        }

        if (!empty($filter['module'])) {
            $this->like('module', $filter['module']);
        }

        if (!empty($filter['resource'])) {
            $this->like('resource', $filter['resource']);
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
            'module' => $module,
            'resource' => $resource,
        ];

        $result = $this->orderBy('created_at', 'DESC')->where($data)->findAll();
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
            'module' => $module,
            'resource' => $resource,
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
                'module' => $module,
                'resource' => $resource,
            ];

            $routes = $this->where($data)->findAll();
            if (empty($routes)) {
                return false;
            }

            $this->where($data)->delete();
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
                    $file_content .= "\$routes->add('".$router['route']."', '".ucfirst($router['resource'])."', ['namespace' => 'App\Modules\\".ucfirst($router['module'])."\\Controllers']);\n";
                }
            }

            write_file(WRITEPATH.'config/Routes.php', $file_content);
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
            if (!empty($urls['language_id']) && !empty($urls['route_old'])) {
                $this->where(['language_id' => $urls['language_id'], 'route' => $urls['route_old']])->delete();
            }

            if (empty($urls['route'])) {
                return false;
            }

            $urls['route'] = get_seo_extension($urls['route']);
            $route_data = [
                'module' => $module,
                'resource' => $resource,
                'language_id' => language_id_admin(),
                'route' => $urls['route'],
                'user_id' => session('user_info.user_id'),
                'published' => STATUS_ON,
            ];
            $this->insert($route_data);
        } else {
            foreach (list_language_admin() as $key => $value) {
                if (!empty($urls[$key]['language_id']) && !empty($urls[$key]['route_old'])) {
                    $this->where(['route' => $urls[$key]['route_old'], 'language_id' => $key])->delete();
                }

                if (empty($urls[$key]['route'])) {
                    continue;
                }

                $urls[$key]['route'] = get_seo_extension($urls[$key]['route']);
                $route_data = [
                    'module' => $module,
                    'resource' => $resource,
                    'language_id' => $key,
                    'route' => $urls[$key]['route'],
                    'user_id' => session('user_info.user_id'),
                    'published' => STATUS_ON,
                ];
                $this->insert($route_data);
            }
        }
        $this->writeFile();

        return true;
    }
}
