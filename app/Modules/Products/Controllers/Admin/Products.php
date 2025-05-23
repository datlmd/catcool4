<?php

namespace App\Modules\Products\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\Products\Models\ProductLangModel;
use App\Modules\Products\Models\ProductModel;

class Products extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    public const MANAGE_ROOT = 'manage/products';
    public const MANAGE_URL = 'manage/products';

    public const SEO_URL_MODULE = 'products';
    public const SEO_URL_RESOURCE = 'Products::Detail/%s';

    public const FOLDER_UPLOAD = 'products/';

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

        $this->themes->addJS('common/js/common/currency');

        $limit = !empty($this->request->getGet('limit')) ? (int)$this->request->getGet('limit') : (int)config_item('product_pagination_admin');

        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $filter_keys = ['product_id', 'name', 'limit'];

        $list = $this->model->getAllByFilter($this->request->getGet($filter_keys), $sort, $order);

        $product_list = $list->paginate($limit);

        $product_ids = array_column($product_list, 'product_id');

        $product_sku_model = new \App\Modules\Products\Models\ProductSkuModel();
        $product_sku_list = $product_sku_model->getListSkuByProductIds($product_ids);

        if (!empty($product_sku_list)) {
            foreach ($product_list as $product_key => $product) {
                $product_list[$product_key]['price'] = service('currency')->format($product['price'], config_item('currency'));

                if (empty($product['variant'])) {
                    continue;
                }

                $sku_quantity = 0;
                $sku_prices = [];
                $is_out_of_stock = false;
                foreach ($product_sku_list as $sku) {
                    if ($product['product_id'] != $sku['product_id']) {
                        continue;
                    }

                    $product_list[$product_key]['sku_list'][] = $sku;

                    $sku_prices[$sku['price']] = service('currency')->format($sku['price'], config_item('currency'));
                    $sku_quantity += $sku['quantity'];

                    if ($sku['quantity'] < 10) {
                        $is_out_of_stock = true;
                    }
                }

                $product_list[$product_key]['quantity'] = $sku_quantity;
                $product_list[$product_key]['is_out_of_stock'] = $is_out_of_stock;

                sort($sku_prices);
                if (count($sku_prices) > 2) {
                    $sku_prices = [$sku_prices[0], $sku_prices[count($sku_prices) - 1]];
                }
                $product_list[$product_key]['price'] = implode(' - ', $sku_prices);
            }
        }

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'list' => $product_list,
            'pager' => $list->pager,
            'sort' => empty($sort) ? 'product_id' : $sort,
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
            ->addPartial('sidebar')::load('product', $data);
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
            $date_available = date('Y-m-d', strtotime($date_available));
        }

        $product_id = $this->request->getPost('product_id');
        $data_product = [
            'master_id' => $this->request->getPost('master_id'),
            'model' => $this->request->getPost('model'),
            'sku' => $this->request->getPost('sku'),
            'upc' => $this->request->getPost('upc'),
            'ean' => $this->request->getPost('ean'),
            'jan' => $this->request->getPost('jan'),
            'isbn' => $this->request->getPost('isbn'),
            'mpn' => $this->request->getPost('mpn'),
            'location' => $this->request->getPost('location'),
            //'variant'         => $this->request->getPost('variant'),
            //'override'        => $this->request->getPost('override'),
            'quantity' => $this->request->getPost('quantity'),
            'stock_status_id' => $this->request->getPost('stock_status_id'),
            //'image'           => $this->request->getPost('image'),
            'manufacturer_id' => $this->request->getPost('manufacturer_id'),
            'shipping' => $this->request->getPost('shipping'),
            'price' => format_decimal($this->request->getPost('price')), //(float)$this->request->getPost('price'),
            'points' => 0, //$this->request->getPost('points'),
            'tax_class_id' => $this->request->getPost('tax_class_id'),
            'date_available' => $date_available,
            'weight' => (float) $this->request->getPost('weight'),
            'weight_class_id' => $this->request->getPost('weight_class_id'),
            'length' => (float) $this->request->getPost('length'),
            'length_class_id' => $this->request->getPost('length_class_id'),
            'width' => (float) $this->request->getPost('width'),
            'height' => (float) $this->request->getPost('height'),
            'subtract' => $this->request->getPost('subtract'),
            'minimum' => $this->request->getPost('minimum'),
            'sort_order' => $this->request->getPost('sort_order'),
            'published' => !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF,
            'viewed' => $this->request->getPost('viewed'),
            'is_comment' => $this->request->getPost('is_comment'),
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
        foreach (list_language_admin() as $language) {
            $edit_data_lang[$language['id']]['language_id'] = $language['id'];
            $edit_data_lang[$language['id']]['product_id'] = $product_id;
            $edit_data_lang[$language['id']]['slug'] = !empty($seo_urls[$language['id']]['route']) ? get_seo_extension($seo_urls[$language['id']]['route']) : '';

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

        $main_image_url = '';
        $product_image_list = $this->request->getPost('product_image');

        if (!empty($product_image_list)) {
            $product_image_sort_order = count($product_image_list);
            foreach ($product_image_list as $value) {
                if (empty($value) || empty($value['image'])) {
                    continue;
                }

                if (stripos($value['image'], UPLOAD_FILE_TMP_DIR) !== false) {
                    $product_image_url = str_replace(UPLOAD_FILE_TMP_DIR, self::FOLDER_UPLOAD."$product_id/", $value['image']);
                    $value['image'] = move_file_tmp($value['image'], $product_image_url);
                }

                $product_image_data = [
                    'product_id' => $product_id,
                    'image' => $value['image'],
                    'sort_order' => $product_image_sort_order,
                ];

                if (!empty($value['product_image_id'])) {
                    $product_image_data['product_image_id'] = $value['product_image_id'];
                }

                $product_image_model->insert($product_image_data);

                --$product_image_sort_order;
                if (!empty($value['image']) && empty($main_image_url)) {
                    $main_image_url = $value['image'];
                }
            }
        }

        // update image main
        if (!empty($main_image_url)) {
            $data_product_image_main['product_id'] = $product_id;
            $data_product_image_main['image'] = $main_image_url;
            $this->model->save($data_product_image_main);
        }

        //product attribute
        $product_attribute_model = new \App\Modules\Products\Models\ProductAttributeModel();
        $product_attribute_model->where(['product_id' => $product_id])->delete();

        $product_attribute_list = $this->request->getPost('product_attribute');
        if (!empty($product_attribute_list)) {
            $data_attribute = [];
            foreach ($product_attribute_list as $value) {
                foreach (list_language_admin() as $language) {
                    if (empty($value['attribute_id']) || empty($value['lang'][$language['id']]['text'])) {
                        continue;
                    }
                    $data_attribute[] = [
                        'product_id' => $product_id,
                        'language_id' => $language['id'],
                        'attribute_id' => $value['attribute_id'],
                        'text' => $value['lang'][$language['id']]['text'],
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
        $seo_urls = $this->request->getPost('seo_urls');
        $route_model->saveRoute($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $product_id));

        //product option
        $product_option_model = new \App\Modules\Products\Models\ProductOptionModel();
        $product_option_value_model = new \App\Modules\Products\Models\ProductOptionValueModel();

        $product_option_model->where(['product_id' => $product_id])->delete();
        $product_option_value_model->where(['product_id' => $product_id])->delete();

        $product_option_list = $this->request->getPost('product_option');
        if (!empty($product_option_list)) {
            foreach ($product_option_list as $value) {
                $product_option_data = [
                    'product_id' => $product_id,
                    'option_id' => $value['option_id'],
                    'required' => $value['required'],
                ];
                if (!empty($value['product_option_id'])) {
                    $product_option_data['product_option_id'] = $value['product_option_id'];
                }
                if ($value['type'] == 'select' || $value['type'] == 'radio' || $value['type'] == 'checkbox' || $value['type'] == 'image') {
                    $product_option_id = $product_option_model->insert($product_option_data);

                    foreach ($value['product_option_value'] as $option_value) {
                        $product_option_value_data = [
                            'product_option_id' => $product_option_id,
                            'product_id' => $product_id,
                            'option_id' => $value['option_id'],
                            'option_value_id' => $option_value['option_value_id'],
                            'quantity' => $option_value['quantity'],
                            'subtract' => $option_value['subtract'],
                            'price' => format_decimal($option_value['price']),
                            'price_prefix' => $option_value['price_prefix'],
                            'points' => $option_value['points'],
                            'points_prefix' => $option_value['points_prefix'],
                            'weight' => $option_value['weight'],
                            'weight_prefix' => $option_value['weight_prefix'],
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

        //Bat dau Variant
        $product_variant_model = new \App\Modules\Products\Models\ProductVariantModel();
        $product_variant_value_model = new \App\Modules\Products\Models\ProductVariantValueModel();

        $variant_value_model = new \App\Modules\Variants\Models\VariantValueModel();
        $variant_value_lang_model = new \App\Modules\Variants\Models\VariantValueLangModel();

        $product_sku_model = new \App\Modules\Products\Models\ProductSkuModel();
        $product_sku_value_model = new \App\Modules\Products\Models\ProductSkuValueModel();

        //xoa tat ca variant trước khi check, nếu co variant thi them vao lại
        $product_variant_model->where(['product_id' => $product_id])->delete();
        $product_variant_value_model->where(['product_id' => $product_id])->delete();
        //product sku
        $product_sku_model->where(['product_id' => $product_id])->delete();

        if ($this->request->getPost('product_variant') && $this->request->getPost('product_variant_combination')) {
            $variant_value_id_list = [];

            //delete cache variant value
            $variant_value_model->deleteCache();

            $sort_product_variant = count($this->request->getPost('product_variant'));

            foreach ($this->request->getPost('product_variant') as $variant) {
                $data_product_variant = [
                    'variant_id' => $variant['variant_id'],
                    'product_id' => $product_id,
                    'sort_order' => $sort_product_variant,
                ];
                $product_variant_model->insert($data_product_variant);
                --$sort_product_variant;

                if (!empty($variant['variant_values'])) {
                    $variant_value_model->where(['variant_id' => $variant['variant_id']])->delete();

                    $sort_product_variant_value = count($variant['variant_values']);

                    foreach ($variant['variant_values'] as $variant_value_key => $variant_value) {
                        if (!empty($variant_value['image']) && stripos($variant_value['image'], UPLOAD_FILE_TMP_DIR) !== false) {
                            $variant_image_url = str_replace(UPLOAD_FILE_TMP_DIR, self::FOLDER_UPLOAD."$product_id/variant_", $variant_value['image']);
                            $variant_value['image'] = move_file_tmp($variant_value['image'], $variant_image_url);
                        }

                        $data_variant_value = [
                            'variant_id' => $variant['variant_id'],
                            'image' => !empty($variant_value['image']) ? $variant_value['image'] : '',
                            'sort_order' => $sort_product_variant_value,
                        ];

                        if (!empty($variant_value['variant_value_id'])) {
                            $data_variant_value['variant_value_id'] = $variant_value['variant_value_id'];
                        }

                        $variant_value_id = $variant_value_model->insert($data_variant_value);
                        $data_variant_value_lang = $variant_value['lang'];
                        foreach (list_language_admin() as $language) {
                            $data_variant_value_lang[$language['id']]['language_id'] = $language['id'];
                            $data_variant_value_lang[$language['id']]['variant_value_id'] = $variant_value_id;
                            $data_variant_value_lang[$language['id']]['variant_id'] = $variant['variant_id'];
                            $data_variant_value_lang[$language['id']]['name'] = trim($data_variant_value_lang[$language['id']]['name']);

                            $variant_value_lang_model->insert($data_variant_value_lang[$language['id']]);
                        }

                        //list variant value row tmp, duoc su dung cho sku
                        $variant_value_id_list[$variant_value_key] = [
                            'variant_id' => $variant['variant_id'],
                            'variant_value_id' => $variant_value_id,
                        ];

                        $data_product_variant_value = [
                            'variant_id' => $variant['variant_id'],
                            'variant_value_id' => $variant_value_id,
                            'product_id' => $product_id,
                            'sort_order' => $sort_product_variant_value,
                        ];
                        $product_variant_value_model->insert($data_product_variant_value);
                        --$sort_product_variant_value;
                    }
                }
            }

            //product sku
            $sort_product_variant_combination = count($this->request->getPost('product_variant_combination'));

            foreach ($this->request->getPost('product_variant_combination') as $combination_key => $combination_value) {
                $data_product_sku = [
                    'product_id' => $product_id,
                    'price' => format_decimal($combination_value['price']),
                    'quantity' => $combination_value['quantity'],
                    'sku' => $combination_value['sku'],
                    'published' => !empty($combination_value['published']) ? STATUS_ON : STATUS_OFF,
                    'sort_order' => $sort_product_variant_combination,
                ];

                if (!empty($combination_value['product_sku_id'])) {
                    $data_product_sku['product_sku_id'] = $combination_value['product_sku_id'];
                }
                $product_sku_id = $product_sku_model->insert($data_product_sku);

                //product sku value
                $product_sku_value_model->where(['product_id' => $product_id, 'product_sku_id' => $product_sku_id])->delete();
                $data_product_sku_value = [];

                $combination_rows = str_ireplace(PRODUCT_VARIANT_COMBINATION_SKU_NAME, '', $combination_key);
                $combination_rows = explode('_', $combination_rows);

                foreach ($combination_rows as $variant_value_row) {
                    if (!isset($variant_value_id_list[$variant_value_row])) {
                        continue;
                    }

                    $data_product_sku_value[] = [
                        'product_sku_id' => $product_sku_id,
                        'product_id' => $product_id,
                        'variant_id' => $variant_value_id_list[$variant_value_row]['variant_id'],
                        'variant_value_id' => $variant_value_id_list[$variant_value_row]['variant_value_id'],
                    ];
                }

                if (!empty($data_product_sku_value)) {
                    $product_sku_value_model->insertBatch($data_product_sku_value);
                }

                --$sort_product_variant_combination;
            }

            //update variant
            $product_variant_list = $product_variant_model->getListVariantByProductId($product_id, $this->language_id);
            $this->model->save(['product_id' => $product_id, 'variant' => json_encode($product_variant_list, JSON_FORCE_OBJECT)]);
        } else {
            //update variant
            $this->model->save(['product_id' => $product_id, 'variant' => '']);
        }
        // het variant

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
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        //add tags
        $this->themes->addCSS('common/js/tags/tagsinput');
        $this->themes->addJS('common/js/tags/tagsinput');

        $this->themes->addCSS('common/plugin/multi-select/css/select2.min');
        $this->themes->addCSS('common/plugin/multi-select/css/select2-bootstrap-5-theme.min');
        $this->themes->addJS('common/plugin/multi-select/js/select2.min');
        if (language_code_admin() == 'vi') {
            $this->themes->addJS('common/plugin/multi-select/js/i18n/vi');
        }

        $this->themes->addJS('common/js/admin/related');

        $this->themes->addJS('common/js/common/currency');

        $this->themes->addJS('common/plugin/shortable-nestable/Sortable.min');

        $this->themes->addCSS('common/js/dropzone/dropdrap');
        $this->themes->addJS('common/js/dropzone/dropdrap');

        $data['language_list'] = list_language_admin();

        //edit
        if (!empty($product_id) && is_numeric($product_id)) {
            $data['text_form'] = lang('ProductAdmin.text_edit');
            $breadcrumb_url = site_url(self::MANAGE_URL."/edit/$product_id");

            $data_form = $this->model->find($product_id);
            if (empty($data_form)) {
                set_alert(lang('Admin.error_empty'), ALERT_ERROR);

                return redirect()->to(site_url(self::MANAGE_URL));
            }

            $data_languages = $this->model_lang->where('product_id', $product_id)->findAll();
            foreach ($data_languages as $value) {
                $data_form['lang'][$value['language_id']] = $value;
            }

            //product filters
            $product_filter_model = new \App\Modules\Products\Models\ProductFilterModel();
            $filter_ids = $product_filter_model->where(['product_id' => $product_id])->findAll();
            $data_form['filter_ids'] = array_column($filter_ids, 'filter_id');

            //product categories
            $product_category_model = new \App\Modules\Products\Models\ProductCategoryModel();
            $category_ids = $product_category_model->where(['product_id' => $product_id])->findAll();
            $data_form['category_ids'] = array_column($category_ids, 'category_id');

            //product related
            $product_related_model = new \App\Modules\Products\Models\ProductRelatedModel();
            $related_ids = $product_related_model->where(['product_id' => $product_id])->findAll();
            $data_form['related_ids'] = array_column($related_ids, 'related_id');

            if (!empty($data_form['related_ids'])) {
                $related_list = $this->model->getListByRelatedIds($data_form['related_ids'], $this->language_id);

                if (!empty($related_list)) {
                    $data_form['related_list_html'] = $this->themes::view('inc/related_list', ['related_list' => $related_list, 'is_checked' => true], true);
                }
            }

            //product image
            $product_image_model = new \App\Modules\Products\Models\ProductImageModel();
            $data_form['image_list'] = $product_image_model->getImagesByProductId($product_id);

            //product attribute
            $product_attribute_model = new \App\Modules\Products\Models\ProductAttributeModel();
            $data_form['product_attribute_list'] = $product_attribute_model->getAttributeByProductId($product_id);

            //lay danh sach seo url tu route
            $route_model = new \App\Modules\Routes\Models\RouteModel();
            $data['seo_urls'] = $route_model->getListByModule(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $product_id));

            //product option
            $product_option_model = new \App\Modules\Products\Models\ProductOptionModel();
            $data_form['product_option_list'] = $product_option_model->getOptionsByProductId($product_id, $this->language_id);

            //product variant
            $product_variant_model = new \App\Modules\Products\Models\ProductVariantModel();
            $product_sku_model = new \App\Modules\Products\Models\ProductSkuModel();

            $data_form['product_variant_list'] = $product_variant_model->getListVariantByProductId($product_id, $this->language_id);
            $data_form['product_sku_list'] = $product_sku_model->getListSkuByProductIds([$product_id]);

            $data['edit_data'] = $data_form;
        } else {
            $data['text_form'] = lang('ProductAdmin.text_add');
            $breadcrumb_url = site_url(self::MANAGE_URL.'/add');
        }

        $stock_status_model = new \App\Modules\Products\Models\StockStatusModel();
        $data['stock_status_list'] = $stock_status_model->getStockStatuses($this->language_id);

        $weight_class_model = new \App\Modules\Products\Models\WeightClassModel();
        $data['weight_class_list'] = $weight_class_model->getWeightClasses($this->language_id);

        $length_class_model = new \App\Modules\Products\Models\LengthClassModel();
        $data['length_class_list'] = $length_class_model->getLengthClasses($this->language_id);

        $manufacturer_model = new \App\Modules\Manufacturers\Models\ManufacturerModel();
        $data['manufacturer_list'] = $manufacturer_model->getManufacturers($this->language_id);

        $category_model = new \App\Modules\Products\Models\CategoryModel();
        $category_list = $category_model->getProductCategories($this->language_id);
        $data['categories_tree'] = format_tree(['data' => $category_list, 'key_id' => 'category_id']);

        $filter_model = new \App\Modules\Filters\Models\FilterModel();
        $data['filter_list'] = $filter_model->getFilters($this->language_id);

        $attribute_model = new \App\Modules\Attributes\Models\AttributeModel();
        $data['attribute_list'] = $attribute_model->getAttributes($this->language_id);
        $data['attribute_default_list'] = $attribute_model->getAttributesDefault($this->language_id);

        $option_model = new \App\Modules\Options\Models\OptionModel();
        $data['option_list'] = $option_model->getOptions($this->language_id);

        $variant_model = new \App\Modules\Variants\Models\VariantModel();
        $data['variant_list'] = $variant_model->getVariants($this->language_id);

        $data['errors'] = $this->errors;

        $this->breadcrumb->add($data['text_form'], $breadcrumb_url);
        add_meta(['title' => $data['text_form']], $this->themes);

        $data['tab_type'] = 'tab_general';
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
        foreach (list_language_admin() as $value) {
            $this->validator->setRule(sprintf('lang.%s.name', $value['id']), lang('ProductAdmin.text_name').' ('.$value['name'].')', 'required');
        }

        if (!empty($this->request->getPost('shipping'))) {
            $this->validator->setRule('length', lang('ProductAdmin.text_length'), 'required|numeric');
            $this->validator->setRule('width', lang('ProductAdmin.text_width'), 'required|numeric');
            $this->validator->setRule('height', lang('ProductAdmin.text_height'), 'required|numeric');
            $this->validator->setRule('weight', lang('ProductAdmin.text_weight'), 'required|numeric');
        }

        if (!empty($this->request->getPost('is_variant')) && $this->request->getPost('product_variant')) {
            $product_variant_list = [];

            foreach ($this->request->getPost('product_variant') as $variant_key => $variant) {
                $this->validator->setRule(
                    sprintf('product_variant.%s.variant_id', $variant_key),
                    lang('ProductAdmin.text_variant_name'),
                    'required',
                );

                if (!empty($product_variant_list[$variant['variant_id']])) {
                    $this->errors[sprintf('product_variant.%s.variant_id', $variant_key)] = lang('ProductAdmin.error_variant_name');
                }
                $product_variant_list[$variant['variant_id']] = $variant['variant_id'];

                if (!empty($variant['variant_values'])) {
                    $variant_value_images = array_filter(array_column($variant['variant_values'], 'image'));

                    $variant_value_name_list = []; // su dung de check phan loai co ton tai trung nhau khong
                    foreach ($variant['variant_values'] as $variant_value_key => $variant_value) {
                        foreach ($variant_value['lang'] as $lang_key => $lang_value) {
                            $variant_value_name_list[$variant_value_key] = $lang_value['name'];
                        }
                    }

                    foreach ($variant['variant_values'] as $variant_value_key => $variant_value) {
                        //kiem tra variant co bi trung nhau khong
                        foreach ($variant_value['lang'] as $lang_key => $lang_value) {
                            $error_variant_values = array_keys($variant_value_name_list, $lang_value['name']);

                            if (empty($error_variant_values)) {
                                continue;
                            }

                            foreach ($error_variant_values as $error_variant_value) {
                                if ($error_variant_value == $variant_value_key) {
                                    continue;
                                }

                                $this->errors[sprintf('product_variant.%s.variant_values.%s.lang.%s.name', $variant_key, $error_variant_value, $lang_key)] = lang('ProductAdmin.error_variant_value_name_unique');
                            }
                            if (!empty($this->errors)) {
                                $this->errors[sprintf('product_variant.%s.variant_values.%s.lang.%s.name', $variant_key, $variant_value_key, $lang_key)] = lang('ProductAdmin.error_variant_value_name_unique');
                            }
                        }

                        if (!empty($variant_value_images)) {
                            $this->validator->setRule(sprintf('product_variant.%s.variant_values.%s.image', $variant_key, $variant_value_key), lang('ProductAdmin.text_variant_value_image'), 'required');
                        }

                        foreach (list_language_admin() as $lang_value) {
                            $this->validator->setRule(sprintf('product_variant.%s.variant_values.%s.lang.%s.name', $variant_key, $variant_value_key, $lang_value['id']), lang('ProductAdmin.text_variant_value').' ('.$lang_value['name'].')', 'required|max_length[50]|min_length[1]');
                        }
                    }
                }
            }

            if (empty($this->request->getPost('product_variant_combination'))) {
                $this->errors['product_variant_combination'] = lang('Validation.required', ['field' => lang('ProductAdmin.text_variant_list')]);
            }

            foreach ($this->request->getPost('product_variant_combination') as $combination_key => $combination_value) {
                if (format_decimal($combination_value['price']) < config_item('price_minimum')) {
                    $this->errors[sprintf('product_variant_combination.%s.price', $combination_key)] = lang('Validation.greater_than_equal_to', ['field' => lang('ProductAdmin.text_price'), 'param' => config_item('price_minimum')]);
                }

                $this->validator->setRule(sprintf('product_variant_combination.%s.price', $combination_key), lang('ProductAdmin.text_price'), 'required|decimal');
                $this->validator->setRule(sprintf('product_variant_combination.%s.quantity', $combination_key), lang('ProductAdmin.text_quantity'), 'required|is_natural');
            }
        } else {
            if (format_decimal($this->request->getPost('price')) < config_item('price_minimum')) {
                $this->errors['price'] = lang('Validation.greater_than_equal_to', ['field' => lang('ProductAdmin.text_price'), 'param' => config_item('price_minimum')]);
            }
            $this->validator->setRule('price', lang('ProductAdmin.text_price'), 'required|decimal');
            $this->validator->setRule('quantity', lang('ProductAdmin.text_quantity'), 'required|is_natural');
        }

        if (!empty($this->request->getPost('product_option'))) {
            foreach ($this->request->getPost('product_option') as $product_option_key => $product_option) {
                if (empty($product_option['product_option_value'])) {
                    continue;
                }

                foreach ($product_option['product_option_value'] as $option_value_key => $option_value) {
                    if (!is_null($option_value['price']) && $option_value['price'] > 0 && format_decimal($option_value['price']) < config_item('price_minimum')) {
                        $this->errors['product_option_errors'] = lang('Validation.greater_than_equal_to', ['field' => lang('ProductAdmin.text_price'), 'param' => config_item('price_minimum')]);
                    }
                }
            }
        }

        //$this->validator->setRule('model', lang('ProductAdmin.text_model'), 'required');

        //        if (!empty($this->request->getPost('product_attribute'))) {
        //            foreach ($this->request->getPost('product_attribute') as $key => $value) {
        //                if (empty($value['lang'])) {
        //                    continue;
        //                }
        //                foreach(list_language_admin() as $lang_value) {
        //                    $this->validator->setRule(sprintf('product_attribute.%s.lang.%s.text', $key, $lang_value['id']), lang('ProductAdmin.text_text') . ' (' . $lang_value['name']  . ')', 'required');
        //                }
        //            }
        //        }

        if (!empty($this->errors)) {
            return false;
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

            $list_delete = $this->model->getProductsByIds($ids, $this->language_id);
            if (empty($list_delete)) {
                json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
            }

            $this->model->delete($ids);
            //$this->model_value->whereIn('product_id', $ids)->delete();

            //xoa slug ra khoi route
            $route_model = new \App\Modules\Routes\Models\RouteModel();
            foreach ($list_delete as $value) {
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

        $delete_ids = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->model->getProductsByIds($delete_ids, $this->language_id);
        if (empty($list_delete)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $data['list_delete'] = $list_delete;
        $data['ids'] = implode(',', $delete_ids);

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

        $related_list = $this->model->findRelated($this->request->getPost('related'), $this->language_id, $this->request->getPost('id'));

        $data = [
            'status' => 'ok',
            'view' => $this->themes::view('inc/related_list', ['related_list' => $related_list], true),
        ];

        json_output($data);
    }

    public function getSkuList()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $errors = [];

        $product_id = $this->request->getGet('product_id');

        $product_info = $this->model->where(['product_id' => $product_id])->first();
        if (empty($product_info)) {
            $errors[] = lang('Admin.error_empty');
        }

        $variant_model = new \App\Modules\Variants\Models\VariantModel();
        $variant_list = $variant_model->getVariants($this->language_id);

        $product_sku_model = new \App\Modules\Products\Models\ProductSkuModel();
        $product_sku_list = $product_sku_model->getListSkuByProductIds([$product_id]);

        foreach ($product_sku_list as $sku_key => $sku) {
            //variant option
            $sku_name = [];
            foreach ($sku['sku_value_list'] as $sku_value) {
                if (empty($variant_list[$sku_value['variant_id']]['value_list'][$sku_value['variant_value_id']])) {
                    $sku_name[] = $sku_value['variant_value_id'];
                } else {
                    $sku_name[] = $variant_list[$sku_value['variant_id']]['value_list'][$sku_value['variant_value_id']]['name'];
                }
            }

            $product_sku_list[$sku_key]['sku_name'] = implode(' - ', $sku_name);
        }

        $product_info['sku_list'] = $product_sku_list;

        $data = [
            'product' => $product_info,
            'errors' => $errors,
        ];

        echo $this->themes::view('inc/product_sku_form', $data);
    }

    public function editSku()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $token = csrf_hash();

        if (!isset($_POST) || empty($_POST)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $this->errors = [];

        if (!empty($this->request->getPost('product_sku'))) {
            foreach ($this->request->getPost('product_sku') as $sku) {
                if (format_decimal($sku['price']) < config_item('price_minimum')) {
                    $this->errors[sprintf('product_sku.%s.price', $sku['product_sku_id'])] = lang('Validation.greater_than_equal_to', ['field' => lang('ProductAdmin.text_price'), 'param' => config_item('price_minimum')]);
                }

                $this->validator->setRule(sprintf('product_sku.%s.product_id', $sku['product_sku_id']), lang('ProductAdmin.text_product_id'), 'required');
                $this->validator->setRule(sprintf('product_sku.%s.product_sku_id', $sku['product_sku_id']), lang('ProductAdmin.text_product_sku_id'), 'required');
                $this->validator->setRule(sprintf('product_sku.%s.price', $sku['product_sku_id']), lang('ProductAdmin.text_price'), 'required|decimal');
                $this->validator->setRule(sprintf('product_sku.%s.quantity', $sku['product_sku_id']), lang('ProductAdmin.text_quantity'), 'required|is_natural');
            }
        }

        if (!empty($this->request->getPost('product_info'))) {
            if (format_decimal($this->request->getPost('product_info')['price']) < config_item('price_minimum')) {
                $this->errors['product_info.price'] = lang('Validation.greater_than_equal_to', ['field' => lang('ProductAdmin.text_price'), 'param' => config_item('price_minimum')]);
            }

            $this->validator->setRule('product_info.product_id', lang('ProductAdmin.text_product_id'), 'required');
            $this->validator->setRule('product_info.price', lang('ProductAdmin.text_price'), 'required|decimal');
            $this->validator->setRule('product_info.quantity', lang('ProductAdmin.text_quantity'), 'required|is_natural');
        }

        if (!$this->validator->withRequest($this->request)->run()) {
            $this->errors = $this->validator->getErrors();
        }

        if (!empty($this->errors)) {
            json_output(['token' => $token, 'status' => 'ng', 'error' => $this->errors]);
        }

        $product_id = null;
        $sku_quantity = 0;
        $price_show = '';

        if (!empty($this->request->getPost('product_sku'))) {
            $data_edit = [];

            foreach ($this->request->getPost('product_sku') as $sku) {
                $data_edit[] = [
                    'product_sku_id' => $sku['product_sku_id'],
                    'price' => format_decimal($sku['price']),
                    'quantity' => $sku['quantity'],
                ];

                $sku_prices[$sku['price']] = service('currency')->format(format_decimal($sku['price']), config_item('currency'));
                $sku_quantity += $sku['quantity'];
                $product_id = $sku['product_id'];
            }

            $product_sku_model = new \App\Modules\Products\Models\ProductSkuModel();
            $product_sku_model->updateBatch($data_edit, 'product_sku_id');

            sort($sku_prices);
            if (count($sku_prices) > 2) {
                $sku_prices = [$sku_prices[0], $sku_prices[count($sku_prices) - 1]];
            }

            $price_show = implode(' - ', $sku_prices);
        } elseif (!empty($this->request->getPost('product_info'))) {
            $data_edit = [
                'product_id' => $this->request->getPost('product_info')['product_id'],
                'price' => format_decimal($this->request->getPost('product_info')['price']),
                'quantity' => $this->request->getPost('product_info')['quantity'],
            ];

            $this->model->save($data_edit);

            $sku_quantity = $data_edit['quantity'];
            $price_show = service('currency')->format($data_edit['price'], config_item('currency'));
            $product_id = $data_edit['product_id'];
        }

        $data = [
            'price' => $price_show,
            'quantity' => $sku_quantity,
            'product_id' => $product_id,
        ];

        set_alert(lang('Admin.text_edit_success'), ALERT_SUCCESS, ALERT_POPUP);
        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_edit_success'), 'data' => $data]);
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

        $id = $this->request->getPost('id');
        $item_edit = $this->model->find($id);
        if (empty($item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $item_edit['published'] = !empty($this->request->getPost('published')) ? STATUS_ON : STATUS_OFF;
        if (!$this->model->update($id, $item_edit)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_json')]);
        }

        $data = ['token' => $token, 'status' => 'ok', 'msg' => lang('Admin.text_published_success')];

        json_output($data);
    }
}
