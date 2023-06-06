{strip}
	<div id="address_row_row_{$address_row}" class="row g-3">
		<div class="col-md-6">
			<label for="inputEmail4" class="form-label"></label>
			<input type="text" class="form-control" name="address[{$address_row}][firstname]" id="input_address_{$address_row}_firstname">
			<div id="error_address_{$address_row}_firstname" class="invalid-feedback"></div>
		</div>
		<div class="col-md-6">
			<label for="inputPassword4" class="form-label">Password</label>
			<input type="password" class="form-control" id="inputPassword4">
		</div>
		<div class="col-12">
			<label for="inputAddress" class="form-label">Address</label>
			<input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
		</div>
		<div class="col-12">
			<label for="inputAddress2" class="form-label">Address 2</label>
			<input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
		</div>
		<div class="col-md-6">
			<label for="inputCity" class="form-label">City</label>
			<input type="text" class="form-control" id="inputCity">
		</div>
		<div class="col-md-4">
			<label for="inputState" class="form-label">State</label>
			<select id="inputState" class="form-select">
				<option selected>Choose...</option>
				<option>...</option>
			</select>
		</div>
		<div class="col-md-2">
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
		<div class="col-12">
			<button type="button" onclick="$('#address_row_row_{$address_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
		</div>
	</div>
{/strip}