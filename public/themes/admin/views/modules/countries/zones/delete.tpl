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
                    <ul class="list-unstyled bullet-check font-14 ms-5">
                        {foreach $list_delete as $item}
                            <li class="text-danger">{$item.name} (ID: {$item.zone_id})</li>
                        {/foreach}
                    </ul>
                {/if}
                <div class="form-group text-center clearfix">
                    <input type="hidden" name="ids" value="{$ids}">
                    <input type="hidden" name="is_delete" value="1">
                    <button type="button" id="submit_delete" onclick="Catcool.submitDelete('delete_validationform');" class="btn btn-sm btn-space btn-danger"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete')}</button>
                    <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
{/strip}
