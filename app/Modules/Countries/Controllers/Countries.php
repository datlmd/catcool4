<?php namespace App\Modules\Countries\Controllers;

use App\Controllers\BaseController;
use App\Modules\Countries\Models\CountryModel;
use App\Modules\Countries\Models\ProvinceModel;

class Countries extends BaseController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function provinces()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        $province_model = new ProvinceModel();
        $country_id    = str_ireplace('_', '', $this->request->getPost('country_id'));
        $province_list = $province_model->getListDisplay($country_id);
        if (!empty($province_list)) {
            foreach ($province_list as $key => $value) {
                $province_list['_'.$key] = $value;
                unset($province_list[$key]);
            }
        }

        if (empty($province_list)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        json_output(['status' => 'ok', 'provinces' => $province_list, 'none' => lang('Country.text_none')]);
    }

    public function districts()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        $district_model = new DistrictModel();

        $province_id   = str_ireplace('_', '', $this->request->getPost('province_id'));
        $district_list = $district_model->getListDisplay($province_id);
        if (!empty($district_list)) {
            foreach ($district_list as $key => $value) {
                $district_list['_'.$key] = $value;
                unset($district_list[$key]);
            }
        }

        if (empty($district_list)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        json_output(['status' => 'ok', 'districts' => $district_list, 'none' => lang('Country.text_none')]);
    }

    public function wards()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        $ward_model = new WardModel();

        $district_id = str_ireplace('_', '', $this->request->getPost('district_id'));
        $ward_list   = $ward_model->getListDisplay($district_id);
        if (!empty($ward_list)) {
            foreach ($ward_list as $key => $value) {
                $ward_list['_'.$key] = $value;
                unset($ward_list[$key]);
            }
        }

        if (empty($ward_list)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        json_output(['status' => 'ok', 'wards' => $ward_list, 'none' => lang('Country.text_none')]);
    }
}
