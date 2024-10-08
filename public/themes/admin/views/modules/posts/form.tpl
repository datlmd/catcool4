{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content form-confirm-leave">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('PostAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{back_to($manage_url)}" class="btn btn-sm btn-secondary btn-space {if !empty($edit_data.post_id)}me-0{/if}" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                    {if empty($edit_data.post_id)}
                        <button type="button" class="btn btn-sm btn-light btn-space me-0" data-bs-toggle="modal" data-bs-target="#robot_news"><i class="far fa-newspaper me-1"></i>{lang('NewsAdmin.text_robot_news')}</button>
                    {/if}
                </div>
            </div>
            {if !empty($edit_data.post_id)}
                {form_hidden('post_id', $edit_data.post_id)}
            {/if}
            <div class="row">
                {if !empty(print_flash_alert())}
                    <div class="col-12">{print_flash_alert()}</div>
                {/if}
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header" data-bs-toggle="collapse" data-bs-target="#article_content_collapse" aria-expanded="false" aria-controls="article_content_collapse">
                            <i class="fas {if !empty($edit_data.post_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form} {if isset($edit_data.deleted) && !is_null($edit_data.deleted)}<small class="text-danger">({lang('Admin.text_trashed')})</small>{/if}
                        </h5>
                        <div class="card-body collapse show" id="article_content_collapse">
                            <div class="form-group">
                                <label class="form-label required-label">{lang('NewsAdmin.text_name')}</label>
                                <input type="text" name="name" value='{old("name", $edit_data.name)}' id="input_name" data-preview-title="seo_meta_title" data-title-id="input_meta_title" data-preview-slug="seo_meta_url" data-slug-id="input_slug" class="form-control {if empty($edit_data.post_id)}make-slug{/if} {if validation_show_error("name")}is-invalid{/if}">
                                <div class="invalid-feedback">
                                    {validation_show_error("name")}
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_description')}</label>
                                <textarea name="description" cols="40" rows="2" id="input_description" type="textarea" class="form-control">{old("description", $edit_data.description)}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label required-label">{lang('NewsAdmin.text_content')}</label>
                                <textarea name="content" cols="40" rows="5" data-bs-toggle="tinymce" id="input-content" type="textarea" class="form-control {if validation_show_error("content")}is-invalid{/if}">{old("content", htmlentities($edit_data.content))}</textarea>
                                <div class="invalid-feedback">
                                    {validation_show_error("content")}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header" data-bs-toggle="collapse" data-bs-target="#article_images_collapse" aria-expanded="false" aria-controls="article_images_collapse">{lang('Admin.text_image')}</h5>
                        <div class="card-body collapse show" id="article_images_collapse">
                            <div class="row text-center">
                                <div class="col-md-4 col-sm-4 col-6">
                                    Thumbnail Small<br/>
                                    <a href="javascript:void(0);" id="thumb_image_root" data-target="input_image_root_path" data-thumb="load_thumb_image_root" data-bs-toggle="image" class="my-1">
                                        <img src="{if !empty(old('images.thumb', $edit_data.images.thumb))}{image_root(old('images.thumb', $edit_data.images.thumb))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_thumb_image_root" data-placeholder="{image_default_url()}"/>
                                        <div class="btn-group w-100 mt-1" role="group">
                                            <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                            <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </a>
                                    <input type="hidden" name="images[thumb]" value="{old('images.thumb', $edit_data.images.thumb)}" id="input_image_root_path" />
                                    <small>{lang('NewsAdmin.help_thumb_small')}</small>
                                </div>
                                <div class="col-md-4 col-sm-4 col-6">
                                    Thumbnail Large<br/>
                                    <a href="javascript:void(0);" id="thumb_image_thumb_large" data-target="input_image_thumb_large_path" data-thumb="load_thumb_image_thumb_large" data-bs-toggle="image" class="my-1">
                                        <img src="{if !empty(old('images.thumb_large', $edit_data.images.thumb_large))}{image_root(old('images.thumb_large', $edit_data.images.thumb_large))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_thumb_image_thumb_large" data-placeholder="{image_default_url()}"/>
                                        <div class="btn-group w-100 mt-1" role="group">
                                            <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                            <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </a>
                                    <input type="hidden" name="images[thumb_large]" value="{old('images.thumb_large', $edit_data.images.thumb_large)}" id="input_image_thumb_large_path" />
                                    <small>{lang('NewsAdmin.help_thumb_large')}</small>
                                </div>
                                <div class="col-md-4 col-sm-4 col-6">
                                    Thumbnail Facebook<br/>
                                    <a href="javascript:void(0);" id="thumb_image_robot_fb" data-target="input_image_robot_fb_path" data-thumb="load_thumb_image_robot_fb" data-bs-toggle="image" class="my-1">
                                        <img src="{if !empty(old('images.fb', $edit_data.images.fb))}{image_root(old('images.fb', $edit_data.images.fb))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_thumb_image_robot_fb" data-placeholder="{image_default_url()}"/>
                                        <div class="btn-group w-100 mt-1" role="group">
                                            <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                            <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </a>
                                    <input type="hidden" name="images[fb]" value="{old('images.fb', $edit_data.images.fb)}" id="input_image_robot_fb_path" />
                                    <small>{lang('NewsAdmin.help_thumb_fp')}</small>
                                </div>

                                {if isset($edit_data.url_image_fb)}
                                    <div class="col-md-4 col-sm-4 col-6 border mt-3 bg-danger py-2">
                                        <a href="javascript:void(0);" data-bs-toggle="image">
                                            <img src="{$edit_data.url_image_fb}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" />
                                        </a>
                                        <a href="{$edit_data.url_image_fb}" class="text-white" target="_blank" download>Download Image Url</a>
                                    </div>
                                {/if}
                            </div>
                            {if !empty($edit_data.post_id)}
                                {if !empty($edit_data.images.robot) || !empty($edit_data.images.robot_fb)}
                                    <label class="form-label fw-bold mt-3">Image Robot</label>
                                    <div class="row text-center">
                                        <div class="col-md-4 col-sm-4 col-6">
                                            Thumbnail Robot<br/>
                                            <a href="{$edit_data.images.robot}" data-lightbox="photos">
                                                <img src="{old('images.robot', $edit_data.images.robot)}" class="img-thumbnail me-1 img-fluid" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="images[robot]" value="{old('images.robot', $edit_data.images.robot)}" />
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-6">
                                            Thumbnail Robot Facebook<br/>
                                            <a href="{$edit_data.images.robot_fb}" data-lightbox="photos">
                                                <img src="{old('images.robot_fb', $edit_data.images.robot_fb)}" class="img-thumbnail me-1 img-fluid" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="images[robot_fb]" value="{old('images.robot_fb', $edit_data.images.robot_fb)}" />
                                        </div>
                                    </div>
                                {/if}
                            {/if}
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header" data-bs-toggle="collapse" data-bs-target="#article_seo_collapse" aria-expanded="false" aria-controls="article_seo_collapse">{lang('Admin.tab_seo')}</h5>
                        <div class="card-body collapse show" id="article_seo_collapse">
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_seo_title')}</label>
                                <input type="text" name="meta_title" value='{old("meta_title", $edit_data.meta_title)|unescape:"html"}' id="input-meta_title" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_slug')}</label>
                                <input type="text" name="slug" value='{old("slug", $edit_data.slug)}' id="input_slug" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_seo_description')}</label>
                                <textarea name="meta_description" cols="40" rows="3" id="input-meta_description" type="textarea" class="form-control">{old("meta_description", $edit_data.meta_description)|unescape:"html"}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_seo_keyword')}</label>
                                <input type="text" name="meta_keyword" data-role="tagsinput" value='{old("meta_keyword", $edit_data.meta_keyword)|unescape:"html"}' id="input-meta_keyword" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{lang('NewsAdmin.text_source_type')}</label><br/>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="3" {if old('source_type', $edit_data.source_type)|default:3 eq 3}checked="checked"{/if} id="source_type_self_writing" class="form-check-input">
                                    <label class="form-check-label" for="source_type_self_writing">Self Writing</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="1" {if old('source_type', $edit_data.source_type)|default:3 eq 1}checked="checked"{/if} id="source_type_robot" class="form-check-input">
                                    <label class="form-check-label" for="source_type_robot">Robot</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="2" {if old('source_type', $edit_data.source_type)|default:3 eq 2}checked="checked"{/if} id="source_type_copy" class="form-check-input">
                                    <label class="form-check-label" for="source_type_copy">Copy</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="4" {if old('source_type', $edit_data.source_type)|default:3 eq 4}checked="checked"{/if} id="source_type_pr" class="form-check-input">
                                    <label class="form-check-label" for="source_type_pr">PR</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="5" {if old('source_type', $edit_data.source_type)|default:3 eq 5}checked="checked"{/if} id="source_type_translate" class="form-check-input">
                                    <label class="form-check-label" for="source_type_translate">Translate</label>
                                </label>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_source')}</label>
                                <input type="text" name="source" value="{old('source', $edit_data.source)}" id="source" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_tracking_code')}</label>
                                <input type="text" name="tracking_code" value="{old('tracking_code', $edit_data.tracking_code)}" id="tracking_code" class="form-control">
                                <small>{lang('NewsAdmin.help_tracking_code')}</small>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_post_format')}</label><br/>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="post_format" value="1" {if old('post_format', $edit_data.post_format)|default:1 eq 1}checked="checked"{/if} id="post_format_normal" class="form-check-input">
                                    <label class="form-check-label" for="post_format_normal">{lang("PostAdmin.post_format_normal")}</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="post_format" value="2" {if old('post_format', $edit_data.post_format)|default:1 eq 2}checked="checked"{/if} id="post_format_image" class="form-check-input">
                                    <label class="form-check-label" for="post_format_image">{lang("PostAdmin.post_format_image")}</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="post_format" value="3" {if old('post_format', $edit_data.post_format)|default:1 eq 3}checked="checked"{/if} id="post_format_video" class="form-check-input">
                                    <label class="form-check-label" for="post_format_video">{lang("PostAdmin.post_format_video")}</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="post_format" value="4" {if old('post_format', $edit_data.post_format)|default:1 eq 4}checked="checked"{/if} id="post_format_lesson" class="form-check-input">
                                    <label class="form-check-label" for="post_format_lesson">{lang("PostAdmin.post_format_lesson")}</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header" data-bs-toggle="collapse" data-bs-target="#article_related_collapse" aria-expanded="false" aria-controls="article_related_collapse">{lang('NewsAdmin.text_related')}</h5>
                        <div class="card-body collapse show" id="article_related_collapse">
                            {if !empty($edit_data.related_list_html)}
                                {include file=get_theme_path('views/inc/articles/find_related.tpl') related_url='manage/posts/related' related_list_html=$edit_data.related_list_html}
                            {else}
                                {include file=get_theme_path('views/inc/articles/find_related.tpl') related_url='manage/posts/related'}
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                        <div class="card-body">

                            <div class="row">
                                <label class="col-auto fw-bold" for="input_published">{lang('Admin.text_published')}</label>
                                <div class="col-7 form-control-lg py-0 ">
                                    <div class="form-check form-switch" style="margin-top: -4px;">
                                        <input class="form-check-input" type="checkbox" name="published" id="input_published"
                                            {set_checkbox('published', 1, $edit_data.published|default:false)} value="1">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label fw-bold">{lang('Admin.text_is_comment')}</label><br />
                                <label class="form-check ms-2">
                                    <input type="radio" name="is_comment" id="is_comment_off" class="form-check-input" value="{COMMENT_STATUS_OFF}" {set_radio('is_comment', COMMENT_STATUS_OFF, ($edit_data.is_comment == COMMENT_STATUS_OFF))}>
                                    <label class="form-check-label" for="is_comment_off">{lang('Admin.text_comment_status_off')}</label>
                                </label>
                                <label class="form-check ms-2">
                                    <input type="radio" name="is_comment" id="is_comment_confirm" class="form-check-input" value="{COMMENT_STATUS_CONFIRM}" {set_radio('is_comment', COMMENT_STATUS_CONFIRM, ($edit_data.is_comment == COMMENT_STATUS_CONFIRM))}>
                                    <label class="form-check-label" for="is_comment_confirm">{lang('Admin.text_comment_status_confirm')}</label>
                                </label>
                                <label class="form-check ms-2">
                                    {if isset($edit_data.is_comment)}
                                        <input type="radio" name="is_comment" id="is_comment_on" class="form-check-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, ($edit_data.is_comment == COMMENT_STATUS_ON))}>
                                    {else}
                                        <input type="radio" name="is_comment" id="is_comment_on" class="form-check-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, true)}>
                                    {/if}
                                    <span class="form-check-label" for="is_comment_on">{lang('Admin.text_comment_status_on')}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label"><a href="{site_url('manage/post_categories')}" target="_blank" class="link-primary">{lang('Admin.text_category')}</a></label>

                                {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                <select name="category_ids[]" id="category_ids[]" class="form-control form-control-sm cc-form-select-multi {if validation_show_error("category_ids")}is-invalid{/if}" multiple="multiple" data-placeholder="{lang('Admin.text_select')}">
                                    {draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, old('category_ids', $edit_data.category_ids))}
                                </select>
                                <div class="invalid-feedback">
                                    {validation_show_error("category_ids")}
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <label class="form-label">{lang('NewsAdmin.text_author')}</label>
                                <input type="text" name="author" value="{old('author', $edit_data.author)}" id="author" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_sort_order')}</label>
                                <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="sort_order" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                {if isset($edit_data.publish_date)}
                                    {assign var="publish_date" value="`$edit_data.publish_date`"}
                                {else}
                                    {assign var="publish_date" value="{get_date()}"}
                                {/if}
                                <label class="form-label">{lang('NewsAdmin.text_publish_date')}</label>
                                <div class="input-group date show-date-picker" id="show-date-picker" data-target-input="nearest" data-date-format="{get_date_format_ajax()|upper}" data-date-locale="{language_code_admin()}">
                                    <input type="text" name="publish_date" id="publish_date" class="form-control datetimepicker-input" {if old('publish_date', $publish_date)}value="{old('publish_date', $publish_date)|date_format:{get_date_format(true)}}"{/if} placeholder="{get_date_format_ajax()}" data-target="#show-date-picker" />
                                    <div class="input-group-text" data-target="#show-date-picker" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                                <label class="form-label mt-2">{lang('NewsAdmin.text_publish_time')}</label>
                                <div class="input-group date show-time-picker mb-2" id="show-time-picker" data-target-input="nearest" data-date-format="HH:mm">
                                    <input type="text" name="publish_date_hour" id="publish_date_hour" class="form-control datetimepicker-input" {if old('publish_date_hour', $publish_date)}value="{old('publish_date_hour', $publish_date)|date_format:'H:i'}"{/if} placeholder="H:i" data-target="#show-time-picker" />
                                    <div class="input-group-text" data-target="#show-time-picker" data-toggle="datetimepicker"><i class="fa fa-clock"></i></div>
                                </div>
                                <small>{lang('NewsAdmin.help_publish_date')}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-3">
                                <label class="col-7 fw-bold" for="input_is_ads">{lang('NewsAdmin.text_is_ads')}</label>
                                <div class="col-5 form-control-lg py-0 " style="margin-top: -4px; min-height: 30px">
                                    <div class="form-check form-switch float-end">
                                        <input class="form-check-input" type="checkbox" name="is_ads" id="input_is_ads"
                                            {set_checkbox('is_ads', 1, $edit_data.is_ads|default:true)} value="1">
                                    </div>
                                </div>
                                <small>{lang('NewsAdmin.help_is_ads')}</small>
                            </div>

                            <div class="row mb-3">
                                <label class="col-7 fw-bold" for="input_is_fb_ia">{lang('NewsAdmin.text_is_fb_ia')}</label>
                                <div class="col-5 form-control-lg py-0 " style="margin-top: -4px; min-height: 30px">
                                    <div class="form-check form-switch float-end">
                                        <input class="form-check-input" type="checkbox" name="is_fb_ia" id="input_is_fb_ia"
                                            {set_checkbox('is_fb_ia', 1, $edit_data.is_fb_ia|default:true)} value="1">
                                    </div>
                                </div>
                                <small>{lang('NewsAdmin.help_is_fb_ia')}</small>
                            </div>
                         
                            <div class="row mb-3">
                                <label class="col-7 fw-bold" for="input_is_hot">{lang('NewsAdmin.text_is_hot')}</label>
                                <div class="col-5 form-control-lg py-0 " style="margin-top: -4px; min-height: 30px">
                                    <div class="form-check form-switch float-end">
                                        <input class="form-check-input" type="checkbox" name="is_hot" id="input_is_hot"
                                            {set_checkbox('is_hot', 1, $edit_data.is_hot|default:false)} value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-7 fw-bold" for="input_is_homepage">{lang('NewsAdmin.text_is_homepage')}</label>
                                <div class="col-5 form-control-lg py-0 " style="margin-top: -4px; min-height: 30px">
                                    <div class="form-check form-switch float-end">
                                        <input class="form-check-input" type="checkbox" name="is_homepage" id="input_is_homepage"
                                            {set_checkbox('is_homepage', 1, $edit_data.is_homepage|default:false)} value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-7 fw-bold" for="input_is_disable_follow">{lang('NewsAdmin.text_is_disable_follow')}</label>
                                <div class="col-5 form-control-lg py-0 " style="margin-top: -4px; min-height: 30px">
                                    <div class="form-check form-switch float-end">
                                        <input class="form-check-input" type="checkbox" name="is_disable_follow" id="input_is_disable_follow"
                                            {set_checkbox('is_disable_follow', 1, $edit_data.is_disable_follow|default:false)} value="1">
                                    </div>
                                </div>
                                <small>{lang('NewsAdmin.help_is_disable_follow')}</small>
                            </div>

                            <div class="row mb-3">
                                <label class="col-7 fw-bold" for="input_is_disable_robot">{lang('NewsAdmin.text_is_disable_robot')}</label>
                                <div class="col-5 form-control-lg py-0 " style="margin-top: -4px; min-height: 30px">
                                    <div class="form-check form-switch float-end">
                                        <input class="form-check-input" type="checkbox" name="is_disable_robot" id="input_is_disable_robot"
                                            {set_checkbox('is_disable_robot', 1, $edit_data.is_disable_robot|default:false)} value="1">
                                    </div>
                                </div>
                                <small>{lang('NewsAdmin.help_is_disable_robot')}</small>
                            </div>
                            
            
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_tags')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" name="tags" value="{old('tags', $edit_data.tags)}" id="tags" class="form-control" data-role="tagsinput">
                            </div>
                        </div>
                    </div>
                    {if !empty($edit_data.post_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                    {/if}
                </div>
            </div>
        {form_close()}
    </div>

    <!-- Modal add -->
    <div class="modal fade" id="robot_news" tabindex="-1" role="dialog" aria-labelledby="robotNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Robot- Scan News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {form_open('manage/posts/add', ['id' => 'robot_news_form', 'method' => 'get'])}
                        <div class="form-group">
                            Url
                            <input type="text" name="url" id="url" class="form-control" value="{if !empty($url)}{$url}{/if}" />
                        </div>

                    {include file=get_theme_path('views/modules/news/inc/link_robot_list.tpl')}

                        <div class="form-group row text-center">
                            <div class="col-12 col-sm-3"></div>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <button type="submit" class="btn btn-sm btn-space btn-primary btn-robot-news"><i class="far fa-newspaper me-1"></i>{lang('NewsAdmin.text_robot_news')}</button>
                                <a href="#" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</span>
                                </a>
                            </div>
                        </div>
                    {form_close()}

                </div>
            </div>
        </div>
    </div>
{/strip}
