{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ['id' => 'customer_validationform', "method" => "post", "data-cc-toggle" => "ajax"])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.heading_title')}
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
                <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.customer_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">

                            <h3 class="border-bottom pb-3">{lang('Admin.text_customer_detail')}</h3>

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
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('UserAdmin.text_phone')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="tel" name="phone" value="{old('phone', $edit_data.phone)}" id="input_phone" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('UserAdmin.text_email')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="email" value='{old("email", $edit_data.email)}' id="input_email" class="form-control {if $validator->hasError('email')}is-invalid{/if}">
                                    <div id="error_email" class="invalid-feedback">{$validator->getError("email")}</div>
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
                                    <div class="input-group date show-date-picker" id="show_date_picker" data-target-input="nearest" data-date-format="DD/MM/YYYY" data-date-locale="{get_lang(true)}">
                                        <input type="text" name="dob" id="input_dob" class="form-control datetimepicker-input" {if old('dob', $edit_data.dob)}value="{old('dob', $edit_data.dob)|date_format:'d/m/Y'}"{/if} placeholder="dd/mm/yyyy" data-target="#show_date_picker" />
                                        <div class="input-group-text" data-target="#show_date_picker" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_address')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <textarea type="textarea" name="address" id="input_address" cols="40" rows="2" class="form-control">{old('address', $edit_data.address)}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('UserAdmin.text_company')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="company" value="{old('company', $edit_data.company)}" id="input_company" class="form-control">
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
                <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                        <div class="card-body">
                            <div class="form-group">
                                {lang('UserAdmin.text_avatar')}
                                <!-- Drag and Drop container-->
                                <div class="drop-drap-file" data-module="users" data-image-id="image_avatar_thumb" data-input-name="avatar" data-image-class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200">
                                    <div id="image_avatar_thumb" class="image-crop-target text-center">
                                        {if !empty(old('avatar'))}
                                            <a href="{image_url(old('avatar'))}" data-lightbox="users"><img src="{image_url(old('avatar'))}" style="background-image: url('{image_url(old('avatar'))}');" class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200"></a>
                                            <input type="hidden" name="avatar" value="{old('avatar')}">
                                        {elseif !empty($edit_data.image)}
                                            <a href="{image_url($edit_data.image)}" data-lightbox="users"><img src="{image_url($edit_data.image)}" style="background-image: url('{image_url($edit_data.image)}');" class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200"></a>
                                        {/if}
                                        {if isset($edit_data.image)}
                                            <input type="hidden" name="avatar_root" value="{$edit_data.image}">
                                        {/if}
                                    </div>
                                    <input type="file" name="file" id="file" size="20" />
                                    <button type="button" id="button-image-crop" class="btn btn-xs btn-primary w-100 mt-2" {if !empty(old('avatar'))}onclick="Catcool.cropImage('{old('avatar')}', 1);"{elseif !empty($edit_data.image)}onclick="Catcool.cropImage('{$edit_data.image}', 1);"{else}style="display: none;"{/if}>
                                        <i class="fas fa-crop me-1"></i>{lang('Admin.text_photo_crop')}
                                    </button>
                                    <div class="upload-area dropzone dz-clickable " id="uploadfile">
                                        <h5 class="dz-message py-3"><i class="fas fa-plus me-1"></i><i class="fas fa-image"></i></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{lang('Admin.text_active')}</label>
                                <label class="form-check form-check-inline ms-2 mt-2">
                                    <input type="radio" name="active" value="{STATUS_ON}" {if old('active', $edit_data.active)|default:1 eq STATUS_ON}checked="checked"{/if} id="active_on" class="form-check-input">
                                    <label class="form-check-label" for="active_on">ON</label>
                                </label>
                                <label class="form-check form-check-inline mt-2 me-2">
                                    <input type="radio" name="active" value="{STATUS_OFF}" {if old('active', $edit_data.active)|default:1 eq STATUS_OFF}checked="checked"{/if} id="active_off" class="form-check-input">
                                    <label class="form-check-label" for="active_off">OFF</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    {if !empty($edit_data.customer_id)}
                        {include file=get_theme_path('views/inc/status_form.inc.tpl') status = $edit_data.active}
                    {/if}
                </div>
            </div>
            <div class="row d-none">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas fa-lock-open me-2"></i>{lang('UserAdmin.text_permission_select')}</h5>
                        <div class="card-body">
                            {if !empty($permissions)}
                                <div class="form-check border-bottom pb-2">
                                    <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" {if !empty($user_permissions) && count($user_permissions) == count($permissions)}checked{/if} class="form-check-input">
                                    <label class="form-check-label" for="cb_permission_all">{lang('Admin.text_select_all')}</label>
                                </div>
                                <div id="list_permission" class="row">
                                    {foreach $permissions as $key => $item}
                                        <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                            <h4 class="text-capitalize text-dark">{$key}</h4>
                                            {foreach $item as $value}
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]" id="permission_{$value.customer_id}" value="{$value.customer_id}" {if !empty($user_permissions) && in_array($value.customer_id, array_column($user_permissions, 'permission_id'))}checked{/if} class="form-check-input">
                                                    <label class="form-check-label" for="permission_{$value.customer_id}">{$value.description} <b>[{$value.name}]</b></label>
                                                </div>
                                            {/foreach}
                                        </div>
                                    {/foreach}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>
{/strip}
