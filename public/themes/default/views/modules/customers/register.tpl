{strip}
    <h1 class="mb-2 text-start">
        {lang('Customer.text_account_register')}
    </h1>
    <div class="mb-4">{sprintf(lang('Customer.text_register_description'), site_url('account/login'))}</div>

    {form_open($register, ["id" => "form_register", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#register_alert"])}

        <div id="register_alert">{print_flash_alert()}</div>

        <fieldset>
            <legend class="mb-2">{lang('Customer.text_your_details')}</legend>

            <div class="form-group row mb-3">
                <div class="col-md-6">
                    <label for="input_first_name" class="form-label fw-bold required-label">{lang('Customer.text_first_name')}</label>
                    <input type="text" name="first_name" id="input_first_name" value="{old('first_name')}" placeholder="{lang('Customer.text_first_name')}" class="form-control {if validation_show_error('first_name')}is-invalid{/if}">
                    <div id="error_first_name" class="invalid-feedback">{validation_show_error("first_name")}</div>
                    <div class="form-text">{lang('Customer.help_first_name')}</div>
                </div>
                <div class="col-md-6">
                    <label for="input_last_name" class="form-label fw-bold required-label">{lang('Customer.text_last_name')}</label>
                    <input type="text" name="last_name" id="input_last_name" value="{old('last_name')}" placeholder="{lang('Customer.holder_last_name')}" class="form-control {if validation_show_error('last_name')}is-invalid{/if}">
                    <div id="error_last_name" class="invalid-feedback">{validation_show_error("last_name")}</div>
                    <div class="form-text">{lang('Customer.help_last_name')}</div>
                </div>
            </div>

            <div class="form-group row mb-3">
                
                <label class="form-label fw-bold">{lang('General.text_gender')}</label>
                    
                <div class="col-6">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_male">{lang('General.text_male')}</label>
                        <input class="form-check-input {if validation_show_error('gender')}is-invalid{/if}" type="radio" name="gender" id="gender_male" value="{GENDER_OTHER}" {if old('gender') eq GENDER_MALE || !in_array(old('gender'), [GENDER_MALE,GENDER_FEMALE,GENDER_OTHER])}checked{/if} >
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_female">{lang('General.text_female')}</label>
                        <input class="form-check-input {if validation_show_error('gender')}is-invalid{/if}" type="radio" name="gender" id="gender_female" value="{GENDER_FEMALE}" {if old('gender') eq GENDER_FEMALE}checked{/if} >
                    </div>
                </div>
                {* <div class="col-4">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_other">{lang('General.text_other')}</label>
                        <input class="form-check-input {if validation_show_error('gender')}is-invalid{/if}" type="radio" name="gender" id="gender_other" value="{GENDER_OTHER}" {if old('gender') eq GENDER_OTHER}checked{/if} >
                    </div>
                </div> *}
                
            </div>

            <div class="form-group row mb-3">
                <div class="col-12">
                    <label class="form-label fw-bold">{lang('General.text_dob')}</label>
                    <div class="row">
                        <div class="col-4">
                            <select name="dob_day" class="form-control">
                                {for $d = 1; $d <= 31; $d++}
                                    <option value="{$d}" {if $d eq date('d')}selected{/if}>{$d}</option>
                                {/for}
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="dob_month" class="form-control">
                                {for $m = 1; $m <= 12; $m++}
                                    <option value="{$m}" {if $m eq date('m')}selected{/if}>
                                        {if get_language() eq 'vi'}
                                            {lang('General.text_month')} {$m}
                                        {else}
                                            {date("F", mktime(0, 0, 0, $m, 10))}
                                        {/if}
                                    </option>
                                {/for}
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="dob_year" class="form-control">
                                {for $y = date("Y"); $y >= 1900; $y--}
                                    <option value="{$y}">{$y}</option>
                                {/for}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="input_email" class="form-label fw-bold required-label">{lang('Customer.text_email')}</label>
                <div class="col-12">
                    <input type="text" name="email" id="input_email" value="{old('email')}" placeholder="{lang('Customer.text_email')}" class="form-control {if validation_show_error('email')}is-invalid{/if}">
                    <div id="error_email" class="invalid-feedback">{validation_show_error("email")}</div>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="input_phone" class="form-label fw-bold">{lang('Customer.text_phone')}</label>
                <div class="col-12">
                    <input type="text" name="phone" id="input_phone" value="{old('phone')}" placeholder="{lang('Customer.text_phone')}" class="form-control {if validation_show_error('phone')}is-invalid{/if}">
                    <div id="error_phone" class="invalid-feedback">{validation_show_error("phone")}</div>
                </div>
            </div>


        </fieldset>

        <fieldset class="mt-3">
            <legend class="mb-2">{lang('Customer.text_your_password')}</legend>
            <div class="form-group row mb-3">
                <label for="input_password" class="form-label fw-bold">{lang('Customer.text_password')}</label>
                <div class="col-12">
                    <input type="password" name="password" id="input_password" value="" placeholder="{lang('Customer.text_password')}" class="form-control {if validation_show_error('password')}is-invalid{/if}">
                    <div id="error_password" class="invalid-feedback">{validation_show_error("password")}</div>
                </div>
            </div>
        </fieldset>

        <fieldset class="mt-3">
            <legend class="mb-2">{lang('Customer.text_newsletter')}</legend>
            
            <div class="form-check form-switch form-control-lg">
                <input class="form-check-input" type="checkbox" name="newsletter" id="input_newsletter" value="1">
                <label for="input_newsletter" class="form-check-label">{lang('Customer.text_subscribe')}</label>
            </div>

        </fieldset>

        <div class="form-group row mt-4 mb-2">
            <div class="col-12">
                <div class="form-check form-switch form-control-lg form-check-inline">
                    <input class="form-check-input" type="checkbox" name="agree" id="input_agree" value="1">
                    <label for="input_agree" class="form-check-label">{lang('Customer.text_register_policy')}</label>
                </div>
                <div id="error_agree" class="invalid-feedback">{validation_show_error("agree")}</div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <div class="col-12">
                <input type="submit" class="btn btn-primary" value="{lang('General.button_register')}">
            </div>
        </div>
    {form_close()}
{/strip}
