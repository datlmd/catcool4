{if !$is_ajax}<div id="view_albums">{/if}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform_album'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                {if $edit_data.album_id}
                    <button type="button" onclick="Photo.submitAlbum('validationform_album', true);" class="btn btn-sm btn-space btn-primary mb-0" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                {else}
                    <button type="button" onclick="Photo.submitAlbum('validationform_album');" class="btn btn-sm btn-space btn-primary mb-0" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                {/if}
                <button type="button" onclick="Photo.loadView('{get_last_url($manage_url)}');" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></button>
            </div>
        </div>
        {if !empty($edit_data.album_id)}
            {form_hidden('album_id', $edit_data.album_id)}
            <div id="token_content_album">{create_input_token($csrf)}</div>
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.album_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        <div class="tab-regular">
                            {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                            <div class="tab-content border-0 pt-3" id="album_tab_content">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <span class="required-label">{lang('text_name')}</span>
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" data-slug-id="input-slug-{$language.id}" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang('text_description')}
                                                <textarea name="manager_description[{$language.id}][description]" cols="40" rows="2" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang("text_seo_title")}
                                                <input type="text" name="manager_description[{$language.id}][meta_title]" value='{set_value("manager_description[`$language.id`][meta_title]", $edit_data.details[$language.id].meta_title)}' id="input-meta-title[{$language.id}]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang("text_seo_description")}
                                                <textarea name="manager_description[{$language.id}][meta_description]" cols="40" rows="2" id="input-meta-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang("text_seo_keyword")}
                                                <input type="text" name="manager_description[{$language.id}][meta_keyword]" value='{set_value("manager_description[`$language.id`][meta_keyword]", $edit_data.details[$language.id].meta_keyword)}' id="input-meta-keyword[{$language.id}]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('text_manage_more')}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {lang('text_published')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.album_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_is_comment')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="is_comment" value="{STATUS_ON}" {if $edit_data.album_id}{if $edit_data.is_comment eq true}checked="checked"{/if}{else}checked="checked"{/if} id="is_comment">
                                <span><label for="is_comment"></label></span>
                            </div>
                        </div>
                        {if $edit_data.album_id}
                            <div class="form-group">
                                {lang('text_image')}<br />
                                <a href="{image_url($edit_data.image)}" data-lightbox="photos">
                                    <img src="{image_url($edit_data.image)}" class="img-thumbnail w-50 me-1 img-fluid" alt="" title=""/>
                                </a>
                            </div>
                        {/if}
                        <div class="form-group">
                            {lang('text_sort_order')}
                            <input type="number" name="sort_order" value="{if $edit_data.album_id}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                        </div>
                    </div>
                </div>
                {if $edit_data.album_id}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                {/if}
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div id="form_drop_album" class="card-body p-3">
                        {lang('text_select_photos')}
                        <!-- Drag and Drop container-->
                        <div class="drop-drap-file" data-is-multi="multiple">
                            <input type="file" name="file" id="file" multiple accept="audio/*,video/*,image/*" /> {*multiple*}
                            <div class="upload-area dropzone dz-clickable"  id="uploadfile">
                                <h5 class="dz-message py-4"><i class="fas fa-plus me-1 font-20"></i><i class="fas fa-image font-20"></i></h5>
                            </div>
                        </div>
                        <ul id="image_thumb" class="row list-album-photos sortable_photos mt-2">
                            {if !empty($list_photo)}
                                {foreach $list_photo as $item}
                                    <li id="photo_key_{$item.photo_id}" data-id="{$item.photo_id}" class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 p-2 mb-2 photo-item {if !is_mobile()}hover{/if}">
                                        <a href="{image_url($item.image)}" data-lightbox="photos">
                                            <img src="" style="background-image: url('{image_url($item.image)}');" class="img-thumbnail img-fluid img-photo-list">
                                        </a>
                                        <div class="top_right">
                                            <button type="button" onclick="Photo.photoEditModal({$item.photo_id});" class="btn btn-xs btn-light"><i class="fas fa-edit"></i></button>
                                            <div class="btn btn-xs btn-light text-danger" data-photo_key="{$item.photo_id}" onclick="Photo.delete_div_photo(this);" ><i class="fas fa-trash-alt"></i></div>
                                        </div>
                                        <input type="hidden" name="photo_url[{$item.photo_id}]" value="{$item.image}" class="form-control">
                                    </li>
                                {/foreach}
                            {/if}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
<div id="load_view_modal"></div>
<input type="hidden" name="confirm_title" value="{lang("text_confirm_title")}">
<input type="hidden" name="confirm_content" value="{lang("text_confirm_delete")}">
<input type="hidden" name="confirm_btn_ok" value="{lang("button_delete")}">
<input type="hidden" name="confirm_button_close" value="{lang("button_close")}">
{if !$is_ajax}</div>{/if}
