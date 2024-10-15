<?php namespace App\Modules\Countries\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class Districts extends Controller
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->request->isAJAX()) {
            return $this->failNotFound(lang('Country.text_none'));
        }
        
        if (empty($this->request->getPost('zone_id'))) {
            return $this->failNotFound(lang('Country.text_none'));
        }

        $district_model = \CodeIgniter\Config\Factories::models('\App\Modules\Countries\Models\DistrictModel');
        $district_list = $district_model->getDistrictsDropdown($this->request->getPost('zone_id'));
       
        $data['none'] = lang('Country.text_none');
        
        if (empty($district_list)) {
            return $this->respond($data);
        }

        foreach ($district_list as $key => $value) {
            $district_list['_'.$key] = $value;
            unset($district_list[$key]);
        }
        
        $data['districts'] = $district_list;

        return $this->respond($data, 200);
    }
}
