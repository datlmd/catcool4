{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}

            {if !empty($edit_data.province_id)}
                {form_hidden('province_id', $edit_data.province_id)}
            {/if}
            <div class="row">

                <div class="col-sm-9 col-12">

                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryProvinceAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.province_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryProvinceAdmin.text_country')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {form_dropdown('country_id', $country_list, old('country_id', $edit_data.country_id), ['class' => 'form-control'])}
                                </div>
                            </div>
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
                                    {lang('CountryProvinceAdmin.text_type')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="type" value="{old('type', $edit_data.type)}" id="type" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryProvinceAdmin.text_telephone_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="telephone_code" value="{old('telephone_code', $edit_data.telephone_code)}" id="telephone_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryProvinceAdmin.text_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="zip_code" value="{old('zip_code', $edit_data.zip_code)}" id="zip_code" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('CountryProvinceAdmin.text_country_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="country_code" value="{old('country_code', $edit_data.country_code)}" id="country_code" class="form-control">
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
