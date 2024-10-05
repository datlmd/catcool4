{strip}
    <h1 class="mb-2 text-start">
        {lang('Customer.text_newsletter_title')}
    </h1>

    {form_open($save, ["id" => "form_account_edit", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#account_edit_alert"])}

        <div id="account_edit_alert">{print_flash_alert()}</div>

        <fieldset class="mt-3 ps-5">
            
            <div class="form-check form-switch form-control-lg">
                <input class="form-check-input" type="checkbox" name="newsletter" id="input_newsletter" {set_checkbox('newsletter', 1, $customer_info.newsletter|default:false)} value="1">
                <label for="input_newsletter" class="form-check-label">{lang('Customer.text_subscribe')}</label>
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
