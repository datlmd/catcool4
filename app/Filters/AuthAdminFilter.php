<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Modules\Users\Models\UserModel;
use App\Modules\Permissions\Models\PermissionModel;
use App\Modules\Users\Models\UserPermissionModel;

class AuthAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user_id = session('user_id');
        if(empty($user_id))
        {
            helper(['cookie','catcool']);
            $user_model = new UserModel();
            if (!$user_model->loginRememberedUser())
            {
                $query_string = '';
                if ( !empty(\Config\Services::request()->getGet()))
                {
                    $query_string = (strpos(site_url(), '?') === FALSE) ? '?' : '&amp;';
                    $query_string =  $query_string.http_build_query(\Config\Services::request()->getGet());
                }
                $redirect = 'users/manage/login?redirect='.urlencode(current_url().$query_string);

                return redirect()->to(site_url($redirect));
            }
        }

        if(empty(session('is_admin')) || session('is_admin') == false)
        {
            //chuyen sang trang frontend
            return redirect()->to(site_url());
        }

        $is_super_admin = session('super_admin');
        if (empty($is_super_admin) || !$is_super_admin)
        {
            $permission_model      = new PermissionModel();
            $user_permission_model = new UserPermissionModel();

            $name_permission = uri_string();
            $id_permission   = 0;

            $permissions = $permission_model->getListPublished();
            foreach($permissions as $key => $val)
            {
                if ($name_permission == $val['name'])
                {
                    $id_permission = $val['id'];
                    break;
                }
            }

            $relationship = $user_permission_model->where(['user_id' => $user_id, 'permission_id' => $id_permission])->findAll();
            if (empty($relationship))
            {
                set_alert(lang('Admin.error_permission_edit'), ALERT_ERROR,);
                return redirect()->to(site_url('permissions/not_allowed'));
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
