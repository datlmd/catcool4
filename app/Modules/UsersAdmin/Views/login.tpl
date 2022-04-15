{strip}
    <style>
        body {
            background: url({img_url(config_item('background_image_admin_path'))}) no-repeat center center;
        }
    </style>
    <div class="splash-container">
        <div class="card mb-0">
            <div class="card-header">
                {include file=get_theme_path('views/inc/logo.tpl') lodo_sub_class="text-dark" is_disable_link = 1}
            </div>
            <div class="card-body pt-4">
                {if !empty($errors)}
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                {/if}
                {form_open(uri_string())}
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" name="username" value="{old('username', $username)}" placeholder="{lang('Admin.text_username')}" autocomplete="off">
                        <label for="username">{lang('Admin.text_username')}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="{lang('Admin.text_password')}">
                        <label for="password">{lang('Admin.text_password')}</label>
                    </div>

                    <div class="form-group text-center">
                        {reCaptcha3('captcha', ['id' => 'recaptcha_v3'], ['action' => 'loginRootForm'])}
                    </div>
                    <div class="form-group form-check mt-3">
                        {if !empty(old('remember', $remember))}
                            {form_checkbox('remember', '1', true, 'id="remember" class="form-check-input"')}
                        {else}
                            {form_checkbox('remember', '1', false, 'id="remember" class="form-check-input"')}
                        {/if}
                        <label class="form-check-label" for="remember"> {lang('Admin.text_login_remember')}</label>
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="redirect" value="{old('redirect', $redirect)}">
                        <button type="submit" class="btn btn-primary btn-lg mt-2 w-100">{lang('Admin.button_login')}</button>
                    </div>
                {form_close()}
            </div>
            <div class="card-footer bg-white text-center p-0">
              <div class="card-footer-item card-footer-item-bordered">
                  {anchor("users_admin/manage/forgot_password", lang('Admin.text_forgot_password'), 'class="footer-link"')}
              </div>
            </div>
        </div>
    </div>
{/strip}
