{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            {if !empty($edit_data.weight_class_id)}
                {form_hidden('weight_class_id', $edit_data.weight_class_id)}
            {/if}
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                    {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="weight_classes"}
                </div>

                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductWeightClassAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.weight_class_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>

                        <div class="card-body">

                            <div class="form-group row border-bottom pb-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('ProductWeightClassAdmin.text_value')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="value" value="{old('value', $edit_data.value)}" id="value" class="form-control {if validation_show_error("value")}is-invalid{/if}">
                                    <div class="invalid-feedback">
                                        {validation_show_error("value")}
                                    </div>
                                    <small>{lang('ProductWeightClassAdmin.help_weight_value')}</small>
                                </div>
                            </div>
                            <div class="form-group row border-bottom py-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {foreach $language_list as $language}
                                        <div class="input-group {if !$language@last}mb-2{/if}">
                                            {if $language_list|count > 1}<span class="input-group-text" title="{$language.name}">{$language.icon}</span>{/if}
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_name_{$language.id}" class="form-control {if validation_show_error("lang.`$language.id`.name")}is-invalid{/if}">
                                            <div class="invalid-feedback">
                                                {validation_show_error("lang.`$language.id`.name")}
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('ProductWeightClassAdmin.text_unit')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {foreach $language_list as $language}
                                        <div class="input-group {if !$language@last}mb-2{/if}">
                                            {if $language_list|count > 1}<span class="input-group-text" title="{$language.name}">{$language.icon}</span>{/if}
                                            <input type="text" name="lang[{$language.id}][unit]" value="{old("lang.`$language.id`.unit", $edit_data.lang[$language.id].unit)}" id="input_unit_{$language.id}" class="form-control {if validation_show_error("lang.`$language.id`.unit")}is-invalid{/if}">
                                            <div class="invalid-feedback">
                                                {validation_show_error("lang.`$language.id`.unit")}
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
