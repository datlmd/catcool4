<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Countries extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('countries', $this->_site_lang);
    }

    public function provinces()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'none' => lang('text_none')]);
        }

        $this->load->model("countries/Province", 'Province');

        $country_id    = $this->input->post('country_id');
        $province_list = $this->Province->get_list_display($country_id);
        if (empty($province_list)) {
            json_output(['status' => 'ng', 'none' => lang('text_none')]);
        }

        json_output(['status' => 'ok', 'provinces' => $province_list, 'none' => lang('text_none')]);
    }

    public function districts()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'none' => lang('text_none')]);
        }

        $this->load->model("countries/District", 'District');

        $province_id   = $this->input->post('province_id');
        $district_list = $this->District->get_list_display($province_id);
        if (empty($district_list)) {
            json_output(['status' => 'ng', 'none' => lang('text_none')]);
        }

        json_output(['status' => 'ok', 'districts' => $district_list, 'none' => lang('text_none')]);
    }

    public function wards()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'none' => lang('text_none')]);
        }

        $this->load->model("countries/Ward", 'Ward');

        $district_id = $this->input->post('district_id');
        $ward_list   = $this->Ward->get_list_display($district_id);
        if (empty($ward_list)) {
            json_output(['status' => 'ng', 'none' => lang('text_none')]);
        }

        json_output(['status' => 'ok', 'wards' => $ward_list, 'none' => lang('text_none')]);
    }
}
