{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}
            <input type="hidden" name="filter_group_id" value="{$edit_data.filter_group_id}">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('FilterAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.filter_group_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <h3 class="border-bottom pb-1">{lang('FilterAdmin.text_filter_group')}</h3>
                            <div class="form-group row required has-error">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('FilterAdmin.text_filter_group_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {foreach $language_list as $language}
                                        <div class="input-group {if !$language@last}mb-2{/if}">
                                            <span class="input-group-text" title="{$language.name}">{$language.icon}</span>
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_lang_{$language.id}_name" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                            <div id="error_lang_{$language.id}_name" class="invalid-feedback">
                                                {$validator->getError("lang.`$language.id`.name")}
                                            </div>
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

                    <div id="filter_list" class="card">
                        <h5 class="card-header">{lang('FilterAdmin.text_filter')}</h5>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-start required required-label">{lang('FilterAdmin.text_filter_name')}</th>
                                    <th class="text-center" width="250">{lang('Admin.text_sort_order')}</th>
                                    <th width="70"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    {if !empty($edit_data.filters)}
                                        {counter assign=filter_row start=1 print=false}

                                        {foreach $edit_data.filters as $filter}

                                            <tr id="filters_row_{$filter_row}">
                                                <td class="text-start">
                                                    <input type="hidden" name="filters[{$filter_row}][filter_id]" value="{$filter.filter_id}" />
                                                    {foreach $language_list as $language}
                                                        <div class="input-group {if !$language@last}mb-2{/if}">
                                                            <span class="input-group-text">{$language.icon}</span>
                                                            <input type="text" name="filters[{$filter_row}][lang][{$language.id}][name]" value='{$filter.lang[$language.id].name}' id="input_filters_{$filter_row}_lang_{$language.id}_name" class="form-control">
                                                            <div id="error_filters_{$filter_row}_lang_{$language.id}_name" class="invalid-feedback"></div>
                                                        </div>
                                                    {/foreach}
                                                </td>
                                                <td class="text-end">
                                                    <input type="number" name="filters[{$filter_row}][sort_order]" value="{$filter.sort_order}" id="input_filters_{$filter_row}_sort_order" min="0" placeholder="{lang('Admin.text_sort_order')}" class="form-control"/>
                                                    <div id="error_filters_{$filter_row}_sort_order" class="invalid-feedback"></div>
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" onclick="$('#filters_row_{$filter_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>

                                            {counter}

                                        {/foreach}
                                    {/if}

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-end"><button type="button" onclick="addFilter();" data-bs-toggle="tooltip" title="{lang('FilterAdmin.text_filter_add')}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>

    <div id="html_filter" style="display: none">
        <table>
            <tbody>
                <tr id="filters_row_{'filter_row_value'}">
                    <td class="text-start">
                        <input type="hidden" name="filters[{'filter_row_value'}][filter_id]" value="" />
                        {foreach $language_list as $language}
                            <div class="input-group {if !$language@last}mb-2{/if}">
                                <span class="input-group-text">{$language.icon}</span>
                                <input type="text" name="filters[{'filter_row_value'}][lang][{$language.id}][name]" value='{old("filters[filter_row][lang][{$language.id}][name]")}' id="input_filters_{'filter_row_value'}_lang_{$language.id}_name" class="form-control">
                                <div id="error_filters_{'filter_row_value'}_lang_{$language.id}_name" class="invalid-feedback"></div>
                            </div>
                        {/foreach}
                    </td>
                    <td class="text-end">
                        <input type="number" name="filters[{'filter_row_value'}][sort_order]" value="0" id="input_filters_{'filter_row_value'}_sort_order" min="0" placeholder="{lang('Admin.text_sort_order')}" class="form-control"/>
                        <div id="error_filters_{'filter_row_value'}_sort_order" class="invalid-feedback"></div>
                    </td>
                    <td class="text-end">
                        <button type="button" onclick="$('#filters_row_{'filter_row_value'}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <input type="hidden" name="filter_row" id="filter_row" value="{if !empty($edit_data.filters)}{$edit_data.filters|@count}{else}0{/if}">
{/strip}
<script type="text/javascript">
    function addFilter() {
        var filter_row = $('#filter_row').val();
        filter_row = parseInt(filter_row) + 1;
        $('#filter_row').val(filter_row);

        var html = $('#html_filter table tbody').html().replaceAll('filter_row_value', filter_row);
        $('#filter_list table tbody').append(html);
    }
</script>
