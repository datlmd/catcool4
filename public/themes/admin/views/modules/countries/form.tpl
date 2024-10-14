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
                                <label class="col-12 col-sm-4 text-sm-end required-label col-form-label fw-bold">
                                    {lang('Admin.text_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="name" value="{old('name', $edit_data.name)}" id="name" class="form-control {if validation_show_error('name')}is-invalid{/if}">
                                    <div class="invalid-feedback">{validation_show_error("name")}</div>
                                </div>
                            </div>
             
                            <div class="form-group row">
                                <label class="col-12 col-sm-4 text-sm-end col-form-label fw-bold">
                                    {lang('CountryAdmin.text_country_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="iso_code_2" value="{old('iso_code_2', $edit_data.iso_code_2)}" id="input_iso_code_2" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-4 text-sm-end col-form-label fw-bold">
                                    {lang('CountryAdmin.text_country_code3')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="iso_code_3" value="{old('iso_code_3', $edit_data.iso_code_3)}" id="input_iso_code_3" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-12 col-sm-4 text-sm-end col-form-label fw-bold">
                                    {lang('CountryAdmin.text_address_format')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {form_dropdown('address_format_id', $address_format_list, old('address_format_id', $settings.address_format_id), ['class' => 'form-control'])}                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 col-sm-4 text-sm-end ">
                                    <label class="col-form-label fw-bold" for="input_postcode_required">
                                        {lang('CountryAdmin.text_postcode_required')}
                                    </label>
                                </div>
                                
                                <div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="postcode_required" id="input_postcode_required"
                                            {set_checkbox('postcode_required', 1, $edit_data.postcode_required|default:false)} value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-4 text-sm-end col-form-label fw-bold" for="input_published">
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
