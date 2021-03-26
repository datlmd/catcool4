{strip}
    {form_hidden('manage_url', $manage_url)}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{site_url($manage_url)}{http_get_query()}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.country_id)}
                {form_hidden('country_id', $edit_data.country_id)}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.country_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('Admin.text_name')}
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
                                    {lang('CountryAdmin.text_formal_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.formal_name)}
                                        {assign var="formal_name" value="`$edit_data.formal_name`"}
                                    {else}
                                        {assign var="formal_name" value=""}
                                    {/if}
                                    <input type="text" name="formal_name" value="{old('formal_name', $formal_name)}" id="formal_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.country_code)}
                                        {assign var="country_code" value="`$edit_data.country_code`"}
                                    {else}
                                        {assign var="country_code" value=""}
                                    {/if}
                                    <input type="text" name="country_code" value="{old('country_code', $country_code)}" id="country_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_code3')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.country_code3)}
                                        {assign var="country_code3" value="`$edit_data.country_code3`"}
                                    {else}
                                        {assign var="country_code3" value=""}
                                    {/if}
                                    <input type="text" name="country_code3" value="{old('country_code3', $country_code3)}" id="country_code3" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_type')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.country_type)}
                                        {assign var="country_type" value="`$edit_data.country_type`"}
                                    {else}
                                        {assign var="country_type" value=""}
                                    {/if}
                                    <input type="text" name="country_type" value="{old('country_type', $country_type)}" id="country_type" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_sub_type')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.country_sub_type)}
                                        {assign var="country_sub_type" value="`$edit_data.country_sub_type`"}
                                    {else}
                                        {assign var="country_sub_type" value=""}
                                    {/if}
                                    <input type="text" name="country_sub_type" value="{old('country_sub_type', $country_sub_type)}" id="country_sub_type" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_sovereignty')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.sovereignty)}
                                        {assign var="sovereignty" value="`$edit_data.sovereignty`"}
                                    {else}
                                        {assign var="sovereignty" value=""}
                                    {/if}
                                    <input type="text" name="sovereignty" value="{old('sovereignty', $sovereignty)}" id="sovereignty" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_capital')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.capital)}
                                        {assign var="capital" value="`$edit_data.capital`"}
                                    {else}
                                        {assign var="capital" value=""}
                                    {/if}
                                    <input type="text" name="capital" value="{old('capital', $capital)}" id="capital" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_currency_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.currency_code)}
                                        {assign var="currency_code" value="`$edit_data.currency_code`"}
                                    {else}
                                        {assign var="currency_code" value=""}
                                    {/if}
                                    <input type="text" name="currency_code" value="{old('currency_code', $currency_code)}" id="currency_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_currency_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.currency_name)}
                                        {assign var="currency_name" value="`$edit_data.currency_name`"}
                                    {else}
                                        {assign var="currency_name" value=""}
                                    {/if}
                                    <input type="text" name="currency_name" value="{old('currency_name', $currency_name)}" id="currency_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_telephone_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.telephone_code)}
                                        {assign var="telephone_code" value="`$edit_data.telephone_code`"}
                                    {else}
                                        {assign var="telephone_code" value=""}
                                    {/if}
                                    <input type="text" name="telephone_code" value="{old('telephone_code', $telephone_code)}" id="telephone_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_number')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.country_number)}
                                        {assign var="country_number" value="`$edit_data.country_number`"}
                                    {else}
                                        {assign var="country_number" value=""}
                                    {/if}
                                    <input type="text" name="country_number" value="{old('country_number', $country_number)}" id="country_number" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_internet_country_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.internet_country_code)}
                                        {assign var="internet_country_code" value="`$edit_data.internet_country_code`"}
                                    {else}
                                        {assign var="internet_country_code" value=""}
                                    {/if}
                                    <input type="text" name="internet_country_code" value="{old('internet_country_code', $internet_country_code)}" id="internet_country_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_flags')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.flags)}
                                        {assign var="flags" value="`$edit_data.flags`"}
                                    {else}
                                        {assign var="flags" value=""}
                                    {/if}
                                    <input type="text" name="flags" value="{old('flags', $flags)}" id="flags" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('Admin.text_sort_order')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.sort_order)}
                                        {assign var="sort_order" value="`$edit_data.sort_order`"}
                                    {else}
                                        {assign var="sort_order" value="0"}
                                    {/if}
                                    <input type="text" name="sort_order" value="{old('sort_order', $sort_order)}" id="sort_order" class="form-control">
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
