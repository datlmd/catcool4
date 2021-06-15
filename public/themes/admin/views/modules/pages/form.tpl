{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('PageAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{if previous_url() eq current_url()}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.page_id)}
                {form_hidden('page_id', $edit_data.page_id)}
                {assign var="page_id" value="`$edit_data.page_id`"}
            {else}
                {assign var="page_id" value=""}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.page_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body p-0 pt-3 bg-light">
                            <div class="tab-regular">
                                {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$language_list}
                                <div class="tab-content border-0 pt-3" id="page_tab_content">
                                    {foreach $language_list as $language}
                                        <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label class="form-label required-label">{lang('PageAdmin.text_name')}</label>
                                                    {if !empty($edit_data.lang[$language.id].name)}
                                                        {assign var="name" value="`$edit_data.lang[$language.id].name`"}
                                                    {else}
                                                        {assign var="name" value=""}
                                                    {/if}
                                                    <input type="text" name="lang[{$language.id}][name]" value='{old("lang.{$language.id}.name", $name)}' id="input_name_{$language.id}" data-preview-title="seo_meta_title_{$language.id}" data-title-id="input_meta_title_{$language.id}" data-preview-slug="seo_meta_url_{$language.id}" data-slug-id="input_slug_{$language.id}" class="form-control {if empty($edit_data.page_id)}make-slug{/if} {if $validator->hasError("lang.{$language.id}.name")}is-invalid{/if}">
                                                    <div class="invalid-feedback">
                                                        {$validator->getError("lang.{$language.id}.name")}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label class="form-label required-label">{lang('PageAdmin.text_content')}</label>
                                                    {if !empty($edit_data.lang[$language.id].content)}
                                                        {assign var="content" value="`$edit_data.lang[$language.id].content`"}
                                                    {else}
                                                        {assign var="content" value=""}
                                                    {/if}
                                                    <textarea name="lang[{$language.id}][content]" cols="40" rows="5" data-bs-toggle="tinymce" id="input-content[{$language.id}]" type="textarea" class="form-control">{old("lang.{$language.id}.content", $content)}</textarea>
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
                                <label class="form-label">{lang('PageAdmin.text_layout')}</label>
                                {if isset($edit_data.layout)}
                                    {assign var="layout" value="`$edit_data.layout`"}
                                {else}
                                    {assign var="layout" value=""}
                                {/if}
                                <input type="text" name="layout" value="{old('layout', $layout)}" id="layout" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('PageAdmin.text_body_class')}</label>
                                {if isset($edit_data.body_class)}
                                    {assign var="body_class" value="`$edit_data.body_class`"}
                                {else}
                                    {assign var="body_class" value=""}
                                {/if}
                                <input type="text" name="body_class" value="{old('body_class', $body_class)}" id="author" class="form-control">
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
                    {if !empty($edit_data.page_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                    {/if}
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
