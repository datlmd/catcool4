{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            {lang('text_name', 'text_name', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="name" value="{set_value('name', $edit_data.name)}" id="name" class="form-control {if !empty($errors["name"])}is-invalid{/if}">
                                {if !empty($errors["name"])}
                                    <div class="invalid-feedback">{$errors["name"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_code', 'text_code', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="code" value="{set_value('code', $edit_data.code)}" id="code" class="form-control {if !empty($errors["code"])}is-invalid{/if}">
                                {if !empty($errors["code"])}
                                    <div class="invalid-feedback">{$errors["code"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_icon', 'text_icon', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="input-group col-12 col-sm-8 col-lg-6">
                                <input type="text" name="icon" id="icon" class="form-control icon-picker-class-input" value="{set_value('icon', $edit_data.icon)}">
                                <div class="input-group-append">
                                    <span class="input-group-text icon-picker-demo" id="input_icon_picker"><i class="{$edit_data.icon}"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_published', 'text_published', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
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
{include file=get_theme_path('views/inc/icon_picker_popup.tpl')}
