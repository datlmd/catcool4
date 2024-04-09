{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}
            <input type="hidden" name="variant_id" value="{$edit_data.variant_id}">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('VariantAdmin.heading_title')}
                        </div>
                        <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                            <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                            <a href="{back_to($manage_url)}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                        </div>
                    </div>

                    {if !empty(print_flash_alert())}
                        {print_flash_alert()}
                    {/if}
                    {if !empty($errors)}
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    {/if}

                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.variant_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">

                            <div class="form-group row required has-error">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('VariantAdmin.text_variant_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {foreach $language_list as $language}
                                        <div class="input-group {if !$language@last}mb-1{/if}">
                                            {if $language_list|count > 1}<span class="input-group-text" title="{$language.name}">{$language.icon}</span>{/if}
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_lang_{$language.id}_name" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                        </div>
                                        <div id="error_lang_{$language.id}_name" class="invalid-feedback">
                                            {$validator->getError("lang.`$language.id`.name")}
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_sort_order')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="input_sort_order" min="0" class="form-control">
                                    <div id="error_sort_order" class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {*
                    <div id="variant_value_list" class="card">
                        <h5 class="card-header">{lang('VariantAdmin.text_variant_value')}</h5>
                        <div class="card-body">
                            <table id="variant_value" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-start required required-label">{lang('VariantAdmin.text_variant_value_name')}</th>
                                    <th class="text-center" width="180">{lang('Admin.text_image')}</th>
                                    <th class="text-center" width="150">{lang('Admin.text_sort_order')}</th>
                                    <th width="70"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    {if !empty($edit_data.variant_values)}
                                        {counter assign=variant_value_row start=1 print=false}

                                        {foreach $edit_data.variant_values as $variant_value}
                                            <tr id="variant_value_row_{$variant_value_row}">
                                                <td class="text-start">
                                                    <input type="hidden" name="variant_value[{$variant_value_row}][variant_value_id]" value="{$variant_value.variant_value_id}" />
                                                    {foreach $language_list as $language}
                                                        <div class="input-group {if !$language@last}mb-1{/if}">
                                                            {if $language_list|count > 1}<span class="input-group-text">{$language.icon}</span>{/if}
                                                            <input type="text" name="variant_value[{$variant_value_row}][lang][{$language.id}][name]" value='{$variant_value.lang[$language.id].name}' id="input_variant_value_{$variant_value_row}_lang_{$language.id}_name" class="form-control">
                                                            <div id="error_variant_value_{$variant_value_row}_lang_{$language.id}_name" class="invalid-feedback"></div>
                                                        </div>
                                                    {/foreach}
                                                </td>
                                                <td class="text-center">

                                                    <a href="javascript:void(0);" id="variant_value_{$variant_value_row}_image" data-target="input_variant_value_{$variant_value_row}_image" data-thumb="variant_value_{$variant_value_row}_load_image_url" data-type="image" data-bs-toggle="image">
                                                        <img src="{if !empty($variant_value.image)}{image_thumb_url($variant_value.image)}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="variant_value_{$variant_value_row}_load_image_url" data-placeholder="{image_default_url()}"/>
                                                        <div class="btn-group w-100 mt-1" role="group">
                                                            <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                                            <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                                        </div>

                                                    </a>
                                                    <input type="hidden" name="variant_value[{$variant_value_row}][image]" value="{$variant_value.image}" id="input_variant_value_{$variant_value_row}_image" />

                                                </td>
                                                <td class="text-end">
                                                    <input type="number" name="variant_value[{$variant_value_row}][sort_order]" value="{$variant_value.sort_order}" id="input_variant_value_{$variant_value_row}_sort_order" min="0" placeholder="{lang('Admin.text_sort_order')}" class="form-control"/>
                                                    <div id="error_variant_value_{$variant_value_row}_sort_order" class="invalid-feedback"></div>
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" onclick="$('#variant_value_row_{$variant_value_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>

                                            {counter}

                                        {/foreach}
                                    {/if}

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end"><button type="button" onclick="addVariantValue();" data-bs-toggle="tooltip" title="{lang('VariantAdmin.text_variant_value_add')}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    *}

                </div>
            </div>
        {form_close()}
    </div>

    <div id="html_variant_value" style="display: none">
        <table>
            <tbody>
                <tr id="variant_value_row_{'variant_value_row_value'}">
                    <td class="text-start">
                        <input type="hidden" name="variant_value[{'variant_value_row_value'}][variant_value_id]" value="" />
                        {foreach $language_list as $language}
                            <div class="input-group {if !$language@last}mb-1{/if}">
                                {if $language_list|count > 1}<span class="input-group-text">{$language.icon}</span>{/if}
                                <input type="text" name="variant_value[{'variant_value_row_value'}][lang][{$language.id}][name]" value='{old("variant_value[variant_value_row][lang][{$language.id}][name]")}' id="input_variant_value_{'variant_value_row_value'}_lang_{$language.id}_name" class="form-control">
                                <div id="error_variant_value_{'variant_value_row_value'}_lang_{$language.id}_name" class="invalid-feedback"></div>
                            </div>
                        {/foreach}
                    </td>
                    <td class="text-center">

                        <a href="javascript:void(0);" id="variant_value_{'variant_value_row_value'}_image" data-target="input_variant_value_{'variant_value_row_value'}_image" data-thumb="variant_value_{'variant_value_row_value'}_load_image_url" data-type="image" data-bs-toggle="image">
                            <img src="{image_default_url()}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="variant_value_{'variant_value_row_value'}_load_image_url" data-placeholder="{image_default_url()}"/>
                            <div class="btn-group w-100 mt-1" role="group">
                                <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                            </div>
                        </a>
                        <input type="hidden" name="variant_value[{'variant_value_row_value'}][image]" value="" id="input_variant_value_{'variant_value_row_value'}_image" />

                    </td>
                    <td class="text-end">
                        <input type="number" name="variant_value[{'variant_value_row_value'}][sort_order]" value="0" id="input_variant_value_{'variant_value_row_value'}_sort_order" min="0" placeholder="{lang('Admin.text_sort_order')}" class="form-control"/>
                        <div id="error_variant_value_{'variant_value_row_value'}_sort_order" class="invalid-feedback"></div>
                    </td>
                    <td class="text-end">
                        <button type="button" onclick="$('#variant_value_row_{'variant_value_row_value'}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <input type="hidden" name="variant_value_row" id="variant_value_row" value="{if !empty($edit_data.variant_values)}{$edit_data.variant_values|@count}{else}0{/if}">
{/strip}
<script type="text/javascript">
    $('#input_type').on('change', function() {
        if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this.value == 'image') {
            $('#variant_value_list').show();
        } else {
            $('#variant_value_list').hide();
        }
    });

    $('#input_type').trigger('change');

    function addVariantValue() {
        var variant_value_row = $('#variant_value_row').val();
        variant_value_row = parseInt(variant_value_row) + 1;
        $('#variant_value_row').val(variant_value_row);

        var html = $('#html_variant_value table tbody').html().replaceAll('variant_value_row_value', variant_value_row);
        $('#variant_value tbody').append(html);
    }
</script>
