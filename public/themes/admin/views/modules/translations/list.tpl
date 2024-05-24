{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    {csrf_field()}
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('TranslationAdmin.heading_title')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                {if !empty($module.id)}
                    <button type="button" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('TranslationAdmin.text_add')}" onclick="openPopup();"><i class="fas fa-plus"></i></button>
                    <button type="button" id="btn_save_translate" onclick="saveTranslate()" class="btn btn-sm btn-secondary btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <button type="button" id="btn_write_translate" onclick="writeTranslate({$module.id})" class="btn btn-sm btn-light btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_write')}"><i class="fas fa-sync me-1"></i>{lang('Admin.button_write')}</button>
                {/if}
                <button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space me-0" data-bs-toggle="tooltip" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
                {if strpos(previous_url(), 'translations') === false}
                    <a href="{previous_url()}" class="btn btn-sm btn-space btn-secondary ms-1 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_back')}</a>
                {/if}
            </div>
        </div>
        <div class="row collapse {if !empty($filter_active)}show{/if}" id="filter_manage">
            <div class="row-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
                    {form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                <label class="form-label">{lang('TranslationAdmin.text_key')}</label>
                                {form_input('key', old('key', $request->getGet('key'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter key'])}
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                <label class="form-label">{lang('TranslationAdmin.text_value')}</label>
                                {form_input('value', old('value', $request->getGet('value'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter text'])}
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                <label class="form-label">{lang('TranslationAdmin.text_modules')}</label>
                                {if !empty($module_list)}
                                    <select name="module_id" class="form-select form-select-sm cc-form-select-single" data-placeholder="{lang('Admin.text_select')}">
                                        <option value="">{lang('Admin.text_none')}</option>
                                        {foreach $module_list as $value}
                                            <option value="{$value.id}" {if old('module_id', $request->getGet('module_id')) eq $value.id}selected="selected"{/if}>{$value.module}{if !empty($value.sub_module)} - Sub: {$value.sub_module}{/if}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('Admin.filter_submit')}</button>
                            </div>
                        </div>
                    </div>
                    {form_close()}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('TranslationAdmin.text_list')}</h5>
                    <div class="card-body">
                        {if !empty($module)}
                            <h5 class="mb-2">
                                {lang("TranslationAdmin.text_module")}: <strong class="text-primary">{$module.module|capitalize}</strong>
                                {if !empty($module.sub_module)} <br/>{lang("TranslationAdmin.text_sub_module")}: <strong class="text-secondary">{$module.sub_module|capitalize}</strong>{/if}
                            </h5>
                        {/if}
                        <input type="hidden" name="module_id" value="{$module.id}">
                        <ul class="text-danger mb-3">
                            {foreach $file_list as $file => $permissions}
                                <li>{$file}: <strong>{$permissions}</strong></li>
                            {/foreach}
                        </ul>
                        {if !empty($list)}

                            <div class="mb-2">{lang("TranslationAdmin.text_total")}: {count($list)}</div>

                            {form_open('manage/translations/save', ['id' => 'save_validationform'])}
                                {form_hidden('module_id', $module.id)}
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered second">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="60">
                                                    <a href="{site_url($manage_url)}?sort=id&order={$order}{$url}" class="text-dark">
                                                        No
                                                        {if $sort eq 'id'}
                                                            <i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
                                                        {/if}
                                                    </a>
                                                </th>
                                                <th class="text-start">
                                                    <a href="{site_url($manage_url)}?sort=lang_key&order={$order}{$url}" class="text-dark">
                                                        {lang('TranslationAdmin.text_key')}
                                                        {if $sort eq 'lang_key'}
                                                            <i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
                                                        {/if}
                                                    </a>
                                                </th>
                                                {foreach $language_list as $lang}
                                                    <th class="text-start">{$lang.name|capitalize}</th>
                                                {/foreach}
                                                <th width="80"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {assign var=key_no value=1}
                                        {foreach $list as $key => $item}
                                            <tr id="{$key}">
                                                <td align="center">{$key_no}{$key_no=$key_no+1}</td>
                                                <td>
                                                    {$key}<br/>
                                                    {if empty($module) && !empty($module_list[$item.module_id])}
                                                        <p class="badge badge-info">{$module_list[$item.module_id].module}/{$module_list[$item.module_id].sub_module}</p>
                                                    {/if}
                                                </td>
                                                {foreach $language_list as $lang}
                                                    <td>
                                                        {if isset($item.list[$lang.id])}
                                                            <textarea id="{$key}_{$lang.id}" name="translate[{$key}][{$lang.id}]" data-edit-modal="edit_value_{$lang.id}" class="form-control" rows="2" style="min-width: 140px;">{$item.list[$lang.id].lang_value}</textarea>
                                                        {else}
                                                            <textarea id="{$key}_{$lang.id}" name="translate[{$key}][{$lang.id}]" data-edit-modal="edit_value_{$lang.id}" class="form-control" rows="2" style="min-width: 140px;"></textarea>
                                                        {/if}
                                                    </td>
                                                {/foreach}
                                                <td class="text-center">
                                                    <div class="btn-group ms-auto">
                                                        <button type="button" class="btn btn-sm btn-light" data-key="{$key}" data-module="{$item.module_id}" onclick="editTranslate(this)" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-light text-danger" data-module="{$item.module_id}" data-key="{$key}" onclick="deleteTranslate(this)" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            {form_close()}
                        {else}
                            {lang('Admin.text_no_results')}
                        {/if}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal add -->
    <div class="modal fade" id="add_lang" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">{lang('TranslationAdmin.text_add')}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="add_validation_error" class="text-danger"></div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        {form_open('manage/translations/add', ['id' => 'add_lang_form'])}
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('TranslationAdmin.text_modules')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if !empty($module_list)}
                                        {if empty($module.id)}
                                            <select name="module_id" class="form-control form-control-sm">
                                                {foreach $module_list as $value}
                                                    <option value="{$value.id}" {if old('module_id', $module.id) eq $value.id}selected="selected"{/if}>{$value.module}{if !empty($value.sub_module)} - Sub: {$value.sub_module}{/if}</option>
                                                {/foreach}
                                            </select>
                                        {elseif !empty($module_list[$module.id])}
                                            {form_hidden('module_id', $module.id)}
                                            <label class="col-12 col-sm-3 col-form-label">
                                                {$module_list[$module.id].module}/{$module_list[$module.id].sub_module}
                                            </label>
                                        {/if}
                                    {/if}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('TranslationAdmin.text_key')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="add_key" value="" class="form-control">
                                </div>
                            </div>
                            {foreach $language_list as $lang}
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                        {$lang.name|capitalize}
                                    </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <textarea id="add_value_{$lang.id}" name="add_value[{$lang.id}]" class="form-control"></textarea>
                                    </div>
                                </div>
                            {/foreach}
                            <div class="form-group row text-center">
                                <div class="col-12 col-sm-3"></div>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <button type="button" onclick="addTranslate()" class="btn btn-sm btn-space btn-primary btn-add-translate"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                                    <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                                </div>
                            </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_language" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">{lang('TranslationAdmin.text_edit')}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="edit_validation_error" class="text-danger"></div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        {form_open('manage/translations/edit', ['id' => 'edit_lang_form'])}
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('TranslationAdmin.text_modules')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {if !empty($module_list)}
                                        <select name="module_id" class="form-control form-control-sm cc-form-select-single">
                                            {foreach $module_list as $value}
                                                <option value="{$value.id}">{$value.module}{if !empty($value.sub_module)} - Sub: {$value.sub_module}{/if}</option>
                                            {/foreach}
                                        </select>
                                    {/if}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('TranslationAdmin.text_key')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" id="edit_key" name="edit_key" value="" class="form-control">
                                    <input type="hidden" id="edit_key_old" name="edit_key_old" value="">
                                </div>
                            </div>
                            {foreach $language_list as $lang}
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                        {$lang.name|capitalize}
                                    </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <textarea id="edit_value_{$lang.id}" name="edit_value[{$lang.id}]" class="form-control"></textarea>
                                    </div>
                                </div>
                            {/foreach}
                            <div class="form-group row text-center">
                                <div class="col-12 col-sm-3"></div>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="hidden" name="module_id_old" id="module_id_old" value="">
                                    <button type="button" onclick="submitEditTranslate()" class="btn btn-sm btn-space btn-primary btn-edit-translate"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                                    <button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
                                </div>
                            </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/strip}
<script>

    function openPopup() {
        $('#add_lang').modal('show');
    }
    function addTranslate() {
        $('#add_validation_error').html('');

        $.ajax({
            url: $("#add_lang_form").attr('action'),
            type: 'POST',
            data: $("#add_lang_form").serialize(),
            beforeSend: function () {
                $('.btn-add-translate').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
            },
            complete: function () {
                $('.btn-add-translate').find('i').replaceWith('<i class="fas fa-save me-1"></i>');
            },
            success: function (data) {
                var response = JSON.stringify(data);
                response     = JSON.parse(response);

                if (response.token) {
                    // Update CSRF hash
                    $("input[name*='" + csrf_token + "']").val(response.token);
                }

                if (response.status == 'ng') {
                    $('#add_validation_error').html(response.msg);
                    return false;
                }

                location.reload();
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

    function editTranslate(obj) {
        $('#edit_validation_error').html('');

        var key = $(obj).data('key');
        var module_id = $(obj).data('module');

        $('#edit_language #edit_key').val(key);
        $('#edit_language #edit_key_old').val(key);
        $('#edit_language textarea').val();

        $('#edit_language #module_id_old').val(module_id);
        $("#edit_language select").val(module_id).change();

        $('#' + key + ' textarea').each(function() {
            $('#edit_language #' + $(this).attr('data-edit-modal')).val($(this).val());
        });

        $('#edit_language').modal('show');
    }

    function submitEditTranslate() {
        $('#edit_validation_error').html('');

        $.ajax({
            url: $("#edit_lang_form").attr('action'),
            type: 'POST',
            data: $("#edit_lang_form").serialize(),
            beforeSend: function () {
                $('.btn-edit-translate').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
            },
            complete: function () {
                $('.btn-edit-translate').find('i').replaceWith('<i class="fas fa-save me-1"></i>');
            },
            success: function (data) {
                var response = JSON.stringify(data);
                response     = JSON.parse(response);

                if (response.token) {
                    // Update CSRF hash
                    $("input[name*='" + csrf_token + "']").val(response.token);
                }

                if (response.status == 'ng') {
                    $('#edit_validation_error').html(response.msg);
                    return false;
                }

                location.reload();
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

    function saveTranslate() {
        $.ajax({
            url: $("#save_validationform").attr('action'),
            type: 'POST',
            data: $("#save_validationform").serialize(),
            beforeSend: function () {
                $('#btn_save_translate').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
            },
            complete: function () {
                $('#btn_save_translate').find('i').replaceWith('<i class="fas fa-save me-1"></i>');
            },
            success: function (data) {
                var response = JSON.stringify(data);
                response     = JSON.parse(response);

                if (response.token) {
                    // Update CSRF hash
                    $("input[name*='" + csrf_token + "']").val(response.token);
                }

                if (response.status == 'ng') {
                    $.notify(response.msg, {
                        'type':'danger'
                    });
                    return false;
                }

                location.reload();
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
    function deleteTranslate(obj) {
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
                    action: function(){
                        var key = $(obj).data("key");
                        $.ajax({
                            url: 'manage/translations/delete',
                            type: 'POST',
                            data: {
								module_id: $(obj).data("module"),
								key: key,
                                [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                            },
                            beforeSend: function () {
                                $(obj).find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                            },
                            complete: function () {
                                $(obj).find('i').replaceWith('<i class="fas fa-trash-alt"></i>');
                            },
                            success: function (data) {
                                var response = JSON.stringify(data);
                                response     = JSON.parse(response);

                                if (response.token) {
                                    // Update CSRF hash
                                    $("input[name*='" + csrf_token + "']").val(response.token);
                                }

                                if (response.status == 'ng') {
                                    $.notify(response.msg, {
										'type':'danger'
                                    });
                                    return false;
                                }

								$('#' + key).fadeOut(300, function(){ $(this).remove();});
                                $.notify(response.msg)
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
    }
    function writeTranslate(module_id) {
        $.confirm({
            title: '{{lang("Admin.text_confirm_title")}}',
            content: '{{lang("Admin.text_confirm_write")}}',
            icon: 'fa fa-question',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'blue',
            buttons: {
                formSubmit: {
                    text: '{{lang("Admin.button_write")}}',
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        $.ajax({
                            url: 'manage/translations/write',
                            type: 'POST',
                            data: {
                                module_id: module_id,
                                [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                            },
                            beforeSend: function () {
                                $('#btn_write_translate').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
                            },
                            complete: function () {
                                $('#btn_write_translate').find('i').replaceWith('<i class="fas fa-sync me-1"></i>');
                            },
                            success: function (data) {
                                var response = JSON.stringify(data);
                                response     = JSON.parse(response);
                                $.notify(response.msg)

                                if (response.token) {
                                    // Update CSRF hash
                                    $("input[name*='" + csrf_token + "']").val(response.token);
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
    }
</script>
