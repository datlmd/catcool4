{strip}

            <div class="row">


                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.article_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>

                        <div class="card-body p-0 pt-3 bg-light">

                            <div class="tab-regular">
                                {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$language_list}
                                <div class="tab-content border-0 pt-3" id="article_tab_content">
                                    {foreach $language_list as $language}
                                        <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label class="form-label required-label">{lang('ArticleAdmin.text_name')}</label>
                                                    <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_name_{$language.id}" data-preview-title="seo_meta_title_{$language.id}" data-title-id="input_meta_title_{$language.id}" data-preview-slug="seo_meta_url_{$language.id}" data-slug-id="input_slug_{$language.id}" class="form-control {if empty($edit_data.article_id)}make-slug{/if} {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                                    <div class="invalid-feedback">
                                                        {$validator->getError("lang.`$language.id`.name")}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label class="form-label">{lang('Admin.text_description')}</label>
                                                    <textarea name="lang[{$language.id}][description]" cols="40" rows="2" id="input_description_{$language.id}" type="textarea" class="form-control">{old("lang.`$language.id`.description", $edit_data.lang[$language.id].description)}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label class="form-label required-label">{lang('ArticleAdmin.text_content')}</label>
                                                    <textarea name="lang[{$language.id}][content]" cols="40" rows="5" data-bs-toggle="tinymce" id="input-content[{$language.id}]" type="textarea" class="form-control">{old("lang.`$language.id`.content", $edit_data.lang[$language.id].content)}</textarea>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">{lang('Admin.tab_seo')}</label>
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
                        <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_published')}</label>
                                <label class="form-check form-check-inline ms-2">
                                    <input type="radio" name="published" value="{STATUS_ON}" {if old('published', $edit_data.published)|default:1 eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
                                    <label class="form-check-label" for="published_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline me-2">
                                    <input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $edit_data.published)|default:1 eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
                                    <label class="form-check-label" for="published_off">OFF</label>
                                </label>
                            </div>
                            <div class="form-group border-bottom pb-2 mb-2">
                                <label class="form-label">{lang('Admin.text_is_comment')}</label><br />
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
                            <div class="form-group border-bottom pb-3 mb-2">
                                <label class="form-label">{lang('ArticleAdmin.text_publish_date')}</label>
                                <div class="input-group date show-date-picker" id="show-date-picker" data-target-input="nearest" data-date-format="DD/MM/YYYY" data-date-locale="{get_lang(true)}">
                                    <input type="text" name="publish_date" id="publish_date" class="form-control datetimepicker-input" value="{old('publish_date', $edit_data.publish_date|default:get_date())|date_format:'d/m/Y'}" placeholder="dd/mm/yyyy" data-target="#show-date-picker" />
                                    <div class="input-group-text" data-target="#show-date-picker" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                                <label class="form-label mt-2">{lang('ArticleAdmin.text_publish_time')}</label>
                                <div class="input-group date show-time-picker" id="show-time-picker" data-target-input="nearest" data-date-format="hh:mm">
                                    <input type="text" name="publish_date_hour" id="publish_date_hour" class="form-control datetimepicker-input" value="{old('publish_date_hour', $edit_data.publish_date|default:get_date())|date_format:'h:i'}" placeholder="H:i" data-target="#show-time-picker" />
                                    <div class="input-group-text" data-target="#show-time-picker" data-toggle="datetimepicker"><i class="fa fa-clock"></i></div>
                                </div>
                            </div>
                            <div class="form-group border-bottom pb-2 mb-2">
                                <label class="form-label">{lang("Admin.text_image")}</label>
                                <!-- Drag and Drop container-->
                                <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image" data-type="image">
                                    <img src="{if !empty(old('images', $edit_data.images))}{image_url(old('images', $edit_data.images))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
                                    <div class="btn-group w-100 mt-1" role="group">
                                        <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                        <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </a>
                                <input type="hidden" name="images" value="{old('images', $edit_data.images)}" id="input-image-path" />
                            </div>
                            <div class="form-group">
                                <label class="form-label"><a href="{site_url('articles/categories_manage')}" target="_blank" class="link-primary">{lang('Admin.text_category')}</a></label>
                                {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                <select name="category_ids[]" id="category_ids[]" class="form-control form-control-sm multiselect" multiple="multiple" title="{lang('Admin.text_select')}">
                                    {draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, old('category_ids', $edit_data.categories))}
                                </select>
                                <div id="category_review" class="w-100 p-3 bg-light"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_tags')}</label>
                                <input type="text" name="tags" value="{old('tags', $edit_data.tags)}" id="tags" class="form-control" data-role="tagsinput">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('ArticleAdmin.text_author')}</label>
                                <input type="text" name="author" value="{old('author', $edit_data.author)}" id="author" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('ArticleAdmin.text_source')}</label>
                                <input type="text" name="source" value="{old('source', $edit_data.source)}" id="source" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_sort_order')}</label>
                                <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="sort_order" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                    {if !empty($edit_data.article_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                    {/if}
                </div>
            </div>

{/strip}
