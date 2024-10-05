{strip}
    <h1 class="mb-2 text-start">
        {lang('Customer.text_change_password_title')}
    </h1>

    {form_open($save, ["id" => "form_account_edit", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#account_edit_alert"])}

        <div id="account_edit_alert">{print_flash_alert()}</div>

        <fieldset class="mt-3">
            <legend class="mb-4">{lang('Customer.text_your_password')}</legend>
            
            <div class="form-group row mb-3 px-4">
                <label for="input_password_old" class="form-label fw-bold required-label">{lang('Customer.text_password_old')}</label>
                <div class="col-12 pb-4 border-bottom">
                    <input type="password" name="password_old" id="input_password_old" value="" placeholder="{lang('Customer.text_password_old')}" class="form-control {if validation_show_error('password_old')}is-invalid{/if}">
                    <div id="error_password_old" class="invalid-feedback">{validation_show_error("password_old")}</div>
                </div>
            </div>

            <div class="form-group row mb-4 px-4">
                <label for="input_password_new" class="form-label fw-bold required-label">{lang('Customer.text_password_new')}</label>
                <div class="col-12">
                    <input type="password" name="password_new" id="input_password_new" value="" placeholder="{lang('Customer.text_password_new')}" class="form-control {if validation_show_error('password_new')}is-invalid{/if}">
                    <div id="error_password_new" class="invalid-feedback">{validation_show_error("password_new")}</div>
                </div>
            </div>

            <div class="form-group row mb-4 px-4">
                <label for="input_confirm" class="form-label fw-bold required-label">{lang('Customer.text_password_confirm')}</label>
                <div class="col-12">
                    <input type="password" name="confirm" id="input_confirm" value="" placeholder="{lang('Customer.text_password_confirm')}" class="form-control {if validation_show_error('confirm')}is-invalid{/if}">
                    <div id="error_confirm" class="invalid-feedback">{validation_show_error("confirm")}</div>
                </div>
            </div>

        </fieldset>
        
        <div class="form-group row mt-4 mb-3">
            <div class="col">
                <a href="{$back}" class="btn btn-light">{lang('General.button_back')}</a>
            </div>
            <div class="col text-end">
                <button type="submit" class="btn btn-primary px-4">{lang('General.button_save')}</button>
            </div>
        </div>
        
    {form_close()}
{/strip}
