<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class LoginAttemptModel extends MyModel
{
    protected $table      = 'customer_login_attempt';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'ip',
        'customer_id',
        'time'
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function getTotalAttempts($customer_id, $ip_address = NULL)
    {
        if (!empty(config_item('track_login_attempts'))) {
            $this->where('customer_id', $customer_id);
            if (!empty(config_item('track_login_ip_address'))) {

                if (empty($ip_address)) {
                    $ip_address = get_client_ip();
                }
                $this->where('ip', $ip_address);
            }

            $this->where('time >', time() - config_item('lockout_time'));

            return $this->countAllResults();
        }

        return 0;
    }

    public function isMaxLoginAttemptsExceeded($customer_id, $ip_address = NULL)
    {
        if (!empty(config_item('track_login_attempts'))) {
            $max_attempts = config_item('maximum_login_attempts');
            if ($max_attempts > 0) {
                $attempts = $this->getTotalAttempts($customer_id, $ip_address);
                return $attempts >= $max_attempts;
            }
        }

        return false;
    }

    public function clearLoginAttempts($customer_id, $old_attempts_expire_period = 86400, $ip_address = NULL)
    {
        if (!empty(config_item('track_login_attempts'))) {
            // Make sure $old_attempts_expire_period is at least equals to lockout_time
            $old_attempts_expire_period = max($old_attempts_expire_period, config_item('lockout_time'));

            $this->where('customer_id', $customer_id);
            if (!empty(config_item('track_login_ip_address'))) {
                if (empty($ip_address)) {
                    $ip_address = get_client_ip();
                }
                $this->where('ip', $ip_address);
            }
            // Purge obsolete login attempts
            $this->orWhere('time <', time() - $old_attempts_expire_period);

            return $this->delete();
        }
        return FALSE;
    }

    public function increaseLoginAttempts($customer_id)
    {
        if (!empty(config_item('track_login_attempts'))) {
            $data = [
                'ip'      => '',
                'customer_id' => $customer_id,
                'time'    => time()
            ];
            if (!empty(config_item('track_login_ip_address'))) {
                $data['ip'] = get_client_ip();
            }
            return $this->insert($data);
        }
        return FALSE;
    }
}
