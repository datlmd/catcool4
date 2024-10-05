{strip}
    <h1 class="mb-3 text-start">
        {lang('Customer.text_account_edit_title')}
    </h1>

    {form_open($save, ["id" => "form_account_edit", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#account_edit_alert"])}

        <div id="account_edit_alert">{print_flash_alert()}</div>

        <fieldset>
            <legend class="mb-4">{lang('Customer.text_your_details')}</legend>

            {if $customer_group_list|@count > 1}
                <div class="form-group row mb-3 px-4">
                    <div class="col">
                        <label for="input_customer_group_id" class="form-label fw-bold required-label">{lang('Customer.text_customer_group')}</label>
                        <select name="customer_group_id" id="input_customer_group_id" class="form-control">
                            {foreach $customer_group_list as $customer_group}
                                <option value="{$customer_group.customer_group_id}" {set_select('customer_group_id', $customer_group.customer_group_id, ($customer_group.customer_group_id == $customer_info.customer_group_id))}>{$customer_group.name}</option>
                            {/foreach}
                        </select>
                        <div id="error_customer_group_id" class="invalid-feedback"></div>
                    </div>
                </div>
            {/if}

            <div class="form-group row mb-3 px-4">
                <div class="col-md-6">
                    <label for="input_first_name" class="form-label fw-bold required-label">{lang('Customer.text_first_name')}</label>
                    <input type="text" name="first_name" id="input_first_name" value="{old('first_name', $customer_info.first_name)}" placeholder="{lang('Customer.text_first_name')}" class="form-control {if validation_show_error('first_name')}is-invalid{/if}">
                    <div id="error_first_name" class="invalid-feedback">{validation_show_error("first_name")}</div>
                    <div class="form-text">{lang('Customer.help_first_name')}</div>
                </div>
                <div class="col-md-6">
                    <label for="input_last_name" class="form-label fw-bold required-label">{lang('Customer.text_last_name')}</label>
                    <input type="text" name="last_name" id="input_last_name" value="{old('last_name', $customer_info.last_name)}" placeholder="{lang('Customer.holder_last_name')}" class="form-control {if validation_show_error('last_name')}is-invalid{/if}">
                    <div id="error_last_name" class="invalid-feedback">{validation_show_error("last_name")}</div>
                    <div class="form-text">{lang('Customer.help_last_name')}</div>
                </div>
            </div>

            <div class="form-group row mb-3 px-4">
                
                <label class="form-label fw-bold">{lang('General.text_gender')}</label>
                    
                <div class="col-6">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_male">{lang('General.text_male')}</label>
                        <input class="form-check-input {if validation_show_error('gender')}is-invalid{/if}" type="radio" name="gender" id="gender_male" value="{GENDER_MALE}" {if old('gender', $customer_info.gender) eq GENDER_MALE || !in_array(old('gender', $customer_info.gender), [GENDER_MALE,GENDER_FEMALE,GENDER_OTHER])}checked{/if} >
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_female">{lang('General.text_female')}</label>
                        <input class="form-check-input {if validation_show_error('gender')}is-invalid{/if}" type="radio" name="gender" id="gender_female" value="{GENDER_FEMALE}" {if old('gender', $customer_info.gender) eq GENDER_FEMALE}checked{/if} >
                    </div>
                </div>
                {* <div class="col-4">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_other">{lang('General.text_other')}</label>
                        <input class="form-check-input {if validation_show_error('gender')}is-invalid{/if}" type="radio" name="gender" id="gender_other" value="{GENDER_OTHER}" {if old('gender', $customer_info.gender) eq GENDER_OTHER}checked{/if} >
                    </div>
                </div> *}
                
            </div>

            <div class="form-group row mb-3 px-4">
                <div class="col-12">
                    <label class="form-label fw-bold">{lang('General.text_dob')}</label>
                    <div class="input-group date show-date-picker" id="show-date-picker"
                        data-target-input="nearest" data-date-format="{get_date_format_ajax()|upper}"
                        data-date-locale="{language_code()}">
                        <input type="text" 
                            name="dob" 
                            id="dob" 
                            class="form-control datetimepicker-input"
                            {if old('dob', $customer_info.dob)}value="{old('dob', $customer_info.dob)|date_format:get_date_format(true)}"{/if} 
                            placeholder="{get_date_format_ajax()}" 
                            data-target="#show-date-picker" 
                        />
                        <div class="input-group-text" data-target="#show-date-picker"
                            data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                    
                </div>
            </div>

            <div class="form-group row mb-3 px-4">
                <label for="input_email" class="form-label fw-bold required-label">{lang('Customer.text_email')}</label>
                <div class="col-12">
                    <input type="text" name="email" id="input_email" value="{old('email', $customer_info.email)}" placeholder="{lang('Customer.text_email')}" class="form-control {if validation_show_error('email')}is-invalid{/if}">
                    <div id="error_email" class="invalid-feedback">{validation_show_error("email")}</div>
                </div>
            </div>

            <div class="form-group row mb-3 px-4">
                <label for="input_phone" class="form-label fw-bold">{lang('Customer.text_phone')}</label>
                <div class="col-12">
                    <input type="text" name="phone" id="input_phone" value="{old('phone', $customer_info.phone)}" placeholder="{lang('Customer.text_phone')}" class="form-control {if validation_show_error('phone')}is-invalid{/if}">
                    <div id="error_phone" class="invalid-feedback">{validation_show_error("phone")}</div>
                </div>
            </div>

        </fieldset>
        
        <div class="form-group row my-4">
            <div class="col">
                <a href="{$back}" class="btn btn-light">{lang('General.button_back')}</a>
            </div>
            <div class="col text-end">
                <button type="submit" class="btn btn-primary px-4">{lang('General.button_save')}</button>
            </div>
        </div>
    {form_close()}
{/strip}
