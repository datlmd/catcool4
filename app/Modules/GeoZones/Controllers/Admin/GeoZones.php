<?php

namespace App\Modules\GeoZones\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\GeoZones\Models\GeoZoneModel;
use App\Modules\GeoZones\Models\ZoneToGeoZoneModel;

class GeoZones extends AdminController
{
    protected $errors = [];

    protected $model_zone_to_geo_zone;

    public const MANAGE_ROOT = 'manage/geo_zones';
    public const MANAGE_URL = 'manage/geo_zones';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new GeoZoneModel();
        $this->model_zone_to_geo_zone = new ZoneToGeoZoneModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('GeoZoneAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang('GeoZoneAdmin.heading_title')], $this->themes);

        $limit = $this->request->getGet('limit');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $filter_keys = ['geo_zone_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);


        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list' => $list->paginate($limit),
            'pager' => $list->pager,
            'sort' => empty($sort) ? 'name' : $sort,
            'order' => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url' => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        if ($this->request->isAJAX()) {
            return $this->themes::view('list', $data);
        }

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('geo_zone', $data);
    }

    public function add()
    {
        return $this->_getForm();
    }

    public function edit($id = null)
    {
        if (is_null($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);

            return redirect()->to(site_url(self::MANAGE_URL));
        }

        return $this->_getForm($id);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $json = [];

        if (!$this->_validateForm()) {
            $json['error'] = $this->errors;
        }

        $json['token'] = csrf_hash();

        if (!empty($json['error'])) {
            json_output($json);
        }

        $geo_zone_id = $this->request->getPost('geo_zone_id');
        $data_geo_zone = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if (empty($geo_zone_id)) {
            //Them moi
            $geo_zone_id = $this->model->insert($data_geo_zone);
            if (empty($geo_zone_id)) {
                $json['error'] = lang('Admin.error');
            }
        } else {
            //cap nhat
            $data_geo_zone['geo_zone_id'] = $geo_zone_id;
            if (!$this->model->save($data_geo_zone)) {
                $json['error'] = lang('Admin.error');
            }
        }

        if (!empty($json['error'])) {
            json_output($json);
        }

        //option value
        if (!empty($this->request->getPost('geo_zone_id'))) {
            $this->model_zone_to_geo_zone->where(['geo_zone_id' => $geo_zone_id])->delete();
        }

        $zone_to_geo_zones = $this->request->getPost('zone_to_geo_zones');
        if (!empty($zone_to_geo_zones)) {
            foreach ($zone_to_geo_zones as $value) {
                $data_zone_to_geo_zone = [
                    'geo_zone_id' => $geo_zone_id,
                    'country_id' => $value['country_id'],
                    'zone_id' => $value['zone_id'],
                ];

                $this->model_zone_to_geo_zone->insert($data_zone_to_geo_zone);
            }
        }

        $json['geo_zone_id'] = $geo_zone_id;

        $json['success'] = lang('Admin.text_add_success');
        if (!empty($this->request->getPost('geo_zone_id'))) {
            $json['success'] = lang('Admin.text_edit_success');
        }

        json_output($json);
    }

    private function _getForm($id = null)
    {
        // $this->themes->addJS('common/js/country/load');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $country_model = \CodeIgniter\Config\Factories::models('\App\Modules\Countries\Models\CountryModel');
        $data['country_list'] = $country_model->getCountriesDropdown();
        unset($data['country_list'][0]);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('GeoZoneAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL."/edit/$id");

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);

                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data_form['zone_to_geo_zones'] = $this->model_zone_to_geo_zone->getZoneToGeoZones($id);

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('GeoZoneAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL.'/add');
        }

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('name', lang('GeoZoneAdmin.text_name'), 'required|max_length[32]');
        $this->validator->setRule('description', lang('GeoZoneAdmin.text_description'), 'required|max_length[255]');

        if (!empty($this->request->getPost('zone_to_geo_zones'))) {
            foreach ($this->request->getPost('zone_to_geo_zones') as $key => $value) {
                $this->validator->setRule(sprintf('zone_to_geo_zones.%s.country_id', $key), lang('GeoZoneAdmin.text_country'), 'is_natural_no_zero');
                $this->validator->setRule(sprintf('zone_to_geo_zones.%s.zone_id', $key), lang('GeoZoneAdmin.text_zone'), 'is_natural');

                if (empty($value['lang'])) {
                    continue;
                }
                foreach (list_language_admin() as $lang_value) {
                    $this->validator->setRule(sprintf('option_value.%s.lang.%s.name', $key, $lang_value['id']), lang('GeoZoneAdmin.text_option_value_name').' ('.$lang_value['name'].')', 'required');
                }
            }
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors = $this->validator->getErrors();

        return $is_validation;
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids'))) {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(',', $ids);

            $list_delete = $this->model->find($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            //@todo check product co su dung geo_zone_id & option_value_id khong

            $this->model->delete($ids);
            $this->model_zone_to_geo_zone->whereIn('geo_zone_id', $ids)->delete();

            json_output(['token' => $token, 'status' => 'ok', 'ids' => $ids, 'msg' => lang('Admin.text_delete_success')]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $delete_ids = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->find($delete_ids);
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids'] = (string) implode(',', $delete_ids);

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }
}
