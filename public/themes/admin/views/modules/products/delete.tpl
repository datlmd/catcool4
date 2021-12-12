<div id="deletemanager" class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="photoModalLabel">{lang('text_confirm_delete')}</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
        <div class="modal-body">
            {form_open(uri_string(), ['id' => 'delete_validationform'])}
                {if !empty($list_delete)}
                    <ul class="list-unstyled bullet-check font-14 ms-5">
                        {foreach $list_delete as $item}
                            <li class="text-danger">{$item.detail.name} (ID={$item.product_id})</li>
                        {/foreach}
                    </ul>
                {/if}
                <div class="form-group text-center clearfix">
                    {form_hidden('ids', $ids)}
                    {form_hidden('is_delete', true)}
                    {create_input_token($csrf)}
                    <button type="button" id="submit_delete" onclick="Catcool.submitDelete('delete_validationform');" class="btn btn-sm btn-space btn-danger"><i class="fas fa-trash-alt me-2"></i>{lang('button_delete')}</button>
                    <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                </div>
            {form_close()}
        </div>
    </div>
</div>
