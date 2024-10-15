{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}

            {if !empty($edit_data.country_id)}
                {form_hidden('country_id', $edit_data.country_id)}
            {/if}
            <div class="row">

                <div class="col-sm-9 col-12">

                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.country_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('Admin.text_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="name" value="{old('name', $edit_data.name)}" id="name" class="form-control {if validation_show_error('name')}is-invalid{/if}">
                                    <div class="invalid-feedback">{validation_show_error("name")}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_formal_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="formal_name" value="{old('formal_name', $edit_data.formal_name)}" id="formal_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="country_code" value="{old('country_code', $edit_data.country_code)}" id="country_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_code3')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="country_code3" value="{old('country_code3', $edit_data.country_code3)}" id="country_code3" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_type')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="country_type" value="{old('country_type', $edit_data.country_type)}" id="country_type" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_sub_type')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="country_sub_type" value="{old('country_sub_type', $edit_data.country_sub_type)}" id="country_sub_type" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_sovereignty')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="sovereignty" value="{old('sovereignty', $edit_data.sovereignty)}" id="sovereignty" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_capital')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="capital" value="{old('capital', $edit_data.capital)}" id="capital" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_currency_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="currency_code" value="{old('currency_code', $edit_data.currency_code)}" id="currency_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_currency_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="currency_name" value="{old('currency_name', $edit_data.currency_name)}" id="currency_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_telephone_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="telephone_code" value="{old('telephone_code', $edit_data.telephone_code)}" id="telephone_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_country_number')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="country_number" value="{old('country_number', $edit_data.country_number)}" id="country_number" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_internet_country_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="internet_country_code" value="{old('internet_country_code', $edit_data.internet_country_code)}" id="internet_country_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryAdmin.text_flags')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="flags" value="{old('flags', $edit_data.flags)}" id="flags" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('Admin.text_sort_order')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="sort_order" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label" for="input_published">
                                    {lang('Admin.text_published')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="published" id="input_published"
                                            {set_checkbox('published', 1, $edit_data.published|default:true)} value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-12">
                    {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="countries"}
                </div>
                
            </div>
        {form_close()}
    </div>
{/strip}
