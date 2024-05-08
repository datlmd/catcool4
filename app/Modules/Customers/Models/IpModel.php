<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class IpModel extends MyModel
{
    protected $table      = 'customer_ip';
    protected $primaryKey = 'customer_ip_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'customer_ip_id',
        'customer_id',
        'ip',
        'agent',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function addLogin(int $customer_id, string $agent = ''): void {
     
        $request = \Config\Services::request();
        $agent   = $request->getUserAgent();
            
        $data = [
            'customer_id' => $customer_id,
            'ip' => get_client_ip(),
            'agent' => $agent->getAgentString()
        ];

        $this->insert($data);
    }
}
