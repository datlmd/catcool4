{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'user_validationform'])}
        {form_hidden('id', $item_edit.id)}
        {create_input_token($csrf)}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save"></i></button>
                <a href="{base_url($manage_url)}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('text_cancel')}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-lock-open mr-2"></i>{lang('text_permission_select')}</h5>
                    <div class="card-body">
                        <h3>ID#{$item_edit.id} - {$item_edit.username} ({$item_edit.first_name})</h3>
                        {if !empty($permissions)}
                            <label class="custom-control custom-checkbox border-bottom pb-2">
                                <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" {if !empty($user_permissions) && count($user_permissions) == count($permissions)}checked{/if} class="custom-control-input">
                                <span class="custom-control-label">{lang('text_select_all')}</span>
                            </label>
                            <div id="list_permission" class="row">
                                {foreach $permissions as $permission}
                                    <div class="col-sm-6 col-12">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" name="permissions[]" id="permission_{$permission.id}" value="{$permission.id}" {if !empty($user_permissions) && in_array($permission.id, array_column($user_permissions, 'permission_id'))}checked{/if} class="custom-control-input">
                                            <span class="custom-control-label">{$permission.description} <b>[{$permission.name}]</b></span>
                                        </label>
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
