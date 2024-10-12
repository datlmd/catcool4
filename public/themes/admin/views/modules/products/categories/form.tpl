{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductCategoryAdmin.heading_title')}
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
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.category_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body px-0">
                            <div class="tab-regular">
                                {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$language_list}
                                <div class="tab-content border-0 p-3" id="cate_tab_content">
                                    {foreach $language_list as $language}
                                        <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                            <div class="form-group row required has-error">
                                                <label class="col-12 col-sm-2 fw-bold col-form-label required-label text-sm-end">
                                                    {lang('Admin.text_name')}
                                                </label>
                                                <div class="col-12 col-sm-9 col-lg-9">
                                                    <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_name_{$language.id}" class="form-control {if validation_show_error("lang.`$language.id`.name")}is-invalid{/if}">
                                                    <div class="invalid-feedback">
                                                        {validation_show_error("lang.`$language.id`.name")}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 fw-bold col-form-label text-sm-end">
                                                    {lang('Admin.text_description')}
                                                </label>
                                                <div class="col-12 col-sm-9 col-lg-9">
                                                    <textarea name="lang[{$language.id}][description]" cols="40" rows="2" id="input_description_{$language.id}" type="textarea" class="form-control">{old("lang.`$language.id`.description", $edit_data.lang[$language.id].description)}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 fw-bold col-form-label text-sm-end">
                                                    {lang('Admin.tab_seo')}
                                                </label>
                                                <div class="col-12 col-sm-9 col-lg-9 mt-2">
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
                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-12 col-12">
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

                            <div class="form-group border-top pt-3">
                                <label class="form-label fw-bold">{lang("Admin.text_image")}</label>
                                <!-- Drag and Drop container-->
                                <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image">
                                    <img src="{if !empty(old('image', $edit_data.image))}{image_url(old('image', $edit_data.image))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
                                    <div class="btn-group w-100 mt-1" role="group">
                                        <button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                        <button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </a>
                                <input type="hidden" name="image" value="{old('image', $edit_data.image)}" id="input-image-path" />
                            </div>

                            <div class="row mt-4 border-top pt-3">
                                <label class="col-auto fw-bold" for="input_top">{lang('ProductCategoryAdmin.text_top')}</label>
                                <div class="col-6 form-control-lg py-0 ">
                                    <div class="form-check form-switch" style="margin-top: -4px;">
                                        <input class="form-check-input" type="checkbox" name="top" id="input_top"
                                            {set_checkbox('top', 1, $edit_data.top|default:false)} value="1">
                                    </div>
                                </div>
                                <small>{lang('ProductCategoryAdmin.help_top')}</small>
                            </div>

                            <div class="form-group mt-4 border-top pt-3">
                                <label class="form-label fw-bold">{lang('ProductCategoryAdmin.text_column')}</label>
                                <input type="number" name="column" value="{old('column', $edit_data.column)|default:1}" id="column" class="form-control">
                                <small>{lang('ProductCategoryAdmin.help_column')}</small>
                            </div>
                            <div class="form-group mt-4 border-top pt-3">
                                <label class="form-label fw-bold">{lang('Admin.text_sort_order')}</label>
                                <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="sort_order" min="0" class="form-control">
                            </div>
                            <div class="form-group mt-4 border-top pt-3">
                                <label class="form-label fw-bold">{lang('ProductCategoryAdmin.text_filter')}</label>
                                {$filter_ids = old('filter_ids', $edit_data.filter_ids)|default:[]}
                                <select name="filter_ids[]" id="input_filter_ids[]" class="form-control form-control-sm cc-form-select-multi" multiple="multiple" data-placeholder="{lang('Admin.text_select')}">
                                    {foreach $filter_list as $value}
                                        <option value="{$value.filter_id}" {if in_array($value.filter_id, $filter_ids)}selected="selected"{/if}>{$value.name}</option>
                                    {/foreach}
                                </select>

                            </div>
                            <div class="form-group mt-4 border-top pt-3">
                                <label class="form-label fw-bold">{lang('Admin.text_parent')}</label>
                                <select name="parent_id" id="parent_id" class="form-control cc-form-select-single" data-placeholder="{lang('Admin.text_select')}">
                                    <option value="">{lang('Admin.text_select')}</option>
                                    {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                    {draw_tree_output_name(['data' => $parent_list, 'key_id' => 'category_id', 'id_root' => $edit_data.category_id], $output_html, 0, old('parent_id', $edit_data.parent_id))}
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
