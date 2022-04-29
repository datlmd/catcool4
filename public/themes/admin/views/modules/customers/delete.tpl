<div id="deletemanager" class="modal-dialog modal-lg">
    <li class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="photoModalLabel">{lang('text_confirm_delete')}</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
        <div class="modal-body">
            {form_open(uri_string(), ['id' => 'delete_validationform'])}
                {if !empty($list_delete)}
                    <ul class="list-unstyled bullet-check ms-5">
                        {foreach $list_delete as $item}
                            <li class="text-danger">#{$item.customer_id}: {$item.username} ({full_name($item.first_name, $item.last_name)})</li>
                        {/foreach}
                    </ul>
                    <div class="form-group text-center clearfix">
                        {form_hidden('ids', $ids)}
                        {form_hidden('is_delete', true)}
                        {create_input_token($csrf)}
                        <button type="button" id="submit_delete" onclick="Catcool.submitDelete('delete_validationform');" class="btn btn-sm btn-space btn-danger"><i class="fas fa-trash-alt me-2"></i>{lang('button_delete')}</button>
                        <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                    </div>
                {/if}
            {form_close()}
            {if !empty($list_undelete)}
                <div class="text-primary">{lang('error_permission_super_admin')}</div>
                <ul class="list-unstyled bullet-check font-14">
                    {foreach $list_undelete as $item}
                        <li class="text-muted">#{$item.customer_id}: {$item.username} ({full_name($item.first_name, $item.last_name)})</li>
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
