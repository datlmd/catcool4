{strip}
    <div id="deletemanager" class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{lang('Admin.text_confirm_delete')}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {form_open(uri_string(), ['id' => 'delete_validationform'])}
                    {if !empty($list_delete)}
                        <ul class="list-unstyled bullet-check ms-5">
                            {foreach $list_delete as $item}
                                <li class="text-danger">#{$item.user_id}: {$item.username} ({full_name($item.first_name, $item.last_name)})</li>
                            {/foreach}
                        </ul>
                        <div class="form-group text-center clearfix">
                            <input type="hidden" name="ids" value="{$ids}">
                            <input type="hidden" name="is_delete" value="1">

                            <button type="button" id="submit_delete" onclick="Catcool.submitDelete('delete_validationform');" class="btn btn-sm btn-space btn-danger"><i class="fas fa-trash-alt me-2"></i>{lang('Admin.button_delete')}</button>
                            <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                        </div>
                    {/if}
                {form_close()}
                {if !empty($list_undelete)}
                    <div class="text-primary">{lang('Admin.error_permission_super_admin')}</div>
                    <ul class="list-unstyled bullet-check font-14">
                        {foreach $list_undelete as $item}
                            <li class="text-muted">#{$item.user_id}: {$item.username} ({full_name($item.first_name, $item.last_name)})</li>
                        {/foreach}
                    </ul>
                    {if empty($list_delete)}
                        <div class="form-group text-center clearfix">
                            <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                        </div>
                    {/if}
                {/if}
            </div>

        </div>

    </div>
{/strip}
