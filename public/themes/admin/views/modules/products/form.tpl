{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}

            <input type="hidden" name="product_id" value="{$edit_data.product_id}">
            <input type="hidden" name="master_id" value="{$edit_data.master_id|default:0}">
            <input type="hidden" name="variant" value="{$edit_data.variant|default:""}">
            <input type="hidden" name="override" value="{$edit_data.override|default:""}">

            <div class="row">
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

                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.product_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body px-0">
                            {include file=get_theme_path('views/modules/products/inc/tab_general.tpl')}
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">{lang('Admin.tab_image')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_images.tpl')}
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">{lang('ProductAdmin.text_attribute_title')}</h5>

                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_attributes.tpl')}
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">{lang('Admin.tab_data')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_data.tpl')}
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">{lang('Admin.tab_links')}</h5>
                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_links.tpl')}
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">{lang('Admin.tab_option')}</h5>

                        <div class="card-body">
                            {include file=get_theme_path('views/modules/products/inc/tab_options.tpl')}
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
                            <span class="input-group-text">{$language.icon}</span>
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
                <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-light" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" onclick="$(this).parent().parent().parent().remove();" class="btn btn-xs btn-light" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
            </div>
        </a>
        <input type="hidden" name="product_image[{'product_image_row_value'}][image]" value="" id="input_product_image_{'product_image_row_value'}_image" />

    </div>
    <input type="hidden" name="product_image_row" id="product_image_row" value="{if !empty($edit_data.image_list)}{$edit_data.image_list|@count}{else}0{/if}">
    {* end template product image *}

{/strip}
