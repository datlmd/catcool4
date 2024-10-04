{strip}
    <h1 class="mb-2 text-start">
        {lang('Customer.text_account_forgotten')}
    </h1>
    <div class="my-3">{lang('Customer.text_forgotten_email')}</div>

    {form_open($forgotten, ["id" => "form_account_forgotten", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#account_forgotten_alert"])}

        <div id="account_forgotten_alert">{print_flash_alert()}</div>

        <fieldset>
            <legend>{lang('Customer.text_your_email')}</legend>
            <div class="row mb-3 required">
                <label for="input_email" class="col-sm-2 col-form-label">{lang('Customer.text_input_email')}</label>
                
                <div class="col-sm-7">
                    <input type="text" name="email" value="" placeholder="{lang('Customer.text_input_email')}"
                        id="input_email" class="form-control" />
                    <div id="error_email" class="invalid-feedback"></div>
                </div>

                <div class="col-sm-3 text-end">
                    <button type="submit" class="btn btn-primary w-100">{lang('Customer.button_account_forgotten')}</button>
                </div>
            </div>
        </fieldset>

    {form_close()}

{/strip}
