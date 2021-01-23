{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
        </div>
        <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
            <button type="button" id="btn_search" class="btn btn-sm btn-brand" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
        </div>
    </div>
	<div class="row">
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
            {include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=modules}
        </div>
        <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
            <div class="collapse {if $filter_active}show{/if}" id="filter_manage">
                <div class="card">
                    {form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mb-0 mt-1 ms-2"><i class="fas fa-filter me-2"></i>{lang('filter_header')}</h5>
                            </div>
                            <div class="col-6 text-end">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('filter_submit')}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                Key
                                {form_input('filter[key]', $this->input->get('filter[key]'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter key'])}
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                Value
                                {form_input('filter[value]', $this->input->get('filter[value]'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter value'])}
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                Modules
                                {if !empty($list_module)}
                                    <select name="filter[module_id]" class="form-control form-control-sm">
                                        {foreach $list_module as $value}
                                            <option value="{$value.id}" {if $this->input->get('filter[module_id]') eq $value.id || $this->input->get('module_id') eq $value.id}selected="selected"{/if}>{$value.module}{if !empty($value.sub_module)} - Sub: {$value.sub_module}{/if}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </div>
                        </div>
                    </div>
                    {form_close()}
                </div>
            </div>
			<div class="card">
                <div class="card-header pb-2">
                    <div class="row">
                        <div class="col-5">
                            <h5 class="mb-0 mt-1"><i class="fas fa-list me-2"></i>{lang('text_list')}</h5>
                        </div>
                        <div class="col-7 text-end">
                            <button type="button" class="btn btn-sm btn-space btn-primary" data-toggle="modal" data-target="#addLang"><i class="fas fa-plus me-1"></i>{lang('text_add')}</button>
                            <button type="button" id="btn_save_translate" onclick="save_translate()" class="btn btn-sm btn-space btn-secondary"><i class="fas fa-save me-1"></i>{lang('button_save')}</button>
                            <button type="button" id="btn_write_translate" onclick="write_translate({$module.id})" class="btn btn-sm btn-space btn-success"><i class="fas fa-sync me-1"></i>{lang('button_write')}</button>
                        </div>
                    </div>
                </div>
				<div class="card-body">
					<h5 class="mb-2">
                        <strong>Module:</strong> {$module.module|capitalize}
                        {if !empty($module.sub_module)} - <strong>Sub:</strong> {$module.sub_module|capitalize}{/if}
                    </h5>
					<input type="hidden" name="module_id" value="{$module.id}">
                    <ul class="text-danger mb-3">
                        {foreach $list_file as $file => $permissions}
                            <li>{$file}: <strong>{$permissions}</strong></li>
                        {/foreach}
                    </ul>
					{if !empty($list) && !empty($module)}
                        <strong>Total: {$total}</strong><br/><br/>
                        {form_open('translations/manage/edit', ['id' => 'save_validationform'])}
                            {form_hidden('module_id', $module.id)}
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered second">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Key</th>
                                            {foreach $list_lang as $lang}
                                                <th>{$lang.name|capitalize}</th>
                                            {/foreach}
                                            <th width="80"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {foreach $list as $key => $item}
                                        <tr id="{$key}">
                                            <td>{$key}</td>
                                            {foreach $list_lang as $lang}
                                                <td>
                                                    {if isset($item[$lang.id])}
                                                        <textarea id="{$key}_{$lang.id}" name="translate[{$key}][{$lang.id}]" class="form-control" rows="1">{$item[$lang.id].lang_value}</textarea>
                                                    {else}
                                                        <textarea id="{$key}_{$lang.id}" name="translate[{$key}][{$lang.id}]" class="form-control" rows="1"></textarea>
                                                    {/if}
                                                </td>
                                            {/foreach}
                                            <td class="text-center">
                                                <div class="btn-group ms-auto">
                                                    <button type="button" class="btn btn-sm btn-outline-light text-danger" data-module="{$module.id}" data-key="{$key}" onclick="delete_translate(this)" title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        {form_close()}
					{else}
						{lang('text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal add -->
<div class="modal fade" id="addLang" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addModalLabel">{lang('text_add')}</h5>
				<a href="#" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</a>
			</div>
			<div class="modal-body">
				<div id="add_validation_error" class="text-danger"></div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    {form_open('translations/manage/add', ['id' => 'add_lang_form'])}
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
								Key:
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="add_key" value="" class="form-control">
							</div>
						</div>
						{foreach $list_lang as $lang}
							<div class="form-group row">
								<label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
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
								<input type="hidden" name="module_id" value="{$module.id}">
								<button type="button" onclick="add_translate()" class="btn btn-sm btn-space btn-primary btn-add-translate"><i class="fas fa-save me-1"></i>{lang('button_save')}</button>
                                <a href="#" class="btn btn-sm btn-space btn-light" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('button_cancel')}</span>
                                </a>
							</div>
						</div>
                    {form_close()}
				</div>
			</div>
            {*<div class="modal-footer text-center">*}
            {*<button type="submit" class="btn btn-sm btn-space btn-primary">{lang('button_save')}</button>*}
            {*<a href="#" class="btn btn-secondary btn-sm btn-space" data-dismiss="modal">Close</a>*}
            {*</div>*}
		</div>
	</div>
</div>
<script>
    function add_translate() {
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
                if (response.status == 'ng') {
                    $('#add_validation_error').html(response.msg);
                    return false;
                }

                location.reload();
            },
            error: function (xhr, errorType, error) {
            }
        });
    }
    function save_translate() {
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
                if (response.status == 'ng') {
                    $.notify(response.msg);
                    return false;
                }

                location.reload();
            },
            error: function (xhr, errorType, error) {
            }
        });
    }
    function delete_translate(obj) {
        $.confirm({
            title: '{{lang("text_confirm_title")}}',
            content: '{{lang("text_confirm_delete")}}',
            icon: 'fa fa-question',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'red',
            buttons: {
                formSubmit: {
                    text: '{{lang("button_delete")}}',
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        var key = $(obj).attr("data-key");
                        $.ajax({
                            url: 'translations/manage/delete',
                            type: 'POST',
                            data: {
								module_id: $(obj).attr("data-module"),
								key: key
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
                            }
                        });
                    }
                },
                cancel: {
                    text: '{{lang("button_close")}}',
                    keys: ['n']
                },
            }
        });
    }
    function write_translate(module_id) {
        $.confirm({
            title: '{{lang("text_confirm_title")}}',
            content: '{{lang("text_confirm_write")}}',
            icon: 'fa fa-question',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'blue',
            buttons: {
                formSubmit: {
                    text: '{{lang("button_write")}}',
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        $.ajax({
                            url: 'translations/manage/write',
                            type: 'POST',
                            data: {
                                module_id: module_id
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
                            },
                            error: function (xhr, errorType, error) {
                            }
                        });
                    }
                },
                cancel: {
                    text: '{{lang("button_close")}}',
                    keys: ['n']
                },
            }
        });
    }
</script>
