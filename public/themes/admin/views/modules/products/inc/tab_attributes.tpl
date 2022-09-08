{strip}

	{form_hidden('tab_type', 'tab_attributes')}

	<table id="product_attribute_list" class="table table-bordered table-hover">
		<thead>
		<tr>
			<th class="text-start">{lang('ProductAdmin.text_attribute')}</th>
			<th class="text-start">{lang('ProductAdmin.text_text')}</th>
			<th width="70"></th>
		</tr>
		</thead>
		<tbody>
		{if !empty($edit_data.product_attribute_list)}
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
