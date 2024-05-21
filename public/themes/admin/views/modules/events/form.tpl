{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}
            <input type="hidden" name="event_id" value="{$edit_data.event_id}">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('EventAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.event_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            
                            <div class="form-group row required has-error pb-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_code">
                                    {lang('EventAdmin.text_code')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="code" value="{old('code', $edit_data.code)}" id="input_code" placeholder="{lang('EventAdmin.text_code')}"
                                           class="form-control {if !empty(validation_show_error('code'))}is-invalid{/if}">
                                    <div id="error_code" class="invalid-feedback">
                                        {validation_show_error('code')}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row required has-error pb-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_action">
                                    {lang('EventAdmin.text_action')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <textarea name="action" rows="5" placeholder="{lang('EventAdmin.text_action')}" id="input_action"
                                              class="form-control {if !empty(validation_show_error('action'))}is-invalid{/if}">
                                        {old('action', $edit_data.action)}
                                    </textarea>
                                    <div id="error_action" class="invalid-feedback">
                                        {validation_show_error('action')}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row required has-error pb-3">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_priority">
                                    {lang('EventAdmin.text_priority')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="number" name="priority" value="{old('priority', $edit_data.priority|default:1)}" id="input_priority" placeholder="{lang('EventAdmin.text_priority')}"
                                           class="form-control {if !empty(validation_show_error('priority'))}is-invalid{/if}">
                                    <div id="error_priority" class="invalid-feedback">
                                        {validation_show_error('priority')}
                                    </div>
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
            </div>
        {form_close()}
    </div>
{/strip}
