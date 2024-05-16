{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'user_validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.heading_title')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i
                        class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                <a href="{back_to($manage_url)}" class="btn btn-sm btn-secondary me-0 mb-0"
                    title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
            </div>
        </div>
        {if !empty($edit_data.user_id)}
            <input type="hidden" name="user_id" value="{$edit_data.user_id}">
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
            <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i
                            class="fas {if !empty($edit_data.user_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row required has-error">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('Admin.text_username')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="text" name="username" value='{old("username", $edit_data.username)}'
                                    id="username" class="form-control {if validation_show_error('username')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("username")}</div>
                            </div>
                        </div>
                        {if empty($edit_data.user_id)}
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_password')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="password" name="password" value="" id="password"
                                        class="form-control {if validation_show_error('password')}is-invalid{/if}">
                                    <div class="invalid-feedback">{validation_show_error("password")}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('Admin.text_confirm_password')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="password" name="password_confirm" value="" id="password_confirm"
                                        class="form-control {if validation_show_error('password_confirm')}is-invalid{/if}">
                                    <div class="invalid-feedback">{validation_show_error("password_confirm")}</div>
                                </div>
                            </div>
                        {/if}
                        <div class="form-group row border-top mt-2 pt-3">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('Admin.text_first_name')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="text" name="first_name" value='{old("first_name", $edit_data.first_name)}'
                                    id="first_name"
                                    class="form-control {if validation_show_error('first_name')}is-invalid{/if}">
                                <small>{lang('Admin.help_first_name')}</small>
                                <div class="invalid-feedback">{validation_show_error("first_name")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_last_name')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="text" name="last_name" value='{old("last_name", $edit_data.last_name)}'
                                    id="last_name"
                                    class="form-control {if validation_show_error('last_name')}is-invalid{/if}">
                                <small>{lang('Admin.help_last_name')}</small>
                                <div class="invalid-feedback">{validation_show_error("last_name")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                {lang('UserAdmin.text_email')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="text" name="email" value='{old("email", $edit_data.email)}' id="email"
                                    class="form-control {if validation_show_error('email')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("email")}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_gender')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <label class="form-check form-check-inline mt-2">
                                    <input type="radio" name="gender" value="{GENDER_MALE}"
                                        {if old('gender', $edit_data.gender)|default:1 eq GENDER_MALE}checked="checked"
                                        {/if} id="gender_male" class="form-check-input">
                                    <label class="form-check-label"
                                        for="gender_male">{lang('Admin.text_gender_male')}</label>
                                </label>
                                <label class="form-check form-check-inline mt-2 me-2">
                                    <input type="radio" name="gender" value="{GENDER_FEMALE}"
                                        {if old('gender', $edit_data.gender)|default:1 eq GENDER_FEMALE}checked="checked"
                                        {/if} id="gender_female" class="form-check-input">
                                    <label class="form-check-label"
                                        for="gender_female">{lang('Admin.text_gender_female')}</label>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_dob')}
                            </label>
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <div class="input-group date show-date-picker" id="show-date-picker"
                                    data-target-input="nearest" data-date-format="{get_date_format_ajax()|upper}"
                                    data-date-locale="{language_code_admin()}">
                                    <input type="text" name="dob" id="dob" class="form-control datetimepicker-input"
                                        {if old('dob', $edit_data.dob)}value="{old('dob', $edit_data.dob)|date_format:get_date_format(true)}"
                                        {/if} placeholder="{get_date_format_ajax()}" data-target="#show-date-picker" />
                                    <div class="input-group-text" data-target="#show-date-picker"
                                        data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('UserAdmin.text_phone')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="tel" name="phone" value="{old('phone', $edit_data.phone)}" id="phone"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_address')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <textarea type="textarea" name="address" id="address" cols="40" rows="2"
                                    class="form-control">{old('address', $edit_data.address)}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('UserAdmin.text_company')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                <input type="text" name="company" value="{old('company', $edit_data.company)}" id="company"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                {lang('Admin.text_group')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-7">
                                {if !empty($groups)}
                                    <select name="groups[]" id="groups[]"
                                        class="form-control form-control-sm cc-form-select-multi" multiple="multiple"
                                        data-placeholder="{lang('Admin.text_select')}">
                                        <option value="">{lang('Admin.text_select')}</option>
                                        {foreach $groups as $key => $group}
                                            <option value="{$key}"
                                                {if !empty($user_groups) && in_array($key, array_column($user_groups, 'group_id'))}selected{/if}>
                                                {$group.name}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('Admin.text_manage_more')}</h5>
                    <div class="card-body">

                        {if !empty($edit_data.user_id)}

                            <div class="mb-3">
                                <a href="{site_url($manage_url)}/change_password/{$edit_data.user_id}"
                                    class="fw-bold text-primary">{lang('UserAdmin.text_change_password')}</a>
                            </div>
                            <div class="mb-3">
                                <a class="fw-bold text-primary"
                                href='{site_url("`$manage_url`/permission/`$edit_data.user_id`")}'>{lang('UserAdmin.text_permission_select')}</a>
                            </div>
                        {/if}

                        <div class="form-group">
                            <label class="fw-bold">{lang('UserAdmin.text_avatar')}</label>
                            <!-- Drag and Drop container-->
                            <div class="drop-drap-file" data-module="users" data-lightbox="users" data-input-name="avatar"
                                data-image-class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200">
                                <div class="text-center drop-drap-image-content"
                                    {if !isset($edit_data.image)}style="display: none" {/if}>
                                    <div class="drop-drap-image">
                                        {if !empty(old('avatar'))}
                                            <a href="{image_url(old('avatar'))}" data-lightbox="users"><img
                                                    src="{image_url(old('avatar'))}"
                                                    style="background-image: url('{image_url(old('avatar'))}');"
                                                    class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200"></a>
                                            <input type="hidden" name="avatar" value="{old('avatar')}">
                                        {elseif !empty($edit_data.image)}
                                            <a href="{image_url($edit_data.image)}" data-lightbox="users"><img
                                                    src="{image_url($edit_data.image)}"
                                                    style="background-image: url('{image_url($edit_data.image)}');"
                                                    class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200"></a>
                                        {/if}
                                        {if isset($edit_data.image)}
                                            <input type="hidden" name="avatar_root" value="{$edit_data.image}">
                                        {/if}
                                    </div>

                                    <div class="btn-group w-50 mt-2" role="group">
                                        <button type="button" class="btn btn-xs btn-light button-image-crop"
                                            title="{lang('Admin.text_photo_crop')}"
                                            {if !empty(old('avatar'))}onclick="Catcool.cropImage('{old('avatar')}', 1, this);"
                                            {elseif !empty($edit_data.image)}onclick="Catcool.cropImage('{$edit_data.image}', 1, this);"
                                            {else}style="display: none;" 
                                            {/if}>
                                            <i class="fas fa-crop"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-light button-image-delete"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </div>

                                <input type="file" name="file_input" class="file-input" style="display: none;" />
                                <div class="upload-area dropzone dz-clickable"
                                    {if isset($edit_data.image)}style="display: none" {/if}>
                                    <h5 class="dz-message py-5">
                                        <i class="fas fa-plus text-success me-1"></i>
                                        <i class="fas fa-image text-success"></i>
                                        <br /><small>{lang("Admin.text_upload_drop_drap")}</small>
                                    </h5>
                                </div>
                                <div class="text-danger image-error mt-2"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 fw-bold" for="input_active">{lang('Admin.text_active')}</label>
                            <div class="col-sm-8 form-control-lg py-0">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="active" id="input_active"
                                        {set_checkbox('active', 1, $edit_data.active|default:true)} value="1">
                                </div>
                            </div>
                        </div>
                        {if !empty($is_super_admin)}
                            <div class="row">
                                <label class="col-sm-4 fw-bold" for="input_super_admin">{lang('Admin.text_super_admin')}</label>
                                <div class="col-sm-8 form-control-lg py-0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="super_admin"
                                            id="input_super_admin"
                                            {set_checkbox('super_admin', 1, $edit_data.super_admin|default:false)} value="1">
                                    </div>
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>
                {if !empty($edit_data.user_id)}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl') status = $edit_data.active}
                {/if}
            </div>
        </div>

        <div class="row d-none">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-lock-open me-2"></i>{lang('UserAdmin.text_permission_select')}
                    </h5>
                    <div class="card-body">
                        {if !empty($permissions)}
                            <div class="form-check border-bottom pb-2">
                                <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all"
                                    {if !empty($user_permissions) && count($user_permissions) == count($permissions)}checked{/if}
                                    class="form-check-input">
                                <label class="form-check-label" for="cb_permission_all">{lang('Admin.text_select_all')}</label>
                            </div>
                            <div id="list_permission" class="row">
                                {foreach $permissions as $key => $item}
                                    <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                        <h4 class="text-capitalize text-dark">{$key}</h4>
                                        {foreach $item as $value}
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" id="permission_{$value.id}"
                                                    value="{$value.id}"
                                                    {if !empty($user_permissions) && in_array($value.id, array_column($user_permissions, 'permission_id'))}checked{/if}
                                                    class="form-check-input">
                                                <label class="form-check-label" for="permission_{$value.id}">{$value.description}
                                                    <b>[{$value.name}]</b></label>
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

        {if !empty($edit_data.user_id)}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('UserAdmin.text_user_token')}
                        </h5>
                        <div class="card-body">
                            <div id="token_alert"></div>
                            <div id="user_token_list"></div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">{lang('UserAdmin.text_user_login_history')}
                        </h5>
                        <div class="card-body">

                            <div id="user_ip_list"></div>

                        </div>
                    </div>
                </div>
            </div>
        {/if}


    </div>
{/strip}
{if !empty($edit_data.user_id)}
    <script type="text/javascript">
        $('#user_token_list').load('{{site_url('users/manage/token_list/'|cat:{$edit_data.user_id})}}');
        $('#user_ip_list').load('{{site_url('users/manage/user_ip_list/'|cat:{$edit_data.user_id})}}');

        $('#user_ip_list').on('click', 'thead a, .pagination a', function (e) {
            e.preventDefault();

            $('#user_ip_list').load(this.href);
        });

        $('#user_token_list').on('click', 'thead a, .pagination a', function (e) {
            e.preventDefault();

            $('#user_token_list').load(this.href);
        });

        $('#user_token_list').on('click', '.btn', function (e) {
            e.preventDefault();

            var element = this;

            $('#token_alert').html("");

            $.confirm({
                title: '{{lang("Admin.text_confirm_title")}}',
                content: '{{lang("Admin.text_confirm_delete")}}',
                icon: 'fa fa-question',
                //theme: 'bootstrap',
                closeIcon: true,
                //animation: 'scale',
                typeAnimated: true,
                type: 'red',
                buttons: {
                    formSubmit: {
                        text: '{{lang("Admin.button_delete")}}',
                        btnClass: 'btn-danger',
                        keys: ['y', 'enter', 'shift'],
                        action: function() {
                            $.ajax({
                                url: 'users/manage/delete_token',
                                type: 'POST',
                                data: {
                                    user_id: {{$edit_data.user_id}},
                                    remember_selector: $(element).data("remember-selector"),
                                    [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                                },
                                dataType: 'json',
                                beforeSend: function () {
                                    $(element).find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                                },
                                complete: function () {
                                    $(element).find('i').replaceWith('<i class="fas fa-trash-alt"></i>');
                                },
                                success: function (json) {

                                    if (json['token']) {
                                        // Update CSRF hash
                                        $("input[name*='" + csrf_token + "']").val(json['token']);
                                    }

                                    if (json['redirect']) {
                                        location = json['redirect'].replaceAll('&amp;', '&');
                                    }

                                    if (json['error']) {
                                        $.notify(json['error'], {
                                            'type':'danger'
                                        });
                                    }

                                    if (json['alert']) {
                                        $('#token_alert').prepend(json['alert']);
                                    }

                                    if (json['success']) {
                                        $.notify(json['success']);
                                        $('#user_token_list').load('{{site_url('users/manage/token_list/'|cat:{$edit_data.user_id})}}');
                                    }
                                },
                                error: function (xhr, errorType, error) {
                                    $.notify({
                                            message: xhr.responseJSON.message + " Please reload the page!!!",
                                            url: window.location.href,
                                            target: "_self",
                                        },
                                        {
                                            'type': 'danger'
                                        },
                                    );
                                }
                            });
                        }
                    },
                    cancel: {
                        text: '{{lang("Admin.button_close")}}',
                        keys: ['n']
                    },
                }
            });
        });
    </script>
{/if}