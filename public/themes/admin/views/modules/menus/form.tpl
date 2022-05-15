{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('MenuAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{back_to($manage_url)}" class="btn btn-sm btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.menu_id)}
                {form_hidden('menu_id', $edit_data.menu_id)}
                {form_hidden('is_admin', session('is_menu_admin'))}
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
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.menu_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body p-0 pt-3 bg-light">
                            <div class="tab-regular">
                                {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$language_list}
                                <div class="tab-content border-0 p-3" id="menu_tab_content">
                                    {foreach $language_list as $language}
                                        <div class="tab-pane fade {if !empty($language.active)}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                            <div class="form-group row required has-error">
                                                <label class="col-12 col-sm-2 col-form-label required-label text-sm-end">
                                                    {lang('MenuAdmin.text_name')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-8">
                                                    <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_name_{$language.id}" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                                    <div class="invalid-feedback">
                                                        {$validator->getError("lang.`$language.id`.name")}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 col-form-label text-sm-end">
                                                    {lang('Admin.text_description')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-8">
                                                    <textarea name="lang[{$language.id}][description]" cols="40" rows="2" id="input_description_{$language.id}" type="textarea" class="form-control">{old("lang.`$language.id`.description", $edit_data.lang[$language.id].description)}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 col-form-label text-sm-end">
                                                    {lang('MenuAdmin.text_url')}
                                                </label>
                                                <div class="col-12 col-sm-8 col-lg-8">
                                                    <input type="text" name="lang[{$language.id}][slug]" value='{old("lang.`$language.id`.slug", $edit_data.lang[$language.id].slug)}' id="input_slug_{$language.id}" class="form-control">
                                                    <small>{lang('MenuAdmin.help_url')}</small><br/>
                                                    <small>Extension: {get_seo_extension()}</small><br/>
                                                    <small>Example: {get_seo_extension('seo-url')}</small>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                        <h5 class="card-header">{lang('Admin.text_attribute')}</h5>
                        <div class="card-body bg-light">
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('MenuAdmin.text_attributes')}</label>
                                <div class="col-12 col-sm-8 col-lg-8">
                                    <input type="text" name="attributes" value="{old('attributes', htmlspecialchars($edit_data.attributes, ENT_QUOTES,'UTF-8'))}" id="attributes" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('MenuAdmin.text_selected')}</label>
                                <div class="col-12 col-sm-8 col-lg-8">
                                    <textarea name="selected" cols="40" rows="2" id="selected" type="textarea" class="form-control">{old("selected", $edit_data.selected)}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('MenuAdmin.text_nav_key')}</label>
                                <div class="col-12 col-sm-8 col-lg-8">
                                    <input type="text" name="nav_key" value="{old('nav_key', $edit_data.nav_key)}" id="nav_key" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('MenuAdmin.text_label')}</label>
                                <div class="col-12 col-sm-8 col-lg-8">
                                    <input type="text" name="label" value="{old('label', $edit_data.label)}" id="label" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('MenuAdmin.text_icon')}</label>
                                <div class="col-12 col-sm-8 col-lg-8">
                                    <div class="input-group">
                                        <input type="text" name="icon" value="{old('icon', $edit_data.icon)}" id="icon" class="form-control icon-picker-class-input">
                                        <span class="input-group-text icon-picker-demo" id="input_icon_picker"><i class="{old('icon', $edit_data.icon)}"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_context')}</label>
                                <div class="col-12 col-sm-8 col-lg-8 pt-1">
                                    {if isset($edit_data.context)}
                                        {assign var="context" value="`$edit_data.context`"}
                                    {else}
                                        {assign var="context" value="main"}
                                    {/if}
                                    <label class="form-check form-check-inline ms-2 mt-1">
                                        <input type="radio" name="context" class="form-check-input" id="rd_context_main" value="{MENU_POSITION_MAIN}" {if old('context', $context) eq MENU_POSITION_MAIN}checked="checked"{/if}>
                                        <label class="form-check-label" for="rd_context_main">{MENU_POSITION_MAIN}</label>
                                    </label>
                                    <label class="form-check form-check-inline ms-2 mt-1">
                                        <input type="radio" name="context" class="form-check-input" id="rd_context_footer" value="{MENU_POSITION_FOOTER}" {if old('context', $context) eq MENU_POSITION_FOOTER}checked="checked"{/if}>
                                        <label class="form-check-label" for="rd_context_footer">{MENU_POSITION_FOOTER}</label>
                                    </label>
                                    <label class="form-check form-check-inline ms-2 mt-1">
                                        <input type="radio" name="context" class="form-check-input" id="rd_context_top" value="{MENU_POSITION_TOP}" {if old('context', $context) eq MENU_POSITION_TOP}checked="checked"{/if}>
                                        <label class="form-check-label" for=""rd_context_top>{MENU_POSITION_TOP}</label>
                                    </label>
                                    <label class="form-check form-check-inline ms-2 mt-1">
                                        <input type="radio" name="context" class="form-check-input" id="rd_context_bottom" value="{MENU_POSITION_BOTTOM}" {if old('context', $context) eq MENU_POSITION_BOTTOM}checked="checked"{/if}>
                                        <label class="form-check-label" for="rd_context_bottom">{MENU_POSITION_BOTTOM}</label>
                                    </label>
                                    <label class="form-check form-check-inline ms-2 mt-1">
                                        <input type="radio" name="context" class="form-check-input" id="rd_context_other" value="{MENU_POSITION_OTHER}" {if old('context', $context) eq MENU_POSITION_OTHER}checked="checked"{/if}>
                                        <label class="form-check-label" for="rd_context_other">{MENU_POSITION_OTHER}</label>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
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
                            <div class="form-group">
                                <label class="form-label">{lang("Admin.text_image")}</label>
                                <!-- Drag and Drop container-->
                                <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image">
                                    <img src="{if !empty(old('image', $edit_data.image))}{image_url(old('image', $edit_data.image))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
                                    <button type="button" id="button-image" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-2"></i>{lang('Admin.text_photo_edit')}</button>
                                    <button type="button" id="button-clear" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-2"></i>{lang('Admin.text_photo_clear')}</button>
                                </a>
                                <input type="hidden" name="image" value="{old('image', $edit_data.image)}" id="input-image-path" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_sort_order')}</label>
                                <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="sort_order" min="0" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_parent')}</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">{lang('Admin.text_select')}</option>
                                    {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                    {draw_tree_output_name(['data' => $patent_list, 'key_id' => 'menu_id', 'id_root' => $edit_data.menu_id], $output_html, 0, old('parent_id', $edit_data.parent_id))}
                                </select>
                            </div>
                        </div>
                    </div>
                    {if !empty($edit_data.menu_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                    {/if}
                </div>
            </div>
        {form_close()}
    </div>
    {include file=get_theme_path('views/inc/icon_picker_popup.tpl')}
{/strip}

