{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('RouteAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{if previous_url() eq current_url()}{site_url($manage_url)}{else}{previous_url()}{/if}" class="btn btn-sm btn-space btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.id)}
                {form_hidden('id', $edit_data.id)}
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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('RouteAdmin.text_route')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.route)}
                                        {assign var="route" value="`$edit_data.route`"}
                                    {else}
                                        {assign var="route" value=""}
                                    {/if}
                                    <input type="text" name="route" value="{old('route', $route)}" id="route" class="form-control {if $validator->hasError('route')}is-invalid{/if}">
                                    <div class="invalid-feedback">{$validator->getError("route")}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('RouteAdmin.text_module')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.module)}
                                        {assign var="module" value="`$edit_data.module`"}
                                    {else}
                                        {assign var="module" value=""}
                                    {/if}
                                    <input type="text" name="module" value="{old('module', $module)}" id="module" class="form-control {if $validator->hasError('module')}is-invalid{/if}">
                                    <div class="invalid-feedback">{$validator->getError("module")}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('RouteAdmin.text_resource')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.resource)}
                                        {assign var="resource" value="`$edit_data.resource`"}
                                    {else}
                                        {assign var="resource" value=""}
                                    {/if}
                                    <input type="text" name="resource" value="{old('resource', $resource)}" id="resource" class="form-control {if $validator->hasError('resource')}is-invalid{/if}">
                                    <div class="invalid-feedback">{$validator->getError("resource")}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('Admin.text_language')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.language_id)}
                                        {assign var="language_id" value="`$edit_data.language_id`"}
                                    {else}
                                        {assign var="language_id" value=""}
                                    {/if}
                                    <select name="language_id" id="language_id" class="form-control">
                                        {foreach get_list_lang(true) as $language}
                                            <option value="{$language.id}" {if $language_id eq $language.id}selected="selected"{/if}>{$language.name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                    {lang('Admin.text_published')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if isset($edit_data.published)}
                                        {assign var="published" value="`$edit_data.published`"}
                                    {else}
                                        {assign var="published" value="1"}
                                    {/if}
                                    <label class="form-check form-check-inline ms-2 mt-2">
                                        <input type="radio" name="published" value="{STATUS_ON}" {if old('published', $published) eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
                                        <label class="form-check-label" for="published_on">ON</label>
                                    </label>
                                    <label class="form-check form-check-inline me-2 mt-2">
                                        <input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $published) eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
                                        <label class="form-check-label" for="published_off">OFF</label>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('text_example')}</div>
                                <code class="col-12 col-sm-8 col-lg-6 text-start">
                                    $routes->add('product/(:num)', 'App\Catalog::productLookup');<br/>
                                    $routes->add('journals', 'App\Blogs');<br/>
                                    $routes->add('blog/joe', 'Blogs::users/34');<br/>
                                    $routes->add('product/(:segment)', 'Catalog::productLookup/$1');<br/>
                                    {literal}$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');{/literal}<br/>
                                    $routes->add('users/(:uuid)', 'Users::show/$1');<br/>
                                    $routes->add('users', 'Users::index');<br/>
                                    $routes->add('users', 'Admin\Users::index');
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
