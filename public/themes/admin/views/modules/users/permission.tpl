{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'user_validationform'])}
        {form_hidden('id', $item_edit.id)}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.text_permission_select')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                <a href="{back_to($manage_url)}" class="btn btn-sm btn-secondary mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
            </div>
        </div>
        <div class="row">
            {if !empty(print_flash_alert())}
                <div class="col-12">{print_flash_alert()}</div>
            {/if}
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-lock-open me-2"></i>{lang('UserAdmin.text_permission_select')}</h5>
                    <div class="card-body">
                        <h3>ID#{$item_edit.id} - {$item_edit.username} ({$item_edit.first_name})</h3>
                        {if !empty($permissions)}
                            <div class="form-check border-bottom pb-2">
                                <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" {if !empty($user_permissions) && count($user_permissions) == count($permissions)}checked{/if} class="form-check-input">
                                <label class="form-check-label" for="cb_permission_all">{lang('Admin.text_select_all')}</label>
                            </div>
                            <div id="list_permission" class="row p-3">
                                {foreach $permissions as $key => $item}
                                    <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                        <h4 class="text-capitalize text-dark">{$key}</h4>
                                        {foreach $item as $value}
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" id="permission_{$value.id}" value="{$value.id}" {if !empty($user_permissions) && in_array($value.id, array_column($user_permissions, 'permission_id'))}checked{/if} class="form-check-input">
                                                <label class="form-check-label" for="permission_{$value.id}">{$value.description} <b>[{$value.name}]</b></label>
                                            </div>
                                        {/foreach}
                                    </div>
                                {/foreach}
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
{/strip}
