{strip}
    <h4 class="color-primary text-4 text-uppercase mb-3 {$register_title_class}">{lang('Frontend.title_register')}</h4>
    {if !empty(print_flash_alert())}
        <div class="col-12">{print_flash_alert()}</div>
    {/if}
    {if !empty($errors)}
        <div class="col-12">
            {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
        </div>
    {/if}
    {form_open({site_url('users/post_register')}, ['id' => 'form_register', 'class' => 'row g-3'])}
        <div class="col-md-12">
            <label for="email" class="form-label fw-bold text-dark required-label">{lang('Frontend.text_email')}</label>
            <input type="email" name="email" id="email" value="" class="form-control {if $validator->hasError('email')}is-invalid{/if}">
            <div class="invalid-feedback">{$validator->getError("email")}</div>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label fw-bold text-dark required-label">{lang('Frontend.text_password')}</label>
            <input type="password" name="password" id="password" value="" class="form-control {if $validator->hasError('password')}is-invalid{/if}">
            <div class="invalid-feedback">{$validator->getError("password")}</div>
        </div>
        <div class="col-md-6">
            <label for="password_confirm" class="form-label fw-bold text-dark required-label">{lang('Frontend.text_password_confirm')}</label>
            <input type="password" name="password_confirm" id="password_confirm" value="" class="form-control {if $validator->hasError('password_confirm')}is-invalid{/if}">
            <div class="invalid-feedback">{$validator->getError("password_confirm")}</div>
        </div>
        <div class="col-md-6">
            <label for="first_name" class="form-label fw-bold text-dark required-label">{lang('Frontend.text_first_name')}</label>
            <input type="text" name="first_name" id="first_name" value="" class="form-control {if $validator->hasError('first_name')}is-invalid{/if}">
            <div class="invalid-feedback">{$validator->getError("first_name")}</div>
        </div>
        <div class="col-md-6">
            <label for="last_name" class="form-label fw-bold text-dark">{lang('Frontend.text_last_name')}</label>
            <input type="text" name="last_name" id="last_name" value="" class="form-control">
        </div>
        <div class="col-md-12">
            <label for="phone" class="form-label fw-bold text-dark">{lang('Frontend.text_phone')}</label>
            <input type="text" name="phone" id="phone" value="" class="form-control">
        </div>
        <div class="col-12">
            <label for="address" class="form-label fw-bold text-dark">{lang('Frontend.text_address')}</label>
            <input type="text" name="address" class="form-control" id="address">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input type="checkbox" name="policy" id="cb_policy" class="form-check-input mt-2 {if $validator->hasError('policy')}is-invalid{/if}">
                <label class="form-check-label" for="gridCheck">
                    {lang('Frontend.text_register_policy')}
                </label>
                <div class="invalid-feedback">{$validator->getError("policy")}</div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">{lang('Frontend.button_register')}</button>
        </div>
    {form_close()}
{/strip}
