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
                                            <span class="input-group-text" title="{$language.name}">{$language.icon}</span>
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_lang_{$language.id}_name" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                            <div id="error_lang_{$language.id}_name" class="invalid-feedback">
                                                {$validator->getError("lang.`$language.id`.name")}
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
                                            <span class="input-group-text" title="{$language.name}">{$language.icon}</span>
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

                            <div class="form-group row border-top">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('CustomerGroupAdmin.text_approval')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <label class="form-check form-check-inline col-form-label ms-2">
                                        <input type="radio" name="approval" value="{STATUS_ON}" {if old('approval', $edit_data.approval)|default:0 eq STATUS_ON}checked="checked"{/if} id="approval_on" class="form-check-input">
                                        <label class="form-check-label" for="approval_on">ON</label>
                                    </label>
                                    <label class="form-check form-check-inline col-form-label me-2">
                                        <input type="radio" name="approval" value="{STATUS_OFF}" {if old('approval', $edit_data.approval)|default:0 eq STATUS_OFF}checked="checked"{/if} id="approval_off" class="form-check-input">
                                        <label class="form-check-label" for="approval_off">OFF</label>
                                    </label>
                                    <div class="form-text">{lang('CustomerGroupAdmin.help_approval')}</div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        {form_close()}
    </div>
{/strip}
