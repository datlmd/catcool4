{form_open(uri_string(), ['id' => 'form_mail'])}
{create_input_token($csrf)}
{form_hidden('tab_type', 'tab_mail')}
<div class="form-group row">
	{lang('text_email_engine', 'text_email_engine', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<select name="email_engine" id="email_engine" class="form-control">
			<option value="mail" {if $settings.email_engine eq 'mail'}selected="selected"{/if}>{lang('text_email')}</option>
			<option value="smtp" {if $settings.email_engine eq 'smtp'}selected="selected"{/if}>SMTP</option>
		</select>
		<small>{lang('help_email_engine')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_email_parameter', 'text_email_parameter', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_parameter" value="{set_value('email_parameter', $settings.email_parameter)}" id="email_parameter" class="form-control">
		<small>{lang('help_email_parameter')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_email_host', 'text_email_host', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_host" value="{set_value('email_host', $settings.email_host)}" id="email_host" class="form-control">
		<small>{lang('help_email_host')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_email_smtp_user', 'text_email_smtp_user', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_smtp_user" value="{set_value('email_smtp_user', $settings.email_smtp_user)}" id="email_smtp_user" class="form-control">
	</div>
</div>
<div class="form-group row">
	{lang('text_email_smtp_pass', 'text_email_smtp_pass', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_smtp_pass" value="{set_value('email_smtp_pass', $settings.email_smtp_pass)}" id="email_smtp_pass" class="form-control">
		<small>{lang('help_email_smtp_pass')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_email_port', 'text_email_port', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_port" value="{set_value('email_port', $settings.email_port)}" id="email_port" class="form-control">
	</div>
</div>
<div class="form-group row">
	{lang('text_email_smtp_timeout', 'text_email_smtp_timeout', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_smtp_timeout" value="{set_value('email_smtp_timeout', $settings.email_smtp_timeout)}" id="email_smtp_timeout" class="form-control">
	</div>
</div>
<div class="form-group row">
	{lang('text_email_subject_title', 'text_email_subject_title', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_subject_title" value="{set_value('email_subject_title', $settings.email_subject_title)}" id="email_subject_title" class="form-control">
	</div>
</div>
<div class="form-group row">
	{lang('text_email_from', 'text_email_from', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="email_from" value="{set_value('email_from', $settings.email_from)}" id="email_from" class="form-control">
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_email_alerts')}</div>
<div class="form-group row">
	{lang('text_email_alert', 'text_email_alert', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('email_alert', $timezone_list, set_value('email_alert', $settings.email_alert), ['class' => 'form-control'])}
		<small>{lang('help_email_alert')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_email_alert_email', 'text_email_alert_email', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('email_alert_email', $timezone_list, set_value('email_alert_email', $settings.email_alert_email), ['class' => 'form-control'])}
		<small>{lang('help_email_alert_email')}</small>
	</div>
</div>

<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
	<div class="col-12 col-sm-8 col-lg-6">
		<button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save me-1"></i>{lang('button_save')}</button>
	</div>
</div>
{form_close()}