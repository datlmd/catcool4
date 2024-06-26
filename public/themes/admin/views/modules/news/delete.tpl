{strip}
    <div id="deletemanager" class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {if !empty($is_trash) && $is_trash}
                        {lang('Admin.text_confirm_trash')}
                    {else}
                        {lang('Admin.text_confirm_delete')}
                    {/if}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5">
                {form_open(uri_string(), ['id' => 'delete_validationform'])}
                    {if !empty($list_delete)}
                        <ul class="list-unstyled bullet-check font-14 mx-auto">
                            {foreach $list_delete as $item}
                                <li class="text-danger">{$item.name|unescape:"html"} (ID={$item.news_id})</li>
                            {/foreach}
                        </ul>
                    {/if}
                    <div class="form-group text-center clearfix">
                        <input type="hidden" name="ids" value="{$ids}">
                        <input type="hidden" name="is_delete" value="1">
                        {form_hidden('is_trash', $is_trash)}
                        <button type="button" id="submit_delete" onclick="Catcool.submitDelete('delete_validationform');" class="btn btn-sm btn-space btn-danger">
                            <i class="fas fa-trash-alt me-1"></i>
                            {if !empty($is_trash) && $is_trash}
                                {lang('Admin.text_move_to_trash')}
                            {else}
                                {lang('Admin.button_delete')}
                            {/if}
                        </button>
                        <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
{/strip}
