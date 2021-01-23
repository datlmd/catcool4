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
        {if !empty($edit_data.stock_status_id)}
            {form_hidden('stock_status_id', $edit_data.stock_status_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.stock_status_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        <div class="tab-regular">
                            {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                            <div class="tab-content border-0 p-3" id="dummy_tab_content">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                        <div class="form-group row required has-error">
                                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                                {lang('text_name')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-7">
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('text_published')}</label>
                            <div class="col-12 col-sm-8 col-lg-7 pt-1">
                                <div class="switch-button switch-button-xs mt-1">
                                    <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.stock_status_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    {form_close()}
</div>
