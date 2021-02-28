{strip}
<style>
    body {
        background: url({img_url('auth-bg.jpg')}) no-repeat center center;
    }
</style>
<div class="splash-container">
    <div class="card mb-0">
        <div class="card-header">
            {include file=get_theme_path('views/inc/logo.tpl') lodo_sub_class="text-dark"}
        </div>
        <div class="card-body pt-4">
            {if !empty($errors)}
                {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
            {/if}
            {form_open(uri_string())}
                <div class="input-group mb-3">
                    <span class="input-group-text" id="input_group_username"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" value="{old('username', $username)}" id="username" placeholder="{lang('Admin.text_username')}" class="form-control form-control-lg" describedby="input_group_username" autocomplete="off">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="input_group_password"><i class="fas fa-key"></i></span>
                    <input type="password" name="password" value="" id="password" placeholder="{lang('Admin.text_password')}" describedby="input_group_password" class="form-control form-control-lg">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_captcha"><i class="fas fa-shield-alt"></i></span>
                    </div>
                    <input type="number" name="captcha" value="" id="captcha" placeholder="{lang('text_captcha')}" describedby="input_group_captcha" class="form-control form-control-lg" autocomplete="off">
                </div>
                <div class="form-group text-center">

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
                    <button type="submit" class="btn btn-primary btn-lg mt-2">{lang('Admin.button_login')}</button>
                </div>
            {form_close()}
        </div>
        <div class="card-footer bg-white text-center p-0">
          <div class="card-footer-item card-footer-item-bordered">
              {anchor("users/manage/forgot_password", lang('Admin.text_forgot_password'), 'class="footer-link"')}
          </div>
        </div>
    </div>
</div>
{/strip}
