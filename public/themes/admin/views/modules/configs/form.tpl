{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">

    {include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=configs}

    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ConfigAdmin.heading_title')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                <a href="{if previous_url() eq current_url()}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-space btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
            </div>
        </div>
        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
        {/if}
        <div class="row">

            <div class="col-12">
                {if !empty(print_flash_alert())}
                    <div class="col-12 px-0">{print_flash_alert()}</div>
                {/if}
                {if !empty($errors)}
                    <div class="col-12 px-0">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('ConfigAdmin.text_config_key')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.config_key)}
                                    {assign var="config_key" value="`$edit_data.config_key`"}
                                {else}
                                    {assign var="config_key" value=""}
                                {/if}
                                <input type="text" name="config_key" value="{old('config_key', $config_key)}" id="config_key" class="form-control {if $validator->hasError('config_key')}is-invalid{/if}">
                                <div class="invalid-feedback">{$validator->getError("config_key")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('ConfigAdmin.text_config_value')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.config_value)}
                                    {assign var="config_value" value="`$edit_data.config_value`"}
                                {else}
                                    {assign var="config_value" value=""}
                                {/if}
                                <input type="text" name="config_value" value="{old('config_value', $config_value)}" id="config_value" class="form-control">
                                <small>Format Array: ['value','value']</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_description')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.description)}
                                    {assign var="description" value="`$edit_data.description`"}
                                {else}
                                    {assign var="description" value=""}
                                {/if}
                                <textarea type="textarea" name="description" id="description" cols="40" rows="5" class="form-control">{old('description', $description)}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_group')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {if isset($edit_data.group_id)}
                                    {assign var="group_id" value="`$edit_data.group_id`"}
                                {else}
                                    {assign var="group_id" value=""}
                                {/if}
                                {form_dropdown('group_id', $groups, $group_id, ['class' => 'form-control'])}
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
