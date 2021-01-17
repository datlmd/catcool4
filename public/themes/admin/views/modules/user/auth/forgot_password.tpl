<!-- ============================================================== -->
<!-- forgot password  -->
<!-- ============================================================== -->
<div class="splash-container">
    <div class="card">
        <div class="card-header text-center">
            <a href="{site_url()}" titel="{lang('login_heading')}">{img('logo.png', 'class="logo-img" alt="logo"', 'themes/admin/assets/img/')}</a>
            <span class="splash-description">{lang('forgot_password_heading')}</span>
        </div>
        <div class="card-body">
            {form_open("user/auth/forgot_password")}
                <p>{sprintf(lang('forgot_password_subheading'), $text_identity)}</p>
                <div class="form-group">
                    {if $type=='email'}
                        {sprintf(lang('forgot_password_email_label'), $text_identity)}
                    {else}
                        {sprintf(lang('forgot_password_identity_label'), $text_identity)}
                    {/if}
                    <br />
                    {form_input($identity, '', 'class="form-control form-control-lg"')}
                </div>
                <div class="form-group pt-1">
                    <button type="submit" class="btn btn-block btn-primary btn-xl">{lang('forgot_password_submit_btn')}</button>
                </div>
            {form_close()}
        </div>
        <div class="card-footer text-center">
            <span>Don't have an account? <a href="pages-sign-up.html">Sign Up</a></span>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- end forgot password  -->
<!-- ============================================================== -->
