<?php

namespace App\Validation;

use App\Modules\Routes\Models\RouteModel;
use Exception;

class CustomRules
{
    public function checkRoute(string $str = null, string $params = null, array $data = null, string &$error = null) : bool
    {
        $seo_url = $str;

        if (!is_null($seo_url)) {
            /**
             * $params: route, route_old, language_id, language_name
             */
            $params = explode(',', $params);
            if (empty($params[0])) {
                return true;
            }

            $where  = null;
            if (count($params) >= 3) {
                $where = [
                    'route' => get_seo_extension($params[0]),
                    'language_id' => $params[2],
                ];

                if (!empty($params[1])) {
                    $where['route !='] = get_seo_extension($params[1]);
                }
            }

            $model_route = new RouteModel();
            $seo_data    = $model_route->getListAvailable($where);
            if (empty($seo_data)) {
                return true;
            }

            $language = !empty($params[3]) ? "($params[3])" : null;
            $error    = lang('Admin.error_slug_exists', [$language]);

            return false;
        }

        return true;
    }
}
