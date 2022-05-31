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
            $model_route = new RouteModel();

            $params = explode(',', $params);
            $where  = sprintf(
                "route = '%s' AND module = '%s' AND language_id = %s",
                get_seo_extension($seo_url),
                $params[1] ?? null,
                $params[2] ?? null
            );

            if (!empty($params[0])) {
                $where .= " AND id != $params[0]";
            }

            $seo_data = $model_route->getListAvailable($where);
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
