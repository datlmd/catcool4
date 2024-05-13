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
                    <a href="{back_to($manage_url)}" class="btn btn-sm btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.category_id)}
                {form_hidden('category_id', $edit_data.category_id)}
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
                        <div class="card-body">

                            <div class="form-group">
                                <label class="form-label required-label">{lang('Admin.text_name')}</label>
                                <input type="text" name="name" value='{old("name", $edit_data.name)}' id="input_name" data-slug-id="input_slug" class="form-control {if empty($edit_data.category_id)}make-slug{/if} {if validation_show_error("name")}is-invalid{/if}">
                                <div class="invalid-feedback">
                                    {validation_show_error("name")}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label text-sm-end">{lang('Admin.text_description')}</label>
                                <textarea name="description" cols="40" rows="2" id="input_description" type="textarea" class="form-control">{old("description", $edit_data.description)}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.tab_seo')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_seo_title')}</label>
                                <input type="text" name="meta_title" value='{old("meta_title", $edit_data.meta_title)|unescape:"html"}' id="input-meta_title" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">{lang('Admin.text_slug')}</label>
                                <input type="hidden" name="route_old" value="{$seo_url.route}">
                                <input type="text" name="slug" value='{old("slug", $seo_url.route)}' id="input_slug" class="form-control {if validation_show_error("slug")}is-invalid{/if}">
                                <div class="invalid-feedback">
                                    {validation_show_error("slug")}
                                </div>
                                <small>Extension: {get_seo_extension()}</small><br/>
                                <small>Example: {get_seo_extension('seo-url')}</small>
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
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                        <div class="card-body">

                            <div class="row">
                                <label class="col-auto fw-bold" for="input_published">{lang('Admin.text_published')}</label>
                                <div class="col-6 form-control-lg py-0 ">
                                    <div class="form-check form-switch" style="margin-top: -4px;">
                                        <input class="form-check-input" type="checkbox" name="published" id="input_published"
                                            {set_checkbox('published', 1, $edit_data.published|default:true)} value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">{lang("Admin.text_image")}</label>
                                <!-- Drag and Drop container-->
                                <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image">
                                    <img src="{if !empty(old('image', $edit_data.image))}{image_root(old('image', $edit_data.image))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
                                    <div class="btn-group w-100 mt-1" role="group">
                                        <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                        <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </a>
                                <input type="hidden" name="image" value="{old('image', $edit_data.image)}" id="input-image-path" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">{lang('Admin.text_sort_order')}</label>
                                <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="sort_order" min="0" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label fw-bold">{lang('Admin.text_parent')}</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">{lang('Admin.text_select')}</option>
                                    {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                    {draw_tree_output_name(['data' => $patent_list, 'key_id' => 'category_id', 'id_root' => $edit_data.category_id], $output_html, 0, old('parent_id', $edit_data.parent_id))}
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
