{strip}
    <h1 class="text-uppercase mb-4 text-center">
        {lang('General.text_login')}
    </h1>
    
    <div class="mx-auto" style="max-width:500px;">
        {form_open(site_url("account/login"), ["id" => "login_form", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#login_alert"])}
            
            <input type="hidden" name="return_url" value="{$return_url}">

            <div id="login_alert"></div>

            <div class="form-group row">
                <div class=" col-12">
                
                    <input type="text" name="login_identity" id="inpu_login_identity" value="" placeholder="{lang('General.text_login_identity')}" class="form-control {if $validator->hasError('login_identity')}is-invalid{/if}">
                    <div id="error_login_identity" class="invalid-feedback">{$validator->getError("login_identity")}</div>

                </div>
            </div>
            <div class="form-group row mt-3">
                <div class="col-12">
                    <input type="password" name="login_password" id="input_login_password" value="" class="form-control {if $validator->hasError('login_password')}is-invalid{/if}" placeholder="{lang('General.text_password')}">
                    <div id="error_login_password" class="invalid-feedback">{$validator->getError("login_password")}</div>
                </div>
            </div>
            <div class="form-group row mt-2">
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label text-2" for="remember">{lang('General.text_remember')}</label>
                    </div>
                </div>
            </div>
            <div class="fform-group row my-2">
                <div class="col-6 text-start">
                    <input type="submit" value="{lang('General.button_login')}" class="btn btn-primary" data-loading-text="Loading...">
                </div>
                <div class="col-6 text-end">
                    <a class="" href="#">{lang('General.text_lost_password')}</a>
                </div>
            </div>

        {form_close()}

        <div class="col-12 text-center mt-3">
            
        </div> 
        <div class="text-center-line mt-3">{lang('General.text_or')}</div>

        {include file=get_module_path("Customers/Views/inc/login_social.tpl")}
    </div>
{/strip}
