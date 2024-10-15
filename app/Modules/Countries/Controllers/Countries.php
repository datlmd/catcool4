<?php namespace App\Modules\Countries\Controllers;

use App\Controllers\MyController;
use App\Modules\Countries\Models\DistrictModel;
use App\Modules\Countries\Models\ZoneModel;
use App\Modules\Countries\Models\WardModel;

class Countries extends MyController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function zones()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        $zone_model = new ZoneModel();
        $country_id    = $this->request->getPost('country_id');
        $zone_list = $zone_model->getZonesDropdown($country_id);
        if (!empty($zone_list)) {
            foreach ($zone_list as $key => $value) {
                $zone_list['_'.$key] = $value;
                unset($zone_list[$key]);
            }
        }

        if (empty($zone_list)) {
            json_output(['status' => 'ng', 'none' => lang('Country.text_none')]);
        }

        json_output(['status' => 'ok', 'zones' => $zone_list, 'none' => lang('Country.text_none')]);
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

        $zone_id   = $this->request->getPost('zone_id');
        $district_list = $district_model->getDistrictsDropdown($zone_id);
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

        $district_id = $this->request->getPost('district_id');
        $ward_list   = $ward_model->getWardsDropdown($district_id);
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
