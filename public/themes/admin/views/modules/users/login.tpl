<style>
    body {
        background: url({img_url('assets/images/auth-bg.jpg')}) no-repeat center center;
    }
</style>
<div class="splash-container">
    <div class="card">
        <div class="card-header">
            {include file=get_theme_path('views/inc/logo.tpl') lodo_sub_class="text-dark"}
        </div>
        <div class="card-body pt-4">
            {if !empty($errors)}
                {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
            {/if}
            {form_open(uri_string())}
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_username"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="username" value="" id="username" placeholder="{lang('text_username')}" class="form-control form-control-lg" describedby="input_group_username" autocomplete="off">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_password"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" value="" id="password" placeholder="{lang('text_password')}" describedby="input_group_password" class="form-control form-control-lg">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_captcha"><i class="fas fa-shield-alt"></i></span>
                    </div>
                    <input type="number" name="captcha" value="" id="captcha" placeholder="{lang('text_captcha')}" describedby="input_group_captcha" class="form-control form-control-lg" autocomplete="off">
                </div>
                <div class="form-group text-center">
                    {$image_captcha}
                </div>
                <div class="form-group mt-3">
                  <label class="custom-control custom-checkbox">
                      {form_checkbox('remember', '1', FALSE, 'id="remember" class="custom-control-input"')}
                      <span class="custom-control-label"> {lang('text_login_remember')}</span>
                  </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-2">{lang('button_login')}</button>
            {form_close()}
        </div>
        <div class="card-footer bg-white text-center p-0">
          <div class="card-footer-item card-footer-item-bordered">
              {anchor("users/manage/forgot_password", lang('text_forgot_password'), 'class="footer-link"')}
          </div>
        </div>
    </div>
</div>
