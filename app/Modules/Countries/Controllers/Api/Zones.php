<?php namespace App\Modules\Countries\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class Zones extends Controller
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->request->isAJAX()) {
            return $this->failNotFound(lang('Country.text_none'));
        }
        
        if (empty($this->request->getPost('country_id'))) {
            return $this->failNotFound(lang('Country.text_none'));
        }

        $zone_model = \CodeIgniter\Config\Factories::models('\App\Modules\Countries\Models\ZoneModel');
        $zone_list = $zone_model->getZonesByCountry($this->request->getPost('country_id'));

        $data['none'] = lang('Country.text_none');

        if (empty($zone_list)) {
            return $this->respond($data);
        }

        foreach ($zone_list as $key => $value) {
            $zone_list['_'.$key] = $value;
            unset($zone_list[$key]);
        }
        
        $data['zones'] = $zone_list;
        
        return $this->respond($data, 200);
    }
}
