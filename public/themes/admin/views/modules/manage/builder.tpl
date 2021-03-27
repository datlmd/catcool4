{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
	{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
	<div class="row">
		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=create_module}
		</div>
		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('heading_title')}</h5>
				<div class="card-body">
					{ul(explode('||', lang('builder_caution')), ['class' => 'list-unstyled arrow'])}
					{if !empty(validation_errors())}
						<ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
					{elseif !empty($error_created)}
						{ul($error_created, ['class' => 'text-danger'])}
					{elseif !empty($success)}
						{include file=get_theme_path('views/inc/alert.tpl') message=$success type='success'}
						<a href="{$tool_manage}" target="_blank" class="badge badge-info py-2 px-4 mb-3"><i class="fas fa-link me-2"></i>Tool: {$tool_manage}</a>
					{/if}
                    {form_open(uri_string(), ['id' => 'add_validationform'])}
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('module_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('module_name', set_value("module_name", $this->input->post('module_name')), ['class' => 'form-control'])}
								Ex: Tags
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('controller_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
                                {form_input('controller_name', set_value("controller_name", $this->input->post('controller_name')), ['class' => 'form-control'])}
								Ex: Tags or Manage - Submodule: Groups
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('model_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('model_name', set_value("model_name", $this->input->post('model_name')), ['class' => 'form-control'])}
								Ex: Tag - Submodule: Group
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								{lang('table_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('table_name', set_value("table_name", $this->input->post('table_name')), ['class' => 'form-control'])}
								Ex: tag (If null = model)
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
								Is Language?
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<div class="switch-button switch-button-xs mt-2">
									<input type="checkbox" name="is_language" value="{STATUS_ON}" {set_checkbox('is_language', STATUS_ON, true)} id="is_language">
									<span><label for="is_language"></label></span>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
							<div class="col-12 col-sm-8 col-lg-6">
								<button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-file-medical me-1"></i>{lang('btn_create_module')}</button>
								<button type="reset" class="btn btn-sm btn-space btn-secondary"><i class="fas fa-undo me-1"></i>{lang('button_reset')}</button>
							</div>
						</div>
					{form_close()}
				</div>
			</div>
		</div>
	</div>
</div>
