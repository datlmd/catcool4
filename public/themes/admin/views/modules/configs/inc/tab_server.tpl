{form_open(uri_string(), ['id' => 'form_server'])}
{create_input_token($csrf)}
{form_hidden('tab_type', 'tab_server')}
<div class="border-bottom mx-3 lead pb-1 my-3">{lang(lang('text_general'))}</div>
<div class="form-group row">
	{lang('text_maintenance', 'text_maintenance', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="maintenance" value="{STATUS_ON}" {set_checkbox('maintenance', STATUS_ON, ($settings.maintenance|lower eq 'true'))} id="maintenance">
			<span><label for="maintenance"></label></span>
		</div><br/>
		<small>{lang('help_maintenance')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_seo_url', 'text_seo_url', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="seo_url" value="{STATUS_ON}" {set_checkbox('seo_url', STATUS_ON, ($settings.seo_url|lower eq 'true'))} id="seo_url">
			<span><label for="seo_url"></label></span>
		</div><br/>
		<small>{lang('help_seo_url')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_robots', 'text_robots', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<textarea type="textarea" name="robots" id="robots" cols="40" rows="5" class="form-control {if !empty(form_error("robots"))}is-invalid{/if}">{str_replace('|', PHP_EOL, set_value('robots', $settings.robots))}</textarea>
		<small>{lang('help_robots')}</small>
		{if !empty(form_error("robots"))}
			<div class="invalid-feedback">{form_error("robots")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_compression', 'text_compression', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="compression" value="{set_value('compression', $settings.compression)}" id="compression" class="form-control">
		<small>{lang('help_compression')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang(lang('text_security'))}</div>
<div class="form-group row">
	{lang('text_enable_ssl', 'text_enable_ssl', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="enable_ssl" value="{STATUS_ON}" {set_checkbox('enable_ssl', STATUS_ON, ($settings.enable_ssl|lower eq 'true'))} id="enable_ssl">
			<span><label for="enable_ssl"></label></span>
		</div><br/>
		<small>{lang('help_enable_ssl')}</small>
	</div>
</div>
<div class="form-group row d-none">
	{lang('text_encryption_key', 'text_encryption_key', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<textarea type="textarea" name="encryption_key" id="encryption_key" cols="40" rows="5" class="form-control">{$settings.encryption_key}</textarea>
		<small>{lang('help_encryption_key')}</small>
	</div>
</div>

<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-right"></div>
	<div class="col-12 col-sm-8 col-lg-6">
		<button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save me-1"></i>{lang('button_save')}</button>
	</div>
</div>
{form_close()}