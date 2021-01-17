<div class="splash-container">
  <div class="card">
    <div class="card-header text-center">
        <a href="{site_url()}" title="{lang('login_heading')}">{img('logo.png', 'class="logo-img" alt="logo"', 'themes/admin/assets/img/')}</a>
        <span class="splash-description">{lang('login_subheading')}</span>
    </div>
    <div class="card-body">
        {form_open("user/auth/login")}
            <div class="form-group">
                {form_input($identity)}
            </div>
            <div class="form-group">
                {form_input($password)}
            </div>
            <div class="form-group">
              <label class="custom-control custom-checkbox">
                  {form_checkbox('remember', '1', FALSE, 'id="remember" class="custom-control-input"')}
                  <span class="custom-control-label"> {lang('login_remember_label')}</span>
              </label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">{lang('login_submit_btn')}</button>
        {form_close()}
    </div>
    <div class="card-footer bg-white p-0">
      <div class="card-footer-item card-footer-item-bordered">
          {anchor("user/auth/create_user", 'Create An Account', 'class="footer-link"')}
      </div>
      <div class="card-footer-item card-footer-item-bordered">
          {anchor("user/auth/forgot_password", lang('login_forgot_password'), 'class="footer-link"')}
      </div>
    </div>
  </div>
</div>
