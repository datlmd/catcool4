{strip}

    {form_open($save, ["id" => "form_account_forgotten_reset", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#account_forgotten_reset_alert"])}

        <fieldset>
          <legend>{lang('Customer.text_forgotten_password')}</legend>
          
          <div id="account_forgotten_reset_alert">{print_flash_alert()}</div>

          <div class="row mb-3">
            <label for="input-password" class="col-sm-2 col-form-label">{lang('Customer.text_password')}</label>
            <div class="col-sm-10">
              <input type="password" name="password" value="" id="input_password" class="form-control"/>
              <div id="error_password" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="input-confirm" class="col-sm-2 col-form-label">{lang('Customer.text_password_confirm')}</label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="" id="input_confirm" class="form-control"/>
              <div id="error_confirm" class="invalid-feedback"></div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">{lang('Customer.button_account_forgotten_reset')}</button>
            </div>
          </div>
        </fieldset>

    {form_close()}

{/strip}
