<?php namespace App\Modules\Products\Controllers;

use App\Controllers\AdminController;
use App\Modules\Currencies\Models\CurrencyModel;
use App\Modules\Products\Models\ProductModel;
use App\Modules\Products\Models\ProductLangModel;

class Manage extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    CONST MANAGE_ROOT = 'products/manage';
    CONST MANAGE_URL  = 'products/manage';

    CONST SEO_URL_MODULE   = 'products';
    CONST SEO_URL_RESOURCE = 'Products::Detail/%s';

    const FOLDER_UPLOAD = 'products/';

    private $_variant_combination_name = 'variant_option_info_row_';
    private $_variant_option_row_name = 'r%s';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new ProductModel();
        $this->model_lang = new ProductLangModel();

        $this->currency_model = new \App\Modules\Currencies\Models\CurrencyModel();
        $this->smarty->assign('currency', $this->currency_model->getCurrency());

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('ProductAdmin.heading_title'), site_url(self::MANAGE_URL));
    }

	public function index()
	{
        add_meta(['title' => lang('ProductAdmin.heading_title')], $this->themes);

        $limit       = $this->request->getGet('limit');
        $sort        = $this->request->getGet('sort');
        $order       = $this->request->getGet('order');
        $filter_keys = ['product_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

	    $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list->paginate($limit),
            'pager'         => $list->pager,
            'sort'          => empty($sort) ? 'product_id' : $sort,
            'order'         => ($order == 'ASC') ? 'DESC' : 'ASC',
            'url'           => $this->getUrlFilter($filter_keys),
            'filter_active' => count(array_filter($this->request->getGet($filter_keys))) > 0,
        ];

        if ($this->request->isAJAX()) {
            return $this->themes::view('list', $data);
        }

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('product', $data);
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

        $date_available = $this->request->getPost('date_available');
        if (!empty($date_available)) {
            $date_available = date("Y-m-d", strtotime($date_available));
        }

        $product_id   = $this->request->getPost('product_id');
        $data_product = [
            'master_id'       => $this->request->getPost('master_id'),
            'model'           => $this->request->getPost('model'),
            'sku'             => $this->request->getPost('sku'),
            'upc'             => $this->request->getPost('upc'),
            'ean'             => $this->request->getPost('ean'),
            'jan'             => $this->request->getPost('jan'),
            'isbn'            => $this->request->getPost('isbn'),
            'mpn'             => $this->request->getPost('mpn'),
            'location'        => $this->request->getPost('location'),
            'variant'         => $this->request->getPost('variant'),
            'override'        => $this->request->getPost('override'),
            'quantity'        => $this->request->getPost('quantity'),
            'stock_status_id' => $this->request->getPost('stock_status_id'),
            //'image'           => $this->request->getPost('image'),
            'manufacturer_id' => $this->request->getPost('manufacturer_id'),
            'shipping'        => $this->request->getPost('shipping'),
            'price'           => (float)$this->request->getPost('price'),
            'points'          => 0,//$this->request->getPost('points'),
            'tax_class_id'    => $this->request->getPost('tax_class_id'),
            'date_available'  => $date_available,
            'weight'          => (float)$this->request->getPost('weight'),
            'weight_class_id' => $this->request->getPost('weight_class_id'),
            'length'          => (float)$this->request->getPost('length'),
            'length_class_id' => $this->request->getPost('length_class_id'),
            'width'           => (float)$this->request->getPost('width'),
            'height'          => (float)$this->request->getPost('height'),
            'subtract'        => $this->request->getPost('subtract'),
            'minimum'         => $this->request->getPost('minimum'),
            'sort_order'      => $this->request->getPost('sort_order'),
            'published'       => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            'viewed'          => $this->request->getPost('viewed'),
            'is_comment'      => $this->request->getPost('is_comment'),
        ];

        if (empty($product_id)) {
            //Them moi
            $product_id = $this->model->insert($data_product);
            if (empty($product_id)) {
                $json['error'] = lang('Admin.error');
            }
        } else {
            //cap nhat
            $data_product['product_id'] = $product_id;
            if (!$this->model->save($data_product)) {
                $json['error'] = lang('Admin.error');
            }
        }

        if (!empty($json['error'])) {
            json_output($json);
        }

        if (!empty($this->request->getPost('product_id'))) {
            $this->model_lang->where(['product_id' => $product_id])->delete();
        }

        $edit_data_lang = $this->request->getPost('lang');
        foreach (get_list_lang(true) as $language) {
            $edit_data_lang[$language['id']]['language_id'] = $language['id'];
            $edit_data_lang[$language['id']]['product_id']  = $product_id;
            $edit_data_lang[$language['id']]['slug']        = !empty($seo_urls[$language['id']]['route']) ? get_seo_extension($seo_urls[$language['id']]['route']) : '';

            $this->model_lang->insert($edit_data_lang[$language['id']]);
        }

        //product category
        $product_category_model = new \App\Modules\Products\Models\ProductCategoryModel();
        $product_category_model->where(['product_id' => $product_id])->delete();

        $category_ids = $this->request->getPost('category_ids');
        if (!empty($category_ids)) {
            foreach ($category_ids as $category_id) {
                $product_category_model->insert(['product_id' => $product_id, 'category_id' => $category_id]);
            }
        }

        //product filter
        $product_filter_model = new \App\Modules\Products\Models\ProductFilterModel();
        $product_filter_model->where(['product_id' => $product_id])->delete();

        $filter_ids = $this->request->getPost('filter_ids');
        if (!empty($filter_ids)) {
            foreach ($filter_ids as $filter_id) {
                $product_filter_model->insert(['product_id' => $product_id, 'filter_id' => $filter_id]);
            }
        }

        //product related
        $product_related_model = new \App\Modules\Products\Models\ProductRelatedModel();
        $product_related_model->where(['product_id' => $product_id])->delete();

        $related_ids = $this->request->getPost('related_ids');
        if (!empty($related_ids)) {
            foreach ($related_ids as $related_id) {
                $product_related_model->insert(['product_id' => $product_id, 'related_id' => $related_id]);
            }
        }

        //product image
        $product_image_model = new \App\Modules\Products\Models\ProductImageModel();
        $product_image_model->where(['product_id' => $product_id])->delete();

        $main_image_url = "";
        $product_image_list = $this->request->getPost('product_image');

        if (!empty($product_image_list)) {
            $product_image_sort_order = count($product_image_list);
            foreach ($product_image_list as $value) {
                if (empty($value) || empty($value['image'])) {
                    continue;
                }

                if (stripos($value['image'], UPLOAD_FILE_TMP_DIR) !== false) {
                    $product_image_url = str_replace(UPLOAD_FILE_TMP_DIR, self::FOLDER_UPLOAD . "$product_id/", $value['image']);
                    $value['image']    = move_file_tmp($value['image'], $product_image_url);
                }

                $product_image_data = [
                    'product_id' => $product_id,
                    'image'      => $value['image'],
                    'sort_order' => $product_image_sort_order
                ];

                if (!empty($value['product_image_id'])) {
                    $product_image_data['product_image_id'] = $value['product_image_id'];
                }

                $product_image_model->insert($product_image_data);

                $product_image_sort_order--;
                if (!empty($value['image']) && empty($main_image_url)) {
                    $main_image_url = $value['image'];
                }
            }
        }

        // update image main
        if (!empty($main_image_url)) {
            $data_product_image_main['product_id'] = $product_id;
            $data_product_image_main['product_id'] = $main_image_url;
            $this->model->save($data_product_image_main);
        }

        //product attribute
        $product_attribute_model = new \App\Modules\Products\Models\ProductAttributeModel();
        $product_attribute_model->where(['product_id' => $product_id])->delete();

        $product_attribute_list = $this->request->getPost('product_attribute');
        if (!empty($product_attribute_list)) {
            $data_attribute = [];
            foreach ($product_attribute_list as $value) {
                foreach (get_list_lang(true) as $language) {
                    if (empty($value['attribute_id']) || empty($value['lang'][$language['id']]['text'])) {
                        continue;
                    }
                    $data_attribute[] = [
                        'product_id'   => $product_id,
                        'language_id'  => $language['id'],
                        'attribute_id' => $value['attribute_id'],
                        'text'         => $value['lang'][$language['id']]['text'],
                    ];

                    //$product_attribute_model->insert($data_attribute);
                }
            }
            if (!empty($data_attribute)) {
                $product_attribute_model->insertBatch($data_attribute);
            }
        }

        //save route url
        $route_model = new \App\Modules\Routes\Models\RouteModel();
        $seo_urls    = $this->request->getPost('seo_urls');
        $route_model->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $product_id));

        //product option
        $product_option_model       = new \App\Modules\Products\Models\ProductOptionModel();
        $product_option_value_model = new \App\Modules\Products\Models\ProductOptionValueModel();

        $product_option_model->where(['product_id' => $product_id])->delete();
        $product_option_value_model->where(['product_id' => $product_id])->delete();

        $product_option_list = $this->request->getPost('product_option');
        if (!empty($product_option_list)) {
            foreach ($product_option_list as $value) {
                $product_option_data = [
                    'product_id' => $product_id,
                    'option_id'  => $value['option_id'],
                    'required'   => $value['required'],
                ];
                if (!empty($value['product_option_id'])) {
                    $product_option_data['product_option_id'] = $value['product_option_id'];
                }
                if ($value['type'] == 'select' || $value['type'] == 'radio' || $value['type'] == 'checkbox' || $value['type'] == 'image') {
                    $product_option_id = $product_option_model->insert($product_option_data);

                    foreach ($value['product_option_value'] as $option_value) {
                        $product_option_value_data = [
                            'product_option_id' => $product_option_id,
                            'product_id'        => $product_id,
                            'option_id'         => $value['option_id'],
                            'option_value_id'   => $option_value['option_value_id'],
                            'quantity'          => $option_value['quantity'],
                            'subtract'          => $option_value['subtract'],
                            'price'             => $option_value['price'],
                            'price_prefix'      => $option_value['price_prefix'],
                            'points'            => $option_value['points'],
                            'points_prefix'     => $option_value['points_prefix'],
                            'weight'            => $option_value['weight'],
                            'weight_prefix'     => $option_value['weight_prefix'],
                        ];
                        if (!empty($option_value['product_option_value_id'])) {
                            $product_option_value_data['product_option_value_id'] = $option_value['product_option_value_id'];
                        }
                        $product_option_value_model->insert($product_option_value_data);
                    }
                } else {
                    $product_option_data['value'] = $value['value'];
                    $product_option_model->insert($product_option_data);
                }
            }
        }

        //Variant option
        if ($this->request->getPost('product_variant_option') && $this->request->getPost('product_variant_combination')) {

            $option_value_model                 = new \App\Modules\Options\Models\OptionValueModel();
            $option_value_lang_model            = new \App\Modules\Options\Models\OptionValueLangModel();
            $product_variant_option_model       = new \App\Modules\Products\Models\ProductVariantOptionModel();
            $product_variant_option_value_model = new \App\Modules\Products\Models\ProductVariantOptionValueModel();
            $product_sku_model                  = new \App\Modules\Products\Models\ProductSkuModel();
            $product_sku_value_model            = new \App\Modules\Products\Models\ProductSkuValueModel();

            $option_value_id_list = [];

            $product_variant_option_model->where(['product_id' => $product_id])->delete();
            $product_variant_option_value_model->where(['product_id' => $product_id])->delete();

            //delete cache option value
            $option_value_model->deleteCache();

            $sort_product_variant_option = count($this->request->getPost('product_variant_option'));
            //cc_debug($this->request->getPost('product_variant_option'));
            foreach ($this->request->getPost('product_variant_option') as $variant_option) {
                $data_product_variant_option = [
                    'option_id'  => $variant_option['option_id'],
                    'product_id' => $product_id,
                    'sort_order' => $sort_product_variant_option,
                ];
                $product_variant_option_model->insert($data_product_variant_option);
                $sort_product_variant_option--;

                if (!empty($variant_option['option_values'])) {
                    $option_value_model->where(['option_id' => $variant_option['option_id']])->delete();

                    $sort_product_variant_option_value = count($variant_option['option_values']);

                    foreach ($variant_option['option_values'] as $option_value_key => $variant_option_value) {
                        $data_option_value = [
                            'option_id'  => $variant_option['option_id'],
                            'image'      => $variant_option_value['option_value_id'] ?? "",
                            'sort_order' => $sort_product_variant_option_value,
                        ];

                        if (!empty($variant_option_value['option_value_id'])) {
                            $data_option_value['option_value_id'] = $variant_option_value['option_value_id'];
                        }

                        $option_value_id = $option_value_model->insert($data_option_value);
                        $data_option_value_lang = $variant_option_value['lang'];
                        foreach (get_list_lang(true) as $language) {
                            $data_option_value_lang[$language['id']]['language_id']     = $language['id'];
                            $data_option_value_lang[$language['id']]['option_value_id'] = $option_value_id;
                            $data_option_value_lang[$language['id']]['option_id']       = $variant_option['option_id'];

                            $option_value_lang_model->insert($data_option_value_lang[$language['id']]);
                        }

                        //list option value row tmp
                        $option_value_id_list[$option_value_key] = [
                            'option_id'       => $variant_option['option_id'],
                            'option_value_id' => $option_value_id,
                        ];

                        $data_product_variant_option_value = [
                            'option_id'       => $variant_option['option_id'],
                            'option_value_id' => $option_value_id,
                            'product_id'      => $product_id,
                            'sort_order'      => $sort_product_variant_option_value,
                        ];
                        $product_variant_option_value_model->insert($data_product_variant_option_value);
                        $sort_product_variant_option_value--;
                    }
                }
            }

            //product sku
            $product_sku_model->where(['product_id' => $product_id])->delete();

            foreach ($this->request->getPost('product_variant_combination') as $combination_key => $combination_value) {
                $data_product_sku = [
                    'product_id' => $product_id,
                    'price'      => $combination_value['price'],
                    'quantity'   => $combination_value['quantity'],
                    'sku'        => $combination_value['sku'],
                    'published'  => !empty($combination_value['published']) ? STATUS_ON : STATUS_OFF,
                ];

                if (!empty($combination_value['product_sku_id'])) {
                    $data_product_sku['product_sku_id'] = $combination_value['product_sku_id'];
                }
                $product_sku_id = $product_sku_model->insert($data_product_sku);

                //product sku value
                $product_sku_value_model->where(['product_id' => $product_id, 'product_sku_id' => $product_sku_id])->delete();
                $data_product_sku_value = [];

                $combination_rows = str_ireplace($this->_variant_combination_name, '', $combination_key);
                $combination_rows = explode('_', $combination_rows);

                foreach ($combination_rows as $option_value_row) {
                    if (!isset($option_value_id_list[$option_value_row])) {
                        continue;
                    }

                    $data_product_sku_value[] = [
                        'product_sku_id'  => $product_sku_id,
                        'product_id'      => $product_id,
                        'option_id'       => $option_value_id_list[$option_value_row]['option_id'],
                        'option_value_id' => $option_value_id_list[$option_value_row]['option_value_id'],
                    ];
                }

                if (!empty($data_product_sku_value)) {
                    $product_sku_value_model->insertBatch($data_product_sku_value);
                }
            }
        }

        $json['product_id'] = $product_id;

        $json['success'] = lang('Admin.text_add_success');
        if (!empty($this->request->getPost('product_id'))) {
            $json['success'] = lang('Admin.text_edit_success');
        }

        json_output($json);
    }

    private function _getForm($product_id = null)
    {
        $this->themes->addJS('common/js/admin/products/products');

        $this->themes->addJS('common/js/tinymce/tinymce.min');
        $this->themes->addJS('common/js/admin/tiny_content');

        //add datetimepicker
        $this->themes->addCSS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (get_lang(true) == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        //add tags
        $this->themes->addCSS('common/js/tags/tagsinput');
        $this->themes->addJS('common/js/tags/tagsinput');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (get_lang(true) == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $this->themes->addJS('common/js/admin/related');

        $this->themes->addJS('common/plugin/shortable-nestable/Sortable.min');

        $this->themes->addCSS('common/js/dropzone/dropdrap');

        $data['language_list'] = get_list_lang(true);

        //edit
        if (!empty($product_id) && is_numeric($product_id)) {
            $data['text_form'] = lang('ProductAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/edit/$product_id");

            $data_form = $this->model->getDetail($product_id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);
                return redirect()->to(site_url(self::MANAGE_URL));
            }

            //product filters
            $product_filter_model  = new \App\Modules\Products\Models\ProductFilterModel();
            $filter_ids = $product_filter_model->where(['product_id' => $product_id])->findAll();
            $data_form['filter_ids'] = array_column($filter_ids, 'filter_id');

            //product categories
            $product_category_model  = new \App\Modules\Products\Models\ProductCategoryModel();
            $category_ids = $product_category_model->where(['product_id' => $product_id])->findAll();
            $data_form['category_ids'] = array_column($category_ids, 'category_id');

            //product related
            $product_related_model  = new \App\Modules\Products\Models\ProductRelatedModel();
            $related_ids = $product_related_model->where(['product_id' => $product_id])->findAll();
            $data_form['related_ids'] = array_column($related_ids, 'related_id');

            if (!empty($data_form['related_ids'])) {
                $related_list = $this->model->getListByRelatedIds($data_form['related_ids']);

                if (!empty($related_list)) {
                    $data_form['related_list_html'] = $this->themes::view('inc/related_list', ['related_list' => $related_list, 'is_checked' => true], true);
                }
            }

            //product image
            $product_image_model  = new \App\Modules\Products\Models\ProductImageModel();
            $data_form['image_list'] = $product_image_model->getListByProductId($product_id);

            //product attribute
            $product_attribute_model  = new \App\Modules\Products\Models\ProductAttributeModel();
            $data_form['product_attribute_list'] = $product_attribute_model->getListByProductId($product_id);

            //lay danh sach seo url tu route
            $route_model = new \App\Modules\Routes\Models\RouteModel();
            $data['seo_urls'] = $route_model->getListByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $product_id));

            //product option
            $product_option_model = new \App\Modules\Products\Models\ProductOptionModel();
            $data_form['product_option_list'] = $product_option_model->getListByProductId($product_id);

            //product variant
            $product_variant_option_model = new \App\Modules\Products\Models\ProductVariantOptionModel();
            $product_sku_model            = new \App\Modules\Products\Models\ProductSkuModel();

            $data_form['product_variant_option_list'] = $product_variant_option_model->getListVariantOptionByProductId($product_id);
            $data_form['product_sku_list'] = $product_sku_model->getListSkuByProductId($product_id);
            //cc_debug($data_form['product_sku_list']);

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('ProductAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL . "/add");
        }

        $stock_status_model = new \App\Modules\Products\Models\StockStatusModel();
        $data['stock_status_list'] = $stock_status_model->getListAll();

        $weight_class_model = new \App\Modules\Products\Models\WeightClassModel();
        $data['weight_class_list'] = $weight_class_model->getListAll();

        $length_class_model = new \App\Modules\Products\Models\LengthClassModel();
        $data['length_class_list'] = $length_class_model->getListAll();

        $manufacturer_model = new \App\Modules\Manufacturers\Models\ManufacturerModel();
        $data['manufacturer_list'] = $manufacturer_model->getListAll();

        $category_model = new \App\Modules\Products\Models\CategoryModel();
        $category_list = $category_model->getListAll();
        $data['categories_tree'] = format_tree(['data' => $category_list, 'key_id' => 'category_id']);

        $filter_model = new \App\Modules\Filters\Models\FilterModel();
        $data['filter_list'] = $filter_model->getListAll();

        $attribute_model = new \App\Modules\Attributes\Models\AttributeModel();
        $data['attribute_list'] = $attribute_model->getListAll();
        $data['attribute_default_list'] = $attribute_model->getListAttributeDefault();

        $option_model = new \App\Modules\Options\Models\OptionModel();
        $data['option_list'] = $option_model->getListAll();

        $data['variant_option_row_name'] = $this->_variant_option_row_name;

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['tab_type']   = 'tab_general';
        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            //      ->addPartial('sidebar')
            ::load('form', $data);
    }

    private function _validateForm()
    {
        $this->validator->setRule('sort_order', lang('Admin.text_sort_order'), 'is_natural');
        foreach(get_list_lang(true) as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('ProductAdmin.text_name') . ' (' . $value['name']  . ')', 'required');
        }

        if (!empty($this->request->getPost('shipping'))) {
            $this->validator->setRule('length', lang('ProductAdmin.text_length'), 'required|numeric');
            $this->validator->setRule('width', lang('ProductAdmin.text_width'), 'required|numeric');
            $this->validator->setRule('height', lang('ProductAdmin.text_height'), 'required|numeric');
            $this->validator->setRule('weight', lang('ProductAdmin.text_weight'), 'required|numeric');
        }

        if ($this->request->getPost('product_variant_option')) {
            $product_variant_option_list = [];

            foreach ($this->request->getPost('product_variant_option') as $option_key => $variant_option) {

                $this->validator->setRule(
                    sprintf('product_variant_option.%s.option_id', $option_key),
                    lang('ProductAdmin.text_variant_name'),
                    'required',
                );

                if (!empty($product_variant_option_list[$variant_option['option_id']])) {
                    $this->errors[sprintf('product_variant_option.%s.option_id', $option_key)] = lang('ProductAdmin.error_variant_name');
                    return false;
                }
                $product_variant_option_list[$variant_option['option_id']] = $variant_option['option_id'];

                if (!empty($variant_option['option_values'])) {
                    foreach ($variant_option['option_values'] as $option_value_key => $variant_option_value) {
                        foreach (get_list_lang(true) as $lang_value) {
                            $this->validator->setRule(sprintf('product_variant_option.%s.option_values.%s.lang.%s.name', $option_key, $option_value_key, $lang_value['id']), lang('ProductAdmin.text_variant_option') . ' (' . $lang_value['name'] . ')', 'required');
                        }
                    }
                }
            }

            foreach ($this->request->getPost('product_variant_combination') as $combination_key => $combination_value) {
                $this->validator->setRule(sprintf('product_variant_combination.%s.price', $combination_key), lang('ProductAdmin.text_price'), 'required|decimal');
                $this->validator->setRule(sprintf('product_variant_combination.%s.quantity', $combination_key), lang('ProductAdmin.text_quantity'), 'required|is_natural_no_zero');
            }
        } else {
            $this->validator->setRule('price', lang('ProductAdmin.text_price'), 'required|decimal');
            $this->validator->setRule('quantity', lang('ProductAdmin.text_quantity'), 'required|numeric');
        }

        //$this->validator->setRule('model', lang('ProductAdmin.text_model'), 'required');

//        if (!empty($this->request->getPost('product_attribute'))) {
//            foreach ($this->request->getPost('product_attribute') as $key => $value) {
//                if (empty($value['lang'])) {
//                    continue;
//                }
//                foreach(get_list_lang(true) as $lang_value) {
//                    $this->validator->setRule(sprintf('product_attribute.%s.lang.%s.text', $key, $lang_value['id']), lang('ProductAdmin.text_text') . ' (' . $lang_value['name']  . ')', 'required');
//                }
//            }
//        }

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
            //$this->model_value->whereIn('product_id', $ids)->delete();

            //xoa slug ra khoi route
            $route_model = new \App\Modules\Routes\Models\RouteModel();
            foreach($list_delete as $value) {
                $route_model->deleteByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $value['product_id']));
            }

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
        $data['ids']         = $delete_ids;

        json_output(['token' => $token, 'data' => $this->themes::view('delete', $data)]);
    }

    public function related()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (empty($this->request->getPost())) {
            json_output(['status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $related_list = $this->model->findRelated($this->request->getPost('related'), $this->request->getPost('id'));

        $data = [
            'status' => 'ok',
            'view' => $this->themes::view('inc/related_list', ['related_list' => $related_list], true)
        ];

        json_output($data);
    }
}
