{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'user_validationform'])}
            {form_hidden('id', $item_edit.user_id)}
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
                            <h3 class="text-primary">ID#{$item_edit.user_id} - {$item_edit.username} ({full_name($item_edit.first_name, $item_edit.last_name)})</h3>
                            {if !empty($permissions)}
                                <div class="border-bottom pb-2">
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" {if !empty($user_permissions) && count($user_permissions) == count($permissions)}checked{/if} class="form-check-input">
                                        <label class="form-check-label me-3" for="cb_permission_all">{lang('Admin.text_select_all')}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="cb_permission_read" id="cb_permission_read" value="all" class="form-check-input">
                                        <label class="form-check-label me-3" for="cb_permission_read">Read</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="cb_permission_add" id="cb_permission_add" value="all" class="form-check-input">
                                        <label class="form-check-label me-3" for="cb_permission_add">Add</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="cb_permission_update" id="cb_permission_update" value="all" class="form-check-input">
                                        <label class="form-check-label me-3" for="cb_permission_update">Update</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="cb_permission_delete" id="cb_permission_delete" value="all" class="form-check-input">
                                        <label class="form-check-label" for="cb_permission_delete">Delete</label>
                                    </div>
                                </div>
                                <div id="list_permission" class="row">
                                    {foreach $permissions as $key => $item}
                                        <div class="col-sm-6 col-12 mt-3">
                                            <button class="btn btn-outline-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_module_{$key}" aria-expanded="false" aria-controls="collapse_module_{$key}">
                                                <span class="text-dark">{$key}</span>
                                            </button>
                                            <div class="collapse show mt-3 px-2" id="collapse_module_{$key}">
                                                {foreach $item as $value}
                                                    <div class="form-check my-2">
                                                        <input type="checkbox" name="permissions[]" id="permission_{$value.id}" value="{$value.id}" data-name="{$value.name}" data-description="{$value.description}" {if !empty($user_permissions) && in_array($value.id, array_column($user_permissions, 'permission_id'))}checked{/if} class="form-check-input">
                                                        <label class="form-check-label" for="permission_{$value.id}">{$value.description} [<code>{$value.name}</code>]</label>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                        {*<div class="col-lg-4 col-sm-6 col-12 mt-3">*}
                                            {*<h4 class="text-capitalize text-dark">{$key}</h4>*}
                                            {*{foreach $item as $value}*}
                                                {*<div class="form-check">*}
                                                    {*<input type="checkbox" name="permissions[]" id="permission_{$value.id}" value="{$value.id}" {if !empty($user_permissions) && in_array($value.id, array_column($user_permissions, 'permission_id'))}checked{/if} class="form-check-input">*}
                                                    {*<label class="form-check-label" for="permission_{$value.id}">{$value.description} <b>[{$value.name}]</b></label>*}
                                                {*</div>*}
                                            {*{/foreach}*}
                                        {*</div>*}
                                    {/foreach}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>
    {literal}
        <script>

            $(document).on('change', 'input[name="cb_permission_all"]', function() {
                $('input[name="cb_permission_read"]').prop('checked', $(this).prop("checked"));
                $('input[name="cb_permission_add"]').prop('checked', $(this).prop("checked"));
                $('input[name="cb_permission_update"]').prop('checked', $(this).prop("checked"));
                $('input[name="cb_permission_delete"]').prop('checked', $(this).prop("checked"));
            });

            $(document).on('change', 'input[name="cb_permission_read"]', function() {
                var is_check = false;
                if ($('input[name="cb_permission_read"]:checked').length) {
                    is_check = true;
                }

                $('input[name="permissions[]"]').each(function () {
                    var action_name = $(this).data('name');
                    var action_description = $(this).data('description');
                    if (action_name.toLowerCase().indexOf("index") >= 0
                            || action_name.toLowerCase().indexOf("list") >= 0
                            || action_description.toLowerCase().indexOf("list") >= 0
                    ) {
                        $(this).prop('checked', is_check);
                    }
                });
            });

            $(document).on('change', 'input[name="cb_permission_add"]', function() {
                var is_check = false;
                if ($('input[name="cb_permission_add"]:checked').length) {
                    is_check = true;
                }

                $('input[name="permissions[]"]').each(function () {
                    var action_name = $(this).data('name');
                    var action_description = $(this).data('description');
                    if (action_name.toLowerCase().indexOf("/add") >= 0) {
                        $(this).prop('checked', is_check);
                    }
                });
            });

            $(document).on('change', 'input[name="cb_permission_update"]', function() {
                var is_check = false;
                if ($('input[name="cb_permission_update"]:checked').length) {
                    is_check = true;
                }

                $('input[name="permissions[]"]').each(function () {
                    var action_name = $(this).data('name');
                    var action_description = $(this).data('description');
                    if (action_name.toLowerCase().indexOf("/edit") >= 0
                            || action_name.toLowerCase().indexOf("/publish") >= 0
                            || action_name.toLowerCase().indexOf("/active") >= 0
                            || action_name.toLowerCase().indexOf("/status") >= 0
                    ) {
                        $(this).prop('checked', is_check);
                    }
                });
            });

            $(document).on('change', 'input[name="cb_permission_delete"]', function() {
                var is_check = false;
                if ($('input[name="cb_permission_delete"]:checked').length) {
                    is_check = true;
                }

                $('input[name="permissions[]"]').each(function () {
                    var action_name = $(this).data('name');
                    var action_description = $(this).data('description');
                    if (action_name.toLowerCase().indexOf("/delete") >= 0
                            || action_name.toLowerCase().indexOf("/restore") >= 0
                            || action_name.toLowerCase().indexOf("/empty_trash") >= 0
                    ) {
                        $(this).prop('checked', is_check);
                    }
                });
            });
        </script>
    {/literal}
{/strip}
