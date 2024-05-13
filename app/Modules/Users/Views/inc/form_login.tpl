{strip}
    <h4 class="color-primary text-4 text-uppercase mb-3 {if !empty($title_class)}{$title_class}{/if}">
        {lang('General.text_login')}
    </h4>
    {form_open({site_url('users/post_login')}, ['id' => 'form_login', 'class' => 'needs-validation'])}
        <div class="form-group row">
            <div class=" col-12">
                <input type="text" name="login_identity" id="login_identity" value="" placeholder="{lang('General.text_login_identity')}" class="form-control {if validation_show_error('login_identity')}is-invalid{/if}">
                <div class="invalid-feedback">{validation_show_error("login_identity")}</div>
            </div>
        </div>
        <div class="form-group row mt-3">
            <div class="col-12">
                <input type="password" name="login_password" id="login_password" value="" class="form-control {if validation_show_error('login_password')}is-invalid{/if}" placeholder="{lang('General.text_password')}">
                <div class="invalid-feedback">{validation_show_error("login_password")}</div>
            </div>
        </div>
        <div class="form-group row mt-2">
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label text-2" for="remember">{lang('General.text_remember')}</label>
                </div>
            </div>
        </div>
        <div class="fform-group row my-2">
            <div class="col-12 text-center">
                <input type="submit" value="{lang('General.button_login')}" class="btn btn-primary" data-loading-text="Loading...">
            </div>
        </div>
    {form_close()}

    <div class="col-12 text-center">
        <a class="" href="#">{lang('General.text_lost_password')}</a>
    </div>
    <div class="text-center-line mt-3">{lang('General.text_or')}</div>

    {include file=get_module_path("Users/Views/inc/login_social.tpl")}
{/strip}
