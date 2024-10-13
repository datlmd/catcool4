<?php

if (!function_exists('config_customer_group_id')) {
    function config_customer_group_id()
    {
        if (!empty(session('customer'))) {
            return session('customer.customer_group_id');
        } elseif (service('customer')->isLogged()) {
            return service('customer')->getGroupId();
        }

        return config_item('customer_group_id');
    }
}
