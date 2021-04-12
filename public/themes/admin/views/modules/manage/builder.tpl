{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
	{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')  heading_title=lang('Builder.heading_title')}
	<div class="row">
		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=create_module}
		</div>
		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('Builder.heading_title')}</h5>
				<div class="card-body">
					{ul(explode('||', lang('Builder.builder_caution')), ['class' => 'list-unstyled arrow'])}
					<ul class="text-danger mb-3">
						{foreach $file_list as $file => $permissions}
							<li>{$file}: <strong>{$permissions}</strong></li>
						{/foreach}
					</ul>
					{if !empty($validator->getErrors())}
						{$validator->listErrors()}
					{elseif !empty($error_created)}
						{ul($error_created, ['class' => 'text-danger'])}
					{elseif !empty($success)}
						{include file=get_theme_path('views/inc/alert.tpl') message=$success type='success'}
					{/if}
					{if !empty($tool_manage)}
						<a href="{$tool_manage}" target="_blank" class="badge badge-info py-2 px-4 mb-3"><i class="fas fa-link me-2"></i>Tool: {$tool_manage}</a>
					{/if}
                    {form_open(uri_string(), ['id' => 'add_validationform'])}
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('Builder.module_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="module_name" value="{old('module_name')}" id="module_name" class="form-control {if $validator->hasError('module_name')}is-invalid{/if}">
								Ex: Tags
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('Builder.controller_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="controller_name" value="{old('controller_name')}" id="controller_name" class="form-control {if $validator->hasError('controller_name')}is-invalid{/if}">
								Ex: Tags or Manage - Submodule: Groups
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('Builder.model_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="model_name" value="{old('model_name')}" id="model_name" class="form-control {if $validator->hasError('model_name')}is-invalid{/if}">
								Ex: Tag - Submodule: Group
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-end">
								{lang('Builder.table_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="table_name" value="{old('table_name')}" id="table_name" class="form-control">
								Ex: tag (If null = model)
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-end">
								Is Language?
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<div class="switch-button switch-button-xs mt-2">
									<input type="checkbox" name="is_language" value="{STATUS_ON}" {set_checkbox('is_language', STATUS_ON, false)} id="is_language">
									<span><label for="is_language"></label></span>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
							<div class="col-12 col-sm-8 col-lg-6">
								<button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-file-medical me-1"></i>{lang('Builder.btn_create_module')}</button>
								<button type="reset" class="btn btn-sm btn-space btn-secondary"><i class="fas fa-undo me-1"></i>{lang('Admin.button_reset')}</button>
							</div>
						</div>
					{form_close()}
				</div>
			</div>
		</div>
	</div>
</div>
