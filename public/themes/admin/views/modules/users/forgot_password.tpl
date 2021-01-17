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
            {elseif !empty($success)}
                {include file=get_theme_path('views/inc/alert.tpl') message=$success type='success'}
            {/if}
            {form_open(uri_string())}
                <p class="mb-2">{lang('text_forgot_password_note')}</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_username"><i class="fas fa-inbox"></i></span>
                    </div>
                    <input type="text" name="email" value="{set_value('email')}" id="email" placeholder="{lang('text_forgot_password_input')}" class="form-control form-control-lg" describedby="input_group_username">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-2">{lang('button_reset_password')}</button>
            {form_close()}
        </div>
        <div class="card-footer bg-white text-center p-0">
            <div class="card-footer-item card-footer-item-bordered">
                {anchor("users/manage/login", lang('text_login_back'), 'class="footer-link"')}
            </div>
        </div>
    </div>
</div>
