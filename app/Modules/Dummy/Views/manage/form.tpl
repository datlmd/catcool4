{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('Dummy.heading_title')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.dummy_id)}
            {form_hidden('dummy_id', $edit_data.dummy_id)}
            {create_input_token($csrf)}
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
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.dummy_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        <div class="tab-regular">
                            {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                            <div class="tab-content border-0 p-3" id="dummy_tab_content">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if !empty($language.active)}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                        <div class="form-group row required has-error">
                                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
                                                {lang('text_name')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-7">
                                                <input type="text" name="lang_{$language.id}_name" value='{if !empty($edit_data.dummy_lang[$language.id].name)}{old("lang_`$language.id`_name", $edit_data.dummy_lang[$language.id].name)}{/if}' id="input_name_{$language.id}" class="form-control {if $validator->hasError("lang_`$language.id`_name")}is-invalid{/if}">
                                                <div class="invalid-feedback">
                                                    {$validator->getError("lang_`$language.id`_name")}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang('text_description')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-7">
                                                <textarea name="lang_{$language.id}_description" cols="40" rows="2" id="input_description_{$language.id}" type="textarea" class="form-control">{if !empty($edit_data.dummy_lang[$language.id].description)}{old("lang_`$language.id`_description", $edit_data.dummy_lang[$language.id].description)}{/if}</textarea>
                                            </div>
                                        </div>
                                        {*TPL_DUMMY_DESCRIPTION*}
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('text_manage_more')}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {lang('text_published')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {if isset($edit_data.published)}
                                    <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, ($edit_data.published == STATUS_ON))} id="published">
                                {else}
                                    <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, true)} id="published">
                                {/if}
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        {*TPL_DUMMY_ROOT*}
                        <div class="form-group">
                            {lang('text_sort_order')}
                            <input type="number" name="sort_order" value="{if !empty($edit_data.sort_order)}{old('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                        </div>
                    </div>
                </div>
                {if !empty($edit_data.dummy_id)}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                {/if}
            </div>
        </div>
    {form_close()}
</div>
