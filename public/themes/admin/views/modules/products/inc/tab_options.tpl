{strip}

	{form_hidden('tab_type', 'tab_options')}

	{$product_option_row = 0}
	{$product_option_value_row = 0}

	<div id="option">
		{if !empty($edit_data.product_option_list)}
			{foreach $edit_data.product_option_list as $product_option_data}
				{$product_option_row = $product_option_row + 1}

				<div id="product_option_row_{$product_option_row}" class="mb-4">
					<legend class="float-none text-dark border-bottom pb-1 mt-2 mb-3">
						{$product_option_data.name}
						<button type="button" class="btn btn-danger btn-xs float-end" onclick="$('#product_option_row_{$product_option_row}').remove();">
							<i class="fas fa-trash-alt"></i>
						</button>
					</legend>
					<input type="hidden" name="product_option[{$product_option_row}][product_option_id]" value="{$product_option_data.product_option_id}"/>
					<input type="hidden" name="product_option[{$product_option_row}][name]" value="{$product_option_data.name}"/>
					<input type="hidden" name="product_option[{$product_option_row}][option_id]" value="{$product_option_data.option_id}"/>
					<input type="hidden" name="product_option[{$product_option_row}][type]" value="{$product_option_data.type}"/>

					<div class="row mb-3">
						<label for="input_required_{$product_option_row}" class="col-sm-2 col-form-label text-end">{lang('ProductAdmin.text_required')}</label>
						<div class="col-sm-10">
							<select name="product_option[{$product_option_row}][required]" id="input_required_{$product_option_row}" class="form-select form-select-sm">
								<option value="1"{if $product_option_data.required} selected="selected"{/if}>{lang('Admin.text_enabled')}</option>
								<option value="0"{if !$product_option_data.required} selected="selected"{/if}>{lang('Admin.text_disabled')}</option>
							</select>
						</div>
					</div>

					{if $product_option_data.type == 'text'}
						<div class="row mb-3">
							<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label text-end">{lang('ProductAdmin.text_option_value')}</label>
							<div class="col-sm-10">
								<input type="text" name="product_option[{$product_option_row}][value]" value="{$product_option_data.value}" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control"/>
							</div>
						</div>
					{/if}

					{if $product_option_data.type == 'textarea'}
						<div class="row mb-3">
							<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label text-end">{lang('ProductAdmin.text_option_value')}</label>
							<div class="col-sm-10">
								<textarea name="product_option[{$product_option_row}][value]" rows="5" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control">{$product_option_data.value}</textarea>
							</div>
						</div>
					{/if}

					{if $product_option_data.type == 'file'}
						<div class="row mb-3 d-none">
							<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label text-end">{lang('ProductAdmin.text_option_value')}</label>
							<div class="col-sm-10"><input type="text" name="product_option[{$product_option_row}][value]" value="{$product_option_data.value}" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control"/></div>
						</div>
					{/if}

					{if $product_option_data.type == 'date'}
						<div class="row mb-3">
							<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label text-end">{lang('ProductAdmin.text_option_value')}</label>
							<div class="col-sm-10 col-md-4">
								<div class="input-group">
									<input type="text" name="product_option[{$product_option_row}][value]" value="{$product_option_data.value}" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control date"/>
									<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>
								</div>
							</div>
						</div>
					{/if}

					{if $product_option_data.type == 'time'}
						<div class="row mb-3">
							<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label text-end">{lang('ProductAdmin.text_option_value')}</label>
							<div class="col-sm-10 col-md-4">
								<div class="input-group">
									<input type="text" name="product_option[{$product_option_row}][value]" value="{$product_option_data.value}" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control time"/>
									<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>
								</div>
							</div>
						</div>
					{/if}

					{if $product_option_data.type == 'datetime'}
						<div class="row mb-3">
							<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label">{lang('ProductAdmin.text_option_value')}</label>
							<div class="col-sm-10 col-md-4">
								<div class="input-group">
									<input type="text" name="product_option[{$product_option_row}][value]" value="{$product_option_data.value}" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control datetime"/>
									<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>
								</div>
							</div>
						</div>
					{/if}

					{if $product_option_data.type == 'select' || $product_option_data.type == 'radio' || $product_option_data.type == 'checkbox' || $product_option_data.type == 'image'}
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
								<tr>
									<th class="text-start">{lang('ProductAdmin.text_option_value')}</th>
									<th class="text-end">{lang('ProductAdmin.text_quantity')}</th>
									<th class="text-start">{lang('ProductAdmin.text_subtract')}</th>
									<th class="text-end">{lang('ProductAdmin.text_price')}</th>
									<th class="text-end">{lang('ProductAdmin.text_points')}</th>
									<th class="text-end">{lang('ProductAdmin.text_weight')}</th>
									<th></th>
								</tr>
								</thead>
								<tbody id="product_option_value_{$product_option_row}">
								{foreach $product_option_data.product_option_value_list as $product_option_value}
									{$product_option_value_row = $product_option_value_row + 1}

									<tr id="product_option_value_row_{$product_option_value_row}">
										<td class="text-start">
											{$product_option_value.name}
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][option_value_id]" value="{$product_option_value.option_value_id}"/>
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][product_option_value_id]" value="{$product_option_value.product_option_value_id}"/>
										</td>
										<td class="text-end">
											{$product_option_value.quantity}
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][quantity]" value="{$product_option_value.quantity}"/>
										</td>
										<td class="text-start">
											{if $product_option_value.subtract}
												{lang('Admin.text_yes')}
											{else}
												{lang('Admin.text_no')}
											{/if}
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][subtract]" value="{$product_option_value.subtract}"/>
										</td>
										<td class="text-end">
											{$product_option_value.price_prefix}{$product_option_value.price}
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][price_prefix]" value="{$product_option_value.price_prefix}"/>
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][price]" value="{$product_option_value.price}"/>
										</td>
										<td class="text-end">
											{$product_option_value.points_prefix}{$product_option_value.points}
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][points_prefix]" value="{$product_option_value.points_prefix}"/>
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][points]" value="{$product_option_value.points}"/>
										</td>
										<td class="text-end">
											{$product_option_value.weight_prefix}{$product_option_value.weight}
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][weight_prefix]" value="{$product_option_value.weight_prefix}"/>
											<input type="hidden" name="product_option[{$product_option_row}][product_option_value][{$product_option_value_row}][weight]" value="{$product_option_value.weight}"/>
										</td>
										<td class="text-end">
											<button type="button" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}" data-product_option_row="{$product_option_row}" data-product_option_value_row="{$product_option_value_row}" class="btn btn-xs btn-primary me-1"><i class="fas fa-edit"></i></button>
											<button type="button" onclick="$('#product_option_value_row_{$product_option_value_row}').remove();" data-bs-toggle="tooltip" title="{lang('Admin.button_remove')}" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
										</td>
									</tr>

								{/foreach}
								</tbody>
								<tfoot>
									<tr>
										<td colspan="6"></td>
										<td class="text-end"><button type="button" data-bs-toggle="tooltip" title="{lang('ProductAdmin.button_option_value_add')}" data-product_option_row="{$product_option_row}" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i></button>
										</td>
									</tr>
								</tfoot>
							</table>
							<select id="product_option_values_{$product_option_row}" class="d-none">
								{foreach $product_option_data.option_value_list as $option_value}
									<option value="{$option_value.option_value_id}">{$option_value.name}</option>
								{/foreach}
							</select>
						</div>
					{/if}

				</div>

			{/foreach}
		{/if}
	</div>

	<fieldset>
		<legend class="float-none border-bottom mb-3 bg-light p-2">{lang('ProductAdmin.text_option_add')}</legend>
		<div class="row mb-3">
			<label for="option_select_add" class="col-sm-2 col-form-label text-end">{lang('ProductAdmin.text_option')}</label>
			<div class="col-sm-10">
				<select name="option_select_add" id="option_select_add" class="form-select form-select-sm">
					<option value="0">{lang('Admin.text_none')}</option>
					{foreach $option_list as $option}
						<option value="{$option.option_id}">{$option.name}</option>
					{/foreach}
				</select>
				<div class="form-text">{lang('ProductAdmin.help_option')}</div>
			</div>
		</div>
	</fieldset>

	<input type="hidden" name="product_option_row" id="product_option_row" value="{$product_option_row}">
	<input type="hidden" name="product_option_value_row" id="product_option_value_row" value="{$product_option_value_row}">
{/strip}
<script type="text/javascript">
	$('#option').on('click', '.btn-primary', function () {
		var element = this;

		var product_option_value_row = $('#product_option_value_row').val();
		if ($(element).data('product_option_value_row')) {
			product_option_value_row = $(element).data('product_option_value_row');
		} else {
			product_option_value_row = parseInt(product_option_value_row) + 1;
		}

		element.product_option_value_row = product_option_value_row;

		$('.modal').remove();
		html = '<div id="modal_option" class="modal fade">';
		html += '  <div class="modal-dialog">';
		html += '    <div class="modal-content">';
		html += '      <div class="modal-header">';
		html += '        <h5 class="modal-title"><i class="fas fa-pencil"></i>{{lang('ProductAdmin.text_option_value')}}</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>';
		html += '      </div>';
		html += '      <div class="modal-body">';
		html += '        <div class="mb-3">';
		html += '      	   <label for="input-modal-option-value" class="form-label">{{lang('ProductAdmin.text_option_value')}}</label>';
		html += '      	   <select name="option_value_id" id="input_modal_option_value" class="form-select form-select-sm">';
		option_value = $('#product_option_values_' + $(element).data('product_option_row') + ' option');
		for (i = 0; i < option_value.length; i++) {
			if ($(element).data('product_option_value_row') && $(option_value[i]).val() == $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][option_value_id]\']').val()) {
				html += '<option value="' + $(option_value[i]).val() + '" selected="selected">' + $(option_value[i]).text() + '</option>';
			} else {
				html += '<option value="' + $(option_value[i]).val() + '">' + $(option_value[i]).text() + '</option>';
			}
		}
		html += '      	   </select>';
		html += '          <input type="hidden" name="product_option_value_id" value="' + ($(element).data('product_option_value_row') ? $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][product_option_value_id]\']').val() : '') + '"/>';
		html += '        </div>';
		html += '        <div class="mb-3">';
		html += '      	   <label for="input-modal-quantity" class="form-label">{{lang('ProductAdmin.text_quantity')}}</label>';
		html += '      	   <input type="text" name="quantity" value="' + ($(element).data('product_option_value_row') ? $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][quantity]\']').val() : '1') + '" placeholder="{{lang('ProductAdmin.text_quantity') }}" id="input-modal-quantity" class="form-control"/>';
		html += '        </div>';
		html += '        <div class="mb-3">';
		html += '      	   <label for="input-modal-subtract" class="form-label">{{lang('ProductAdmin.text_subtract') }}</label>';
		html += '      	   <select name="subtract" id="input-modal-subtract" class="form-select form-select-sm">';
		if ($(element).data('product_option_value_row') && $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][subtract]\']').val() == '1') {
			html += '        <option value="1" selected="selected">{{lang('Admin.text_yes')}}</option>';
			html += '      	 <option value="0">{{lang('Admin.text_no')}}</option>';
		} else {
			html += '      	 <option value="1">{{lang('Admin.text_yes')}}</option>';
			html += '      	 <option value="0" selected="selected">{{lang('Admin.text_no')}}</option>';
		}
		html += '      	   </select>';
		html += '        </div>';
		html += '        <div class="mb-3">';
		html += '      	   <label for="input-modal-price" class="form-label">{{lang('ProductAdmin.text_price')}}</label>';
		html += '          <div class="input-group">';
		html += '            <select name="price_prefix" class="form-select form-select-sm">';
		if ($(element).data('product_option_value_row') && $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][price_prefix]\']').val() == '+') {
			html += '      	   <option value="+" selected="selected">+</option>';
		} else {
			html += '      	   <option value="+">+</option>';
		}
		if ($(element).data('product_option_value_row') && $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][price_prefix]\']').val() == '-') {
			html += '      	       <option value="-" selected="selected">-</option>';
		} else {
			html += '      	       <option value="-">-</option>';
		}
		html += '      	     </select>';
		html += '      	     <input type="text" name="price" value="' + ($(element).data('product_option_value_row') ? $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][price]\']').val() : '0') + '" placeholder="{{lang('ProductAdmin.text_price')}}" id="input-modal-price" class="form-control"/>';
		html += '          </div>';
		html += '        </div>';
		html += '        <div class="mb-3">';
		html += '      	   <label for="input-modal-points" class="form-label">{{lang('ProductAdmin.text_points')}}</label>';
		html += '          <div class="input-group">';
		html += '      	     <select name="points_prefix" class="form-select form-select-sm">';
		if ($(element).data('product_option_value_row') && $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][points_prefix]\']').val() == '+') {
			html += '      	       <option value="+" selected>+</option>';
		} else {
			html += '      	       <option value="+">+</option>';
		}
		if ($(element).data('product_option_value_row') && $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][points_prefix]\']').val() == '-') {
			html += '      	       <option value="-" selected>-</option>';
		} else {
			html += '      	       <option value="-">-</option>';
		}
		html += '      	     </select>';
		html += '      	     <input type="text" name="points" value="' + ($(element).data('product_option_value_row') ? $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][points]\']').val() : '0') + '" placeholder="{{lang('ProductAdmin.text_points')}}" id="input-modal-points" class="form-control"/>';
		html += '          </div>';
		html += '        </div>';
		html += '        <div class="mb-3">';
		html += '      	   <label for="input-modal-weight" class="form-label">{{lang('ProductAdmin.text_weight')}}</label>';
		html += '          <div class="input-group">';
		html += '      	     <select name="weight_prefix" class="form-select form-select-sm">';
		if ($(element).data('product_option_value_row') && $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][weight_prefix]\']').val() == '+') {
			html += '      	       <option value="+" selected>+</option>';
		} else {
			html += '      	       <option value="+">+</option>';
		}
		if ($(element).data('product_option_value_row') && $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][weight_prefix]\']').val() == '-') {
			html += '      	       <option value="-" selected>-</option>';
		} else {
			html += '      	       <option value="-">-</option>';
		}
		html += '      	     </select>';
		html += '      	     <input type="text" name="weight" value="' + ($(element).data('product_option_value_row') ? $('input[name=\'product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][weight]\']').val() : '0') + '" placeholder="{{lang('ProductAdmin.text_weight')}}" id="input-modal-weight" class="form-control"/>';
		html += '          </div>';
		html += '        </div>';
		html += '      </div>';
		html += '      <div class="modal-footer">';
		html += '	     <button type="button" id="button_save" data-product_option_row="' + $(element).data('product_option_row') + '" data-product_option_value_row="' + product_option_value_row + '" class="btn btn-primary">{{lang('Admin.button_save')}}</button> <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{lang('Admin.button_cancel')}}</button>';
		html += '      </div>';
		html += '    </div>';
		html += '  </div>';
		html += '</div>';
		$('body').append(html);
		$('#modal_option').modal('show');
		$('#modal_option #button_save').on('click', function () {
			html = '<tr id="product_option_value_row_' + product_option_value_row + '">';
			html += '  <td class="text-start">' + $('#modal_option select[name=\'option_value_id\'] option:selected').text() + '<input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][option_value_id]" value="' + $('#modal_option select[name=\'option_value_id\']').val() + '"/><input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][product_option_value_id]" value="' + $('#modal_option input[name=\'product_option_value_id\']').val() + '"/></td>';
			html += '  <td class="text-end">' + $('#modal_option input[name=\'quantity\']').val() + '<input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][quantity]" value="' + $('#modal_option input[name=\'quantity\']').val() + '"/></td>';
			html += '  <td class="text-start">' + ($('#modal_option select[name=\'subtract\'] option:selected').val() == '1' ? '{{lang('Admin.text_yes')}}' : '{{lang('Admin.text_no')}}') + '<input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][subtract]" value="' + $('#modal_option select[name=\'subtract\'] option:selected').val() + '"/></td>';
			html += '  <td class="text-end">' + $('#modal_option select[name=\'price_prefix\'] option:selected').val() + $('#modal_option input[name=\'price\']').val() + '<input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][price_prefix]" value="' + $('#modal_option select[name=\'price_prefix\'] option:selected').val() + '"/><input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][price]" value="' + $('#modal_option input[name=\'price\']').val() + '"/></td>';
			html += '  <td class="text-end"> ' + $('#modal_option select[name=\'points_prefix\'] option:selected').val() + $('#modal_option input[name=\'points\']').val() + '<input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][points_prefix]" value="' + $('#modal_option select[name=\'points_prefix\'] option:selected').val() + '"/><input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][points]" value="' + $('#modal_option input[name=\'points\']').val() + '"/></td>';
			html += '  <td class="text-end">' + $('#modal_option select[name=\'weight_prefix\'] option:selected').val() + $('#modal_option input[name=\'weight\']').val() + '<input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][weight_prefix]" value="' + $('#modal_option select[name=\'weight_prefix\'] option:selected').val() + '"/><input type="hidden" name="product_option[' + $(element).data('product_option_row') + '][product_option_value][' + product_option_value_row + '][weight]" value="' + $('#modal_option input[name=\'weight\']').val() + '"/></td>';
			html += '  <td class="text-end"><button type="button" data-bs-toggle="tooltip" title="{{lang('Admin.button_edit')}}" data-product_option_row="' + $(element).data('product_option_row') + '" data-product_option_value_row="' + product_option_value_row + '"class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></button> <button type="button" onclick="$(\'#product_option_value_row_' + product_option_value_row + '\').remove();" data-bs-toggle="tooltip" rel="tooltip" title="{{lang('Admin.button_remove')}}" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button></td>';
			html += '</tr>';

			if ($(element).attr('data-product_option_value_row')) {
				$('#product_option_value_row_' + product_option_value_row).replaceWith(html);
			} else {
				$('#product_option_value_' + $(element).data('product_option_row')).append(html);
				$('#product_option_value_row').val(product_option_value_row);
			}
			$('#modal_option').modal('hide');
		});
	});

	function selectOption(item)
	{
		var product_option_row = $('#product_option_row').val();
		product_option_row = parseInt(product_option_row) + 1;
		$('#product_option_row').val(product_option_row);

		html  = '<div id="product_option_row_' + product_option_row + '" class="mb-4">';
		html += '	<legend class="float-none text-dark border-bottom pb-1 mt-2 mb-3">' + item.name;
		html += '		<button type="button" class="btn btn-danger btn-xs float-end" onclick="$(\'#product_option_row_' + product_option_row + '\').remove();"><i class="fas fa-trash-alt"></i></button>';
		html += '	</legend>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][product_option_id]" value=""/>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][name]" value="' + item.name + '"/>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][option_id]" value="' + item.option_id + '"/>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][type]" value="' + item.type + '"/>';


		html += '  <div class="row mb-3">';
		html += '    <label for="input_required_' + product_option_row + '" class="col-sm-2 col-form-label text-end">{{lang('ProductAdmin.text_required')}}</label>';
		html += '	   <div class="col-sm-10"><select name="product_option[' + product_option_row + '][required]" id="input_required_' + product_option_row + '" class="form-select form-select-sm">';
		html += '	     <option value="1">{{lang('Admin.text_yes')}}</option>';
		html += '	     <option value="0">{{lang('Admin.text_no')}}</option>';
		html += '	 </select></div>';
		html += '  </div>';

		if (item.type == 'text') {
			html += '<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label text-end">{{lang('ProductAdmin.text_option_value')}}</label>';
			html +=	'	<div class="col-sm-10">';
			html += '		<input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="{{lang('ProductAdmin.text_option_value')}}" id="product_option_' + product_option_row + '_value" class="form-control"/>';
			html +=	'	</div>';
			html +=	'</div>';
		}

		if (item.type == 'textarea') {
			html += '<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label text-end">{{lang('ProductAdmin.text_option_value')}}</label>';
			html +=	'	<div class="col-sm-10">';
			html +=	'		<textarea name="product_option[' + product_option_row + '][value]" rows="5" placeholder="{{lang('ProductAdmin.text_option_value')}}" id="product_option_' + product_option_row + '_value" class="form-control"></textarea>';
			html += '	</div>';
			html +=	'</div>';
		}

		if (item.type == 'file') {
			html +=	'<div class="row mb-3 d-none">';
			html +=	'	<label for="product_option_' + product_option_row +'_value" class="col-sm-2 col-form-label text-end">{{lang('ProductAdmin.text_option_value')}}</label>';
			html +=	'	<div class="col-sm-10"><input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="{{lang('ProductAdmin.text_option_value')}}" id="product_option_' + product_option_row + '_value" class="form-control"/></div>';
			html +=	'</div>';
		}

		if (item.type == 'date') {
			html +=	'<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label text-end">{{lang('ProductAdmin.text_option_value')}}</label>';
			html +=	'	<div class="col-sm-10 col-md-4">';
			html +=	'		<div class="input-group">';
			html +=	'			<input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_' + product_option_row + '_value" class="form-control date"/>';
			html +=	'			<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>';
			html +=	'		</div>';
			html +=	'	</div>';
			html +=	'</div>';
		}

		if (item.type == 'time') {
			html +=	'<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label text-end">{{lang('ProductAdmin.text_option_value')}}</label>';
			html +=	'	<div class="col-sm-10 col-md-4">';
			html +=	'		<div class="input-group">';
			html +=	'			<input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="{{lang('ProductAdmin.text_option_value')}}" id="product_option_' + product_option_row + '_value" class="form-control time"/>';
			html +=	'			<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>';
			html +=	'		</div>';
			html +=	'	</div>';
			html +=	'</div>';
		}

		if (item.type == 'datetime') {
			html +=	'<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label text-end">{{lang('ProductAdmin.text_option_value')}}</label>';
			html +=	'	<div class="col-sm-10 col-md-4">';
			html +=	'		<div class="input-group">';
			html +=	'			<input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="{{lang('ProductAdmin.text_option_value')}}" id="product_option_' + product_option_row + '_value" class="form-control datetime"/>';
			html +=	'			<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>';
			html +=	'		</div>';
			html +=	'	</div>';
			html +=	'</div>';
		}

		if (item.type == 'select' || item.type == 'radio' || item.type == 'checkbox' || item.type == 'image') {
			html +=	'<div class="table-responsive">';
			html +=	'	<table class="table table-striped table-hover">';
			html +=	'		<thead>';
			html +=	'			<tr>';
			html +=	'				<th class="text-start">{{lang('ProductAdmin.text_option_value')}}</th>';
			html +=	'				<th class="text-end">{{lang('ProductAdmin.text_quantity')}}</th>';
			html +=	'				<th class="text-start">{{lang('ProductAdmin.text_subtract')}}</th>';
			html +=	'				<th class="text-end">{{lang('ProductAdmin.text_price')}}</th>';
			html +=	'				<th class="text-end">{{lang('ProductAdmin.text_points')}}</th>';
			html +=	'				<th class="text-end">{{lang('ProductAdmin.text_weight')}}</th>';
			html +=	'				<th></th>';
			html +=	'			</tr>';
			html +=	'		</thead>';
			html +=	'	<tbody id="product_option_value_' + product_option_row + '"></tbody>';
			html +=	'	<tfoot>';
			html +=	'		<tr>';
			html +=	'			<td colspan="6"></td>';
			html +=	'			<td class="text-end"><button type="button" data-bs-toggle="tooltip" title="{{lang('ProductAdmin.button_option_value_add')}}" data-product_option_row="' + product_option_row + '" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i></button></td>';
			html +=	'		</tr>';
			html +=	'	</tfoot>';
			html +=	'</table>';
			html +=	'<select id="product_option_values_' + product_option_row + '" class="d-none">';
			$.each( item.option_value_list, function( key, option_value ) {
				html += '<option value="' + option_value.option_value_id + '">' + option_value.name + '</option>';
			});
			html +=	'</select>';
			html +=	'</div>';
		}


		$('#option').append(html);
	}

    {literal}
	$(document).on('change', '#option_select_add', function() {
		if ($(this).val() == 0 || !$(this).val().length) {
			return false;
		}

		$.ajax({
			url: 'options/manage/get_list',
			data: {
				'option_id': $(this).val(),
				[$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
			},
			type:'POST',
			success: function (data) {
				is_product_processing = false;

				var response = JSON.stringify(data);
				response = JSON.parse(response);

				if (response.token) {
					// Update CSRF hash
					$("input[name*='" + csrf_token + "']").val(response.token);
				}

				if (response.status == 'ng') {
					$.notify(response.msg, {'type':'danger'});
					return false;
				}
				selectOption(response.option);
			},
			error: function (xhr, errorType, error) {
				is_product_processing = false;
				$.notify({
							message: xhr.responseJSON.message + " Please reload the page!!!",
							url: window.location.href,
							target: "_self",
						},
						{'type': 'danger'},
				);
			}
		});
	});
	{/literal}
</script>