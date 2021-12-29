{* thong tin ve san pham *}
{capture name=product_info}
    <div class="tab-regular">
        <ul class="nav nav-tabs border-bottom ps-3" id="tab_multi_language" role="tablist">
            {if count($list_lang) > 1}
                {foreach $list_lang as $language}
                    <li class="nav-item">
                        {if !empty($id_content_tab)}
                            <a class="nav-link p-2 ps-3 pe-3 {if $language.active}active{/if}" id="{$id_content_tab}_tab_{$language.id}" data-bs-toggle="tab" href="#{$id_content_tab}_{$language.id}" role="tab" aria-controls="{$id_content_tab}_{$language.id}" aria-selected="{if $language.active}true{else}false{/if}">{$language.icon}{$language.name}</a>
                        {else}
                            <a class="nav-link p-2 ps-3 pe-3 {if $language.active}active{/if}" id="language_tab_{$language.id}" data-bs-toggle="tab" href="#lanuage_content_{$language.id}" role="tab" aria-controls="lanuage_content_{$language.id}" aria-selected="{if $language.active}true{else}false{/if}">{$language.icon}{$language.name}</a>
                        {/if}
                    </li>
                {/foreach}
            {/if}
        </ul>
        <div class="tab-content border-0 p-3" id="dummy_tab_content">
            {foreach $list_lang as $language}
                <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                    <div class="form-group row required has-error">
                        <label class="col-12 col-sm-2 col-form-label required-label text-sm-end">
                            {lang('text_name')}
                        </label>
                        <div class="col-12 col-sm-9 col-lg-9">
                            <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                            {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                            {/if}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-sm-end">
                            {lang('text_description')}
                        </label>
                        <div class="col-12 col-sm-9 col-lg-9">
                            <textarea name="manager_description[{$language.id}][description]" cols="40" rows="2" data-bs-toggle="tinymce" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-sm-end">
                            {lang('text_tags')}
                        </label>
                        <div class="col-12 col-sm-9 col-lg-9">
                            <input type="text" name="manager_description[{$language.id}][tag]" data-role="tagsinput" value='{set_value("manager_description[`$language.id`][tag]", $edit_data.details[$language.id].tag)}' id="input_tag[{$language.id}]" class="form-control">
                            <small class="form-text text-muted">{lang('help_tags')}</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-sm-end">
                            {lang('tab_seo')}
                        </label>
                        <div class="col-12 col-sm-9 col-lg-9 pt-2">
                            {include file=get_theme_path('views/inc/seo_form.tpl') name_seo_url=''}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/capture}
{* end thong tin ve san pham *}

{* data san pham *}
{capture name=product_data}
    <div class="form-group">
        {lang('text_published')}
        <div class="switch-button switch-button-xs float-end mt-1">
            {if isset($edit_data.published)}
                <input type="checkbox" name="status" value="{STATUS_ON}" {set_checkbox('status', STATUS_ON, ($edit_data.status == STATUS_ON))} id="status">
            {else}
                <input type="checkbox" name="status" value="{STATUS_ON}" {set_checkbox('status', STATUS_ON, true)} id="status">
            {/if}
            <span><label for="status"></label></span>
        </div>
    </div>
    <div class="form-group mt-3 mb-3">
        {lang('text_is_comment')}<br />
        <label class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_OFF}" {set_radio('is_comment', COMMENT_STATUS_OFF, ($edit_data.is_comment == COMMENT_STATUS_OFF))}><span class="custom-control-label">{lang('text_comment_status_off')}</span>
        </label><br/>
        <label class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_CONFIRM}" {set_radio('is_comment', COMMENT_STATUS_CONFIRM, ($edit_data.is_comment == COMMENT_STATUS_CONFIRM))}><span class="custom-control-label">{lang('text_comment_status_confirm')}</span>
        </label><br/>
        <label class="custom-control custom-radio custom-control-inline">
            {if isset($edit_data.is_comment)}
                <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, ($edit_data.is_comment == COMMENT_STATUS_ON))}><span class="custom-control-label">{lang('text_comment_status_on')}</span>
            {else}
                <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, true)}><span class="custom-control-label">{lang('text_comment_status_on')}</span>
            {/if}
        </label>
    </div>
    <div class="form-group">
        {lang('text_sort_order')}
        <input type="number" name="sort_order" value="{if $edit_data.product_id}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
    </div>
{/capture}

