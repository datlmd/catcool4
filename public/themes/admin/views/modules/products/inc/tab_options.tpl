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


	<table id="product_attribute_list" class="table table-bordered table-hover">
		<thead>
		<tr>
			<th class="text-start">{lang('ProductAdmin.text_attribute')}</th>
			<th class="text-start">{lang('ProductAdmin.text_text')}</th>
			<th width="70"></th>
		</tr>
		</thead>
		<tbody>
		{if !empty($edit_data.product_option_list)}
			{counter assign=product_attribute_row start=1 print=false}

			{foreach $edit_data.product_attribute_list as $attribute_data}
				<tr id="product_attribute_row_{$product_attribute_row}">
					<td class="text-start">

						<select name="product_attribute[{$product_attribute_row}][attribute_id]" id="input_product_attribute_{$product_attribute_row}_attribute_id" class="form-control form-control-sm">
							{foreach $attribute_list as $attribute}
								<option value="{$attribute.attribute_id}" {if old("product_attribute[{$product_attribute_row}][attribute_id]", $attribute_data.attribute_id) eq $attribute.attribute_id}selected="selected"{/if}>{$attribute.name}</option>
							{/foreach}
						</select>
						<div id="error_product_attribute_{$product_attribute_row}_attribute_id" class="invalid-feedback"></div>

					</td>
					<td class="text-start">


						{foreach $language_list as $language}
							<div class="input-group {if !$language@last}mb-2{/if}">
								<span class="input-group-text">{$language.icon}</span>
								<textarea type="textarea" name="product_attribute[{$product_attribute_row}][lang][{$language.id}][text]" id="input_product_attribute_{$product_attribute_row}_lang_{$language.id}_text" cols="40" rows="2" class="form-control">{old("product_attribute[{$product_attribute_row}][lang][{$language.id}][text]", $attribute_data.lang[$language.id].text)}</textarea>
								<div id="error_product_attribute_{$product_attribute_row}_lang_{$language.id}_text" class="invalid-feedback"></div>
							</div>
						{/foreach}

					</td>
					<td class="text-end">
						<button type="button" onclick="$('#product_attribute_row_{$product_attribute_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
					</td>
				</tr>

				{counter}

			{/foreach}
		{/if}

		</tbody>
		<tfoot>
		<tr>
			<td colspan="2"></td>
			<td class="text-center"><button type="button" onclick="addProductAttribute();" data-bs-toggle="tooltip" title="{lang('ProductAdmin.text_attribute_add')}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button></td>
		</tr>
		</tfoot>
	</table>

{/strip}
