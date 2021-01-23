{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                {include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=configs}
            </div>
            <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            {lang('text_config_key', 'text_config_key', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="config_key" value="{set_value('config_key', $edit_data.config_key)}" id="config_key" class="form-control {if !empty($errors["config_key"])}is-invalid{/if}">
                                {if !empty($errors["config_key"])}
                                    <div class="invalid-feedback">{$errors["config_key"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_config_value', 'text_config_value', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="config_value" value="{set_value('config_value', $edit_data.config_value)}" id="config_value" class="form-control {if !empty($errors["config_value"])}is-invalid{/if}">
                                {if !empty($errors["config_value"])}
                                    <div class="invalid-feedback">{$errors["config_value"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_description', 'text_description', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <textarea type="textarea" name="description" id="description" cols="40" rows="5" class="form-control">{set_value('description', $edit_data.description)}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_group', 'text_group', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_dropdown('group_id', $groups, $edit_data.group_id, ['class' => 'form-control'])}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_published', 'text_published', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button switch-button-xs mt-2">
                                    {if isset($edit_data.published)}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, ($edit_data.published == STATUS_ON))} id="published">
                                    {else}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, true)} id="published">
                                    {/if}
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
