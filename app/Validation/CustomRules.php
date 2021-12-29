<?php

namespace App\Validation;

use App\Modules\Routes\Models\RouteModel;
use Exception;

class CustomRules
{
    public function checkRoute(string $str = null, string $params = null, array $data = null, string &$error = null) : bool
    {
        $seo_url = $str;
        $route_id = $params;

        if (!is_null($seo_url)) {
            $model_route = new RouteModel();

            $seo_url = get_seo_extension($seo_url);

            $seo_data = $model_route->getListAvailable($seo_url, $route_id);
            if (empty($seo_data)) {
                return true;
            }

            $error = lang('Admin.error_slug_exists');
            return false;
        }

        return true;
    }
}
