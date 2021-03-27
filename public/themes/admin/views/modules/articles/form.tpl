{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.article_id)}
            {form_hidden('article_id', $edit_data.article_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.article_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        <div class="tab-regular">
                            {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                            <div class="tab-content border-0 pt-3" id="article_tab_content">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <span class="required-label">{lang('text_name')}</span>
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" data-preview-title="seo_meta_title_{$language.id}" data-preview-slug="seo_meta_url_{$language.id}" data-title-id="input-meta-title-{$language.id}"  data-slug-id="input-slug-{$language.id}" class="form-control make_slug {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang('text_description')}
                                                <textarea name="manager_description[{$language.id}][description]" cols="40" rows="3" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <span class="required-label">{lang('text_content')}</span>
                                                <textarea name="manager_description[{$language.id}][content]" cols="40" rows="5" data-bs-toggle="tinymce" id="input-content[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][content]", $edit_data.details[$language.id].content)}</textarea>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            {include file=get_theme_path('views/inc/seo_form.tpl')}
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
                            <div class="switch-button switch-button-xs float-end mt-1">
                                {if isset($edit_data.published)}
                                    <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, ($edit_data.published == STATUS_ON))} id="published">
                                {else}
                                    <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, true)} id="published">
                                {/if}
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group border-bottom">
                            {lang('text_is_comment')}<br />
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_OFF}" {set_radio('is_comment', COMMENT_STATUS_OFF, ($edit_data.is_comment == COMMENT_STATUS_OFF))}><span class="custom-control-label">{lang('text_comment_status_off')}</span>
                            </label><br/>
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_CONFIRM}" {set_radio('is_comment', COMMENT_STATUS_CONFIRM, ($edit_data.is_comment == COMMENT_STATUS_CONFIRM))}><span class="custom-control-label">{lang('text_comment_status_confirm')}</span>
                            </label><br/>
                            <label class="custom-control custom-radio custom-control-inline">
                                {if isset($edit_data.is_comment)}
                                    <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, ($edit_data.is_comment == COMMENT_STATUS_ON))}><span class="custom-control-label">{lang('text_comment_status_on')}</span>
                                {else}
                                    <input type="radio" name="is_comment" class="custom-control-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, true)}><span class="custom-control-label">{lang('text_comment_status_on')}</span>
                                {/if}
                            </label>
                        </div>
                        <div class="form-group">
                            {lang('text_publish_date')}
                            <div class="input-group">
                                <input type="text" name="publish_date" id="publish_date" class="form-control show-date-picker" data-date-format="DD/MM/YYYY" data-target="#publish_date" data-bs-toggle="datetimepicker" value="{set_value('publish_date', $edit_data.publish_date)|date_format:'d/m/Y'}" autocomplete="off"  />
                                <input type="text" name="publish_date_hour" id="publish_date_hour" class="form-control show-time-picker" data-date-format="LT" data-target="#publish_date_hour" data-bs-toggle="datetimepicker" value="{set_value('publish_date_hour', $edit_data.publish_date)|date_format:'H:i'}" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_image')}
                            <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image">
                                <img src="{if !empty(set_value('image', $edit_data.images))}{image_thumb_url(set_value('image', $edit_data.images))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
                                <button type="button" id="button-image" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('text_photo_edit')}</button>
                                <button type="button" id="button-clear" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('text_photo_clear')}</button>
                            </a>
                            <input type="hidden" name="image" value="{set_value('image', $edit_data.images)}" id="input-image-path" />
                        </div>
                        <div class="form-group">
                            {lang('text_category')}
                            {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                            <select name="category_ids[]" id="category_ids[]" class="selectpicker form-control form-control-sm" data-style="btn-outline-light" data-size="8" title="{lang('text_select')}" multiple data-actions-box="false" data-live-search="true" data-selected-text-format="count > 2">
                                {draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, set_value('category_ids[]', $edit_data.categories))}
                            </select>
                            <div id="category_review" class="w-100 p-3 bg-light">
                                <ul class="list-unstyled bullet-check mb-0">
                                    {if $edit_data.article_id && !empty(set_value('category_ids[]', $edit_data.categories))}
                                        {foreach set_value('category_ids[]', $edit_data.categories) as $value_cate}
                                            <li>{$categories[$value_cate].detail.name}</li>
                                        {/foreach}
                                    {/if}
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_tags')}
                            <input type="text" name="tags" value="{set_value('tags', $edit_data.tags)}" id="tags" class="form-control" data-role="tagsinput">
                        </div>
                        <div class="form-group">
                            {lang('text_author')}
                            <input type="text" name="author" value="{set_value('author', $edit_data.author)}" id="author" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_source')}
                            <input type="text" name="source" value="{set_value('source', $edit_data.source)}" id="source" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_sort_order')}
                            <input type="number" name="sort_order" value="{if $edit_data.article_id || !empty(set_value('sort_order', $edit_data.sort_order))}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                        </div>
                    </div>
                </div>
                {if $edit_data.article_id}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                {/if}
            </div>
            </div>
        </div>
    {form_close()}
</div>
