{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}
            <input type="hidden" name="customer_group_id" value="{$edit_data.customer_group_id}">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CustomerGroupAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.customer_group_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group row required has-error pb-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('CustomerGroupAdmin.text_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {foreach $language_list as $language}
                                        <div class="input-group {if !$language@last}mb-2{/if}">
                                            {if $language_list|count > 1}<span class="input-group-text" title="{$language.name}">{$language.icon}</span>{/if}
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_lang_{$language.id}_name" class="form-control {if validation_show_error("lang.`$language.id`.name")}is-invalid{/if}">
                                            <div id="error_lang_{$language.id}_name" class="invalid-feedback">
                                                {validation_show_error("lang.`$language.id`.name")}
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                            <div class="form-group row border-top py-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_description')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {foreach $language_list as $language}
                                        <div class="input-group {if !$language@last}mb-2{/if}">
                                            {if $language_list|count > 1}<span class="input-group-text" title="{$language.name}">{$language.icon}</span>{/if}
                                            <textarea type="textarea" name="lang[{$language.id}][description]" id="input_lang_{$language.id}_description" class="form-control">{old("lang.`$language.id`.name", $edit_data.lang[$language.id].description)}</textarea>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                            <div class="form-group row border-top py-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_sort_order')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="input_sort_order" min="0" class="form-control">
                                    <div id="error_sort_order" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row border-top mb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_approval">
                                    {lang('CustomerGroupAdmin.text_approval')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7 form-control-lg py-1" style="min-height: 30px;">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="approval" id="input_approval"
                                            {set_checkbox('approval', 1, $edit_data.approval|default:false)} value="1">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3"></div>
                                <div class="col-12 col-sm-8 col-lg-7 form-text">{lang('CustomerGroupAdmin.help_approval')}</div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        {form_close()}
    </div>
{/strip}
