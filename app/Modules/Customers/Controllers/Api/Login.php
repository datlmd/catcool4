<?php namespace App\Modules\Customers\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\MyController;

class Login extends MyController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->request->isAJAX()) {
            return $this->failNotFound();
        }

        $return_url = $this->request->getGet('return_url');
        if (empty($return_url)) {
            $return_url = site_url('account/profile');
        }

        $data['return_url'] = $return_url;

        $redirect = "";
        if (service('customer')->isLogged() && !empty(session('customer_token'))) {
            $redirect = $return_url . '?customer_token=' . session('customer_token');
        } else if (service('customer')->loginRememberedCustomer()) {
            //neu da logout thi check auto login
            $redirect = $return_url . '?customer_token=' . session('customer_token');
        }

        if (!empty($redirect)) {
            return $this->setResponseFormat('json')->respond($data, 200);
        }

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account_login'), base_url('account/login'));

        $params = [
            'breadcrumbs' => service('breadcrumb')->get(),
            'breadcrumb_title' => lang('Contact.text_title'),
            'module' => 'frontend/account',// su dung de load template layout cho trang
        ];

        $data['layouts'] = service("react")->getTemplate(($params));

        $data["forgotten"] = site_url('account/forgotten');
        $data["login"] = site_url('account/login');

        $data["text_login"] = lang('General.text_login');
        $data["text_login_identity"] = lang('General.text_login_identity');
        $data["text_password"] = lang('General.text_password');
        $data["text_remember"] = lang('General.text_remember');
        $data["button_login"] = lang('General.button_login');
        $data["text_or"] = lang('General.text_or');
        
        return $this->setResponseFormat('json')->respond($data, 200);
    }

    public function login()
    {
        $data = [];

        $this->validator->setRule('identity', lang('Customer.text_login_identity'), 'required');
        $this->validator->setRule('password', lang('Customer.text_password'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            $data = [
                'error' => $errors,
                'alert' => print_alert($errors, ALERT_ERROR)
            ];

            return $this->setResponseFormat('json')->respond($data);
        }

        $remember = (bool)$this->request->getPost('remember');
        if (!service('customer')->login($this->request->getPost('login_identity'), html_entity_decode($this->request->getPost('login_password'), ENT_QUOTES, 'UTF-8'), $remember)) {
            $errors = empty(service('customer')->getErrors()) ? lang('Customer.text_login_unsuccessful') : service('customer')->getErrors();

            $data = [
                'error' => $errors,
                'alert' => print_alert($errors, ALERT_ERROR)
            ];
            return $this->setResponseFormat('json')->respond($data);
        }

        $return_url = $this->request->getPost('return_url');
        if (empty($return_url)) {
            $return_url = site_url('account/profile');
        }

        session()->remove(['order_id']);
        session()->remove(['shipping_method']);
        session()->remove(['shipping_methods']);
        session()->remove(['payment_method']);
        session()->remove(['payment_methods']);

        // Wishlist
        if (!empty(session('wishlist')) && is_array(session('wishlist'))) {
            $customer_wishlist_model = new \App\Modules\Customers\Models\WishlistModel();
            $customer_wishlist_model->addLogin(service('customer')->getId());

            foreach (session('wishlist') as $key => $product_id) {
                $customer_wishlist_model->addWishlist(service('customer')->getId(), $product_id);

                unset(session('wishlist')[$key]);
            }
        }

        $customer_ip_model = new \App\Modules\Customers\Models\IpModel();
        $customer_ip_model->addLogin(service('customer')->getId());

        $success = lang('Customer.text_login_successful');
        set_alert($success, ALERT_SUCCESS);

        $data = [
            'success' => $success,
            'alert' => print_alert($success, ALERT_SUCCESS),
            'redirect' => urldecode($return_url) . '?customer_token=' . session('customer_token')
        ];

        return $this->setResponseFormat('json')->respond($data);
    }
}
