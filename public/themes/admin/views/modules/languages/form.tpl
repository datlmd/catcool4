{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}

        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
        {/if}
        <div class="row">

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="languages"}
            </div>

            <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

                <div class="row">
                    <div class="col-sm-7 col-12">
                        {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('LanguageAdmin.heading_title')}
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
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('LanguageAdmin.text_name')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="name" value="{old('name', $edit_data.name)}" id="name" class="form-control {if validation_show_error('name')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("name")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('LanguageAdmin.text_code')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="code" value="{old('code', $edit_data.code)}" id="code" class="form-control {if validation_show_error('code')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("code")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('LanguageAdmin.text_icon')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="input-group">
                                    <input type="text" name="icon" id="icon" class="form-control icon-picker-class-input" value="{old('icon', $edit_data.icon)}">
                                    <span class="input-group-text icon-picker-demo" id="input_icon_picker"><i class="{old('icon', $edit_data.icon)}"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_published">
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
        </div>
    {form_close()}
</div>
{include file=get_theme_path('views/inc/icon_picker_popup.tpl')}
{/strip}