{* model san pham *}
{capture name=product_model}
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end required-label">{lang('text_model')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="model" value="{set_value('model', $edit_data.model)}" id="model" class="form-control {if !empty(form_error("model"))}is-invalid{/if}">
            {if !empty(form_error("model"))}
                <div class="invalid-feedback">{form_error("model")}</div>
            {/if}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_sku')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="sku" value="{set_value('sku', $edit_data.sku)}" id="sku" class="form-control">
            <small class="form-text text-muted">{lang('help_sku')}</small>
        </div>
    </div>
    <div class="form-group row d-none">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_upc')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="upc" value="{set_value('upc', $edit_data.upc)}" id="upc" class="form-control">
            <small class="form-text text-muted">{lang('help_upc')}</small>
        </div>
    </div>
    <div class="form-group row d-none">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_ean')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="ean" value="{set_value('ean', $edit_data.ean)}" id="ean" class="form-control">
            <small class="form-text text-muted">{lang('help_ean')}</small>
        </div>
    </div>
    <div class="form-group row d-none">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_jan')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="jan" value="{set_value('jan', $edit_data.jan)}" id="jan" class="form-control">
            <small class="form-text text-muted">{lang('help_jan')}</small>
        </div>
    </div>
    <div class="form-group row d-none">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_isbn')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="isbn" value="{set_value('isbn', $edit_data.isbn)}" id="isbn" class="form-control">
            <small class="form-text text-muted">{lang('help_isbn')}</small>
        </div>
    </div>
    <div class="form-group row d-none">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_mpn')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="mpn" value="{set_value('mpn', $edit_data.mpn)}" id="mpn" class="form-control">
            <small class="form-text text-muted">{lang('help_mpn')}</small>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_location')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="location" value="{set_value('location', $edit_data.location)}" id="location" class="form-control">
        </div>
    </div>
{/capture}

{* model san pham *}
{capture name=product_price}
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_price')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="price" value="{set_value('price', $edit_data.price)}" id="price" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_tax_class_id')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="tax_class_id" value="{set_value('tax_class_id', $edit_data.tax_class_id)}" id="tax_class_id" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_points')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="points" value="{set_value('points', $edit_data.points)}" id="points" class="form-control">
            <small class="form-text text-muted">{lang('help_points')}</small>
        </div>
    </div>
    <div class="form-group">
        {lang('text_reward_points')}
        {*<input type="text" name="points" value="{set_value('points', $edit_data.reward_points)}" id="points" class="form-control">*}
    </div>
{/capture}

{capture name=product_image}
    <div class="form-group">
        <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image">
            <img src="{if !empty($edit_data.images)}{image_thumb_url($edit_data.images)}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
            <button type="button" id="button-image" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('text_photo_edit')}</button>
            <button type="button" id="button-clear" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('text_photo_clear')}</button>
        </a>
        <input type="hidden" name="image" value="{$edit_data.images}" id="input-image-path" />
    </div>
{/capture}

