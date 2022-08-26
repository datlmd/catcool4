{strip}

    <div class="tab-regular">
        {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$language_list}
        <div class="tab-content border-0 pt-3" id="article_tab_content">
            {foreach $language_list as $language}
                <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                    <div class="form-group row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label class="form-label required-label">{lang('ProductAdmin.text_name')}</label>
                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_lang_{$language.id}_name" data-preview-title="seo_meta_title_{$language.id}" data-title-id="input_meta_title_{$language.id}" data-preview-slug="seo_meta_url_{$language.id}" data-slug-id="input_slug_{$language.id}" class="form-control {if empty($edit_data.article_id)}make-slug{/if} {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                            <div id="error_lang_{$language.id}_name" class="invalid-feedback">
                                {$validator->getError("lang.`$language.id`.name")}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label class="form-label">{lang('Admin.text_description')}</label>
                            <textarea name="lang[{$language.id}][description]" cols="40" rows="2" id="input_lang_{$language.id}_description" data-bs-toggle="tinymce" type="textarea" class="form-control">{old("lang.`$language.id`.description", $edit_data.lang[$language.id].description)}</textarea>
                            <div id="error_lang_{$language.id}_description" class="invalid-feedback"></div>
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

{/strip}
