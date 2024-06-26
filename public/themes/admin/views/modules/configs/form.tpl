{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">

    {form_open(uri_string(), ['id' => 'validationform'])}
        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
        {/if}
        <div class="row">

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                {include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="configs"}
            </div>

            <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

                <div class="row">
                    <div class="col-sm-7 col-12">
                        {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ConfigAdmin.heading_title')}
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
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('ConfigAdmin.text_config_key')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="config_key" value="{old('config_key', $edit_data.config_key)}" id="config_key" class="form-control {if validation_show_error('config_key')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("config_key")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('ConfigAdmin.text_config_value')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="config_value" value="{old('config_value', $edit_data.config_value)}" id="config_value" class="form-control">
                                <small>Format Array: ['value','value']</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_description')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <textarea type="textarea" name="description" id="description" cols="40" rows="5" class="form-control">{old('description', $edit_data.description)}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_group')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_dropdown('group_id', $groups, $edit_data.group_id, ['class' => 'form-control'])}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label" for="input_published">
                                {lang('Admin.text_published')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6 form-control-lg pt-1">
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
{/strip}
