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
                    <div class="row">
                        {foreach $list_delete as $item}
                            <div id="photo_key_{$item.album_id}" class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 mb-3">
                                <a href="{image_url($item.image)}" data-lightbox="photos">
                                    <img src="{image_url($item.image)}" class="img-thumbnail me-1 img-fluid">
                                </a>
                                {$item.detail.name} (ID: {$item.album_id})
                            </div>
                        {/foreach}
                    </div>
                {/if}
                <div class="form-group text-center">
                    {form_hidden('ids', $ids)}
                    {form_hidden('is_delete', true)}
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