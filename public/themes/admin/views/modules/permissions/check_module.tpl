{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}

            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('PermissionAdmin.heading_title')}

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
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>Check Module</h5>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_module')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <select name="module" class="form-control">
                                        {foreach $module_list as $value}
                                            <option value="{$value.module}" {if strtolower($value.module) eq strtolower($module)}selected{/if}>{{$value.module}}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end"></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>{lang('Admin.button_check')}</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    {if !empty($module_methods)}
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered second">
                                        <thead>
                                        <tr class="text-center">
                                            <th width="50">Module</th>
                                            <th>Controller</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {foreach $module_methods as $controller => $methods}
                                            {foreach $methods as $key => $method}
                                                <tr {if empty($method)}class="text-danger"{/if}>
                                                    <td>{$module}</td>
                                                    <td>{$controller}</td>
                                                    <td>{$key}</td>
                                                    <td>
                                                        {if !empty($method)}
                                                            {anchor("$manage_url/edit/`$method.id`", "Added - `$method.id`", 'class="text-dark" target="_blank"')}
                                                        {else}
                                                            {anchor("$manage_url/add?name=`$key`&description=$module $controller ", "Add", 'class="text-danger" target="_blank"')}
                                                        {/if}

                                                    </td>
                                                </tr>
                                            {/foreach}
                                        {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    {/if}

                </div>
            </div>
        {form_close()}
    </div>
{/strip}
