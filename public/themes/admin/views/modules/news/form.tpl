{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('NewsAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{if previous_url() eq current_url()}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.news_id)}
                {form_hidden('news_id', $edit_data.news_id)}
                {assign var="news_id" value="`$edit_data.news_id`"}
            {else}
                {assign var="news_id" value=""}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.news_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label required-label">{lang('NewsAdmin.text_name')}</label>
                                {if !empty($edit_data.name)}
                                    {assign var="name" value="`$edit_data.name`"}
                                {else}
                                    {assign var="name" value=""}
                                {/if}
                                <input type="text" name="name" value='{old("name", $name)}' id="input_name" data-preview-title="seo_meta_title" data-title-id="input_meta_title" data-preview-slug="seo_meta_url" data-slug-id="input_slug" class="form-control {if empty($edit_data.news_id)}make-slug{/if} {if $validator->hasError("name")}is-invalid{/if}">
                                <div class="invalid-feedback">
                                    {$validator->getError("name")}
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_description')}</label>
                                {if !empty($edit_data.description)}
                                    {assign var="description" value="`$edit_data.description`"}
                                {else}
                                    {assign var="description" value=""}
                                {/if}
                                <textarea name="description" cols="40" rows="2" id="input_description" type="textarea" class="form-control">{old("description", $description)}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label required-label">{lang('NewsAdmin.text_content')}</label>
                                {if !empty($edit_data.content)}
                                    {assign var="content" value="`$edit_data.content`"}
                                {else}
                                    {assign var="content" value=""}
                                {/if}
                                <textarea name="content" cols="40" rows="5" data-bs-toggle="tinymce" id="input-content" type="textarea" class="form-control">{old("content", $content)}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_image')}</h5>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4 col-sm-4 col-6">
                                    {if isset($edit_data.images.thumb)}
                                        {assign var="images_thumb" value="`$edit_data.images.thumb`"}
                                    {else}
                                        {assign var="images_thumb" value=""}
                                    {/if}
                                    Thumbnail Small<br/>
                                    <a href="javascript:void(0);" id="thumb_image_root" data-target="input_image_root_path" data-thumb="load_thumb_image_root" data-bs-toggle="image" class="my-1">
                                        <img src="{if !empty(old('images[thumb]', $images_thumb))}{image_url(old('images[thumb]', $images_thumb))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_thumb_image_root" data-placeholder="{image_default_url()}"/>
                                        <button type="button" id="button_image_root" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('Admin.text_photo_edit')}</button>
                                        <button type="button" id="button_clear_root" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('Admin.text_photo_clear')}</button>
                                    </a>
                                    <input type="hidden" name="images[thumb]" value="{old('images[thumb]', $images_thumb)}" id="input_image_root_path" />
                                    <small>{lang('NewsAdmin.help_thumb_small')}</small>
                                </div>
                                <div class="col-md-4 col-sm-4 col-6">
                                    {if isset($edit_data.images.thumb_large)}
                                        {assign var="images_thumb_larger" value="`$edit_data.images.thumb_large`"}
                                    {else}
                                        {assign var="images_thumb_larger" value=""}
                                    {/if}
                                    Thumbnail Large<br/>
                                    <a href="javascript:void(0);" id="thumb_image_thumb_large" data-target="input_image_thumb_large_path" data-thumb="load_thumb_image_thumb_large" data-bs-toggle="image" class="my-1">
                                        <img src="{if !empty(old('images[thumb_large]', $images_thumb_larger))}{image_url(old('images[thumb_large]', $images_thumb_larger))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_thumb_image_thumb_large" data-placeholder="{image_default_url()}"/>
                                        <button type="button" id="button_image_thumb_large" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('Admin.text_photo_edit')}</button>
                                        <button type="button" id="button_clear_thumb_large" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('Admin.text_photo_clear')}</button>
                                    </a>
                                    <input type="hidden" name="images[thumb_large]" value="{old('images[thumb_large]', $images_thumb_larger)}" id="input_image_thumb_large_path" />
                                    <small>{lang('NewsAdmin.help_thumb_large')}</small>
                                </div>
                                <div class="col-md-4 col-sm-4 col-6">
                                    Thumbnail Facebook<br/>
                                    {if isset($edit_data.images.robot_fb)}
                                        {assign var="images_fb" value="`$edit_data.images.robot_fb`"}
                                    {else}
                                        {assign var="images_fb" value=""}
                                    {/if}
                                    <a href="javascript:void(0);" id="thumb_image_robot_fb" data-target="input_image_robot_fb_path" data-thumb="load_thumb_image_robot_fb" data-bs-toggle="image" class="my-1">
                                        <img src="{if !empty(old('images[fb]', $images_fb))}{image_url(old('images[fb]', $images_fb))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_thumb_image_robot_fb" data-placeholder="{image_default_url()}"/>
                                        <button type="button" id="button_image_robot_fb" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('Admin.text_photo_edit')}</button>
                                        <button type="button" id="button_clear_robot_fb" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('Admin.text_photo_clear')}</button>
                                    </a>
                                    <input type="hidden" name="images[fb]" value="{old('images[fb]', $images_fb)}" id="input_image_robot_fb_path" />
                                    <small>{lang('NewsAdmin.help_thumb_fp')}</small>
                                </div>
                            </div>
                            {if !empty($edit_data.news_id)}
                                {if !empty($edit_data.images.robot) || !empty($edit_data.images.robot_fb)}
                                    <label class="form-label fw-bold mt-3">Image Robot</label>
                                    <div class="row text-center">
                                        <div class="col-md-4 col-sm-4 col-6">
                                            Thumbnail Robot<br/>
                                            {if isset($edit_data.images.robot)}
                                                {assign var="images_robot" value="`$edit_data.images.robot`"}
                                            {else}
                                                {assign var="images_robot" value=""}
                                            {/if}
                                            <a href="javascript:void(0);" data-bs-toggle="image">
                                                <img src="{image_url(old('images[robot]', $images_robot))}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="images[robot]" value="{old('images[robot]', $images_robot)}" />
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-6">
                                            Thumbnail Robot Facebook<br/>
                                            {if isset($edit_data.images.robot_fb)}
                                                {assign var="images_robot_fb" value="`$edit_data.images.robot_fb`"}
                                            {else}
                                                {assign var="images_robot_fb" value=""}
                                            {/if}
                                            <a href="javascript:void(0);" data-bs-toggle="image">
                                                <img src="{image_url(old('images[robot_fb]', $images_robot_fb))}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="images[robot_fb]" value="{old('images[robot_fb]', $images_robot_fb)}" />
                                        </div>
                                    </div>
                                {/if}
                            {/if}
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.tab_seo')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_seo_title')}</label>
                                {if !empty($edit_data.meta_title)}
                                    {assign var="meta_title" value="`$edit_data.meta_title`"}
                                {else}
                                    {assign var="meta_title" value=""}
                                {/if}
                                <input type="text" name="meta_title" value='{old("meta_title", $meta_title)|unescape:"html"}' id="input-meta_title" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_slug')}</label>
                                {if !empty($edit_data.slug)}
                                    {assign var="slug" value="`$edit_data.slug`"}
                                {else}
                                    {assign var="slug" value=""}
                                {/if}
                                <input type="text" name="slug" value='{old("slug", $slug)}' id="input_slug" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_seo_description')}</label>
                                {if !empty($edit_data.meta_description)}
                                    {assign var="meta_description" value="`$edit_data.meta_description`"}
                                {else}
                                    {assign var="meta_description" value=""}
                                {/if}
                                <textarea name="meta_description" cols="40" rows="3" id="input-meta_description" type="textarea" class="form-control">{old("meta_description", $meta_description)|unescape:"html"}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_seo_keyword')}</label>
                                {if !empty($edit_data.meta_keyword)}
                                    {assign var="meta_keyword" value="`$edit_data.meta_keyword`"}
                                {else}
                                    {assign var="meta_keyword" value=""}
                                {/if}
                                <input type="text" name="meta_keyword" data-role="tagsinput" value='{old("meta_keyword", $meta_keyword)|unescape:"html"}' id="input-meta_keyword" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{lang('NewsAdmin.text_source_type')}</label><br/>
                                {if isset($edit_data.source_type)}
                                    {assign var="source_type" value="`$edit_data.source_type`"}
                                {else}
                                    {assign var="source_type" value="1"}
                                {/if}
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="1" {if old('source_type', $source_type) eq 1}checked="checked"{/if} id="source_type_robot" class="form-check-input">
                                    <label class="form-check-label" for="source_type_robot">Robot</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="2" {if old('source_type', $source_type) eq 2}checked="checked"{/if} id="source_type_copy" class="form-check-input">
                                    <label class="form-check-label" for="source_type_copy">Copy</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="3" {if old('source_type', $source_type) eq 3}checked="checked"{/if} id="source_type_self_writing" class="form-check-input">
                                    <label class="form-check-label" for="source_type_self_writing">Self Writing</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="4" {if old('source_type', $source_type) eq 4}checked="checked"{/if} id="source_type_pr" class="form-check-input">
                                    <label class="form-check-label" for="source_type_pr">PR</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="source_type" value="5" {if old('source_type', $source_type) eq 5}checked="checked"{/if} id="source_type_translate" class="form-check-input">
                                    <label class="form-check-label" for="source_type_translate">Translate</label>
                                </label>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_source')}</label>
                                {if isset($edit_data.source)}
                                    {assign var="source" value="`$edit_data.source`"}
                                {else}
                                    {assign var="source" value=""}
                                {/if}
                                <input type="text" name="source" value="{old('source', $source)}" id="source" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_tracking_code')}</label>
                                {if isset($edit_data.tracking_code)}
                                    {assign var="tracking_code" value="`$edit_data.tracking_code`"}
                                {else}
                                    {assign var="tracking_code" value=""}
                                {/if}
                                <input type="text" name="tracking_code" value="{old('tracking_code', $tracking_code)}" id="tracking_code" class="form-control">
                                <small>{lang('NewsAdmin.help_tracking_code')}</small>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_post_format')}</label><br/>
                                {if isset($edit_data.post_format)}
                                    {assign var="post_format" value="`$edit_data.post_format`"}
                                {else}
                                    {assign var="post_format" value="1"}
                                {/if}
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="post_format" value="1" {if old('post_format', $post_format) eq 1}checked="checked"{/if} id="post_format_normal" class="form-check-input">
                                    <label class="form-check-label" for="post_format_normal">Normal</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="post_format" value="2" {if old('post_format', $post_format) eq 2}checked="checked"{/if} id="post_format_image" class="form-check-input">
                                    <label class="form-check-label" for="post_format_image">Image</label>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="post_format" value="3" {if old('post_format', $post_format) eq 3}checked="checked"{/if} id="post_format_video" class="form-check-input">
                                    <label class="form-check-label" for="post_format_video">Video</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">{lang('NewsAdmin.text_related')}</h5>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_published')}</label>
                                {if isset($edit_data.published)}
                                    {assign var="published" value="`$edit_data.published`"}
                                {else}
                                    {assign var="published" value="1"}
                                {/if}
                                <label class="form-check form-check-inline ms-2">
                                    <input type="radio" name="published" value="{STATUS_ON}" {if old('published', $published) eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
                                    <label class="form-check-label" for="published_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $published) eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
                                    <label class="form-check-label" for="published_off">OFF</label>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_is_comment')}</label><br />
                                {if isset($edit_data.is_comment)}
                                    {assign var="is_comment" value="`$edit_data.is_comment`"}
                                {else}
                                    {assign var="is_comment" value=""}
                                {/if}
                                <label class="form-check ms-2">
                                    <input type="radio" name="is_comment" id="is_comment_off" class="form-check-input" value="{COMMENT_STATUS_OFF}" {set_radio('is_comment', COMMENT_STATUS_OFF, ($is_comment == COMMENT_STATUS_OFF))}>
                                    <label class="form-check-label" for="is_comment_off">{lang('Admin.text_comment_status_off')}</label>
                                </label>
                                <label class="form-check ms-2">
                                    <input type="radio" name="is_comment" id="is_comment_confirm" class="form-check-input" value="{COMMENT_STATUS_CONFIRM}" {set_radio('is_comment', COMMENT_STATUS_CONFIRM, ($is_comment == COMMENT_STATUS_CONFIRM))}>
                                    <label class="form-check-label" for="is_comment_confirm">{lang('Admin.text_comment_status_confirm')}</label>
                                </label>
                                <label class="form-check ms-2">
                                    {if isset($edit_data.is_comment)}
                                        <input type="radio" name="is_comment" id="is_comment_on" class="form-check-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, ($is_comment == COMMENT_STATUS_ON))}>
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
                                <label class="form-label"><a href="{site_url('articles/categories_manage')}" target="_blank" class="link-primary">{lang('Admin.text_category')}</a></label>

                                {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                <select name="category_ids[]" id="category_ids[]" class="form-control form-control-sm multiselect" multiple="multiple" title="{lang('Admin.text_select')}">
                                    {if !empty($edit_data.category_ids)}
                                        {draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, old('category_ids', $edit_data.category_ids))}
                                    {else}
                                        {draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, old('category_ids'))}
                                    {/if}

                                </select>
                                <div id="category_review" class="w-100 p-3 bg-light">
                                    <ul class="list-unstyled bullet-check mb-0">
                                        {if !empty($news_id) && !empty(old('category_ids', $edit_data.category_ids))}
                                            {foreach old('category_ids', $edit_data.category_ids) as $value_cate}
                                                <li>{$categories_tree[$value_cate].name}</li>
                                            {/foreach}
                                        {/if}
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group border-top pt-3">
                                <label class="form-label">{lang('NewsAdmin.text_author')}</label>
                                {if isset($edit_data.author)}
                                    {assign var="author" value="`$edit_data.author`"}
                                {else}
                                    {assign var="author" value=""}
                                {/if}
                                <input type="text" name="author" value="{old('author', $author)}" id="author" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_sort_order')}</label>
                                {if isset($edit_data.sort_order)}
                                    {assign var="sort_order" value="`$edit_data.sort_order`"}
                                {else}
                                    {assign var="sort_order" value="0"}
                                {/if}
                                <input type="number" name="sort_order" value="{old('sort_order', $sort_order)}" id="sort_order" min="0" class="form-control">
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
                                <div class="input-group date show-date-picker" id="show-date-picker" data-target-input="nearest" data-date-format="DD/MM/YYYY" data-date-locale="{get_lang(true)}">
                                    <input type="text" name="publish_date" id="publish_date" class="form-control datetimepicker-input" {if old('publish_date', $publish_date)}value="{old('publish_date', $publish_date)|date_format:'d/m/Y'}"{/if} placeholder="dd/mm/yyyy" data-target="#show-date-picker" />
                                    <div class="input-group-text" data-target="#show-date-picker" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                                <label class="form-label mt-2">{lang('NewsAdmin.text_publish_time')}</label>
                                <div class="input-group date show-time-picker mb-2" id="show-time-picker" data-target-input="nearest" data-date-format="hh:mm">
                                    <input type="text" name="publish_date_hour" id="publish_date_hour" class="form-control datetimepicker-input" {if old('publish_date_hour', $publish_date)}value="{old('publish_date_hour', $publish_date)|date_format:'h:i'}"{/if} placeholder="H:i" data-target="#show-time-picker" />
                                    <div class="input-group-text" data-target="#show-time-picker" data-toggle="datetimepicker"><i class="fa fa-clock"></i></div>
                                </div>
                                <small>{lang('NewsAdmin.help_publish_date')}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{lang('NewsAdmin.text_is_ads')}</label><br/>
                                {if isset($edit_data.is_ads)}
                                    {assign var="is_ads" value="`$edit_data.is_ads`"}
                                {else}
                                    {assign var="is_ads" value="1"}
                                {/if}
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="is_ads" value="{STATUS_ON}" {if old('is_ads', $is_ads) eq STATUS_ON}checked="checked"{/if} id="is_ads_on" class="form-check-input">
                                    <label class="form-check-label" for="is_ads_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="is_ads" value="{STATUS_OFF}" {if old('is_ads', $is_ads) eq STATUS_OFF}checked="checked"{/if} id="is_ads_off" class="form-check-input">
                                    <label class="form-check-label" for="is_ads_off">OFF</label>
                                </label>
                                <br/>
                                <small>{lang('NewsAdmin.help_is_ads')}</small>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_is_fb_ia')}</label><br/>
                                {if isset($edit_data.is_fb_ia)}
                                    {assign var="is_fb_ia" value="`$edit_data.is_fb_ia`"}
                                {else}
                                    {assign var="is_fb_ia" value="1"}
                                {/if}
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="is_fb_ia" value="{STATUS_ON}" {if old('is_fb_ia', $is_fb_ia) eq STATUS_ON}checked="checked"{/if} id="is_fb_ia_on" class="form-check-input">
                                    <label class="form-check-label" for="is_fb_ia_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="is_fb_ia" value="{STATUS_OFF}" {if old('is_fb_ia', $is_fb_ia) eq STATUS_OFF}checked="checked"{/if} id="is_fb_ia_off" class="form-check-input">
                                    <label class="form-check-label" for="is_fb_ia_off">OFF</label>
                                </label>
                                <br/>
                                <small>{lang('NewsAdmin.help_is_fb_ia')}</small>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_is_hot')}</label><br/>
                                {if isset($edit_data.is_hot)}
                                    {assign var="is_hot" value="`$edit_data.is_hot`"}
                                {else}
                                    {assign var="is_hot" value="0"}
                                {/if}
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="is_hot" value="{STATUS_ON}" {if old('is_hot', $is_hot) eq STATUS_ON}checked="checked"{/if} id="is_hot_on" class="form-check-input">
                                    <label class="form-check-label" for="is_hot_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="is_hot" value="{STATUS_OFF}" {if old('is_hot', $is_hot) eq STATUS_OFF}checked="checked"{/if} id="is_hot_off" class="form-check-input">
                                    <label class="form-check-label" for="is_hot_off">OFF</label>
                                </label>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_is_homepage')}</label><br/>
                                {if isset($edit_data.is_homepage)}
                                    {assign var="is_homepage" value="`$edit_data.is_homepage`"}
                                {else}
                                    {assign var="is_homepage" value="0"}
                                {/if}
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="is_homepage" value="{STATUS_ON}" {if old('is_homepage', $is_homepage) eq STATUS_ON}checked="checked"{/if} id="is_homepage_on" class="form-check-input">
                                    <label class="form-check-label" for="is_homepage_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="is_homepage" value="{STATUS_OFF}" {if old('is_homepage', $is_homepage) eq STATUS_OFF}checked="checked"{/if} id="is_homepage_off" class="form-check-input">
                                    <label class="form-check-label" for="is_homepage_off">OFF</label>
                                </label>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_is_disable_follow')}</label><br/>
                                {if isset($edit_data.is_disable_follow)}
                                    {assign var="is_disable_follow" value="`$edit_data.is_disable_follow`"}
                                {else}
                                    {assign var="is_disable_follow" value="0"}
                                {/if}
                                <label class="form-check form-check-inline">
                                    <input type="radio" name="is_disable_follow" value="{STATUS_ON}" {if old('is_disable_follow', $is_disable_follow) eq STATUS_ON}checked="checked"{/if} id="is_disable_follow_on" class="form-check-input">
                                    <label class="form-check-label" for="is_disable_follow_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="is_disable_follow" value="{STATUS_OFF}" {if old('is_disable_follow', $is_disable_follow) eq STATUS_OFF}checked="checked"{/if} id="is_disable_follow_off" class="form-check-input">
                                    <label class="form-check-label" for="is_disable_follow_off">OFF</label>
                                </label>
                                <br/>
                                <small>{lang('NewsAdmin.help_is_disable_follow')}</small>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('NewsAdmin.text_is_disable_robot')}</label><br/>
                                {if isset($edit_data.is_disable_robot)}
                                    {assign var="is_disable_robot" value="`$edit_data.is_disable_robot`"}
                                {else}
                                    {assign var="is_disable_robot" value="0"}
                                {/if}
                                <label class="form-check form-check-inline ms-2">
                                    <input type="radio" name="is_disable_robot" value="{STATUS_ON}" {if old('is_disable_robot', $is_disable_robot) eq STATUS_ON}checked="checked"{/if} id="is_disable_robot_on" class="form-check-input">
                                    <label class="form-check-label" for="is_disable_robot_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="is_disable_robot" value="{STATUS_OFF}" {if old('is_disable_robot', $is_disable_robot) eq STATUS_OFF}checked="checked"{/if} id="is_disable_robot_off" class="form-check-input">
                                    <label class="form-check-label" for="is_disable_robot_off">OFF</label>
                                </label>
                                <br/>
                                <small>{lang('NewsAdmin.help_is_disable_robot')}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_tags')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                {if isset($edit_data.tags)}
                                    {assign var="tags" value="`$edit_data.tags`"}
                                {else}
                                    {assign var="tags" value=""}
                                {/if}
                                <input type="text" name="tags" value="{old('tags', $tags)}" id="tags" class="form-control" data-role="tagsinput">
                            </div>
                        </div>
                    </div>
                    {if !empty($edit_data.news_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                    {/if}
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
