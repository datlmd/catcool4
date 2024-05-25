{strip}
<style>
    body {
        background: url({img_url(config_item('background_image_admin_path'))}) no-repeat center center; background-size: cover;
    }
</style>
<div class="splash-container">
    <div class="card">
        <div class="card-header text-center">
            {include file=get_theme_path('views/inc/logo.tpl') lodo_sub_class="text-dark"}
        </div>
        <div class="card-body pt-4">
            {if !empty(print_flash_alert())}
                <div class="col-12">{print_flash_alert()}</div>
            {/if}
            {if !empty($errors)}
                {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
            {/if}

            {if !empty($success)}
                {include file=get_theme_path('views/inc/alert.tpl') message=$success type='success'}
            {else}

                {form_open($forgot_password)}
                    <p class="mb-2">{lang('UserAdmin.text_forgot_password_note')}</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_group_username"><i class="fas fa-inbox"></i></span>
                        <input type="text" name="email" value="{set_value('email')}" id="email" placeholder="{lang('UserAdmin.text_forgot_password_input')}" class="form-control form-control-lg" aria-describedby="input_group_username">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-2 w-100">{lang('UserAdmin.button_reset_password')}</button>
                {form_close()}
                
            {/if}
            
        </div>
        <div class="card-footer bg-white text-center p-0">
            <div class="card-footer-item card-footer-item-bordered">
                {anchor("manage/users/login", lang('UserAdmin.text_login_back'), 'class="footer-link"')}
            </div>
        </div>
    </div>
</div>
{/strip}
