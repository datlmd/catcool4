{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}

            {if !empty($edit_data.return_reason_id)}
                {form_hidden('return_reason_id', $edit_data.return_reason_id)}
            {/if}
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                    {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="returns"}
                </div>

                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ReturnReasonAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.return_reason_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">

                            {foreach $language_list as $language}
                                <div class="form-group row required has-error">
                                    <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                        {lang('Admin.text_name')} ({$language.name})
                                    </label>
                                    <div class="col-12 col-sm-8 col-lg-7">
                                        <div class="input-group">
                                            <span class="input-group-text">{$language.icon}</span>
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_name_{$language.id}" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                            <div class="invalid-feedback">
                                                {$validator->getError("lang.`$language.id`.name")}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}

                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_published')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <label class="form-check form-check-inline col-form-label ms-2">
                                        <input type="radio" name="published" value="{STATUS_ON}" {if old('published', $edit_data.published)|default:1 eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
                                        <label class="form-check-label" for="published_on">ON</label>
                                    </label>
                                    <label class="form-check form-check-inline col-form-label me-2">
                                        <input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $edit_data.published)|default:1 eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
                                        <label class="form-check-label" for="published_off">OFF</label>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
