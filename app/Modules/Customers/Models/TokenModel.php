<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class TokenModel extends MyModel
{
    protected $table      = 'customer_token';
    protected $primaryKey = 'customer_id';

    protected $allowedFields = [
        'customer_id',
        'remember_selector',
        'remember_code',
        'user_ip',
        'agent',
        'platform',
        'browser',
        'location',
        'ctime',
        'mtime'
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function addToken($customer_id, $token)
    {
        if (empty($customer_id) || empty($token)) {
            return false;
        }
        try {
            //set token login auto bang cookie
            $request = \Config\Services::request();
            $agent   = $request->getUserAgent();

            $getloc = json_decode(file_get_contents("http://ipinfo.io/"));

            $data_token = [
                'customer_id'           => $customer_id,
                'remember_selector' => $token['selector'],
                'remember_code'     => $token['validator_hashed'],
                'user_ip'           => get_client_ip(),
                'agent'             => $agent->getAgentString(),
                'platform'          => $agent->getPlatform(),
                'browser'           => $agent->getBrowser() . '/' . $agent->getVersion(),
                'location'          => sprintf("%s, %s, %s", $getloc->city, $getloc->region, $getloc->country) ,
            ];

            $user_token = $this->where(['customer_id' => $customer_id, 'remember_selector' => $token['selector']])->first();
            if (empty($user_token)) {
                $data_token['ctime'] = get_date();
                $this->insert($data_token);
            } else {
                $this->where(['remember_selector' => $user_token['remember_selector']])->update($customer_id, $data_token);
            }
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
        }
        return true;
    }

    public function deleteToken($token)
    {
        if (empty($token)) {
            return false;
        }

        $user_token = $this->where(['remember_selector' => $token['selector']])->findAll();
        if (empty($user_token)) {
            return false;
        }

        $this->where(['remember_selector' => $token['selector']])->delete();
        return true;
    }
}
