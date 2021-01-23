{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'user_validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save"></i></button>
                <a href="{$manage_url}/edit/{$edit_data.id}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('text_cancel')}"><i class="fas fa-reply"></i></a>
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
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-key me-2"></i>{lang('text_change_password')}</h5>
                    <div class="card-body">
                        <div class="form-group row required has-error">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('text_username')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7 pt-1">
                                <a href="{$manage_url}/edit/{$edit_data.id}" class="text-dark"><i class="fas fa-user me-2"></i>{$edit_data.username}</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
                                {lang('text_password_old')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_old" value="" id="password_old" class="form-control {if !empty(form_error("password_old"))}is-invalid{/if}">
                                {if !empty(form_error("password_old"))}
                                    <div class="invalid-feedback">{form_error("password_old")}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
                                {lang('text_password_new')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_new" value="" id="password_new" class="form-control {if !empty(form_error("password_new"))}is-invalid{/if}">
                                {if !empty(form_error("password_new"))}
                                    <div class="invalid-feedback">{form_error("password_new")}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
                                {lang('text_confirm_password_new')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_confirm_new" value="" id="password_confirm_new" class="form-control {if !empty(form_error("password_confirm_new"))}is-invalid{/if}">
                                {if !empty(form_error("password_confirm_new"))}
                                    <div class="invalid-feedback">{form_error("password_confirm_new")}</div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
