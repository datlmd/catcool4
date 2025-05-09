<?php

namespace App\Modules\Products\Controllers;

use App\Controllers\MyController;
use App\Modules\Products\Models\CategoryModel;
use App\Modules\Products\Models\ProductModel;

class Category extends MyController
{
    public $config_form = [];

    public function index($slug = null, $category_id = null)
    {
        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $limit = !empty($this->request->getGet('limit')) ? $this->request->getGet('limit') : config_item('product_pagination');
        $page = $this->request->getGet('page');
        $filter = $this->request->getGet('filter');
        $sort = !empty($this->request->getGet('sort')) ? $this->request->getGet('sort') : 'p.sort_order';
        $order = !empty($this->request->getGet('order')) ? $this->request->getGet('order') : 'ASC';

        if (is_numeric($slug) && empty($category_id)) {
            $category_id = (int) $slug;
        }

        $category_model = new CategoryModel();
        $category_list = $category_model->getProductCategories($this->language_id);
        if (empty($category_list[$category_id])) {
            page_not_found();
        }

        foreach ($category_list as $key => $value) {
            unset($category_list[$key]['lang']);
            $category_list[$key]['href'] = $category_model->getUrl($value);
            $category_list[$key]['thumb'] = image_thumb_url(html_entity_decode($value['image'], ENT_QUOTES, 'UTF-8'), config_item('product_category_image_thumb_width'), config_item('product_category_image_thumb_height'));
        }
        $category_info = $category_list[$category_id];

        $parent_list = get_list_tree_selected($category_list, $category_id, 'category_id');
        $parent_id = key($parent_list);
        if (empty($category_list[$parent_id])) {
            page_not_found();
        }

        $category_tree = format_tree([$category_list, 'category_id']);
        $category_list = $category_model->getChildrenQuantity($category_list, $category_tree);

        $product_model = new ProductModel();

        $filter_data = [
            'filter_category_id'  => $category_id,
            'filter_sub_category' => true,
            'filter_filter'       => $filter,
            'sort'                => $sort,
            'order'               => $order,
            'start'               => ($page - 1) * $limit,
            'limit'               => $limit
        ];

        $product_list = [];
        list($products, $product_pager) = $product_model->getProducts($filter_data, $this->language_id);

        foreach ($products as $key => $value) {
            $price = service('currency')->format($value['price'], session('currency'));
            $special = service('currency')->format(199000, session('currency'));
            $tax = 10;
            $product = [
                'product_id'  => $value['product_id'],
                'thumb'       => image_thumb_url($value['image'], config_item('product_image_width'), config_item('product_image_height')),
                'name'        => $value['name'],
                'description' => mb_substr(trim(strip_tags(html_entity_decode($value['description'], ENT_QUOTES, 'UTF-8'))), 0, config_item('product_description_length')) . '...',
                'price'       => $price,
                'special'     => $special,
                'tax'         => $tax,
                'minimum'     => $value['minimum'] > 0 ? $value['minimum'] : 1,
                'rating'      => $value['rating'],
                'href'        => $product_model->getUrl($value)
            ];
            $product_list[] = $this->themes->view('thumb', $product, true);
        }

        //Sort List
        $url = '';

        if (!empty($this->request->getGet('filter'))) {
            $url .= '&filter=' . $filter;
        }

        if (!empty($this->request->getGet('limit'))) {
            $url .= '&limit=' . $limit;
        }

        $sorts = [];

        $sorts[] = [
            'text'  => lang('ProductCategory.text_default'),
            'value' => 'p.sort_order-ASC',
            'href'  => $category_info['href'] . '&sort=p.sort_order&order=ASC' . $url
        ];

        $sorts[] = [
            'text'  => lang('ProductCategory.text_name_asc'),
            'value' => 'pd.name-ASC',
            'href'  => $category_info['href'] . '&sort=pd.name&order=ASC' . $url
        ];

        $sorts[] = [
            'text'  => lang('ProductCategory.text_name_desc'),
            'value' => 'pd.name-DESC',
            'href'  => $category_info['href'] . '&sort=pd.name&order=DESC' . $url
        ];

        $sorts[] = [
            'text'  => lang('ProductCategory.text_price_asc'),
            'value' => 'p.price-ASC',
            'href'  => $category_info['href'] . '&sort=p.price&order=ASC' . $url
        ];

        $sorts[] = [
            'text'  => lang('ProductCategory.text_price_desc'),
            'value' => 'p.price-DESC',
            'href'  => $category_info['href'] . '&sort=p.price&order=DESC' . $url
        ];

        if (config_item('config_review_status')) {
            $sorts[] = [
                'text'  => lang('ProductCategory.text_rating_desc'),
                'value' => 'rating-DESC',
                'href'  => $category_info['href'] . '&sort=rating&order=DESC' . $url
            ];

            $sorts[] = [
                'text'  => lang('ProductCategory.text_rating_asc'),
                'value' => 'rating-ASC',
                'href'  => $category_info['href'] . '&sort=rating&order=ASC' . $url
            ];
        }

        $sorts[] = [
            'text'  => lang('ProductCategory.text_model_asc'),
            'value' => 'p.model-ASC',
            'href'  => $category_info['href'] . '&sort=p.model&order=ASC' . $url
        ];

        $sorts[] = [
            'text'  => lang('ProductCategory.text_model_desc'),
            'value' => 'p.model-DESC',
            'href'  => $category_info['href'] . '&sort=p.model&order=DESC' . $url
        ];

        //Limit
        $url = '';

        if (!empty($this->request->getGet('filter'))) {
            $url .= '&filter=' . $filter;
        }

        if (!empty($this->request->getGet('sort'))) {
            $url .= '&sort=' . $sort;
        }

        if (!empty($this->request->getGet('order'))) {
            $url .= '&order=' . $order;
        }

        $limits = array_unique([(int)config_item('product_pagination'), 25, 50, 75, 100]);

        sort($limits);

        foreach ($limits as $key => $value) {
            $limits[$key] = [
                'text'  => $value,
                'value' => $value,
                'href'  => $category_info['href'] . $url . '&limit=' . $value
            ];
        }


        $data = [
            'product_list' => $product_list,
            // 'page_list' => $page_list,
            'sorts' => $sorts,
            'limits' => $limits,
            'category_list' => $category_list,
            'category_parent' => $category_list[$parent_id],
            'category_id' => $category_id
        ];

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->_addBreadcrumb($parent_list[$parent_id]);

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => $category_info['name'],
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        $this->_setMeta($category_info);

        theme_load('category', $data);
    }

    private function _setMeta($detail)
    {
        //META
        $data_meta = [
            'title'       => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description' => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'keywords'    => !empty($detail['meta_keyword']) ? $detail['meta_keyword'] : "",
            'url'         => $detail['href'],
        ];

        add_meta($data_meta, $this->themes);
    }

    private function _addBreadcrumb($data)
    {
        $this->breadcrumb->add($data['name'], $data['href']);
        if (!empty($data['subs'])) {
            foreach ($data['subs'] as $value) {
                $this->_addBreadcrumb($value);
            }
        }
    }
}
