{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">

	<div class="row">

		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="create_module"}
		</div>

		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

			{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')  heading_title=lang('Builder.heading_title')}

			<div class="card">
				<h5 class="card-header">{lang('Builder.heading_title')}</h5>
				<div class="card-body">
					{ul(explode('||', lang('Builder.builder_caution')), ['class' => 'list-unstyled arrow'])}
					<ul class="text-success mb-3">
						{foreach $file_list as $file => $permissions}
							<li>{$file}: <strong>{$permissions}</strong></li>
						{/foreach}
					</ul>
					{if !empty(validation_list_errors())}
						<div class="text-danger">{validation_list_errors()}</div>
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
								<input type="text" name="module_name" value="{old('module_name')}" id="module_name" class="form-control {if validation_show_error('module_name')}is-invalid{/if}">
								<div class="invalid-feedback">{validation_show_error("module_name")}</div>
								Ex: Tags
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('Builder.controller_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="controller_name" value="{old('controller_name')}" id="controller_name" class="form-control {if validation_show_error('controller_name')}is-invalid{/if}">
								<div class="invalid-feedback">{validation_show_error("controller_name")}</div>
								Ex: Tags or Manage - Submodule: Groups
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('Builder.model_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="model_name" value="{old('model_name')}" id="model_name" class="form-control {if validation_show_error('model_name')}is-invalid{/if}">
								<div class="invalid-feedback">{validation_show_error("model_name")}</div>
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
							<div class="col-12 col-sm-8 col-lg-6 pt-2">
								<label class="form-check form-check-inline ms-2">
									<input type="radio" name="is_language" value="{STATUS_ON}" id="language_yes" class="form-check-input">
									<label class="form-check-label" for="language_yes">YES</label>
								</label>
								<label class="form-check form-check-inline me-2">
									<input type="radio" name="is_language" value="{STATUS_OFF}" id="language_no" class="form-check-input">
									<label class="form-check-label" for="language_no">NO</label>
								</label>
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
