{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')  heading_title=lang('CountryDistrictAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{if previous_url() eq current_url() || strpos(previous_url(), $manage_url) === false}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.district_id)}
                {form_hidden('district_id', $edit_data.district_id)}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.district_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
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
                                    {lang('CountryDistrictAdmin.text_type')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.type)}
                                        {assign var="type" value="`$edit_data.type`"}
                                    {else}
                                        {assign var="type" value=""}
                                    {/if}
                                    <input type="text" name="type" value="{old('type', $type)}" id="type" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryDistrictAdmin.text_lati_long_tude')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.lati_long_tude)}
                                        {assign var="lati_long_tude" value="`$edit_data.lati_long_tude`"}
                                    {else}
                                        {assign var="lati_long_tude" value=""}
                                    {/if}
                                    <input type="text" name="lati_long_tude" value="{old('lati_long_tude', $lati_long_tude)}" id="lati_long_tude" class="form-control">
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
                                    <input type="number" name="sort_order" value="{old('sort_order', $sort_order)}" id="sort_order" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryDistrictAdmin.text_country')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.country_id)}
                                        {assign var="country_id" value="{old('country_id', $edit_data.country_id)}"}
                                    {else}
                                        {assign var="country_id" value=""}
                                    {/if}
                                    {form_dropdown('country_id', $country_list, $country_id, ['class' => 'form-control country-changed'])}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryDistrictAdmin.text_province')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.province_id)}
                                        {assign var="province_id" value="{old('province_id', $edit_data.province_id)}"}
                                    {else}
                                        {assign var="province_id" value=""}
                                    {/if}
                                    {form_dropdown('province_id', $province_list, $province_id, ['class' => 'form-control province-changed'])}
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
