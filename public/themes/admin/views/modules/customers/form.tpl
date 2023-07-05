{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid dashboard-content">
        {form_open(site_url("$manage_url/save"), ['id' => 'customer_validationform', "method" => "post", "data-cc-toggle" => "ajax"])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CustomerAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{back_to($manage_url)}" class="btn btn-sm btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>

            <input type="hidden" name="customer_id" value="{$edit_data.customer_id}">

            <div class="row">
                {if !empty(print_flash_alert())}
                    <div class="col-12">{print_flash_alert()}</div>
                {/if}
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12">
                    <div id="customer_detail" class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.customer_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">

                            <h3 class="border-bottom pb-3">{lang('CustomerAdmin.text_customer_detail')}</h3>

                            <div class="form-group row required has-error">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_username')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="username" value='{old("username", $edit_data.username)}' id="input_username" class="form-control {if $validator->hasError('username')}is-invalid{/if}">
                                    <div id="error_username" class="invalid-feedback">{$validator->getError("username")}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('CustomerAdmin.text_email')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="email" value='{old("email", $edit_data.email)}' id="input_email" class="form-control {if $validator->hasError('email')}is-invalid{/if}">
                                    <div id="error_email" class="invalid-feedback">{$validator->getError("email")}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('CustomerAdmin.text_phone')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="tel" name="phone" value="{old('phone', $edit_data.phone)}" id="input_phone" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_group')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {if !empty($groups)}
                                        <select name="group_id" id="input_group_id" class="form-control form-control-sm">
                                            {foreach $groups as $key => $group}
                                                <option value="{$key}" {if $key eq $edit_data.group_id}selected{/if}>{$group.name}</option>
                                            {/foreach}
                                        </select>
                                    {/if}
                                </div>
                            </div>

                            <h3 class="border-bottom pb-3"></h3>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_first_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="first_name" value='{old("first_name", $edit_data.first_name)}' id="input_first_name" class="form-control {if $validator->hasError('first_name')}is-invalid{/if}">
                                    <small>{lang('Admin.help_first_name')}</small>
                                    <div id="error_first_name" class="invalid-feedback">{$validator->getError("first_name")}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_last_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="last_name" value='{old("last_name", $edit_data.last_name)}' id="input_last_name" class="form-control {if $validator->hasError('last_name')}is-invalid{/if}">
                                    <small>{lang('Admin.help_last_name')}</small>
                                    <div id="error_last_name" class="invalid-feedback">{$validator->getError("last_name")}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_gender')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <label class="form-check form-check-inline mt-2">
                                        <input type="radio" name="gender" value="{GENDER_MALE}" {if old('gender', $edit_data.gender)|default:3 eq GENDER_MALE}checked="checked"{/if} id="gender_male" class="form-check-input">
                                        <label class="form-check-label" for="gender_male">{lang('Admin.text_gender_male')}</label>
                                    </label>
                                    <label class="form-check form-check-inline mt-2 me-2">
                                        <input type="radio" name="gender" value="{GENDER_FEMALE}" {if old('gender', $edit_data.gender)|default:3 eq GENDER_FEMALE}checked="checked"{/if} id="gender_female" class="form-check-input">
                                        <label class="form-check-label" for="gender_female">{lang('Admin.text_gender_female')}</label>
                                    </label>
                                    <label class="form-check form-check-inline mt-2 me-2">
                                        <input type="radio" name="gender" value="{GENDER_OTHER}" {if old('gender', $edit_data.gender)|default:3 eq GENDER_OTHER}checked="checked"{/if} id="gender_other" class="form-check-input">
                                        <label class="form-check-label" for="gender_other">{lang('Admin.text_gender_other')}</label>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_dob')}
                                </label>
                                <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                    <div class="input-group date show-date-picker" id="show_date_picker" data-target-input="nearest" data-date-format="{get_date_format_ajax()|upper}" data-date-locale="{get_lang(true)}">
                                        <input type="text" name="dob" id="input_dob" class="form-control datetimepicker-input {if $validator->hasError('dob')}is-invalid{/if}" {if old('dob', $edit_data.dob)}value="{old('dob', $edit_data.dob)|date_format:get_date_format(true)}"{/if} placeholder="{get_date_format_ajax()}" data-target="#show_date_picker" />
                                        <div class="input-group-text" data-target="#show_date_picker" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                                    </div>
                                    <div id="error_dob" class="invalid-feedback">{$validator->getError("dob")}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('CustomerAdmin.text_company')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="company" value="{old('company', $edit_data.company)}" id="input_company" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('CustomerAdmin.text_fax')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="fax" value="{old('fax', $edit_data.fax)}" id="input_fax" class="form-control">
                                </div>
                            </div>

                            <h3 class="border-bottom pb-3">{lang('Admin.text_password')}</h3>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_password')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="password" name="password" value="" id="input_password" class="form-control {if $validator->hasError('password')}is-invalid{/if}">
                                    <div id="error_password" class="invalid-feedback">{$validator->getError("password")}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_confirm_password')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="password" name="password_confirm" value="" id="input_password_confirm" class="form-control {if $validator->hasError('password_confirm')}is-invalid{/if}">
                                    <div id="error_password_confirm" class="invalid-feedback">{$validator->getError("password_confirm")}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                {lang('CustomerAdmin.text_avatar')}
                                <!-- Drag and Drop container-->
                                <div class="drop-drap-file" data-module="customers" data-image-id="image_image_thumb" data-input-name="image" data-image-class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200">
                                    <div id="image_image_thumb" class="image-crop-target text-center">
                                        {if !empty(old('image'))}
                                            <a href="{image_url(old('image'))}" data-lightbox="customers"><img src="{image_url(old('image'))}" style="background-image: url('{image_url(old('image'))}');" class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200"></a>
                                            <input type="hidden" name="image" value="{old('image')}">
                                        {elseif !empty($edit_data.image)}
                                            <a href="{image_url($edit_data.image)}" data-lightbox="customers"><img src="{image_url($edit_data.image)}" style="background-image: url('{image_url($edit_data.image)}');" class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200"></a>
                                        {/if}
                                        {if isset($edit_data.image)}
                                            <input type="hidden" name="image_root" value="{$edit_data.image}">
                                        {/if}
                                    </div>
                                    <input type="file" name="file" id="file" size="20" />
                                    <button type="button" id="button-image-crop" class="btn btn-xs btn-primary w-100 mt-2" {if !empty(old('image'))}onclick="Catcool.cropImage('{old('image')}', 1);"{elseif !empty($edit_data.image)}onclick="Catcool.cropImage('{$edit_data.image}', 1);"{else}style="display: none;"{/if}>
                                        <i class="fas fa-crop me-1"></i>{lang('Admin.text_photo_crop')}
                                    </button>
                                    <div class="upload-area dropzone dz-clickable " id="uploadfile">
                                        <h5 class="dz-message py-3"><i class="fas {if !empty(($edit_data.image))}fa-edit{else}fa-plus{/if} me-1"></i><i class="fas fa-image"></i></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('CustomerAdmin.text_status')}</label>
                                <label class="form-check form-check-inline ms-2 mt-2">
                                    <input type="radio" name="status" value="{STATUS_ON}" {if old('status', $edit_data.status)|default:1 eq STATUS_ON}checked="checked"{/if} id="status_on" class="form-check-input">
                                    <label class="form-check-label" for="status_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline mt-2 me-2">
                                    <input type="radio" name="status" value="{STATUS_OFF}" {if old('status', $edit_data.status)|default:1 eq STATUS_OFF}checked="checked"{/if} id="status_off" class="form-check-input">
                                    <label class="form-check-label" for="status_off">OFF</label>
                                </label>
                            </div>
                            <h3 class="border-bottom pb-3"></h3>
                            <div class="form-group">
                                <label class="form-label">{lang('CustomerAdmin.text_newsletter')}</label>
                                <label class="form-check form-check-inline ms-2 mt-2">
                                    <input type="radio" name="newsletter" value="{STATUS_ON}" {if old('newsletter', $edit_data.newsletter)|default:1 eq STATUS_ON}checked="checked"{/if} id="newsletter_on" class="form-check-input">
                                    <label class="form-check-label" for="newsletter_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline mt-2 me-2">
                                    <input type="radio" name="newsletter" value="{STATUS_OFF}" {if old('newsletter', $edit_data.newsletter)|default:1 eq STATUS_OFF}checked="checked"{/if} id="newsletter_off" class="form-check-input">
                                    <label class="form-check-label" for="newsletter_off">OFF</label>
                                </label>
                            </div>
                            <h3 class="border-bottom pb-3"></h3>
                            <div class="form-group">
                                <label class="form-label">{lang('CustomerAdmin.text_safe')}</label>
                                <label class="form-check form-check-inline ms-2 mt-2">
                                    <input type="radio" name="safe" value="{STATUS_ON}" {if old('safe', $edit_data.safe)|default:1 eq STATUS_ON}checked="checked"{/if} id="safe_on" class="form-check-input">
                                    <label class="form-check-label" for="safe_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline mt-2 me-2">
                                    <input type="radio" name="safe" value="{STATUS_OFF}" {if old('safe', $edit_data.safe)|default:1 eq STATUS_OFF}checked="checked"{/if} id="safe_off" class="form-check-input">
                                    <label class="form-check-label" for="safe_off">OFF</label>
                                </label>
                                <br/>
                                <small>{lang('CustomerAdmin.help_safe')}</small>
                            </div>
                        </div>
                    </div>
                    {if !empty($edit_data.customer_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl') status = $edit_data.status}
                    {/if}
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('CustomerAdmin.header_address')}</h5>
                        <div class="card-body">
                            {if !empty($edit_data.address_list)}
                                {counter assign=address_row start=1 print=false}

                                {foreach $edit_data.address_list as $address_data}

                                    {include file=get_theme_path('views/modules/customers/inc/address_form.tpl') address=$address_data}

                                    {counter}
                                {/foreach}
                            {/if}
                            <div id="customer_address_content"></div>
                            <div class="text-end">
                                <button type="button" onclick="addAddressForm();" data-bs-toggle="tooltip" title="{lang('ProductAdmin.text_image_add')}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>

{* template address *}
<div id="html_customer_address_row" style="display: none">
    {include file=get_theme_path('views/modules/customers/inc/address_form.tpl')}
</div>
    <input type="hidden" name="customer_address_row" id="customer_address_row" value="{if !empty($edit_data.address_list)}{$edit_data.address_list|@count}{else}0{/if}">
{* end template address *}
{/strip}
<script type="text/javascript">
    $(function () {

    });

    var is_customer_processing = false;

    function addAddressForm()
    {
        var customer_address_row = $('#customer_address_row').val();
        customer_address_row = parseInt(customer_address_row) + 1;
        $('#customer_address_row').val(customer_address_row);

        var html = $('#html_customer_address_row').html().replaceAll('address_row_value', customer_address_row);
        $('#customer_address_content').append(html);
    }
</script>