{capture name=product_stock}
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_quantity')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="quantity" value="{set_value('quantity', $edit_data.quantity)}" id="quantity" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_minimum')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="minimum" value="{set_value('minimum', $edit_data.minimum)}" id="minimum" class="form-control">
            <small class="form-text text-muted">{lang('help_minimum')}</small>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_subtract')}</label>
        <div class="col-12 col-sm-9 col-lg-9 pt-1">
            <div class="switch-button switch-button-xs mt-1">
                <input type="checkbox" name="subtract" value="{STATUS_ON}" {if $edit_data.product_id}{if $edit_data.subtract eq true}checked="checked"{/if}{else}checked="checked"{/if} id="subtract">
                <span><label for="subtract"></label></span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_stock_status_id')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <select name="stock_status_id" id="stock_status_id" class="form-control">
                {foreach $stock_status as $key => $value}
                    <option value="{$key}" {if $edit_data.length_class_id eq $key}selected="selected"{/if}>{$value}</option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_date_available')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <input type="text" name="date_available" value="{set_value('date_available', $edit_data.date_available)}" id="date_available" class="form-control">
        </div>
    </div>
{/capture}
{capture name=product_shipping}
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_shipping')}</label>
        <div class="col-12 col-sm-9 col-lg-9 pt-1">
            <div class="switch-button switch-button-xs mt-1">
                <input type="checkbox" name="shipping" value="{STATUS_ON}" {if $edit_data.product_id}{if $edit_data.shipping eq true}checked="checked"{/if}{else}checked="checked"{/if} id="shipping">
                <span><label for="shipping"></label></span>
            </div>
            <small class="form-text text-muted">{lang('help_shipping')}</small>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_dimension')}</label>
        <div class="col-12 col-sm-9 col-lg-9 input-group">
            <input type="text" name="length" value="{set_value('length', $edit_data.length)}" id="length" class="form-control" placeholder="{lang('text_length')}">
            <input type="text" name="width" value="{set_value('width', $edit_data.width)}" id="width" class="form-control" placeholder="{lang('text_width')}">
            <input type="text" name="height" value="{set_value('height', $edit_data.height)}" id="height" class="form-control" placeholder="{lang('text_height')}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_length_class_id')}</label>
        <div class="col-12 col-sm-9 col-lg-9">
            <select name="length_class_id" id="length_class_id" class="form-control">
                {*<option value="">{lang('text_select')}</option>*}
                {foreach $length_class as $key => $value}
                    <option value="{$key}" {if $edit_data.length_class_id eq $key}selected="selected"{/if}>{$value}</option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_weight')}</label>
        <div class="col-12 col-sm-9 col-lg-9 input-group">
            <input type="text" name="weight" value="{set_value('weight', $edit_data.weight)}" id="weight" class="form-control">
            <div class="input-group-append be-addon">
                <select name="weight_class_id" id="weight_class_id" class="form-control">
                    {*<option value="">{lang('text_select')}</option>*}
                    {foreach $weight_class as $key => $value}
                        <option value="{$key}" {if $edit_data.weight_class_id eq $key}selected="selected"{/if}>{$value}</option>
                    {/foreach}
                </select>
            </div>
            {*<input type="text" name="weight_class_id" value="{set_value('weight_class_id', $edit_data.weight_class_id)}" id="weight_class_id" class="form-control">*}
        </div>
    </div>
{/capture}

{capture name=product_links}
    <div class="form-group">
        {lang('text_category')}
        {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
        <select name="category_ids[]" id="category_ids[]" class="selectpicker form-control form-control-sm" data-style="btn-outline-light" data-size="8" title="{lang('text_select')}" multiple data-actions-box="false" data-live-search="true" data-selected-text-format="count > 2">
            {draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, $edit_data.categories)}
        </select>
        <div id="category_review" class="w-100 p-3 bg-light"></div>
    </div>
    <div class="form-group">
        {lang('text_manufacturer_id')}
        <input type="text" name="manufacturer_id" value="{set_value('manufacturer_id', $edit_data.manufacturer_id)}" id="manufacturer_id" class="form-control">
    </div>
{/capture}

{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.product_id)}
            {form_hidden('product_id', $edit_data.product_id)}
            {create_input_token($csrf)}
        {/if}
        {form_hidden('master_id', $edit_data.master_id)}
        {form_hidden('master_id', $edit_data.master_id)}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.product_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        {$smarty.capture.product_info}
                    </div>{*end card-body*}
                </div>
                <div class="card">
                    <h5 class="card-header bg-light">{lang('text_model')}</h5>
                    <div class="card-body">
                        {$smarty.capture.product_model}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header bg-light">{lang('text_stock')}</h5>
                    <div class="card-body">
                        {$smarty.capture.product_stock}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header bg-light">{lang('text_shipping_title')}</h5>
                    <div class="card-body">
                        {$smarty.capture.product_shipping}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header bg-light">{lang('text_price')}</h5>
                    <div class="card-body">
                        {$smarty.capture.product_price}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{lang('tab_special')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_special}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{lang('tab_discount')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_discount}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{lang('tab_attribute')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_attribute}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{lang('tab_option')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_option}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{lang('tab_recurring')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_recurring}
                    </div>
                </div>

                <div class="card">
                    <h5 class="card-header">{lang('tab_design')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_design}
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="card">
                    {*<h5 class="card-header bg-light">{lang('tab_data')}</h5>*}
                    <div class="card-body">
                        {$smarty.capture.product_data}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{lang('tab_links')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_links}
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{lang('tab_image')}</h5>
                    <div class="card-body bg-light">
                        {$smarty.capture.product_image}
                    </div>
                </div>
                {if $edit_data.product_id}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                {/if}
            </div>
        </div>
        </div>
    {form_close()}
</div>
