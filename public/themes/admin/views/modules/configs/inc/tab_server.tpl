{form_open(uri_string(), ['id' => 'form_server'])}
{form_hidden('tab_type', 'tab_server')}
<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_general')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_maintenance')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.maintenance)}
			{assign var="maintenance" value="`$settings.maintenance`"}
		{else}
			{assign var="maintenance" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="maintenance" value="{STATUS_ON}" {if !empty(old('maintenance', $maintenance))}checked="checked"{/if} id="maintenance_on" class="form-check-input">
			<label class="form-check-label" for="maintenance_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="maintenance" value="{STATUS_OFF}" {if empty(old('maintenance', $maintenance))}checked="checked"{/if} id="maintenance_off" class="form-check-input">
			<label class="form-check-label" for="maintenance_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_maintenance')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_seo_url')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.seo_url)}
			{assign var="seo_url" value="`$settings.seo_url`"}
		{else}
			{assign var="seo_url" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="seo_url" value="{STATUS_ON}" {if !empty(old('seo_url', $seo_url))}checked="checked"{/if} id="seo_url_on" class="form-check-input">
			<label class="form-check-label" for="seo_url_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="seo_url" value="{STATUS_OFF}" {if empty(old('seo_url', $seo_url))}checked="checked"{/if} id="seo_url_off" class="form-check-input">
			<label class="form-check-label" for="seo_url_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_seo_url')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_robots')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.robots)}
			{assign var="robots" value="`$settings.robots`"}
		{else}
			{assign var="robots" value=""}
		{/if}
		<textarea type="textarea" name="robots" id="robots" cols="40" rows="5" class="form-control {if $validator->hasError("robots")}is-invalid{/if}">{str_replace('|', PHP_EOL, old('robots', $robots))}</textarea>
		<div class="invalid-feedback">
			{$validator->getError("robots")}
		</div>
		<small>{lang('ConfigAdmin.help_robots')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_compression')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.compression)}
			{assign var="compression" value="`$settings.compression`"}
		{else}
			{assign var="compression" value="0"}
		{/if}
		<input type="number" name="compression" value="{old('compression', $compression)}" id="compression" class="form-control">
		<small>{lang('ConfigAdmin.help_compression')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang(lang('ConfigAdmin.text_security'))}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_enable_ssl')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.force_global_secure_requests)}
			{assign var="force_global_secure_requests" value="`$settings.force_global_secure_requests`"}
		{else}
			{assign var="force_global_secure_requests" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="force_global_secure_requests" value="{STATUS_ON}" {if !empty(old('force_global_secure_requests', $force_global_secure_requests))}checked="checked"{/if} id="force_global_secure_requests_on" class="form-check-input">
			<label class="form-check-label" for="force_global_secure_requests_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="force_global_secure_requests" value="{STATUS_OFF}" {if empty(old('force_global_secure_requests', $force_global_secure_requests))}checked="checked"{/if} id="force_global_secure_requests_off" class="form-check-input">
			<label class="form-check-label" for="force_global_secure_requests_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_enable_ssl')}</small>
	</div>
</div>
<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
	<div class="col-12 col-sm-8 col-lg-6 ms-0">
		<button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
	</div>
</div>
{form_close()}
