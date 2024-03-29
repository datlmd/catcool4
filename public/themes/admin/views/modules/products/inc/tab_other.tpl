{strip}
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_tax_class_id')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="tax_class_id" value="{old('tax_class_id', $edit_data.tax_class_id)}" id="input_tax_class_id" class="form-control">
			<div id="error_tax_class_id" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_subtract')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check form-check-inline ms-2">
				<input type="radio" name="subtract" value="{STATUS_ON}" {if old('subtract', $edit_data.subtract)|default:1 eq STATUS_ON}checked="checked"{/if} id="subtract_on" class="form-check-input">
				<label class="form-check-label" for="subtract_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="subtract" value="{STATUS_OFF}" {if old('subtract', $edit_data.subtract)|default:1 eq STATUS_OFF}checked="checked"{/if} id="subtract_off" class="form-check-input">
				<label class="form-check-label" for="subtract_off">{lang('Admin.text_off')}</label>
			</label>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_minimum')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="minimum" value="{old('minimum', $edit_data.minimum)}" id="input_minimum" min="0" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_minimum')}</div>
			<div id="error_minimum" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_stock_status_id')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{if !empty($stock_status_list)}
				<select name="stock_status_id" id="input_stock_status_id" class="form-control form-control-sm">
					{foreach $stock_status_list as $value}
						<option value="{$value.stock_status_id}" {if old('stock_status_id', $edit_data.stock_status_id) eq $value.stock_status_id}selected="selected"{/if}>{$value.name}</option>
					{/foreach}
				</select>
			{/if}
			<div id="error_stock_status_id" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_date_available')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div class="input-group date show-date-picker" id="show_date_available" data-target-input="nearest" data-date-format="{get_date_format_ajax()|upper}" data-date-locale="{get_lang(true)}">
				<input type="text" name="date_available" id="input_date_available" class="form-control datetimepicker-input" value="{old('date_available', $edit_data.date_available|default:get_date())|date_format:{get_date_format(true)}}" placeholder="{get_date_format_ajax()}" data-target="#show_date_available" />
				<div class="input-group-text" data-target="#show_date_available" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
			</div>
			<div id="error_date_available" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_location')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="location" value="{old('location', $edit_data.location)}" id="input_location" class="form-control">
			<div id="error_location" class="invalid-feedback"></div>
		</div>
	</div>

{/strip}
