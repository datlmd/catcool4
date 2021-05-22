{form_open(uri_string(), ['id' => 'form_mail'])}
{form_hidden('tab_type', 'tab_mail')}
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_engine')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_engine)}
			{assign var="email_engine" value="`$settings.email_engine`"}
		{else}
			{assign var="email_engine" value=""}
		{/if}
		<select name="email_engine" id="email_engine" class="form-control">
			<option value="mail" {if old('email_engine', $email_engine) eq 'mail'}selected="selected"{/if}>{lang('ConfigAdmin.text_email')}</option>
			<option value="smtp" {if old('email_engine', $email_engine) eq 'smtp'}selected="selected"{/if}>SMTP</option>
		</select>
		<small>{lang('ConfigAdmin.help_email_engine')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_parameter')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_parameter)}
			{assign var="email_parameter" value="`$settings.email_parameter`"}
		{else}
			{assign var="email_parameter" value=""}
		{/if}
		<input type="text" name="email_parameter" value="{old('email_parameter', $email_parameter)}" id="email_parameter" class="form-control">
		<small>{lang('ConfigAdmin.help_email_parameter')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_host')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_host)}
			{assign var="email_host" value="`$settings.email_host`"}
		{else}
			{assign var="email_host" value=""}
		{/if}
		<input type="text" name="email_host" value="{old('email_host', $email_host)}" id="email_host" class="form-control">
		<small>{lang('ConfigAdmin.help_email_host')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_smtp_user')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_smtp_user)}
			{assign var="email_smtp_user" value="`$settings.email_smtp_user`"}
		{else}
			{assign var="email_smtp_user" value=""}
		{/if}
		<input type="text" name="email_smtp_user" value="{old('email_smtp_user', $email_smtp_user)}" id="email_smtp_user" class="form-control">
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_smtp_pass')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_smtp_pass)}
			{assign var="email_smtp_pass" value="`$settings.email_smtp_pass`"}
		{else}
			{assign var="email_smtp_pass" value=""}
		{/if}
		<input type="text" name="email_smtp_pass" value="{old('email_smtp_pass', $email_smtp_pass)}" id="email_smtp_pass" class="form-control">
		<small>{lang('ConfigAdmin.help_email_smtp_pass')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_port')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_port)}
			{assign var="email_port" value="`$settings.email_port`"}
		{else}
			{assign var="email_port" value=""}
		{/if}
		<input type="text" name="email_port" value="{old('email_port', $email_port)}" id="email_port" class="form-control">
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_smtp_timeout')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_smtp_timeout)}
			{assign var="email_smtp_timeout" value="`$settings.email_smtp_timeout`"}
		{else}
			{assign var="email_smtp_timeout" value=""}
		{/if}
		<input type="text" name="email_smtp_timeout" value="{old('email_smtp_timeout', $email_smtp_timeout)}" id="email_smtp_timeout" class="form-control">
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_subject_title')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_subject_title)}
			{assign var="email_subject_title" value="`$settings.email_subject_title`"}
		{else}
			{assign var="email_subject_title" value=""}
		{/if}
		<input type="text" name="email_subject_title" value="{old('email_subject_title', $email_subject_title)}" id="email_subject_title" class="form-control">
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_from')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_from)}
			{assign var="email_from" value="`$settings.email_from`"}
		{else}
			{assign var="email_from" value=""}
		{/if}
		<input type="text" name="email_from" value="{old('email_from', $email_from)}" id="email_from" class="form-control">
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_email_alerts')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_alert')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_alert)}
			{assign var="email_alert" value="`$settings.email_alert`"}
		{else}
			{assign var="email_alert" value=""}
		{/if}
		{form_dropdown('email_alert', $timezone_list, old('email_alert', $email_alert), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_email_alert')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_alert_email')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.email_alert_email)}
			{assign var="email_alert_email" value="`$settings.email_alert_email`"}
		{else}
			{assign var="email_alert_email" value=""}
		{/if}
		{form_dropdown('email_alert_email', $timezone_list, old('email_alert_email', $email_alert_email), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_email_alert_email')}</small>
	</div>
</div>

<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
	<div class="col-12 col-sm-8 col-lg-6 ms-0">
		<button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
	</div>
</div>
{form_close()}
