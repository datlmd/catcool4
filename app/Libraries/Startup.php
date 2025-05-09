<?php

namespace App\Libraries;

class Startup
{
    public function event(): void
    {
        $event_model = new \App\Modules\Events\Models\EventModel();
        $event_list = $event_model->getEvents();
        if (!empty($event_list)) {
            foreach ($event_list as $event) {
                if (empty($event['code']) || empty($event['action'])) {
                    continue;
                }

                $priority = ($event['priority'] && $event['priority'] > 0) ? $event['priority'] : \CodeIgniter\Events\Events::PRIORITY_NORMAL;
                //Call on a static method
                \CodeIgniter\Events\Events::on($event['code'], $event['action'], $priority);
            }
        }
    }

    public function currency(): void
    {
        $currency_model = new \App\Modules\Currencies\Models\CurrencyModel();
        $currencies = $currency_model->getListPublished();

        $code = '';
        session('customer.customer_id');

        if (!empty(session('currency'))) {
            $code = session('currency');
        }

        if (isset($this->request->cookie['currency']) && !isset($currencies[$code])) {
            $code = get_cookie('currency');
        }

        if (!isset($currencies[$code])) {
            $code = config_item('currency');
        }

        if (empty(session('currency')) || session('currency') != $code) {
            session()->set('currency', $code);
        }

        // Set a new currency cookie if the code does not match the current one
        if (empty(get_cookie('currency')) || get_cookie('currency') != $code) {
            $cookie_config = [
                'name'   => 'currency',
                'value'  => $code,
                'expire' => time() + 60 * 60 * 24 * 30,
                'domain' => '',
                'path'   => '/',
                'prefix' => '',
                'secure' => (bool)config_item('force_global_secure_requests'),
                'samesite' => \CodeIgniter\Cookie\Cookie::SAMESITE_LAX,
            ];

            $response = \Config\Services::response();
            $response->setCookie($cookie_config)->send();
        }
    }
}
