<?php namespace App\Modules\Customers\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\MyController;

class Profile extends MyController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->request->isAJAX()) {
            return $this->failNotFound();
        }

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_profile'), site_url('account/profile') . '?customer_token=' . session('customer_token'));

        $params = [
            'breadcrumbs' => service('breadcrumb')->get(),
            'breadcrumb_title' => lang('Customer.text_profile'),
            'module' => 'frontend/account',// su dung de load template layout cho trang
        ];
        $data['layouts'] = service("react")->getTemplate(($params));

        $redirect_url = "";
        if (!service('customer')->isLogged() || (empty($this->request->getGet('customer_token')) || empty(session('customer_token')) || ($this->request->getGet('customer_token') != session('customer_token')))) {
            $redirect_url = site_url("account/login?return_url=" . current_url());
            if (service('customer')->loginRememberedCustomer()) {
                $redirect_url = site_url('account/profile?customer_token=' . session('customer_token'));
            }
        }

        $data['redirect_url'] = $redirect_url;
        if (!empty($redirect_url)) {
            return $this->setResponseFormat('json')->respond($data, 200);
        }

        $data['edit'] = site_url('account/edit') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['password'] = site_url('account/password') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['address'] = site_url('account/address') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['wishlist'] = site_url('account/wishlist') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['order'] = site_url('account/order') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['download'] = site_url('account/download') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['reward'] = site_url('account/reward') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['return'] = site_url('account/return') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['transaction'] = site_url('account/transaction') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['newsletter'] = site_url('account/newsletter') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['subscription'] = site_url('account/subscription') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");

        $data["text_my_account"] = lang('Customer.text_my_account');
        $data["text_profile_edit"] = lang('Customer.text_profile_edit');
        $data["text_profile_password"] = lang('Customer.text_profile_password');
        $data["text_profile_address"] = lang('Customer.text_profile_address');
        $data["text_profile_wishlist"] = lang('Customer.text_profile_wishlist');
        $data["text_my_orders"] = lang('Customer.text_my_orders');
        $data["text_profile_order"] = lang('Customer.text_profile_order');
        $data["text_profile_subscription"] = lang('Customer.text_profile_subscription');
        $data["text_profile_download"] = lang('Customer.text_profile_download');
        $data["text_profile_reward"] = lang('Customer.text_profile_reward');
        $data["text_profile_return"] = lang('Customer.text_profile_return');
        $data["text_profile_transaction"] = lang('Customer.text_profile_transaction');
        $data["text_newsletter"] = lang('Customer.text_newsletter');
        $data["text_profile_newsletter"] = lang('Customer.text_profile_newsletter');
    
        return $this->setResponseFormat('json')->respond($data, 200);
    }
}
