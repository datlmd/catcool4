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
                        <li class="mb-2">
                            <a href="{image_url($item.image)}" data-lightbox="photos">
                                <img src="{image_url($item.image)}" class="img-thumbnail img-fluid" width="100">
                            </a>
                            {$item.detail.name} (ID: {$item.photo_id})
                        </li>
                    {/foreach}
                </ul>
            {/if}
            <div class="form-group text-center clearfix">
                <input type="hidden" name="ids" value="{$ids}">
                <input type="hidden" name="is_delete" value="1">
                {create_input_token($csrf)}
                <button type="button" id="submit_delete" onclick="Catcool.submitDelete('delete_validationform');" class="btn btn-sm btn-space btn-danger"><i class="fas fa-trash-alt me-2"></i>{lang('button_delete')}</button>
                <a href="#" class="btn btn-sm btn-space btn-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('button_cancel')}</span>
                </a>
            </div>
            {form_close()}
        </div>
    </div>
</div>
