<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Activate extends MyController
{
    public function index($id = null, $activation = null)
    {
        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        if ($customer_model->activate($id, $activation)) {
            set_alert(lang('Customer.text_activate_successful'));
        } else {
            set_alert($customer_model->getErrors() ?? lang('Customer.activate_unsuccessful'), ALERT_ERROR);
        }

        return redirect()->to(site_url('account/alert?type=activate'));
    }
}
