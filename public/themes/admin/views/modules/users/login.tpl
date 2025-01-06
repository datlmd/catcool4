{strip}
    <style>
        body {
            background: url({img_url(config_item('background_image_admin_path'))}) no-repeat center center; background-size: cover;
        }
    </style>
    <div class="splash-container">
        <div class="card mb-0">
            <div class="card-header text-center">
                {include file=get_theme_path('views/inc/logo.tpl') lodo_sub_class="text-dark" is_disable_link = 1}
            </div>
            <div class="card-body pt-4">
                {if !empty($errors)}
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                {/if}
                {if !empty(print_flash_alert())}
                    {print_flash_alert()}
                {/if}
                {form_open($login, ["id" => "login_form", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#login_alert"])}
                    <div id="login_alert"></div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="input_username" name="username" value="{old('username', $username)}" placeholder="" autocomplete="off">
                        <label for="input_username">{lang('Admin.text_username')}</label>
                        <div class="invalid-feedback" id="error_username"></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="input_password" name="password" value="" placeholder="">
                        <label for="input_password">{lang('Admin.text_password')}</label>
                        <div class="invalid-feedback" id="error_password"></div>
                    </div>

{*                    <div class="form-group text-center">*}
{*                        {reCaptcha3('captcha', ['id' => 'recaptcha_v3'], ['action' => 'loginRootForm'])}*}
{*                    </div>*}

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
                  {anchor("manage/users/forgot_password", lang('Admin.text_forgot_password'), 'class="footer-link"')}
              </div>
            </div>
        </div>
    </div>
{/strip}
