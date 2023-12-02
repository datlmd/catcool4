{strip}

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_shipping')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check form-check-inline ms-2">
				<input type="radio" name="shipping" value="{STATUS_ON}" {if old('shipping', $edit_data.shipping)|default:1 eq STATUS_ON}checked="checked"{/if} id="shipping_on" class="form-check-input">
				<label class="form-check-label" for="shipping_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="shipping" value="{STATUS_OFF}" {if old('shipping', $edit_data.shipping)|default:1 eq STATUS_OFF}checked="checked"{/if} id="shipping_off" class="form-check-input">
				<label class="form-check-label" for="shipping_off">{lang('Admin.text_off')}</label>
			</label>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_dimension')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="hidden" name="length_class_id" id="input_length_class_id" value="{config_item('length_class')}">
			<div class="input-group">
				<span class="input-group-text">{$length_class_list[config_item('length_class')].unit}</span>
				<input type="number" name="length" value="{old('length', $edit_data.length)}" id="input_length" class="form-control" placeholder="{lang('ProductAdmin.text_length')}">
				<span class="input-group-text">X</span>
				<input type="number" name="width" value="{old('width', $edit_data.width)}" id="input_width" class="form-control" placeholder="{lang('ProductAdmin.text_width')}">
				<span class="input-group-text">X</span>
				<input type="number" name="height" value="{old('height', $edit_data.height)}" id="input_height" class="form-control" placeholder="{lang('ProductAdmin.text_height')}">
			</div>
			<div id="error_length" class="invalid-feedback"></div>
			<div id="error_width" class="invalid-feedback"></div>
			<div id="error_height" class="invalid-feedback"></div>
		</div>
	</div>

{*	<div class="form-group row">*}
{*		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_length_class_id')}</div>*}
{*		<div class="col-12 col-sm-10 col-lg-10">*}
{*			{if !empty($length_class_list)}*}
{*				<select name="length_class_id" id="input_length_class_id" class="form-select">*}
{*					{foreach $length_class_list as $value}*}
{*						<option value="{$value.length_class_id}" {if old('length_class_id', $edit_data.length_class_id) eq $value.length_class_id}selected="selected"{/if}>{$value.name}</option>*}
{*					{/foreach}*}
{*				</select>*}
{*			{/if}*}
{*			<div id="error_length_class_id" class="invalid-feedback"></div>*}
{*		</div>*}
{*	</div>*}

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_weight')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="hidden" name="weight_class_id" id="input_weight_class_id" value="{config_item('weight_class')}">
			<div class="input-group">
				<span class="input-group-text">{$weight_class_list[config_item('weight_class')].unit}</span>
				<input type="number" name="weight" value="{old('weight', $edit_data.weight)}" id="input_weight" class="form-control">
			</div>

			<div id="error_weight" class="invalid-feedback"></div>
		</div>
	</div>
{*	<div class="form-group row">*}
{*		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_weight_class_id')}</div>*}
{*		<div class="col-12 col-sm-10 col-lg-10">*}
{*			{if !empty($weight_class_list)}*}
{*				<select name="weight_class_id" id="input_weight_class_id" class="form-control form-control-sm">*}
{*					{foreach $weight_class_list as $value}*}
{*						<option value="{$value.weight_class_id}" {if old('weight_class_id', $edit_data.weight_class_id) eq $value.weight_class_id}selected="selected"{/if}>{$value.name}</option>*}
{*					{/foreach}*}
{*				</select>*}
{*			{/if}*}
{*			<div id="error_weight_class_id" class="invalid-feedback"></div>*}
{*		</div>*}
{*	</div>*}
{/strip}
