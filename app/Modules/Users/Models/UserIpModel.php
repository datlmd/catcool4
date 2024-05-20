<?php namespace App\Modules\Users\Models;

use App\Models\MyModel;

class UserIpModel extends MyModel
{
    protected $table      = 'user_ip';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_ip_id',
        'user_id',
        'ip',
        'agent',
        'created_at'
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function addLogin(int $user_id): void {
     
        $request = \Config\Services::request();
        $agent   = $request->getUserAgent();
            
        $data = [
            'user_id' => $user_id,
            'ip' => $request->getIPAddress(),
            'agent' => $agent->getAgentString()
        ];

        $this->insert($data);
    }
}
