{strip}
	<div id="address_row_row_{$address_row}" class="row g-3">
		<div class="col-6">
			{lang('CustomerAdmin.header_address')} {$address_row}
		</div>
		<div class="col-6 text-end">
			<button type="button" onclick="$('#address_row_row_{$address_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
		</div>
		<div class="col-md-6">
			<label for="input_address_{$address_row}_firstname" class="form-label">{lang('Admin.text_first_name')}</label>
			<input type="text" value="{old("address[{$address_row}][firstname]", $address.firstname|default:'')}" class="form-control" name="address[{$address_row}][firstname]" id="input_address_{$address_row}_firstname">
			<div id="error_address_{$address_row}_firstname" class="invalid-feedback"></div>
		</div>
		<div class="col-md-6">
			<label for="input_address_{$address_row}_lastname" class="form-label">{lang('Admin.text_last_name')}</label>
			<input type="text" value="{old("address[{$address_row}][lastname]", $address.lastname|default:'')}" class="form-control" name="address[{$address_row}][lastname]" id="input_address_{$address_row}_lastname">
		</div>
		<div class="col-12">
			<label for="input_address_{$address_row}_address_1" class="form-label">{lang('CustomerAdmin.text_address_1')}</label>
			<input type="text" value="{old("address[{$address_row}][address_1]", $address.address_1|default:'')}" class="form-control" name="address[{$address_row}][address_1]" id="input_address_{$address_row}_address_1" placeholder="{lang('CustomerAdmin.help_address_1')}">
			<div id="error_address_{$address_row}_address_1" class="invalid-feedback"></div>
		</div>
		<div class="col-12">
			<label for="input_address_{$address_row}_address_2" class="form-label">{lang('CustomerAdmin.text_address_2')}</label>
			<input type="text" value="{old("address[{$address_row}][address_2]", $address.address_2|default:'')}" class="form-control" name="address[{$address_row}][address_2]" id="input_address_{$address_row}_address_2" placeholder="{lang('CustomerAdmin.help_address_2')}">
		</div>
		<div class="col-md-4">
			<label for="address[{$address_row}][country_id]" class="form-label">{lang('CustomerAdmin.text_country')}</label>
			{form_dropdown("address[{$address_row}][country_id]", $country_list, old("address[{$address_row}][country_id]", $address.country_id|default:''), ["class" => "form-control country-changed", "id" => "address[{$address_row}][country_id]"])}
		</div>
		<div class="col-md-4">
			<label for="address[{$address_row}][zone_id]" class="form-label">{lang('CustomerAdmin.text_zone')}</label>
			{form_dropdown("address[{$address_row}][zone_id]", $province_list, old("address[{$address_row}][zone_id]", $address.zone_id), ["class" => "form-control province-changed", "id" => "address[{$address_row}][zone_id]"])}
		</div>
		<div class="col-md-4">
			<label for="inputZip" class="form-label">Zip</label>
			<input type="text" class="form-control" id="inputZip">
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" id="gridCheck">
				<label class="form-check-label" for="gridCheck">
					Check me out
				</label>
			</div>
		</div>
	</div>
{/strip}