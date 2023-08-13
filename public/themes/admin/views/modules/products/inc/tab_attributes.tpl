{strip}

	{form_hidden('tab_type', 'tab_attributes')}

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_published')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check form-check-inline ms-2">
				<input type="radio" name="published" value="{STATUS_ON}" {if old('published', $edit_data.published)|default:1 eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
				<label class="form-check-label" for="published_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $edit_data.published)|default:1 eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
				<label class="form-check-label" for="published_off">{lang('Admin.text_off')}</label>
			</label>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_is_comment')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check ms-2">
				<input type="radio" name="is_comment" id="is_comment_off" class="form-check-input" value="{COMMENT_STATUS_OFF}" {set_radio('is_comment', COMMENT_STATUS_OFF, ($edit_data.is_comment == COMMENT_STATUS_OFF))}>
				<label class="form-check-label" for="is_comment_off">{lang('Admin.text_comment_status_off')}</label>
			</label>
			<label class="form-check ms-2">
				<input type="radio" name="is_comment" id="is_comment_confirm" class="form-check-input" value="{COMMENT_STATUS_CONFIRM}" {set_radio('is_comment', COMMENT_STATUS_CONFIRM, ($edit_data.is_comment == COMMENT_STATUS_CONFIRM))}>
				<label class="form-check-label" for="is_comment_confirm">{lang('Admin.text_comment_status_confirm')}</label>
			</label>
			<label class="form-check ms-2">
				{if isset($edit_data.is_comment)}
					<input type="radio" name="is_comment" id="is_comment_on" class="form-check-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, ($edit_data.is_comment == COMMENT_STATUS_ON))}>
				{else}
					<input type="radio" name="is_comment" id="is_comment_on" class="form-check-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, true)}>
				{/if}
				<span class="form-check-label" for="is_comment_on">{lang('Admin.text_comment_status_on')}</span>
			</label>
		</div>
	</div>

	<div class="row border-bottom pb-3 mb-3">
		<label for="input_viewed" class="col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_viewed')}</label>
		<div class="col-sm-4">
			<input type="number" name="viewed" value="{old('viewed', $edit_data.viewed)|default:0}" id="input_viewed" min="0" class="form-control">
			<div id="error_viewed" class="invalid-feedback"></div>
		</div>
		<label for="input_sort_order" class="col-sm-2 col-form-label text-sm-end">{lang('Admin.text_sort_order')}</label>
		<div class="col-sm-4">
			<input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="input_sort_order" min="0" class="form-control">
			<div id="error_sort_order" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="row border-bottom pb-3 mb-3">
		<label for="input_manufacturer_id" class="col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_manufacturer')}</label>
		<div class="col-sm-4">
			<select name="manufacturer_id" id="input_manufacturer_id" class="form-select form-select-sm cc-form-select-single" data-placeholder="{lang('Admin.text_select')}">
				<option value="0">{lang('Admin.text_select')}</option>
				{foreach $manufacturer_list as $value}
					<option value="{$value.manufacturer_id}" {if old('manufacturer_id', $edit_data.manufacturer_id) eq $value.manufacturer_id}selected="selected"{/if}>{$value.name}</option>
				{/foreach}
			</select>
			<div id="error_manufacturer_id" class="invalid-feedback"></div>
			<a href="{site_url('manufacturers/manage/add')}" class="link-primary mt-1 d-block">{lang('ProductAdmin.text_manufacturer_add')}</a>
		</div>
		<label for="input_category_ids" class="col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_category')}</label>
		<div class="col-sm-4">
			{$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
			<select name="category_ids[]" id="input_category_ids[]" class="form-select form-select-sm cc-form-select-multi" multiple="multiple" data-placeholder="{lang('Admin.text_select')}">
				{draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, old('category_ids', $edit_data.category_ids))}
			</select>
			<a href="{site_url('products/categories/manage/add')}" class="link-primary mt-1 d-block">{lang('ProductAdmin.text_category_add')}</a>
		</div>
	</div>

	{counter assign=product_attribute_row start=0 print=false}
	<div class="row border-bottom pb-3 mb-3">
		{foreach $attribute_default_list as $attribute}

			{if $attribute@index > 0 && $attribute@index % 2 == 0}
				</div>
				<div class="row {if !$attribute@last}border-bottom pb-3{/if} mb-3">
			{/if}
			<label class="col-sm-2 col-form-label text-sm-end">{$attribute.name}</label>
			<div class="col-sm-4 text-end">
				<input type="hidden" name="product_attribute[{$product_attribute_row}][attribute_id]" value="{$attribute.attribute_id}">
				{foreach $language_list as $language}
					<div class="input-group {if !$language@last}mb-2{/if}">
						<span class="input-group-text">{$language.icon}</span>
						<input type="text" name="product_attribute[{$product_attribute_row}][lang][{$language.id}][text]" id="input_product_attribute_{$product_attribute_row}_lang_{$language.id}_text" class="form-control" value="{old("product_attribute[{$product_attribute_row}][lang][{$language.id}][text]", $edit_data.product_attribute_list[$attribute.attribute_id].lang[$language.id].text)}" >
					</div>
					<div id="error_product_attribute_{$product_attribute_row}_lang_{$language.id}_text" class="invalid-feedback"></div>
				{/foreach}
			</div>

			{counter}

		{/foreach}
	</div>

	<div class="border-bottom lead pb-1 my-3 fw-bold">{lang('ProductAdmin.text_attribute_add_title')}</div>
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

			{foreach $edit_data.product_attribute_list as $attribute_data}
				{if isset($attribute_default_list[$attribute_data.attribute_id])}
					{continue}
				{/if}

				<tr id="product_attribute_row_{$product_attribute_row}">
					<td class="text-start">

						<select name="product_attribute[{$product_attribute_row}][attribute_id]" id="input_product_attribute_{$product_attribute_row}_attribute_id" class="form-control form-control-sm">
							{foreach $attribute_list as $attribute}
								{if isset($attribute_default_list[$attribute.attribute_id])}
									{continue}
								{/if}
								<option value="{$attribute.attribute_id}" {if old("product_attribute[{$product_attribute_row}][attribute_id]", $attribute_data.attribute_id) eq $attribute.attribute_id}selected="selected"{/if}>{$attribute.name}</option>
							{/foreach}
						</select>
						<div id="error_product_attribute_{$product_attribute_row}_attribute_id" class="invalid-feedback"></div>

					</td>
					<td class="text-start">


						{foreach $language_list as $language}
							<div class="input-group {if !$language@last}mb-2{/if}">
								<span class="input-group-text">{$language.icon}</span>
								<input type="text" name="product_attribute[{$product_attribute_row}][lang][{$language.id}][text]" id="input_product_attribute_{$product_attribute_row}_lang_{$language.id}_text" class="form-control" value='{old("product_attribute[{$product_attribute_row}][lang][{$language.id}][text]", $attribute_data.lang[$language.id].text)}' >
							</div>
							<div id="error_product_attribute_{$product_attribute_row}_lang_{$language.id}_text" class="invalid-feedback"></div>
						{/foreach}

					</td>
					<td class="text-center">
						<button type="button" onclick="$('#product_attribute_row_{$product_attribute_row}').remove();" class="btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
					</td>
				</tr>

				{counter}

			{/foreach}
		{/if}

		</tbody>
		<tfoot>
		<tr>
			<td colspan="2"></td>
			<td class="text-center"><button type="button" onclick="addProductAttribute();" data-bs-toggle="tooltip" title="{lang('ProductAdmin.text_attribute_add')}" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i></button></td>
		</tr>
		</tfoot>
	</table>

	<div class="d-none" id="product_attribute_row" data-value="{$product_attribute_row}"></div>
{/strip}
