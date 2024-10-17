<?php namespace App\Modules\Countries\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class Wards extends Controller
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->request->isAJAX()) {
            return $this->failNotFound(lang('Country.text_none'));
        }
        
        if (empty($this->request->getPost('district_id'))) {
            return $this->failNotFound(lang('Country.text_none'));
        }

        $ward_model = \CodeIgniter\Config\Factories::models('\App\Modules\Countries\Models\WardModel');
        $ward_list = $ward_model->getWardsByDistrict($this->request->getPost('district_id'));
       
        $data['none'] = lang('Country.text_none');
        $data['wards'] = [];

        if (empty($ward_list)) {
            return $this->respond($data);
        }

        foreach ($ward_list as $key => $value) {
            $ward_list['_'.$key] = $value;
            unset($ward_list[$key]);
        }
        
        $data['wards'] = $ward_list;

        return $this->respond($data, 200);
    }
}
