{strip}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CurrencyAdmin.heading_title')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                <a href="{site_url($manage_url)}{http_get_query()}" class="btn btn-sm btn-space btn-secondary mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
            </div>
        </div>
        {if !empty($edit_data.currency_id)}
            {form_hidden('currency_id', $edit_data.currency_id)}
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
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.currency_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('CurrencyAdmin.text_name')}
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
                                {lang('CurrencyAdmin.text_code')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.code)}
                                    {assign var="code" value="`$edit_data.code`"}
                                {else}
                                    {assign var="code" value=""}
                                {/if}
                                <input type="text" name="code" value="{old('code', $code)}" id="code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_symbol_left')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.symbol_left)}
                                    {assign var="symbol_left" value="`$edit_data.symbol_left`"}
                                {else}
                                    {assign var="symbol_left" value=""}
                                {/if}
                                <input type="text" name="symbol_left" value="{old('symbol_left', $symbol_left)}" id="symbol_left" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_symbol_right')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.symbol_right)}
                                    {assign var="symbol_right" value="`$edit_data.symbol_right`"}
                                {else}
                                    {assign var="symbol_right" value=""}
                                {/if}
                                <input type="text" name="symbol_right" value="{old('symbol_right', $symbol_right)}" id="symbol_right" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_decimal_place')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.decimal_place)}
                                    {assign var="decimal_place" value="`$edit_data.decimal_place`"}
                                {else}
                                    {assign var="decimal_place" value=""}
                                {/if}
                                <input type="text" name="decimal_place" value="{old('decimal_place', $decimal_place)}" id="decimal_place" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_value')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.value)}
                                    {assign var="value" value="`$edit_data.value`"}
                                {else}
                                    {assign var="value" value=""}
                                {/if}
                                <input type="text" name="value" value="{set_value('value', $value)}" id="value" class="form-control">
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
{/strip}
