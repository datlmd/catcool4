{strip}
<div id="deletemanager" class="modal-dialog modal-lg">
    <li class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="photoModalLabel">{lang('Admin.text_confirm_delete')}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {form_open(uri_string(), ['id' => 'delete_validationform'])}
                {if !empty($list_delete)}
                    <ul class="list-unstyled bullet-check ms-5">
                        {foreach $list_delete as $item}
                            <li class="text-danger">#{$item.id}: {$item.username} ({$item.first_name})</li>
                        {/foreach}
                    </ul>
                    <div class="form-group text-center clearfix">
                        {form_hidden('ids', $ids)}
                        {form_hidden('is_delete', true)}
                        <button type="button" id="submit_delete" onclick="Catcool.submitDelete('delete_validationform');" class="btn btn-sm btn-space btn-danger"><i class="fas fa-trash-alt me-2"></i>{lang('Admin.button_delete')}</button>
                        <a href="#" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</span>
                        </a>
                    </div>
                {/if}
            {form_close()}
            {if !empty($list_undelete)}
                <div class="text-primary">{lang('Admin.error_permission_super_admin')}</div>
                <ul class="list-unstyled bullet-check font-14">
                    {foreach $list_undelete as $item}
                        <li class="text-muted">#{$item.id}: {$item.username} ({$item.first_name})</li>
                    {/foreach}
                </ul>
                {if empty($list_delete)}
                    <div class="form-group text-center clearfix">
                        <a href="#" class="btn btn-sm btn-space btn-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</span>
                        </a>
                    </div>
                {/if}
            {/if}
        </div>
    </div>
</div>
{/strip}
