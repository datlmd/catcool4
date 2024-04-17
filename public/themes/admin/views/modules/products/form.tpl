{strip}
    <style>
        .list-group-item {
            margin-bottom: 0px !important;
        }
    </style>

    {form_hidden('manage_url', site_url($manage_url))}

    <div id="simple-list-example" class="text-end fixed-top mt-5 d-none d-lg-block" style="width: 160px; right: 3px; top: 60px; left: auto;">
        <button type="button" id="btn_search" class="btn btn-sm btn-light" data-bs-toggle="tooltip" data-target="#product_menu_list"><i class="fas fa-list"></i></button>
        <div class="list-group collapse show mt-1" id="product_menu_list">
            <a class="list-group-item list-group-item-action p-1" href="#content_product_general">{lang('Admin.tab_general')}</a>
            <a class="list-group-item list-group-item-action p-1" href="#content_product_images">{lang('Admin.tab_image')}</a>
            <a class="list-group-item list-group-item-action p-1" href="#content_product_attributes">{lang('ProductAdmin.text_attribute_title')}</a>
            <a class="list-group-item list-group-item-action p-1" href="#content_product_data">{lang('ProductAdmin.text_sales_information')}</a>
            <a class="list-group-item list-group-item-action p-1" href="#content_product_shipping">{lang('ProductAdmin.text_shipping_title')}</a>
            <a class="list-group-item list-group-item-action p-1" href="#content_product_other_title">{lang('ProductAdmin.text_other_title')}</a>
            <a class="list-group-item list-group-item-action p-1" href="#content_product_option">{lang('Admin.tab_option')}</a>
            <a class="list-group-item list-group-item-action p-1" href="#content_product_links">{lang('Admin.tab_links')}</a>
        </div>
    </div>
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}

            <input type="hidden" name="product_id" value="{$edit_data.product_id}">
            <input type="hidden" name="master_id" value="{$edit_data.master_id|default:0}">
            <input type="hidden" name="variant" value="{$edit_data.variant|default:""}">
            <input type="hidden" name="override" value="{$edit_data.override|default:""}">

            <div class="row" data-bs-spy="scroll" data-bs-target="#simple-list-example" data-bs-offset="0" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductAdmin.heading_title')}
                        </div>
                        <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                            <div id="form_btn_save_fixed">
                                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                                <a href="{back_to($manage_url)}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                            </div>
                        </div>
                    </div>

                    {if !empty(print_flash_alert())}
                        {print_flash_alert()}
                    {/if}
                    {if !empty($errors)}
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    {/if}

                    <div class="card" id="content_product_general">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.product_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body px-0">
                            {include file=get_theme_path('views/modules/products/inc/tab_general.tpl')}
                        </div>
                    </div>

                    <div class="card" id="content_product_images">
                        <h5 class="card-header">{lang('Admin.tab_image')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_images.tpl')}
                        </div>
                    </div>

                    <div class="card" id="content_product_attributes">
                        <h5 class="card-header">{lang('ProductAdmin.text_attribute_title')}</h5>

                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_attributes.tpl')}
                        </div>
                    </div>

                    <div class="card" id="content_product_data">
                        <h5 class="card-header">{lang('ProductAdmin.text_sales_information')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_data.tpl')}
                        </div>
                    </div>

                    <div class="card" id="content_product_shipping">
                        <h5 class="card-header">{lang('ProductAdmin.text_shipping_title')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_shipping.tpl')}
                        </div>
                    </div>

                    <div class="card" id="content_product_other_title">
                        <h5 class="card-header">{lang('ProductAdmin.text_other_title')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_other.tpl')}
                        </div>
                    </div>

                    <div class="card" id="content_product_option">
                        <h5 class="card-header">{lang('Admin.tab_option')}</h5>

                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_options.tpl')}
                        </div>
                    </div>

                    <div class="card" id="content_product_links">
                        <h5 class="card-header">{lang('Admin.tab_links')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_links.tpl')}
                        </div>
                    </div>
                </div>
            </div>

        {form_close()}
    </div>

    {* template product attribute *}
    <div id="html_product_attribute_row" style="display: none">
        <table>
            <tbody>
            <tr id="product_attribute_row_{'product_attribute_row_value'}">
                <td class="text-start">

                    <select name="product_attribute[{'product_attribute_row_value'}][attribute_id]" id="input_product_attribute_{'product_attribute_row_value'}_attribute_id" class="form-control form-control-sm">
                        {foreach $attribute_list as $attribute}
                            {if isset($attribute_default_list[$attribute.attribute_id])}
                                {continue}
                            {/if}
                            <option value="{$attribute.attribute_id}">{$attribute.name}</option>
                        {/foreach}
                    </select>
                    <div id="error_product_attribute_{'product_attribute_row_value'}_attribute_id" class="invalid-feedback"></div>

                </td>
                <td class="text-start">


                    {foreach $language_list as $language}
                        <div class="input-group {if !$language@last}mb-2{/if}">
                            {if $language_list|count > 1}<span class="input-group-text">{$language.icon}</span>{/if}
                            <input type="text" name="product_attribute[{'product_attribute_row_value'}][lang][{$language.id}][text]" value='{old("product_attribute[{'product_attribute_row_value'}][lang][{$language.id}][text]")}' id="input_product_attribute_{'product_attribute_row_value'}_lang_{$language.id}_text" class="form-control" >
                        </div>
                        <div id="error_product_attribute_{'product_attribute_row_value'}_lang_{$language.id}_text" class="invalid-feedback"></div>
                    {/foreach}

                </td>
                <td class="text-center">
                    <button type="button" onclick="$('#product_attribute_row_{'product_attribute_row_value'}').remove();" class="btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    {* end template product attribute *}

    {* template product image *}
    <div id="html_product_image" style="display: none">

        <input type="hidden" name="product_image[{'product_image_row_value'}][product_image_id]" value="" />

        <a href="javascript:void(0);" class="ms-0" id="product_image_{'product_image_row_value'}_image" data-target="input_product_image_{'product_image_row_value'}_image" data-thumb="product_image_{'product_image_row_value'}_load_image_url" data-type="image" data-bs-toggle="image">
            <img src="{image_default_url()}" style="background-image: url('{image_default_url()}')"  alt="" title="" id="product_image_{'product_image_row_value'}_load_image_url" data-is-background="true" data-placeholder="{image_default_url()}"/>
            <div class="btn-group w-100 mt-1" role="group">
                <button type="button" class="button-image btn btn-xs btn-light" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" onclick="$(this).parent().parent().parent().remove();" class="btn btn-xs btn-light" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
            </div>
        </a>
        <input type="hidden" name="product_image[{'product_image_row_value'}][image]" value="" id="input_product_image_{'product_image_row_value'}_image" />

    </div>
    <input type="hidden" name="product_image_row" id="product_image_row" value="{if !empty($edit_data.image_list)}{$edit_data.image_list|@count}{else}0{/if}">
    {* end template product image *}

    {* template product variant *}
    <div id="html_product_variant_value_form" style="display: none">
        {include file=get_theme_path('views/modules/products/inc/variant_value_form.tpl')}
    </div>
    <div id="html_product_variant_value_form_image" style="display: none">
        {include file=get_theme_path('views/modules/products/inc/variant_value_form.tpl') variant_index=0}
    </div>
    <div id="html_product_variant_form" style="display: none">
        {include file=get_theme_path('views/modules/products/inc/variant_form.tpl')}
    </div>

    <div id="html_product_variant_value_form_td" style="display: none">
        <table>
            <tr>
                {include file=get_theme_path('views/modules/products/inc/variant_sku_form.tpl')
                    product_variant_combination_attr_id='data-id'
                }
{*                <input type="hidden" name="product_variant_combination[__variant_info_row_id__][product_sku_id]" value="" data-id="__variant_info_row_id___product_sku_id" >*}

{*                <td data-id="__variant_info_row_id___price">*}
{*                    <div class="input-group">*}
{*                        <span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>*}
{*                        <input type="number" step="0.01" name="product_variant_combination[__variant_info_row_id__][price]" value="0" data-id="input_product_variant_combination___variant_info_row_id___price" class="form-control">*}
{*                    </div>*}
{*                    <div data-id="error_product_variant_combination___variant_info_row_id___price" class="invalid-feedback"></div>*}
{*                </td>*}
{*                <td data-id="__variant_info_row_id___quantity">*}
{*                    <input type="number" min="0" name="product_variant_combination[__variant_info_row_id__][quantity]" value="0" data-id="input_product_variant_combination___variant_info_row_id___quantity" class="form-control">*}
{*                    <div data-id="error_product_variant_combination___variant_info_row_id___quantity" class="invalid-feedback"></div>*}
{*                </td>*}
{*                <td data-id="__variant_info_row_id___sku">*}
{*                    <input type="text" name="product_variant_combination[__variant_info_row_id__][sku]" value="" data-id="input_product_variant_combination___variant_info_row_id___sku" class="form-control">*}
{*                    <div data-id="error_product_variant_combination___variant_info_row_id___sku" class="invalid-feedback"></div>*}
{*                </td>*}
{*                <td data-id="__variant_info_row_id___published">*}
{*                    <div class="switch-button switch-button-xs catcool-center">*}
{*                        {form_checkbox("product_variant_combination[__variant_info_row_id__][published]", true, true, ['id' => "input_product_variant_combination___variant_info_row_id___published"])}*}
{*                        <span><label for="input_product_variant_combination___variant_info_row_id___published"></label></span>*}
{*                    </div>*}
{*                </td>*}
            </tr>
        </table>
    </div>

    {* end template product variant *}

{/strip}
