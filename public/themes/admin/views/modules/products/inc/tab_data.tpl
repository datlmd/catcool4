{strip}

	{form_hidden('tab_type', 'tab_data')}

	<input type="hidden" name="is_variant" id="is_variant" value="{if !empty($edit_data.product_variant_list)}1{else}0{/if}">

	{* not-variant *}
	<div class="form-group row not-variant" {if !empty($edit_data.product_variant_list)}style="display: none;"{/if}>
		<div class="col-12 col-sm-2 col-form-label text-sm-end required-label">{lang('ProductAdmin.text_price')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div class="input-group">
				<span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
				<input type="text" data-type="currency" name="price" value="{old('price', show_currency_system($edit_data.price))}" id="input_price" class="form-control">
			</div>
			<div id="error_price" class="invalid-feedback"></div>
		</div>
	</div>
	{* not-variant *}
	<div class="form-group row not-variant" {if !empty($edit_data.product_variant_list)}style="display: none;"{/if}>
		<div class="col-12 col-sm-2 col-form-label text-sm-end required-label">{lang('ProductAdmin.text_quantity')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="quantity" value="{old('quantity', $edit_data.quantity)}" id="input_quantity" min="0" class="form-control">
			<div id="error_quantity" class="invalid-feedback"></div>
		</div>
	</div>
	{* not-variant *}
	{if !empty(config_item('is_show_sku'))}
		<div class="form-group row not-variant" {if !empty($edit_data.product_variant_list)}style="display: none;"{/if}>
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_sku')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="sku" value="{old('sku', $edit_data.sku)}" id="input_sku" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_sku')}</div>
				<div id="error_sku" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}
	{* not-variant *}
	<div class="form-group row not-variant" {if !empty($edit_data.product_variant_list)}style="display: none;"{/if}>
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_product_classification')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div id="product_add_variant" class="btn btn-sm btn-warning">{lang('ProductAdmin.text_add_variant')}</div>
			<div class="form-text">{lang('ProductAdmin.help_variant')}</div>
		</div>
	</div>



	{* ----- Variant ----- *}

	{$product_variant_row = 0}
	{$product_variant_value_row = 0}

	<div class="product-variant-content">

		<div id="product_variant" style="{if empty($edit_data.product_variant_list)}display: none;{/if}">
{*			<div class="border-bottom lead pb-1 my-3 fw-bold">{lang('ProductAdmin.text_product_classification')}</div>*}

			<div class="product-variant-group">
				{if !empty($edit_data.product_variant_list)}
					{foreach $edit_data.product_variant_list as $variant}
						{if !empty($variant.value_list)}
							{$product_variant_value_row = $product_variant_value_row + count($variant.value_list)}
							{include file=get_theme_path('views/modules/products/inc/variant_form.tpl')
								vf_variant_row=$variant.variant_id
								data_variant=$variant
								variant_index = $variant@index
							}
						{/if}
					{/foreach}
				{/if}
			</div>

			<div id="product_add_variant_group" class="rounded bg-light p-3 mb-3">
				<div class="btn btn-sm btn-warning">{lang('ProductAdmin.text_add_variant_group')}</div>
			</div>

			<div id="product_variant_info" class="variant-list">

				<h5 class="mb-2">{lang('ProductAdmin.text_variant_list')}</h5>
				<div class="row mb-3">
					<div class="col-12 col-sm-3 pb-1">
						<div class="input-group">
							<span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
							<input type="text" min="0" data-type="currency" name="product_variant_combination_price_all" value="" id="input_product_variant_combination_price_all" class="form-control show-currency" placeholder="{lang('ProductAdmin.text_price')}">
						</div>
					</div>
					<div class="col-12 col-sm-3 pb-1">
						<input type="number" min="0" name="product_variant_combination_quantity_all" value="" id="input_product_variant_combination_quantity_all" class="form-control" placeholder="{lang('ProductAdmin.text_quantity')}">
					</div>
					<div class="col-12 col-sm-3 pb-1">
						<input type="text" name="product_variant_combination_sku_all" value="" id="input_product_variant_combination_sku_all" class="form-control" placeholder="{lang('ProductAdmin.text_variant_sku')}">
					</div>
					<div class="col-12 col-sm-3 text-sm-end">
						<div class="btn btn-sm btn-primary w-100 btn-variant-update-bulk">{lang('ProductAdmin.text_variant_update_bulk')}</div>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table table-hover second">
						<thead class="table-light">
							<tr class="table-light text-center" data-variant="{lang('ProductAdmin.text_variant_group')}"
								data-price="{lang('ProductAdmin.text_price')}"
								data-quantity="{lang('ProductAdmin.text_quantity')}"
								data-sku="{lang('ProductAdmin.text_variant_sku')}"
								data-published="{lang('Admin.text_published')}"
							>
								{if !empty($edit_data.product_variant_list)}
									{foreach $edit_data.product_variant_list as $variant}
										<td id="td_input_product_variant_{$variant.variant_row}_variant_id" class="variant-name">
											{$variant.name}
										</td>
									{/foreach}
									<td>{lang('ProductAdmin.text_price')}</td>
									<td>{lang('ProductAdmin.text_quantity')}</td>
									<td>{lang('ProductAdmin.text_variant_sku')}</td>
									<td>{lang('Admin.text_published')}</td>
								{/if}
							</tr>
						</thead>
						<tbody class="table-group-divider">
							{if !empty($edit_data.product_variant_list)}

								{if !empty($edit_data.product_sku_list)}
									{foreach $edit_data.product_sku_list as $product_sku_info}
										{if empty($product_sku_info.sku_value_list)}
											{continue}
										{/if}

										<tr id="{$product_sku_info.variant_combination_sku_name}">
											{foreach $product_sku_info.sku_value_list as $product_sku_value_info}
												<td data-variant-name="{sprintf('row_%s_name', $product_sku_value_info.variant_value_id)}" class="variant-name text-center">
													{$edit_data.product_variant_list[$product_sku_value_info.variant_id]['value_list'][$product_sku_value_info.variant_value_id].name}
												</td>
											{/foreach}

											{include file=get_theme_path('views/modules/products/inc/variant_sku_form.tpl')
												product_variant_combination_attr_id='id'
												product_variant_combination_row_id=$product_sku_info.variant_combination_sku_name
												product_variant_combination=$product_sku_info
											}
										</tr>
									{/foreach}

								{/if}

							{/if}
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<input type="hidden" name="product_variant_row" id="product_variant_row" value="{$edit_data.product_variant_list|count|default:0}">
		<input type="hidden" name="product_variant_value_row" id="product_variant_value_row" value="{$product_variant_value_row|default:0}">

		<input type="hidden" name="product_variant_combination_sku_name" id="product_variant_combination_sku_name" value="{PRODUCT_VARIANT_COMBINATION_SKU_NAME}">

	</div>

{/strip}
