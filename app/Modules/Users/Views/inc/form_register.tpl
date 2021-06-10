{strip}
    <h4 class="color-primary text-4 text-uppercase mb-3 {if !empty($title_class)}{$title_class}{/if}">{lang('General.title_register')}</h4>
    <div class="col-12">{print_flash_alert()}</div>
    {if !empty($validator->getErrors(['first_name', 'identity', 'password', 'gender', 'policy']))}
        <div class="col-12">
            {include file=get_theme_path('views/inc/alert.tpl') message=$validator->getErrors(['first_name', 'identity', 'password', 'gender', 'policy']) type='danger'}
        </div>
    {/if}
    {form_open({site_url('users/post_register')}, ['id' => 'form_register', 'class' => 'needs-validatio row g-3'])}
        <div class="col-md-6">
            <input type="text" name="first_name" id="first_name" value="{old('first_name')}" required placeholder="{lang('General.text_first_name')}" class="form-control {if $validator->hasError('first_name')}is-invalid{/if}">
            <div class="invalid-feedback">{$validator->getError("first_name")}</div>
        </div>
        <div class="col-md-6">
            <input type="text" name="last_name" id="last_name" value="{old('last_name')}" placeholder="{lang('General.text_last_name')}" class="form-control">
        </div>
        <div class="col-md-12">
            <input type="text" name="identity" id="identity" value="{old('identity')}" required placeholder="{lang('General.text_identity')}" class="form-control {if $validator->hasError('identity')}is-invalid{/if}">
            <div class="invalid-feedback">{$validator->getError("identity")}</div>
        </div>
        <div class="col-md-12">
            <input type="password" name="password" id="password" value="" required placeholder="{lang('General.text_password')}" class="form-control {if $validator->hasError('password')}is-invalid{/if}">
            <div class="invalid-feedback">{$validator->getError("password")}</div>
        </div>

        <div class="col-12">
            <label class="form-label fw-bold text-dark">{lang('General.text_dob')}</label>
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
                                {if get_lang() eq 'vi'}
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
        <div class="col-12">
            <label class="form-label fw-bold text-dark">{lang('General.text_gender')}</label>
            <div class="row">
                <div class="col-4">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_male">{lang('General.text_male')}</label>
                        <input class="form-check-input {if $validator->hasError('gender')}is-invalid{/if}" type="radio" required name="gender" id="gender_male" value="{GENDER_OTHER}" {if old('gender') eq GENDER_MALE || !in_array(old('gender'), [GENDER_MALE,GENDER_FEMALE,GENDER_OTHER])}checked{/if} >
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_female">{lang('General.text_female')}</label>
                        <input class="form-check-input {if $validator->hasError('gender')}is-invalid{/if}" type="radio" required name="gender" id="gender_female" value="{GENDER_FEMALE}" {if old('gender') eq GENDER_FEMALE}checked{/if} >
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                        <label class="form-check-label w-100 ps-1" for="gender_other">{lang('General.text_other')}</label>
                        <input class="form-check-input {if $validator->hasError('gender')}is-invalid{/if}" type="radio" required name="gender" id="gender_other" value="{GENDER_OTHER}" {if old('gender') eq GENDER_OTHER}checked{/if} >
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input type="checkbox" name="policy" id="cb_policy" value="1" required {if !empty(old('policy'))}checked="checked"{/if} class="form-check-input {if $validator->hasError('policy')}is-invalid{/if}">
                <label class="form-check-label" for="cb_policy">
                    {lang('Frontend.text_register_policy')}
                </label>
                <div class="invalid-feedback">{$validator->getError("policy")}</div>
            </div>
        </div>
        <div class="col-12">
            <input type="submit" class="btn btn-primary" value="{lang('General.button_register')}">
        </div>
    {form_close()}
{/strip}
