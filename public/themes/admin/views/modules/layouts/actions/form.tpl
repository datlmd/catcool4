{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('LayoutActionAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{if previous_url() eq current_url() || strpos(previous_url(), $manage_url) === false}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.layout_action_id)}
                {form_hidden('layout_action_id', $edit_data.layout_action_id)}
            {/if}
            <div class="row">
                {if !empty(print_flash_alert())}
                    <div class="col-12">{print_flash_alert()}</div>
                {/if}
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.layout_action_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('Admin.text_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.name)}
                                        {assign var="name" value="`$edit_data.name`"}
                                    {else}
                                        {assign var="name" value=""}
                                    {/if}
                                    <input type="text" name="name" value="{old('name', $name)}" id="name" class="form-control {if $validator->hasError('name')}is-invalid{/if}">
                                    <div class="invalid-feedback">{$validator->getError("name")}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('LayoutActionAdmin.text_controller')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.controller)}
                                        {assign var="controller" value="`$edit_data.controller`"}
                                    {else}
                                        {assign var="controller" value=""}
                                    {/if}
                                    <input type="text" name="controller" value="{old('controller', $controller)}" id="controller" class="form-control {if $validator->hasError('controller')}is-invalid{/if}">
                                    <div class="invalid-feedback">{$validator->getError("controller")}</div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('LayoutActionAdmin.text_action')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.action)}
                                        {assign var="action" value="`$edit_data.action`"}
                                    {else}
                                        {assign var="action" value=""}
                                    {/if}
                                    <input type="text" name="action" value="{old('action', $action)}" id="action" class="form-control {if $validator->hasError('action')}is-invalid{/if}">
                                    <div class="invalid-feedback">{$validator->getError("action")}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
