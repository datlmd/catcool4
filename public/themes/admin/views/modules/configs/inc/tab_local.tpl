{form_open(uri_string(), ['id' => 'form_local'])}
{create_input_token($csrf)}
{form_hidden('tab_type', 'tab_local')}
<div class="form-group row">
	{lang('text_country', 'text_country', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('country', $country_list, set_value('country', $settings.country), ['class' => 'form-control country-changed'])}
	</div>
</div>
<div class="form-group row">
	{lang('text_zone', 'text_zone', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('country_province', $province_list, set_value('country_province', $settings.country_province), ['class' => 'form-control province-changed'])}
	</div>
</div>
<div class="form-group row">
	{lang('text_timezone', 'text_timezone', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('timezone', $timezone_list, set_value('timezone', $settings.timezone), ['class' => 'form-control'])}
	</div>
</div>
<div class="border-bottom mx-3 lead pb-1 my-3"></div>
<div class="form-group row">
	{lang('text_language', 'text_language', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<select name="language" class="form-control form-control-sm">
			{foreach get_list_lang() as $key => $value}
				<option value={$value.code}  {if $value.code == set_value('language', $settings.language)}selected="selected"{/if}>
					{lang($value.code)}
				</option>
			{/foreach}
		</select>
	</div>
</div>
<div class="form-group row">
	{lang('text_language_admin', 'text_language_admin', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<select name="language_admin" class="form-control form-control-sm">
			{foreach get_list_lang() as $key => $value}
				<option value={$value.code}  {if $value.code == set_value('language_admin', $settings.language_admin)}selected="selected"{/if}>
					{lang($value.code)}
				</option>
			{/foreach}
		</select>
	</div>
</div>
<div class="border-bottom mx-3 lead pb-1 my-3"></div>
<div class="form-group row">
	{lang('text_currency', 'text_currency', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('currency', $currency_list, set_value('currency', $settings.currency), ['class' => 'form-control'])}
		<small>{lang('help_currency')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_currency_auto', 'text_currency_auto', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="currency_auto" value="{STATUS_ON}" {set_checkbox('currency_auto', STATUS_ON, ($settings.currency_auto|lower eq 'true'))} id="currency_auto">
			<span><label for="currency_auto"></label></span>
		</div><br/>
		<small>{lang('help_currency_auto')}</small>
	</div>
</div>
<div class="border-bottom mx-3 lead pb-1 my-3"></div>
<div class="form-group row">
	{lang('text_length_class', 'text_length_class', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('length_class', $length_class_list, set_value('length_class', $settings.length_class), ['class' => 'form-control'])}
	</div>
</div>
<div class="form-group row">
	{lang('text_weight_class', 'text_weight_class', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('weight_class', $weight_class_list, set_value('weight_class', $settings.weight_class), ['class' => 'form-control'])}
	</div>
</div>
<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-right"></div>
	<div class="col-12 col-sm-8 col-lg-6">
		<button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save me-1"></i>{lang('button_save')}</button>
	</div>
</div>
{form_close()}