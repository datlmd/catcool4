{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'user_validationform'])}
    <div class="row">
        <div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
        </div>
        <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
            <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
            <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
        </div>
    </div>
    {if !empty($edit_data.id)}
        {form_hidden('id', $edit_data.id)}
        {create_input_token($csrf)}
    {/if}
    <div class="row">
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
                            {lang('text_username')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            <input type="text" name="username" value='{set_value("username", $edit_data.username)}' {if $edit_data.id}readonly{/if} id="username" class="form-control {if !empty(form_error("username"))}is-invalid{/if}">
                            {if !empty(form_error("username"))}
                                <div class="invalid-feedback">{form_error("username")}</div>
                            {/if}
                        </div>
                    </div>
                    {if empty($edit_data)}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('text_password')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password" value="" id="password" class="form-control {if !empty(form_error("password"))}is-invalid{/if}">
                                {if !empty(form_error("password"))}
                                    <div class="invalid-feedback">{form_error("password")}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('text_confirm_password')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="password" name="password_confirm" value="" id="password_confirm" class="form-control {if !empty(form_error("password_confirm"))}is-invalid{/if}">
                                {if !empty(form_error("password_confirm"))}
                                    <div class="invalid-feedback">{form_error("password_confirm")}</div>
                                {/if}
                            </div>
                        </div>
                    {else}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end"></label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <a href="{$manage_url}/change_password/{$edit_data.customer_id}" class="text-dark"><i class="fas fa-key me-2"></i>{lang('text_change_password')}</a>
                            </div>
                        </div>
                    {/if}
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                            {lang('text_full_name')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            <input type="text" name="first_name" value='{set_value("first_name", $edit_data.first_name)}' id="first_name" class="form-control {if !empty(form_error("first_name"))}is-invalid{/if}">
                            {if !empty(form_error("first_name"))}
                                <div class="invalid-feedback">{form_error("first_name")}</div>
                            {/if}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                            {lang('text_email')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            <input type="text" name="email" value='{set_value("email", $edit_data.email)}' id="email" class="form-control {if !empty(form_error("email"))}is-invalid{/if}">
                            {if !empty(form_error("email"))}
                                <div class="invalid-feedback">{form_error("email")}</div>
                            {/if}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('text_gender')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            <label class="custom-control custom-radio mt-1 custom-control-inline">
                                {if $edit_data.gender}
                                    <input type="radio" name="gender" value="{GENDER_MALE}" {if set_value('gender', $edit_data.gender) eq GENDER_MALE}checked="checked"{/if} id="male" class="custom-control-input">
                                {else}
                                    <input type="radio" name="gender" value="{GENDER_MALE}" checked="checked" id="male" class="custom-control-input">
                                {/if}
                                <span class="custom-control-label">{lang('text_gender_male')}</span>
                            </label>
                            <label class="custom-control custom-radio mt-1 custom-control-inline">
                                <input type="radio" name="gender" value="{GENDER_FEMALE}" {if set_value('gender', $edit_data.gender) eq GENDER_FEMALE}checked="checked"{/if} id="female" class="custom-control-input">
                                <span class="custom-control-label">{lang('text_gender_female')}</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('text_dob')}
                        </label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <div class="input-group date show-date-picker" id="show-date-picker" data-target-input="nearest" data-date-format="DD/MM/YYYY">
                                <input type="text" name="dob" id="dob" class="form-control datetimepicker-input" {if $edit_data.dob}value="{$edit_data.dob|date_format:'d/m/Y'}"{/if} placeholder="dd/mm/yyyy" data-target="#show-datet-picker" />
                                <div class="input-group-append" data-target="#show-date-picker" data-bs-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('text_phone')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            <input type="tel" name="phone" value="{set_value('phone', $edit_data.phone)}" id="phone" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('text_address')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            <textarea type="textarea" name="address" id="address" cols="40" rows="2" class="form-control">{set_value('address', $edit_data.address)}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                            {lang('text_company')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-7">
                            <input type="text" name="company" value="{set_value('company', $edit_data.company)}" id="company" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header"><i class="fas fa-lock-open me-2"></i>{lang('text_permission_select')}</h5>
                <div class="card-body">
                    {if !empty($permissions)}
                        <label class="custom-control custom-checkbox border-bottom pb-2">
                            <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" {if !empty($user_permissions) && count($user_permissions) == count($permissions)}checked{/if} class="custom-control-input">
                            <span class="custom-control-label">{lang('text_select_all')}</span>
                        </label>
                        <div id="list_permission" class="">
                            {foreach $permissions as $permission}
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="permissions[]" id="permission_{$permission.id}" value="{$permission.id}" {if !empty($user_permissions) && in_array($permission.id, array_column($user_permissions, 'permission_id'))}checked{/if} class="custom-control-input">
                                    <span class="custom-control-label">{$permission.name}</span>
                                </label>
                            {/foreach}
                        </div>
                    {/if}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{lang('text_manage_more')}</h5>
                <div class="card-body">
                    <div class="form-group">
                        {lang('text_avatar')}
                        <!-- Drag and Drop container-->
                        <div class="drop-drap-file" data-module="users" data-image-id="image_avatar_thumb" data-input-name="avatar" data-image-class="rounded-circle w-100">
                            <div id="image_avatar_thumb" class="image-crop-target">
                                {if !empty($edit_data.image)}
                                    <a href="{image_url($edit_data.image)}" data-lightbox="users"><img src="{image_url($edit_data.image)}" class="rounded-circle w-100"></a>
                                    <input type="hidden" name="avatar_root" value="{$edit_data.image}">
                                {/if}
                            </div>
                            <input type="file" name="file" id="file" size="20" />
                            <button type="button" id="button-image-crop" class="btn btn-xs btn-primary w-100 mt-2" {if !empty($edit_data.image)}onclick="Catcool.cropImage('{$edit_data.image}', 0);"{else}style="display: none;"{/if}><i class="fas fa-crop me-1"></i>{lang('text_photo_crop')}</button>
                            <div class="upload-area dropzone dz-clickable " id="uploadfile">
                                <h5 class="dz-message py-3"><i class="fas fa-plus me-1"></i><i class="fas fa-image"></i></h5>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {lang('text_active')}
                        <div class="switch-button switch-button-xs float-end mt-1">
                            <input type="checkbox" name="active" value="{STATUS_ON}" {if $edit_data.id}{if $edit_data.active eq true}checked="checked"{/if}{else}checked="checked"{/if} id="active">
                            <span><label for="active"></label></span>
                        </div>
                    </div>
                    {if $is_super_admin}
                        <div class="form-group">
                            {lang('text_super_admin')}
                            <div class="switch-button switch-button-xs float-end mt-1">
                                <input type="checkbox" name="super_admin" value="{STATUS_ON}" {if $edit_data.id}{if $edit_data.super_admin eq true}checked="checked"{/if}{else}checked="checked"{/if} id="super_admin">
                                <span><label for="super_admin"></label></span>
                            </div>
                        </div>
                    {/if}
                    <div class="form-group">
                        {lang('text_group')}
                        {if !empty($groups)}
                            <select name="groups[]" id="groups[]" class="selectpicker form-control form-control-sm" data-style="btn-outline-light" data-size="8" title="{lang('text_select')}" multiple data-actions-box="false" data-live-search="true" data-selected-text-format="count > 2">
                                {foreach $groups as $key => $group}
                                    <option value="{$key}" {if !empty($user_groups) && in_array($key, array_column($user_groups, 'group_id'))}selected{/if}>{$group.name}</option>
                                {/foreach}
                            </select>
                            <div id="category_review" class="w-100 p-3 bg-light">
                                <ul class="list-unstyled bullet-check mb-0">
                                    {if $edit_data.id && !empty($user_groups)}
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
            {if $edit_data.id}
                {include file=get_theme_path('views/inc/status_form.inc.tpl') status = $edit_data.active}
            {/if}
        </div>
    </div>
    {form_close()}
</div>
