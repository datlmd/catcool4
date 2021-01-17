{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            {lang('text_route', 'text_route', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="route" value="{set_value('route', $edit_data.route)}" id="route" class="form-control {if !empty($errors["route"])}is-invalid{/if}">
                                {if !empty($errors["route"])}
                                    <div class="invalid-feedback">{$errors["route"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_module', 'text_module', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="module" value="{set_value('module', $edit_data.module)}" id="module" class="form-control {if !empty($errors["module"])}is-invalid{/if}">
                                {if !empty($errors["module"])}
                                    <div class="invalid-feedback">{$errors["module"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_resource', 'text_resource', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="resource" value="{set_value('resource', $edit_data.resource)}" id="resource" class="form-control {if !empty($errors["resource"])}is-invalid{/if}">
                                {if !empty($errors["resource"])}
                                    <div class="invalid-feedback">{$errors["resource"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_language', 'text_language', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <select name="language_id" id="language_id" class="form-control">
                                    {foreach $list_lang as $language}
                                        <option value="{$language.id}" {if $edit_data.language_id eq $language.id}selected="selected"{/if}>{$language.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_published', 'text_published', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button switch-button-xs mt-2">
                                    {if isset($edit_data.published)}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, ($edit_data.published == STATUS_ON))} id="published">
                                    {else}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, true)} id="published">
                                    {/if}
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-3 col-form-label text-sm-right">{lang('text_example')}</div>
                            <code class="col-12 col-sm-8 col-lg-6 text-left">
                                $route["product/:num"] = "catalog/product_lookup";<br />
                                $route["journals"] = "blogs";<br />
                                $route["blog/joe"] = "blogs/users/34";<br />
                                $route["product/(:any)"] = "catalog/product_lookup";<br/>
                                $route["product/(:num)"] ="catalog/product_lookup_by_id/$1";<br/>
                                $route["products/([a-z]+)/(\d+)"] = "$1/id_$2";<br/>
                                $route["login/(.+)"] = "auth/login/$1";<br/>
                                $route["products"]["put"] = "product/insert";<br/>
                                $route["products/(:num)"]["DELETE"] = "product/delete/$1";<br/>
                                $route["default_controller"] = "welcome";<br/>
                                $route["404_override"] = "";
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
