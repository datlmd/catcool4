{strip}
	{form_open(uri_string(), ['id' => 'form_local'])}
	{form_hidden('tab_type', 'tab_local')}
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_country')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('country', $country_list, old('country', $settings.country), ['class' => 'form-control country-changed'])}
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_zone')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('country_province', $province_list, old('country_province', $settings.country_province), ['class' => 'form-control province-changed'])}
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_timezone')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('app_timezone', $timezone_list, old('app_timezone', $settings.app_timezone), ['class' => 'form-control'])}
		</div>
	</div>
	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold"></div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('Admin.text_language')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<select name="default_locale" class="form-control">
				{foreach get_list_lang(true) as $key => $value}
					<option value={$value.code}  {if $value.code == old('default_locale', $settings.default_locale)}selected="selected"{/if}>
						{lang("General."|cat:$value.code)}
					</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_language_admin')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<select name="default_locale_admin" class="form-control">
				{foreach get_list_lang(true) as $key => $value}
					<option value={$value.code}  {if $value.code == old('default_locale_admin', $settings.default_locale_admin)}selected="selected"{/if}>
						{lang("General."|cat:$value.code)}
					</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold"></div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_currency')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('currency', $currency_list, old('currency', $settings.currency), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_currency')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_currency_auto')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="currency_auto" value="{STATUS_ON}" {if !empty(old('currency_auto', $settings.currency_auto))}checked="checked"{/if} id="currency_auto_on" class="form-check-input">
				<label class="form-check-label" for="currency_auto_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="currency_auto" value="{STATUS_OFF}" {if empty(old('currency_auto', $settings.currency_auto))}checked="checked"{/if} id="currency_auto_off" class="form-check-input">
				<label class="form-check-label" for="currency_auto_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_currency_auto')}</small>
		</div>
	</div>
	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold"></div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_length_class')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('length_class', $length_class_list, old('length_class', $settings.length_class), ['class' => 'form-control'])}
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_weight_class')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('weight_class', $weight_class_list, old('weight_class', $settings.weight_class), ['class' => 'form-control'])}
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
