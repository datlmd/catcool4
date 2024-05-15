<?php namespace App\Modules\Subscriptions\Controllers;

use App\Controllers\AdminController;
use App\Modules\Subscriptions\Models\PlanModel;
use App\Modules\Subscriptions\Models\PlanLangModel;

class PlansManage extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    CONST MANAGE_ROOT = 'subscriptions/plans_manage';
    CONST MANAGE_URL  = 'subscriptions/plans_manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new PlanModel();
        $this->model_lang = new PlanLangModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('SubscriptionPlanAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        add_meta(['title' => lang('SubscriptionPlanAdmin.heading_title')], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['subscription_plan_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

	    $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'subscription_plan_id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        if ($this->request->isAJAX()) {
            return $this->themes::view('plans/list', $data);
        }

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('plans/plan', $data);
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

        $subscription_plan_id = $this->request->getPost('subscription_plan_id');
        $data_plan = [
            'trial_price'     => $this->request->getPost('trial_price'),
            'trial_frequency' => $this->request->getPost('trial_frequency'),
            'trial_duration'  => $this->request->getPost('trial_duration'),
            'trial_cycle'     => $this->request->getPost('trial_cycle'),
            'trial_published' => !empty($this->request->getPost('trial_published')) ? STATUS_ON : STATUS_OFF,
            'price'           => $this->request->getPost('price'),
            'frequency'       => $this->request->getPost('frequency'),
            'duration'        => $this->request->getPost('duration'),
            'cycle'           => $this->request->getPost('cycle'),
            'published'       => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            'sort_order'      => $this->request->getPost('sort_order'),
        ];

        if (empty($subscription_plan_id)) {
            //Them moi
            $subscription_plan_id = $this->model->insert($data_plan);
            if (empty($subscription_plan_id)) {
                $json['error'] = lang('Admin.error');
            }
        } else {
            //cap nhat
            $data_plan['subscription_plan_id'] = $subscription_plan_id;
            if (!$this->model->save($data_plan)) {
                $json['error'] = lang('Admin.error');
            }
        }

        if (!empty($json['error'])) {
            json_output($json);
        }

        if (!empty($this->request->getPost('subscription_plan_id'))) {
            $this->model_lang->where(['subscription_plan_id' => $subscription_plan_id])->delete();
        }

        $edit_data_lang = $this->request->getPost('lang');
        foreach (list_language_admin() as $language) {
            $edit_data_lang[$language['id']]['language_id']          = $language['id'];
            $edit_data_lang[$language['id']]['subscription_plan_id'] = $subscription_plan_id;

            $this->model_lang->insert($edit_data_lang[$language['id']]);
        }

        $json['subscription_plan_id'] = $subscription_plan_id;

        $json['success'] = lang('Admin.text_add_success');
        if (!empty($this->request->getPost('subscription_plan_id'))) {
            $json['success'] = lang('Admin.text_edit_success');
        }

        json_output($json);
    }

    private function _getForm($id = null)
    {
        $data['language_list'] = list_language_admin();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form'] = lang('Admin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/edit/$id");

            $data_form = $this->model->getDetail($id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('Admin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/add");
        }

        $data['errors'] = $this->errors;

        $data['frequencie_list'] = [
            'day'        => lang('SubscriptionPlanAdmin.text_day'),
            'week'       => lang('SubscriptionPlanAdmin.text_week'),
            'semi_month' => lang('SubscriptionPlanAdmin.text_semi_month'),
            'month'      => lang('SubscriptionPlanAdmin.text_month'),
            'year'       => lang('SubscriptionPlanAdmin.text_year'),
        ];

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('plans/form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        $this->validator->setRule('trial_price', lang('SubscriptionPlanAdmin.text_trial_price'), 'decimal');
        $this->validator->setRule('trial_duration', lang('SubscriptionPlanAdmin.text_trial_duration'), 'is_natural_no_zero');
        $this->validator->setRule('trial_cycle', lang('SubscriptionPlanAdmin.text_trial_cycle'), 'is_natural');
        $this->validator->setRule('price', lang('SubscriptionPlanAdmin.text_price'), 'decimal');
        $this->validator->setRule('duration', lang('SubscriptionPlanAdmin.text_duration'), 'is_natural_no_zero');
        $this->validator->setRule('cycle', lang('SubscriptionPlanAdmin.text_cycle'), 'is_natural');
        foreach(list_language_admin() as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('SubscriptionPlanAdmin.text_plan_name') . ' (' . $value['name']  . ')', 'required|min_length[3]|max_length[255]');
        }

        $is_validation = $this->validator->withRequest($this->request)->run();
        $this->errors  = $this->validator->getErrors();

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
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->model->getListDetail($ids);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids);

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

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->getListDetail($delete_ids, get_lang_id(true));
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids']         = $this->request->getPost('delete_ids');

        json_output(['token' => $token, 'data' => $this->themes::view('plans/delete', $data)]);
    }
}
