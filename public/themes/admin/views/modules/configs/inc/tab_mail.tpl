{strip}
	{form_open(uri_string(), ['id' => 'form_mail'])}
	{form_hidden('tab_type', 'tab_mail')}
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_engine')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<select name="email_engine" id="email_engine" class="form-control">
				<option value="mail" {if old('email_engine', $settings.email_engine) eq 'mail'}selected="selected"{/if}>{lang('ConfigAdmin.text_email')}</option>
				<option value="smtp" {if old('email_engine', $settings.email_engine) eq 'smtp'}selected="selected"{/if}>SMTP</option>
			</select>
			<small>{lang('ConfigAdmin.help_email_engine')}</small>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_parameter')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_parameter" value="{old('email_parameter', $settings.email_parameter)}" id="email_parameter" class="form-control">
			<small>{lang('ConfigAdmin.help_email_parameter')}</small>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_host')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_host" value="{old('email_host', $settings.email_host)}" id="email_host" class="form-control">
			<small>{lang('ConfigAdmin.help_email_host')}</small>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_smtp_user')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_smtp_user" value="{old('email_smtp_user', $settings.email_smtp_user)}" id="email_smtp_user" class="form-control">
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_smtp_pass')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_smtp_pass" value="{old('email_smtp_pass', $settings.email_smtp_pass)}" id="email_smtp_pass" class="form-control">
			<small>{lang('ConfigAdmin.help_email_smtp_pass')}</small>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_port')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_port" value="{old('email_port', $settings.email_port)}" id="email_port" class="form-control">
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_smtp_timeout')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_smtp_timeout" value="{old('email_smtp_timeout', $settings.email_smtp_timeout)}" id="email_smtp_timeout" class="form-control">
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_subject_title')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_subject_title" value="{old('email_subject_title', $settings.email_subject_title)}" id="email_subject_title" class="form-control">
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_from')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="email_from" value="{old('email_from', $settings.email_from)}" id="email_from" class="form-control">
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_email_alerts')}</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_alert')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<div class="form-control" style="height: 150px; overflow: auto;">
				{foreach $mail_alert_list as $key_alert => $mail_alert}
					<div class="form-check">
						<input type="checkbox" name="mail_alert[]" value="{$key_alert}"
							id="input_email_alert_{$key_alert}" class="form-check-input"
							{if in_array($key_alert, $settings.mail_alert|default:[])}checked{/if} />
						<label for="input_email_alert_{$key_alert}" class="form-check-label ms-1">{$mail_alert}</label>
					</div>
				{/foreach}
			</div>
			<small>{lang('ConfigAdmin.help_email_alert')}</small>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_email_alert_email')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<textarea type="textarea" name="mail_alert_email" id="input_mail_alert_email" cols="40" rows="5" class="form-control {if validation_show_error("mail_alert_email")}is-invalid{/if}">
				{old('mail_alert_email', $settings.mail_alert_email)}
			</textarea>
			<div class="invalid-feedback">
				{validation_show_error("mail_alert_email")}
			</div>
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
{/strip}
