{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}

        {if !empty($edit_data.address_format_id)}
            {form_hidden('address_format_id', $edit_data.address_format_id)}
        {/if}
        <div class="row">

            <div class="col-sm-9 col-12">

                <div class="row">
                    <div class="col-sm-7 col-12">
                        {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('AddressFormatAdmin.heading_title')}
                    </div>
                    <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">

                        <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                        <a href="{back_to($manage_url)}" class="btn btn-sm btn-space btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                
                    </div>
                    
                </div>

                {if !empty(print_flash_alert())}
                    {print_flash_alert()}
                {/if}
                {if !empty($errors)}
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                {/if}

                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.address_format_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('AddressFormatAdmin.text_name')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="name" value="{old('name', $edit_data.name)}" id="input_name" class="form-control {if validation_show_error('name')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("name")}</div>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('AddressFormatAdmin.text_address_format')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <textarea name="address_format" rows="6" id="input_address_format" class="form-control {if validation_show_error('address_format')}is-invalid{/if}">{old('address_format', $edit_data.address_format)}</textarea>
                                <div class="invalid-feedback">{validation_show_error("address_format")}</div>
                                <div class="form-text mt-1">{lang('AddressFormatAdmin.help_address_format')|nl2br}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-12">
                {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="addresses_format"}
            </div>
            
        </div>
    {form_close()}
</div>
{/strip}
