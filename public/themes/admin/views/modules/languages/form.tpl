{strip}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('LanguageAdmin.heading_title')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                <a href="{site_url($manage_url)}{http_get_query()}" class="btn btn-sm btn-space btn-secondary mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
            </div>
        </div>
        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
            {csrf_field('cc_token')}
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('LanguageAdmin.text_name')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.name)}
                                    {assign var="name" value="`$edit_data.name`"}
                                {else}
                                    {assign var="name" value=""}
                                {/if}
                                <input type="text" name="name" value="{old('name', $name)}" id="name" class="form-control {if $validator->hasError('name')}is-invalid{/if}">
                                <div class="invalid-feedback">{$validator->getError("name")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('LanguageAdmin.text_code')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.code)}
                                    {assign var="code" value="`$edit_data.code`"}
                                {else}
                                    {assign var="code" value=""}
                                {/if}
                                <input type="text" name="code" value="{old('code', $code)}" id="code" class="form-control {if $validator->hasError('code')}is-invalid{/if}">
                                <div class="invalid-feedback">{$validator->getError("code")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('LanguageAdmin.text_icon')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.icon)}
                                    {assign var="icon" value="`$edit_data.icon`"}
                                {else}
                                    {assign var="icon" value=""}
                                {/if}
                                <div class="input-group">
                                    <input type="text" name="icon" id="icon" class="form-control icon-picker-class-input" value="{old('icon', $icon)}">
                                    <span class="input-group-text icon-picker-demo" id="input_icon_picker"><i class="{old('icon', $icon)}"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('Admin.text_published')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.published)}
                                    {assign var="published" value="`$edit_data.published`"}
                                {else}
                                    {assign var="published" value="1"}
                                {/if}
                                <label class="form-check form-check-inline ms-2 mt-2">
                                    <input type="radio" name="published" value="{STATUS_ON}" {if old('published', $published) eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
                                    <label class="form-check-label" for="published_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2 mt-2">
                                    <input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $published) eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
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
{include file=get_theme_path('views/inc/icon_picker_popup.tpl')}
{/strip}