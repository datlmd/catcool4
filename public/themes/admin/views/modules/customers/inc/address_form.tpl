{strip}
	{if empty($address_row)}
		{assign var="address_row" value="address_row_value"}
	{/if}
	{if !empty($address.address_id)}
		<input type="hidden" name="address[{$address_row}][address_id]" value="{$address.address_id}"/>
	{/if}

	<div id="address_row_{$address_row}" class="row g-3 mt-1 mb-3 p-2 border border-2 rounded rounded-3">
		<div class="col-6 mt-2 border-bottom">
			<h4 class="text-dark fw-bold">{lang('CustomerAdmin.header_address')} {$address_row}</h4>
		</div>
		<div class="col-6 mt-2 text-end border-bottom">
			<button type="button" onclick="$('#address_row_{$address_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
		</div>

		<div class="row my-3">
			<label class="col-sm-2 col-form-label text-sm-end" for="input_address_{$address_row}_default">{lang('CustomerAdmin.text_address_default')}</label>
			<div class="col-sm-10">
				<label class="form-check mt-2">
					<input type="radio" name="address_default" value="{$address_row}" {if !empty($address.default)}checked="checked"{/if} id="input_address_{$address_row}_default" class="form-check-input">
				</label>
			</div>
		</div>

		<div class="row mb-3">
			<label for="input_address_{$address_row}_firstname" class="col-sm-2 col-form-label text-sm-end required-label">{lang('Admin.text_full_name')}</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="text" value="{old("address[{$address_row}][firstname]", $address.firstname|default:'')}" placeholder="{lang('Admin.text_first_name')}" class="form-control" name="address[{$address_row}][firstname]" id="input_address_{$address_row}_firstname">
					<input type="text" value="{old("address[{$address_row}][lastname]", $address.lastname|default:'')}" placeholder="{lang('Admin.text_last_name')}" class="form-control" name="address[{$address_row}][lastname]" id="input_address_{$address_row}_lastname">
					<div id="error_address_{$address_row}_firstname" class="invalid-feedback"></div>
				</div>
			</div>
		</div>
		<div class="row mb-3">
			<label for="input_address_{$address_row}_address_1" class="col-sm-2 col-form-label text-sm-end required-label">{lang('CustomerAdmin.text_address_1')}</label>
			<div class="col-sm-10">
				<input type="text" value="{old("address[{$address_row}][address_1]", $address.address_1|default:'')}" class="form-control" name="address[{$address_row}][address_1]" id="input_address_{$address_row}_address_1" placeholder="{lang('CustomerAdmin.help_address_1')}">
				<div id="error_address_{$address_row}_address_1" class="invalid-feedback"></div>
			</div>
		</div>
		<div class="row mb-3">
			<label for="input_address_{$address_row}_address_2" class="col-sm-2 col-form-label text-sm-end">{lang('CustomerAdmin.text_address_2')}</label>
			<div class="col-sm-10">
				<input type="text" value="{old("address[{$address_row}][address_2]", $address.address_2|default:'')}" class="form-control" name="address[{$address_row}][address_2]" id="input_address_{$address_row}_address_2" placeholder="{lang('CustomerAdmin.help_address_2')}">
			</div>
		</div>
		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-sm-end">{lang('CustomerAdmin.text_address_type')}</label>
			<div class="col-sm-10">
				<label class="form-check form-check-inline mt-2">
					<input type="radio" name="address[{$address_row}][type]" value="{ADDRESS_TYPE_HOME}" {if old("address[{$address_row}][type]", $address.type)|default:0 eq ADDRESS_TYPE_HOME}checked="checked"{/if} id="input_address_{$address_row}_type_on" class="form-check-input">
					<label class="form-check-label" for="input_address_{$address_row}_type_on">{lang('CustomerAdmin.text_address_type_home')}</label>
				</label>
				<label class="form-check form-check-inline mt-2 me-2">
					<input type="radio" name="address[{$address_row}][type]" value="{ADDRESS_TYPE_OFFICE}" {if old("address[{$address_row}][type]", $address.type)|default:0 eq ADDRESS_TYPE_OFFICE}checked="checked"{/if} id="input_address_{$address_row}_type_off" class="form-check-input">
					<label class="form-check-label" for="input_address_{$address_row}_type_off">{lang('CustomerAdmin.text_address_type_office')}</label>
				</label>
			</div>
		</div>
		<div class="row mb-3">
			<label for="input_address_{$address_row}_company" class="col-sm-2 col-form-label text-sm-end">{lang('CustomerAdmin.text_company')}</label>
			<div class="col-sm-10">
				<input type="text" value="{old("address[{$address_row}][company]", $address.company|default:'')}" class="form-control" name="address[{$address_row}][company]" id="input_address_{$address_row}_company" placeholder="{lang('CustomerAdmin.text_company')}">
			</div>
		</div>
		<div class="row mb-3">
			<label for="input_address_{$address_row}_city" class="col-sm-2 col-form-label text-sm-end">{lang('CustomerAdmin.text_city')}</label>
			<div class="col-sm-10">
				<input type="text" value="{old("address[{$address_row}][city]", $address.city|default:'')}" class="form-control" name="address[{$address_row}][city]" id="input_address_{$address_row}_city" placeholder="{lang('CustomerAdmin.text_city')}">
			</div>
		</div>
		<div class="row mb-3">
			<label for="input_address_{$address_row}_postcode" class="col-sm-2 col-form-label text-sm-end">{lang('CustomerAdmin.text_postcode')}</label>
			<div class="col-sm-10">
				<input type="text" value="{old("address[{$address_row}][postcode]", $address.postcode|default:'')}" class="form-control" name="address[{$address_row}][postcode]" id="input_address_{$address_row}_postcode" placeholder="{lang('CustomerAdmin.text_postcode')}">
			</div>
		</div>
		<div class="row mb-3">
			<label for="input_address_{$address_row}_country_id" class="col-sm-2 col-form-label text-sm-end required-label">{lang('CustomerAdmin.text_country')}</label>
			<div class="col-sm-4">
				{form_dropdown("address[{$address_row}][country_id]", $country_list, old("address[{$address_row}][country_id]", $address.country_id|default:''), ["class" => "form-control country-changed cc-form-select-single", "id" => "input_address_{$address_row}_country_id", "target_id" => "#input_address_{$address_row}_province_id", "data-placeholder" => lang('Admin.text_select')])}
				<div id="error_address_{$address_row}_country_id" class="invalid-feedback"></div>
			</div>
			<label for="input_address_{$address_row}_province_id" class="col-sm-2 col-form-label text-sm-end required-label">{lang('CustomerAdmin.text_province')}</label>
			<div class="col-sm-4">
				{$province_attributes = ["class" => "form-control province-changed cc-form-select-single", "id" => "input_address_{$address_row}_province_id", "target_id" => "#input_address_{$address_row}_district_id", "data-placeholder" => lang('Admin.text_select')]}
				{if empty($address.address_id)}
					{$province_attributes["disabled"] = "disabled"}
				{/if}
				{form_dropdown("address[{$address_row}][province_id]", $address.province_list, old("address[{$address_row}][province_id]", $address.province_id), $province_attributes)}
				<div id="error_address_{$address_row}_province_id" class="invalid-feedback"></div>
			</div>
		</div>
		<div class="row mb-3">
			<label for="input_address_{$address_row}_district_id" class="col-sm-2 col-form-label text-sm-end required-label">{lang('CustomerAdmin.text_district')}</label>
			<div class="col-sm-4">
				{$district_attributes = ["class" => "form-control district-changed cc-form-select-single", "id" => "input_address_{$address_row}_district_id", "target_id" => "#input_address_{$address_row}_ward_id", "data-placeholder" => lang('Admin.text_select')]}
				{if empty($address.address_id)}
					{$district_attributes["disabled"] = "disabled"}
				{/if}
				{form_dropdown("address[{$address_row}][district_id]", $address.district_list, old("address[{$address_row}][district_id]", $address.district_id|default:''), $district_attributes)}
				<div id="error_address_{$address_row}_district_id" class="invalid-feedback"></div>
			</div>
			<label for="input_address_{$address_row}_ward_id" class="col-sm-2 col-form-label text-sm-end required-label">{lang('CustomerAdmin.text_ward')}</label>
			<div class="col-sm-4">
				{$ward_attributes = ["class" => "form-control ward-changed cc-form-select-single", "id" => "input_address_{$address_row}_ward_id", "data-placeholder" => lang('Admin.text_select')]}
				{if empty($address.address_id)}
					{$ward_attributes["disabled"] = "disabled"}
				{/if}
				{form_dropdown("address[{$address_row}][ward_id]", $address.ward_list, old("address[{$address_row}][ward_id]", $address.ward_id), $ward_attributes)}
				<div id="error_address_{$address_row}_ward_id" class="invalid-feedback"></div>
			</div>
		</div>

	</div>
{/strip}
