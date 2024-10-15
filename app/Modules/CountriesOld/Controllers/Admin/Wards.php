<?php namespace App\Modules\CountriesOld\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\CountriesOld\Models\ProvinceModel;
use App\Modules\CountriesOld\Models\DistrictModel;
use App\Modules\CountriesOld\Models\WardModel;
use App\Modules\CountriesOld\Models\CountryModel;

class Wards extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'manage/old/country_wards';
    CONST MANAGE_URL  = 'manage/old/country_wards';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new WardModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('CountryAdmin.heading_title'), site_url('manage/countries'));
        $this->breadcrumb->add(lang('CountryWardAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

    public function index()
    {
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $limit       = $this->request->getGet('limit');
        $filter_keys = ['district_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'total'         => $list->pager->getPerPage(),
            'sort'          => $sort ?? 'district_id',
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        $province_model = new ProvinceModel();
        $data['province_list'] = $province_model->getProvincesDropdown();

        $district_model = new DistrictModel();
        $data['district_list'] = $district_model->getDistrictsByZone();

        add_meta(['title' => lang("CountryWardAdmin.heading_title")], $this->themes);
        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('wards/list', $data);
    }

    public function add()
    {
        if (!empty($this->request->getPost())) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);
                return redirect()->back()->withInput();
            }

            $add_data = [
                'name'           => $this->request->getPost('name'),
                'type'           => $this->request->getPost('type'),
                'lati_long_tude' => $this->request->getPost('lati_long_tude'),
                'district_id'    => $this->request->getPost('district_id'),
                'sort_order'     => $this->request->getPost('sort_order'),
                'published'      => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->insert($add_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->back()->withInput();
            }

            //reset cache
            $this->model->deleteCache();

            set_alert(lang('Admin.text_add_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        return $this->_getForm();
    }

    public function edit($id = null)
    {
        if (empty($id)) {
            set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        if (!empty($this->request->getPost()) && $id == $this->request->getPost('ward_id')) {
            if (!$this->_validateForm()) {
                set_alert([ALERT_ERROR => $this->errors]);
                return redirect()->back()->withInput();
            }

            $edit_data = [
                'name'           => $this->request->getPost('name'),
                'type'           => $this->request->getPost('type'),
                'lati_long_tude' => $this->request->getPost('lati_long_tude'),
                'district_id'    => $this->request->getPost('district_id'),
                'sort_order'     => $this->request->getPost('sort_order'),
                'published'      => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            ];

            if (!$this->model->update($id, $edit_data)) {
                set_alert(lang('Admin.error'), ALERT_ERROR, ALERT_POPUP);
            }

            //reset cache
            $this->model->deleteCache();

            set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        return $this->_getForm($id);
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        //delete
        if (!empty($this->request->getPost('is_delete')) && !empty($this->request->getPost('ids')))
        {
            $ids = $this->request->getPost('ids');
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->find($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }
            $this->model->delete($ids);

            //reset cache
            $this->model->deleteCache();

            set_alert(lang('Admin.text_delete_success'), ALERT_SUCCESS, ALERT_POPUP);
            json_output(['token' => $token, 'status' => 'redirect', 'url' => site_url(self::MANAGE_URL)]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (!empty($this->request->getPost('delete_ids'))) {
            $delete_ids = $this->request->getPost('delete_ids');
        }

        if (empty($delete_ids)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->find($delete_ids);
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids'] = implode(',', $delete_ids);

        json_output(['token' => $token, 'data' => $this->themes::view('wards/delete', $data)]);
    }

    private function _getForm($id = null)
    {
        $this->themes->addJS('common/js/country/load');

        $country_model  = new CountryModel();
        $province_model = new ProvinceModel();
        $district_model = new DistrictModel();

        $province_list = [];
        $district_list = [];

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('CountryWardAdmin.text_edit');
            $data['text_submit'] = lang('CountryWardAdmin.button_save');
            $breadcrumb_url      = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->find($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR, ALERT_POPUP);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $district_data = $district_model->where('district_id', $data_form['district_id'])->first();
            if (!empty($district_data)) {
                $district_list    = $district_model->getDistrictsByZone($district_data['province_id']);
                $data_form['province_id'] = $district_data['province_id'];
            }

            $province_data = $province_model->where('province_id', $district_data['province_id'])->first();
            if (!empty($province_data)) {
                $province_list           = $province_model->getProvincesDropdown($province_data['country_id']);
                $data_form['country_id'] = $province_data['country_id'];
            }

            // display the edit user form
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('CountryWardAdmin.text_add');
            $data['text_submit'] = lang('CountryWardAdmin.button_add');
            $breadcrumb_url      = site_url(self::MANAGE_URL . "/add");
        }

        $data['country_list']  = $country_model->getCountriesDropdown();
        $data['province_list'] = $province_list;
        $data['district_list'] = $district_list;

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => $data['text_form']], $this->themes);

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('wards/form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        $this->validator->setRule('name', lang('Admin.text_name'), 'required');
        $this->validator->setRule('district_id', lang('CountryWardAdmin.text_district'), 'required|is_natural_no_zero');

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

        return $is_validation;
    }

    public function publish()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        if (empty($this->request->getPost())) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $id        = $this->request->getPost('id');
        $item_edit = $this->model->find($id);
        if (empty($item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $item_edit['published'] = !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF;
        if (!$this->model->update($id, $item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $this->model->deleteCache();
        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }
}
