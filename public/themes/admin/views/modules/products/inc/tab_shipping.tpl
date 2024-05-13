{strip}

	<div class="form-group row">
		<label class="col-12 col-sm-2 col-form-label text-sm-end" for="input_shipping">{lang('ProductAdmin.text_shipping')}</label>
		<div class="col-12 col-sm-10 col-lg-10 form-control-lg py-1">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="shipping" id="input_shipping"
					{set_checkbox('shipping', 1, $edit_data.shipping|default:true)} value="1">
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_dimension')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="hidden" name="length_class_id" id="input_length_class_id" value="{config_item('length_class')}">
			<div class="row">
				<div class="col-sm-4">
					<div class="input-group input-group-inline">
						<span class="input-group-text" title="{$length_class_list[config_item('length_class')].name}">{$length_class_list[config_item('length_class')].unit}</span>
						<input type="number" name="length" value="{old('length', $edit_data.length)}" id="input_length" class="form-control" placeholder="{lang('ProductAdmin.text_length')}">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-text" title="{$length_class_list[config_item('length_class')].name}">{$length_class_list[config_item('length_class')].unit}</span>
						<input type="number" name="width" value="{old('width', $edit_data.width)}" id="input_width" class="form-control" placeholder="{lang('ProductAdmin.text_width')}">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-text" title="{$length_class_list[config_item('length_class')].name}">{$length_class_list[config_item('length_class')].unit}</span>
						<input type="number" name="height" value="{old('height', $edit_data.height)}" id="input_height" class="form-control" placeholder="{lang('ProductAdmin.text_height')}">
					</div>
				</div>
			</div>
			<div id="error_length" class="invalid-feedback"></div>
			<div id="error_width" class="invalid-feedback"></div>
			<div id="error_height" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_weight')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="hidden" name="weight_class_id" id="input_weight_class_id" value="{config_item('weight_class')}">
			<div class="input-group">
				<span class="input-group-text">{$weight_class_list[config_item('weight_class')].name} ({$weight_class_list[config_item('weight_class')].unit})</span>
				<input type="number" name="weight" value="{old('weight', $edit_data.weight)}" id="input_weight" class="form-control">
			</div>

			<div id="error_weight" class="invalid-feedback"></div>
		</div>
	</div>

{/strip}
