{strip}

	{form_hidden('tab_type', 'tab_attributes')}

	{if !empty($edit_data.product_option_list)}
		{counter assign=product_option_row start=1 print=false}
		{counter assign=product_option_value_row start=1 print=false}

		{foreach $edit_data.product_option_list as $product_option_data}
			<div id="product_option_row_{$product_option_row}">
				<legend class="float-none">
					{$product_option_data.name}
					<button type="button" class="btn btn-danger btn-sm float-end" onclick="$('#product_option_row_{$product_option_row}').remove();">
						<i class="fa-solid fa-minus-circle"></i>
					</button>
				</legend>
				<input type="hidden" name="product_option[{$product_option_row}][product_option_id]" value="{$product_option_data.product_option_id}"/>
				<input type="hidden" name="product_option[{$product_option_row}][name]" value="{$product_option_data.name}"/>
				<input type="hidden" name="product_option[{$product_option_row}][option_id]" value="{$product_option_data.option_id}"/>
				<input type="hidden" name="product_option[{$product_option_row}][type]" value="{$product_option_data.type}"/>

				{if $product_option_data.type == 'text'}
					<div class="row mb-3">
						<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label">{lang('ProductAdmin.text_option_value')}</label>
						<div class="col-sm-10">
							<input type="text" name="product_option[{$product_option_row}][value]" value="{$product_option_data.value}" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control"/>
						</div>
					</div>
				{/if}

				{if $product_option_data.type == 'textarea'}
					<div class="row mb-3">
						<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label">{lang('ProductAdmin.text_option_value')}</label>
						<div class="col-sm-10">
							<textarea name="product_option[{$product_option_row}][value]" rows="5" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control">{$product_option_data.value}</textarea>
						</div>
					</div>
				{/if}

				{if $product_option_data.type == 'file'}
					<div class="row mb-3 d-none">
						<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label">{lang('ProductAdmin.text_option_value')}</label>
						<div class="col-sm-10"><input type="text" name="product_option[{$product_option_row}][value]" value="{$product_option_data.value}" placeholder="{lang('ProductAdmin.text_option_value')}" id="product_option_{$product_option_row}_value" class="form-control"/></div>
					</div>
				{/if}

				{if $product_option_data.type == 'date'}
					<div class="row mb-3">
						<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label">{lang('ProductAdmin.text_option_value')}</label>
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
						<label for="product_option_{$product_option_row}_value" class="col-sm-2 col-form-label">{lang('ProductAdmin.text_option_value')}</label>
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
						<table class="table table-bordered table-hover">
							<thead>
							<tr>
								<td class="text-start">{lang('ProductAdmin.text_option_value')}</td>
								<td class="text-end">{lang('ProductAdmin.text_quantity')}</td>
								<td class="text-start">{lang('ProductAdmin.text_subtract')}</td>
								<td class="text-end">{lang('ProductAdmin.text_price')}</td>
								<td class="text-end">{lang('ProductAdmin.text_points')}</td>
								<td class="text-end">{lang('ProductAdmin.text_weight')}</td>
								<td></td>
							</tr>
							</thead>
							<tbody id="product_option_value_{$product_option_row}">
							{foreach $product_option_data.product_option_value_list as $product_option_value}
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
										<button type="button" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}" data-option-row="{$product_option_row}" data-option-value-row="{$product_option_value_row}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
										<button type="button" onclick="$('#option-value-row-{$product_option_value_row}').remove();" data-bs-toggle="tooltip" title="{lang('Admin.button_remove')}" class="btn btn-danger"><i class="fa-solid fa-minus-circle"></i></button>
									</td>
								</tr>
							{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="6"></td>
									<td class="text-end"><button type="button" data-bs-toggle="tooltip" title="{lang('Admin.button_option_value_add')}" data-option-row="{$product_option_row}" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i></button>
									</td>
								</tr>
							</tfoot>
						</table>
						<select id="product-option-values-{$product_option_row}" class="d-none">
							<option value="{$option_value.option_value_id}">{$option_value.name}</option>
						</select>
					</div>
				{/if}

			</div>
			{counter}
		{/foreach}
	{/if}
	<fieldset>
		<legend class="float-none">{lang('ProductAdmin.text_option_add')}</legend>
		<div class="row mb-3">
			<label for="input-option" class="col-sm-2 col-form-label">{lang('ProductAdmin.text_option')}</label>
			<div class="col-sm-10">
				<select name="option" class="form-control form-control-sm">
					<option value="0">{lang('Admin.text_select')}</option>
					{foreach $option_list as $option}
						<option value="{$option.type}">{$option.name}</option>
					{/foreach}
				</select>
				<div class="form-text">{lang('ProductAdmin.help_option')}</div>
			</div>
		</div>
	</fieldset>

	<input type="hidden" name="product_option_row" id="product_option_row" value="{if !empty($edit_data.product_option_list)}{$edit_data.product_option_list|@count}{else}0{/if}">
{/strip}
<script type="text/javascript">
	function selectOption(item)
	{
		var product_option_row = $('#product_option_row').val();

		html  = '<div id="product_option_row_' + product_option_row + '">';
		html += '	<legend class=\"float-none\">' + item.name;
		html += '		<button type="button" class="btn btn-danger btn-sm float-end" onclick="$(\'#product_option_row_' + product_option_row + '\').remove();"><i class="fa-solid fa-minus-circle"></i></button>';
		html += '	</legend>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][product_option_id]" value=""/>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][name]" value="' + item.name + '"/>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][option_id]" value="' + item.option_id + '"/>';
		html += '	<input type="hidden" name="product_option[' + product_option_row + '][type]" value="' + item.type + '"/>';


		if (item.type == 'text') {
			html += '<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label">' + {{lang('ProductAdmin.text_option_value')}} + '</label>';
			html +=	'	<div class="col-sm-10">';
			html += '		<input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="' + {{lang('ProductAdmin.text_option_value')}} + '" id="product_option_' + product_option_row + '_value" class="form-control"/>';
			html +=	'	</div>';
			html +=	'</div>';
		}

		if (item.type == 'textarea') {
			html += '<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label">' + {{lang('ProductAdmin.text_option_value')}} + '</label>';
			html +=	'	<div class="col-sm-10">';
			html +=	'		<textarea name="product_option[' + product_option_row + '][value]" rows="5" placeholder="' + {{lang('ProductAdmin.text_option_value')}} + '" id="product_option_' + product_option_row + '_value" class="form-control"></textarea>';
			html += '	</div>';
			html +=	'</div>';
		}

		if (item.type == 'file') {
			html +=	'<div class="row mb-3 d-none">';
			html +=	'	<label for="product_option_' + product_option_row +'_value" class="col-sm-2 col-form-label">' + {{lang('ProductAdmin.text_option_value')}} + '</label>';
			html +=	'	<div class="col-sm-10"><input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="' + {{lang('ProductAdmin.text_option_value')}} + '" id="product_option_' + product_option_row + '_value" class="form-control"/></div>';
			html +=	'</div>';
		}

		if (item.type == 'date') {
			html +=	'<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label">' + {{lang('ProductAdmin.text_option_value')}} + '</label>';
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
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label">' + {{lang('ProductAdmin.text_option_value')}} + '</label>';
			html +=	'	<div class="col-sm-10 col-md-4">';
			html +=	'		<div class="input-group">';
			html +=	'			<input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="' + {{lang('ProductAdmin.text_option_value')}} + '" id="product_option_' + product_option_row + '_value" class="form-control time"/>';
			html +=	'			<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>';
			html +=	'		</div>';
			html +=	'	</div>';
			html +=	'</div>';
		}

		if (item.type == 'datetime') {
			html +=	'<div class="row mb-3">';
			html +=	'	<label for="product_option_' + product_option_row + '_value" class="col-sm-2 col-form-label">' + {{lang('ProductAdmin.text_option_value')}} + '</label>';
			html +=	'	<div class="col-sm-10 col-md-4">';
			html +=	'		<div class="input-group">';
			html +=	'			<input type="text" name="product_option[' + product_option_row + '][value]" value="" placeholder="' + {{lang('ProductAdmin.text_option_value')}} + '" id="product_option_' + product_option_row + '_value" class="form-control datetime"/>';
			html +=	'			<div class="input-group-text"><i class="fa-regular fa-calendar"></i></div>';
			html +=	'		</div>';
			html +=	'	</div>';
			html +=	'</div>';
		}

		if (item.type == 'select' || item.type == 'radio' || item.type == 'checkbox' || item.type == 'image') {
			html +=	'<div class="table-responsive">';
			html +=	'	<table class="table table-bordered table-hover">';
			html +=	'		<thead>';
			html +=	'			<tr>';
			html +=	'				<td class="text-start">' + {{lang('ProductAdmin.text_option_value')}} + '</td>';
			html +=	'				<td class="text-end">' + {{lang('ProductAdmin.text_quantity')}} + '</td>';
			html +=	'				<td class="text-start">' + {{lang('ProductAdmin.text_subtract')}} + '</td>';
			html +=	'				<td class="text-end">' + {{lang('ProductAdmin.text_price')}} + '</td>';
			html +=	'				<td class="text-end">' + {{lang('ProductAdmin.text_points')}} + '</td>';
			html +=	'				<td class="text-end">' + {{lang('ProductAdmin.text_weight')}} + '</td>';
			html +=	'				<td></td>';
			html +=	'			</tr>';
			html +=	'		</thead>';
			html +=	'	<tbody></tbody>';
			html +=	'	<tfoot>';
			html +=	'		<tr>';
			html +=	'			<td colspan="6"></td>';
			html +=	'			<td class="text-end"><button type="button" data-bs-toggle="tooltip" title="' + {{lang('Admin.button_option_value_add')}} + '" data-option-row="' + product_option_row + '" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i></button></td>';
			html +=	'		</tr>';
			html +=	'	</tfoot>';
			html +=	'</table>';
			html +=	'<select id="product-option-values-{$product_option_row}" class="d-none">';
			html +=	'<option value="{$option_value.option_value_id}">{$option_value.name}</option>;
			html +=	'</select>';
			html +=	'</div>';
		}

		{if $product_option_data.type == 'select' || $product_option_data.type == 'radio' || $product_option_data.type == 'checkbox' || $product_option_data.type == 'image'}

		{/if}

	}

	$(document).on('change', '#option', function(e) {
		{*$.ajax({*}
		{*	url: url_api,*}
		{*	data: {*}
		{*		'id' : id,*}
		{*		'published': is_check,*}
		{*		'data': $(obj).data(),*}
		{*		[$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()*}
		{*	},*}
		{*	type:'POST',*}
		{*	success: function (data) {*}
		{*		is_processing = false;*}

		{*		var response = JSON.stringify(data);*}
		{*		response = JSON.parse(response);*}

		{*		if (response.token) {*}
		{*			// Update CSRF hash*}
		{*			$("input[name*='" + csrf_token + "']").val(response.token);*}
		{*		}*}

		{*		if (response.status == 'ng') {*}
		{*			$.notify(response.msg, {'type':'danger'});*}
		{*			$(obj).prop("checked", $(obj).attr("value"));*}
		{*			return false;*}
		{*		}*}
		{*		$.notify(response.msg);*}
		{*	},*}
		{*	error: function (xhr, errorType, error) {*}
		{*		is_processing = false;*}
		{*		$.notify({*}
		{*					message: xhr.responseJSON.message + " Please reload the page!!!",*}
		{*					url: window.location.href,*}
		{*					target: "_self",*}
		{*				},*}
		{*				{'type': 'danger'},*}
		{*		);*}
		{*	}*}
		{*});*}
	});
</script>