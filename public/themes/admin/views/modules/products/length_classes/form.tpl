{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductLengthClassAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{if previous_url() eq current_url() || strpos(previous_url(), $manage_url) === false}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.length_class_id)}
                {form_hidden('length_class_id', $edit_data.length_class_id)}
            {/if}
            <div class="row">
                {if !empty(print_flash_alert())}
                    <div class="col-12">{print_flash_alert()}</div>
                {/if}
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.length_class_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>

                        <div class="card-body p-0 pt-3">

                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('ProductLengthClassAdmin.text_value')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="value" value="{old('value', $edit_data.value)}" id="value" class="form-control {if $validator->hasError("value")}is-invalid{/if}">
                                    <div class="invalid-feedback">
                                        {$validator->getError("value")}
                                    </div>
                                    <small>{lang('ProductLengthClassAdmin.help_length_value')}</small>
                                </div>
                            </div>
                            
                            <div class="tab-regular border-top bg-light pt-3">

                                {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$language_list}
                                <div class="tab-content border-0 p-3" id="dummy_tab_content">
                                    {foreach $language_list as $language}
                                        <div class="tab-pane fade {if !empty($language.active)}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                            <div class="form-group row required has-error">
                                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                                    {lang('Admin.text_name')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-7">
                                                    <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_name_{$language.id}" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                                    <div class="invalid-feedback">
                                                        {$validator->getError("lang.`$language.id`.name")}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                                    {lang('ProductLengthClassAdmin.text_unit')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-7">
                                                    <input type="text" name="lang[{$language.id}][unit]" value="{old("lang.`$language.id`.unit", $edit_data.lang[$language.id].unit)}" id="input_unit_{$language.id}" class="form-control {if $validator->hasError("lang.`$language.id`.unit")}is-invalid{/if}">
                                                    <div class="invalid-feedback">
                                                        {$validator->getError("lang.`$language.id`.unit")}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {*<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">*}
                    {*<div class="card">*}
                        {*<h5 class="card-header">{lang('Admin.text_manage_more')}</h5>*}
                        {*<div class="card-body">*}

                            {*<div class="form-group">*}
                                {*<label class="form-label">{lang('ProductLengthClassAdmin.text_value')}</label>*}
                                {*{if isset($edit_data.value)}*}
                                    {*{assign var="value" value="`$edit_data.value`"}*}
                                {*{else}*}
                                    {*{assign var="value" value=""}*}
                                {*{/if}*}
                                {*<input type="text" name="value" value="{old('value', $value)}" id="value" class="form-control">*}
                            {*</div>*}

                        {*</div>*}
                    {*</div>*}
                {*</div>*}
            </div>
        {form_close()}
    </div>
{/strip}
