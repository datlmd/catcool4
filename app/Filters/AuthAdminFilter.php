<?php namespace App\Filters;

use App\Modules\UsersAdmin\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Modules\Permissions\Models\PermissionModel;

class AuthAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $name_permission = uri_string();
        if (!strpos($name_permission, 'manage')) {
            return null;
        }

        //check login
        $user_id = session('user_id');
        if (empty($user_id)) {
            helper(['cookie', 'catcool', 'inflector']);
            $user_model = new UserModel();
            if (!$user_model->loginRememberedUser()) {
                $query_string = '';
                if (!empty(\Config\Services::request()->getGet())) {
                    $query_string = (strpos(site_url(), '?') === FALSE) ? '?' : '&amp;';
                    $query_string = $query_string . http_build_query(\Config\Services::request()->getGet());
                }
                $redirect = 'users/manage/login?redirect=' . urlencode(current_url() . $query_string);

                return redirect()->to(site_url($redirect));
            }
        }

        if (empty(session('is_admin'))) {
            //chuyen sang trang frontend
            return redirect()->to(site_url());
        }

        $permission_model = new PermissionModel();
        if (!$permission_model->checkPermission()) {
            $permission_text = $permission_model->getTextPermission($name_permission);
            if (\Config\Services::request()->isAJAX()) {
                header('content-type: application/json; charset=utf8');
                echo json_encode(['token' => csrf_hash(), 'status' => 'ng', 'msg' => $permission_text]);
                exit();
            }

            $redirect_url = sprintf('permissions/manage/not_allowed?p=%s', $name_permission);
            return redirect()->to(site_url($redirect_url));
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
