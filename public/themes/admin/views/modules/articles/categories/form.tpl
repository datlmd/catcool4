{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CategoryAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{if previous_url() eq current_url()}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.category_id)}
                {form_hidden('category_id', $edit_data.category_id)}
                {assign var="category_id" value="`$edit_data.category_id`"}
            {else}
                {assign var="category_id" value=""}
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
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.category_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body p-0 pt-3 bg-light">
                            <div class="tab-regular">
                                {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$language_list}
                                <div class="tab-content border-0 p-3" id="cate_tab_content">
                                    {foreach $language_list as $language}
                                        <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                            <div class="form-group row required has-error">
                                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                                    {lang('Admin.text_name')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-8">
                                                    {if !empty($edit_data.lang[$language.id].name)}
                                                        {assign var="name" value="`$edit_data.lang[$language.id].name`"}
                                                    {else}
                                                        {assign var="name" value=""}
                                                    {/if}
                                                    <input type="text" name="lang[{$language.id}][name]" value='{old("lang.{$language.id}.name", $name)}' id="input_name_{$language.id}" class="form-control {if $validator->hasError("lang.{$language.id}.name")}is-invalid{/if}">
                                                    <div class="invalid-feedback">
                                                        {$validator->getError("lang.{$language.id}.name")}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                                    {lang('Admin.text_description')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-8">
                                                    {if !empty($edit_data.lang[$language.id].description)}
                                                        {assign var="description" value="`$edit_data.lang[$language.id].description`"}
                                                    {else}
                                                        {assign var="description" value=""}
                                                    {/if}
                                                    <textarea name="lang[{$language.id}][description]" cols="40" rows="2" id="input_description_{$language.id}" type="textarea" class="form-control">{old("lang.{$language.id}.description", $description)}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                                    {lang('Admin.tab_seo')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-8 mt-2">
                                                    {include file=get_theme_path('views/inc/seo_form.tpl')}
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
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
                                    <input type="radio" name="published" value="{STATUS_OFF}" {if set_value('published', $published) eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
                                    <label class="form-check-label" for="published_off">OFF</label>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang("Admin.text_image")}</label>
                                {if isset($edit_data.image)}
                                    {assign var="image" value="`$edit_data.image`"}
                                {else}
                                    {assign var="image" value=""}
                                {/if}
                                <!-- Drag and Drop container-->
                                <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image">
                                    <img src="{if !empty(old('image', $image))}{image_url(old('image', $image))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
                                    <button type="button" id="button-image" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-2"></i>{lang('Admin.text_photo_edit')}</button>
                                    <button type="button" id="button-clear" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-2"></i>{lang('Admin.text_photo_clear')}</button>
                                </a>
                                <input type="hidden" name="image" value="{old('image', $image)}" id="input-image-path" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_sort_order')}</label>
                                {if !empty($edit_data.sort_order)}
                                    {assign var="sort_order" value="`$edit_data.sort_order`"}
                                {else}
                                    {assign var="sort_order" value="0"}
                                {/if}
                                <input type="number" name="sort_order" value="{old('sort_order', $sort_order)}" id="sort_order" min="0" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_parent')}</label>
                                {if isset($edit_data.parent_id)}
                                    {assign var="parent_id" value="`$edit_data.parent_id`"}
                                {else}
                                    {assign var="parent_id" value=""}
                                {/if}
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">{lang('Admin.text_select')}</option>
                                    {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                    {draw_tree_output_name(['data' => $patent_list, 'key_id' => 'category_id', 'id_root' => $category_id], $output_html, 0, old('parent_id', $parent_id))}
                                </select>
                            </div>
                        </div>
                    </div>
                    {if !empty($edit_data.category_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                    {/if}
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
