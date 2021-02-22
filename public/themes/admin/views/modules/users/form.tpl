{strip}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'user_validationform'])}
    <div class="row">
        <div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.heading_title')}
        </div>
        <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
            <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
            <a href="{base_url($manage_url)}{http_get_query()}" class="btn btn-sm btn-space btn-secondary mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
        </div>
    </div>
    {if !empty($edit_data.id)}
        {form_hidden('id', $edit_data.id)}
        {csrf_field('cc_token')}
    {/if}
    <div class="row">
        {if !empty(print_flash_alert())}
            <div class="col-12">{print_flash_alert()}</div>
        {/if}
        {if !empty($errors)}
            <div class="col-12">
                {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
            </div>
        {/if}
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                <div class="card-body">
                    <div class="form-group row required has-error">
                        <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                            {lang('Admin.text_username')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            {if isset($edit_data.username)}
                                {assign var="username" value="`$edit_data.username`"}
                            {else}
                                {assign var="username" value=""}
                            {/if}
                            <input type="text" name="username" value='{old("username", $username)}' {if !empty($edit_data.id)}readonly{/if} id="username" class="form-control {if $validator->hasError('username')}is-invalid{/if}">
                            <div class="invalid-feedback">{$validator->getError("username")}</div>
                        </div>
                    </div>
                    {if empty($edit_data.id)}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('Admin.text_password')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password" value="" id="password" class="form-control {if $validator->hasError('password')}is-invalid{/if}">
                                <div class="invalid-feedback">{$validator->getError("password")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('Admin.text_confirm_password')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_confirm" value="" id="password_confirm" class="form-control {if $validator->hasError('password_confirm')}is-invalid{/if}">
                                <div class="invalid-feedback">{$validator->getError("password_confirm")}</div>
                            </div>
                        </div>
                    {else}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end"></label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <a href="{site_url($manage_url)}/change_password/{$edit_data.id}" class="text-dark"><i class="fas fa-key me-2"></i>{lang('UserAdmin.text_change_password')}</a>
                            </div>
                        </div>
                    {/if}
                    <div class="form-group row border-top mt-2 pt-3">
                        <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                            {lang('Admin.text_full_name')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            {if isset($edit_data.first_name)}
                                {assign var="first_name" value="`$edit_data.first_name`"}
                            {else}
                                {assign var="first_name" value=""}
                            {/if}
                            <input type="text" name="first_name" value='{old("first_name", $first_name)}' id="first_name" class="form-control {if $validator->hasError('first_name')}is-invalid{/if}">
                            <div class="invalid-feedback">{$validator->getError("first_name")}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                            {lang('UserAdmin.text_email')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            {if isset($edit_data.email)}
                                {assign var="email" value="`$edit_data.email`"}
                            {else}
                                {assign var="email" value=""}
                            {/if}
                            <input type="text" name="email" value='{old("email", $email)}' id="email" class="form-control {if $validator->hasError('email')}is-invalid{/if}">
                            <div class="invalid-feedback">{$validator->getError("email")}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('Admin.text_gender')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            {if isset($edit_data.gender)}
                                {assign var="gender" value="`$edit_data.gender`"}
                            {else}
                                {assign var="gender" value="1"}
                            {/if}
                            <label class="form-check form-check-inline mt-2">
                                <input type="radio" name="gender" value="{GENDER_MALE}" {if old('gender', $gender) eq GENDER_MALE}checked="checked"{/if} id="gender_male" class="form-check-input">
                                <label class="form-check-label" for="gender_male">{lang('Admin.text_gender_male')}</label>
                            </label>
                            <label class="form-check form-check-inline mt-2 me-2">
                                <input type="radio" name="gender" value="{GENDER_FEMALE}" {if old('gender', $gender) eq GENDER_FEMALE}checked="checked"{/if} id="gender_female" class="form-check-input">
                                <label class="form-check-label" for="gender_female">{lang('Admin.text_gender_female')}</label>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('Admin.text_dob')}
                        </label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            {if isset($edit_data.dob)}
                                {assign var="dob" value="`$edit_data.dob`"}
                            {else}
                                {assign var="dob" value=""}
                            {/if}
                            <div class="input-group date show-date-picker" id="show-date-picker" data-target-input="nearest" data-date-format="DD/MM/YYYY" data-date-locale="{get_lang()}">
                                <input type="text" name="dob" id="dob" class="form-control datetimepicker-input" {if old('dob', $dob)}value="{old('dob', $dob)|date_format:'d/m/Y'}"{/if} placeholder="dd/mm/yyyy" data-target="#show-date-picker" />
                                <div class="input-group-text" data-target="#show-date-picker" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('UserAdmin.text_phone')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            {if isset($edit_data.phone)}
                                {assign var="phone" value="`$edit_data.phone`"}
                            {else}
                                {assign var="phone" value=""}
                            {/if}
                            <input type="tel" name="phone" value="{old('phone', $phone)}" id="phone" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('Admin.text_address')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            {if isset($edit_data.address)}
                                {assign var="address" value="`$edit_data.address`"}
                            {else}
                                {assign var="address" value=""}
                            {/if}
                            <textarea type="textarea" name="address" id="address" cols="40" rows="2" class="form-control">{old('address', $address)}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('UserAdmin.text_company')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            {if isset($edit_data.company)}
                                {assign var="company" value="`$edit_data.company`"}
                            {else}
                                {assign var="company" value=""}
                            {/if}
                            <input type="text" name="company" value="{old('company', $company)}" id="company" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header"><i class="fas fa-lock-open me-2"></i>{lang('UserAdmin.text_permission_select')}</h5>
                <div class="card-body">
                    {if !empty($permissions)}
                        <div class="form-check border-bottom pb-2 mb-3">
                            <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" {if !empty($user_permissions) && count($user_permissions) == count($permissions)}checked{/if} class="form-check-input">
                            <label class="form-check-label" for="cb_permission_all">{lang('Admin.text_select_all')}</label>
                        </div>
                        <div id="list_permission" class="row">
                            {foreach $permissions as $permission}
                                <div class="col-sm-6 col-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" id="permission_{$permission.id}" value="{$permission.id}" {if !empty($user_permissions) && in_array($permission.id, array_column($user_permissions, 'permission_id'))}checked{/if} class="form-check-input">
                                        <label class="form-check-label" for="permission_{$permission.id}">{$permission.description} <b>[{$permission.name}]</b></label>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    {/if}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                <div class="card-body">
                    <div class="form-group">
                        {lang('UserAdmin.text_avatar')}
                        {if isset($edit_data.image)}
                            {assign var="image" value="`$edit_data.image`"}
                        {else}
                            {assign var="image" value=""}
                        {/if}
                        <!-- Drag and Drop container-->
                        <div class="drop-drap-file" data-module="users" data-image-id="image_avatar_thumb" data-input-name="avatar" data-image-class="rounded-circle img-w-200 img-h-200">
                            <div id="image_avatar_thumb" class="image-crop-target text-center">
                                {if !empty(old('avatar', $image))}
                                    <a href="{image_url(old('avatar', $image))}" data-lightbox="users"><img src="{image_url(old('avatar', $image))}" class="rounded-circle img-w-200 img-h-200"></a>
                                    <input type="hidden" name="avatar_root" value="{old('avatar', $image)}">
                                {/if}
                            </div>
                            <input type="file" name="file" id="file" size="20" />
                            <button type="button" id="button-image-crop" class="btn btn-xs btn-primary w-100 mt-2" {if !empty(old('avatar', $image))}onclick="Catcool.cropImage('{old('avatar', $image)}', 1);"{else}style="display: none;"{/if}><i class="fas fa-crop me-1"></i>{lang('Admin.text_photo_crop')}</button>
                            <div class="upload-area dropzone dz-clickable " id="uploadfile">
                                <h5 class="dz-message py-3"><i class="fas fa-plus me-1"></i><i class="fas fa-image"></i></h5>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{lang('Admin.text_active')}</label>
                        {if isset($edit_data.active)}
                            {assign var="active" value="`$edit_data.active`"}
                        {else}
                            {assign var="active" value="1"}
                        {/if}
                        <label class="form-check form-check-inline ms-2 mt-2">
                            <input type="radio" name="active" value="{STATUS_ON}" {if old('active', $active) eq STATUS_ON}checked="checked"{/if} id="active_on" class="form-check-input">
                            <label class="form-check-label" for="active_on">ON</label>
                        </label>
                        <label class="form-check form-check-inline mt-2 me-2">
                            <input type="radio" name="active" value="{STATUS_OFF}" {if old('active', $active) eq STATUS_OFF}checked="checked"{/if} id="active_off" class="form-check-input">
                            <label class="form-check-label" for="active_off">OFF</label>
                        </label>
                    </div>
                    {if $is_super_admin}
                        <div class="form-group">
                            <label class="form-label">{lang('UserAdmin.text_super_admin')}</label>
                            {if isset($edit_data.super_admin)}
                                {assign var="super_admin" value="`$edit_data.super_admin`"}
                            {else}
                                {assign var="super_admin" value="1"}
                            {/if}
                            <label class="form-check form-check-inline ms-2 mt-2">
                                <input type="radio" name="super_admin" value="{STATUS_ON}" {if old('super_admin', $super_admin) eq STATUS_ON}checked="checked"{/if} id="super_admin_on" class="form-check-input">
                                <label class="form-check-label" for="super_admin_on">ON</label>
                            </label>
                            <label class="form-check form-check-inline mt-2 me-2">
                                <input type="radio" name="super_admin" value="{STATUS_OFF}" {if old('super_admin', $super_admin) eq STATUS_OFF}checked="checked"{/if} id="super_admin_off" class="form-check-input">
                                <label class="form-check-label" for="super_admin_off">OFF</label>
                            </label>
                        </div>
                    {/if}
                    <div class="form-group">
                        <label class="form-label">{lang('Admin.text_group')}</label><br/>
                        {if !empty($groups)}
                            <select name="groups[]" id="groups[]" class="form-control form-control-sm multiselect" multiple="multiple" title="{lang('text_select')}">
                                {foreach $groups as $key => $group}
                                    <option value="{$key}" {if !empty($user_groups) && in_array($key, array_column($user_groups, 'group_id'))}selected{/if}>{$group.name}</option>
                                {/foreach}
                            </select>
                            <div id="category_review" class="w-100 p-3 bg-light">
                                <ul class="list-unstyled bullet-check mb-0">
                                    {if !empty($edit_data.id) && !empty($user_groups)}
                                        {foreach $user_groups as $group}
                                            <li>{$groups[$group.group_id].name}</li>
                                        {/foreach}
                                    {/if}
                                </ul>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
            {if !empty($edit_data.id)}
                {include file=get_theme_path('views/inc/status_form.inc.tpl') status = $edit_data.active}
            {/if}
        </div>
    </div>
    {form_close()}
</div>
{/strip}
