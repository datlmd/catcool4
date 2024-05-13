{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'user_validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.text_change_password')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"><i class="fas fa-save me-1"></i>{lang('UserAdmin.text_change_password')}</button>
                <a href="{$manage_url}/edit/{$edit_data.user_id}" class="btn btn-sm btn-space btn-secondary mb-0"><i class="fas fa-reply me-1"></i>{lang('Admin.text_cancel')}</a>
            </div>
        </div>
        {if !empty($edit_data.user_id)}
            {form_hidden('user_id', $edit_data.user_id)}
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
                    <h5 class="card-header"><i class="fas fa-key me-2"></i>{lang('UserAdmin.text_change_password')}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_username')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7 pt-2">
                                <a href="{site_url($manage_url)}/edit/{$edit_data.user_id}" class="text-dark"><i class="fas fa-user me-2"></i>{$edit_data.username}</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('UserAdmin.text_password_old')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_old" value="" id="password_old" class="form-control {if validation_show_error('password_old')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("password_old")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('UserAdmin.text_password_new')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_new" value="" id="password_new" class="form-control {if validation_show_error('password_new')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("password_new")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('UserAdmin.text_confirm_password_new')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_confirm_new" value="" id="password_confirm_new" class="form-control {if validation_show_error('password_confirm_new')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("password_confirm_new")}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
{/strip}
