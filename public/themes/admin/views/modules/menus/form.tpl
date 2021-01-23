{form_hidden('manage_url', $manage_url)}
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
        {if !empty($edit_data.menu_id)}
            {form_hidden('menu_id', $edit_data.menu_id)}
            {form_hidden('is_admin', $this->session->is_menu_admin)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
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
                            {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                            <div class="tab-content border-0 p-3" id="photo_tab_content">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                        <div class="form-group row required has-error">
                                            <label class="col-12 col-sm-2 col-form-label required-label text-sm-end">
                                                {lang('text_name')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" data-slug-id="input-slug-{$language.id}" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-2 col-form-label text-sm-end">
                                                {lang('text_description')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <textarea name="manager_description[{$language.id}][description]" cols="40" rows="5" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-2 col-form-label text-sm-end">
                                                {lang('text_url')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="manager_description[{$language.id}][slug]" value='{set_value("manager_description[`$language.id`][slug]", $edit_data.details[$language.id].slug)}' id="input-slug-{$language.id}" class="form-control {if !empty($errors["slug_`$language.id`"])}is-invalid{/if}">
                                                <small>{lang('help_url')}</small>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                    <h5 class="card-header">{lang('text_attribute')}</h5>
                    <div class="card-body mb-3">
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_attributes')}</label>
                            <div class="col-12 col-sm-8 col-lg-8">
                                <input type="text" name="attributes" value="{set_value('attributes', $edit_data.attributes)}" id="attributes" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_selected')}</label>
                            <div class="col-12 col-sm-8 col-lg-8">
                                <input type="text" name="selected" value="{set_value('selected', $edit_data.selected)}" id="selected" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_nav_key')}</label>
                            <div class="col-12 col-sm-8 col-lg-8">
                                <input type="text" name="nav_key" value="{set_value('nav_key', $edit_data.nav_key)}" id="nav_key" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_label')}</label>
                            <div class="col-12 col-sm-8 col-lg-8">
                                <input type="text" name="label" value="{set_value('label', $edit_data.label)}" id="label" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_icon')}</label>
                            <div class="input-group col-12 col-sm-8 col-lg-8">
                                <input type="text" name="icon" value="{set_value('icon', $edit_data.icon)}" id="icon" class="form-control icon-picker-class-input">
                                <div class="input-group-append">
                                    <span class="input-group-text icon-picker-demo" id="input_icon_picker"><i class="{$edit_data.icon}"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label text-sm-end">{lang('text_context')}</label>
                            <div class="col-12 col-sm-8 col-lg-8 pt-1">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="context" class="custom-control-input" value="{MENU_POSITION_MAIN}" {if set_value('context', $edit_data.context) eq MENU_POSITION_MAIN}checked="checked"{/if}><span class="custom-control-label">{MENU_POSITION_MAIN}</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="context" class="custom-control-input" value="{MENU_POSITION_FOOTER}" {if set_value('context', $edit_data.context) eq MENU_POSITION_FOOTER}checked="checked"{/if}><span class="custom-control-label">{MENU_POSITION_FOOTER}</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="context" class="custom-control-input" value="{MENU_POSITION_TOP}" {if set_value('context', $edit_data.context) eq MENU_POSITION_TOP}checked="checked"{/if}><span class="custom-control-label">{MENU_POSITION_TOP}</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="context" class="custom-control-input" value="{MENU_POSITION_BOTTOM}" {if set_value('context', $edit_data.context) eq MENU_POSITION_BOTTOM}checked="checked"{/if}><span class="custom-control-label">{MENU_POSITION_BOTTOM}</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="context" class="custom-control-input" value="{MENU_POSITION_OTHER}" {if set_value('context', $edit_data.context) eq MENU_POSITION_OTHER}checked="checked"{/if}><span class="custom-control-label">{MENU_POSITION_OTHER}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
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
                        <div class="form-group">
                            {lang("text_image")}
                            <!-- Drag and Drop container-->
                            <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-bs-toggle="image">
                                <img src="{if !empty($edit_data.image)}{image_thumb_url($edit_data.image)}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{image_default_url()}"/>
                                <button type="button" id="button-image" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('text_photo_edit')}</button>
                                <button type="button" id="button-clear" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('text_photo_clear')}</button>
                            </a>
                            <input type="hidden" name="image" value="{$edit_data.image}" id="input-image-path" />
                        </div>
                        <div class="form-group">
                            {lang('text_sort_order')}
                            <input type="number" name="sort_order" value="{if $edit_data.menu_id || !empty(set_value('sort_order', $edit_data.sort_order))}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_parent')}
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">{lang('text_select')}</option>
                                {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                {draw_tree_output_name(['data' => $list_patent, 'key_id' => 'menu_id', 'id_root' => $edit_data.menu_id], $output_html, 0, $edit_data.parent_id)}
                            </select>
                        </div>
                    </div>
                </div>
                {if $edit_data.menu_id}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                {/if}
            </div>
        </div>
    {form_close()}
</div>
{include file=get_theme_path('views/inc/icon_picker_popup.tpl')}
