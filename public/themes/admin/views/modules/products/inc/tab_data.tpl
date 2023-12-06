{strip}

	{form_hidden('tab_type', 'tab_data')}

	<div class="form-group row not-variant">
		<div class="col-12 col-sm-2 col-form-label text-sm-end required-label">{lang('ProductAdmin.text_price')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div class="input-group">
				<span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
				<input type="number" name="price" value="{old('price', $edit_data.price)}" id="input_price" class="form-control">
			</div>
			<div id="error_price" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row not-variant">
		<div class="col-12 col-sm-2 col-form-label text-sm-end required-label">{lang('ProductAdmin.text_quantity')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="quantity" value="{old('quantity', $edit_data.quantity)}" id="input_quantity" min="0" class="form-control">
			<div id="error_quantity" class="invalid-feedback"></div>
		</div>
	</div>

	{if !empty(config_item('is_show_sku'))}
		<div class="form-group row not-variant">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_sku')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="sku" value="{old('sku', $edit_data.sku)}" id="input_sku" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_sku')}</div>
				<div id="error_sku" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

	<div class="form-group row not-variant">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_product_classification')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div id="product_add_variant" class="btn btn-sm btn-warning">{lang('ProductAdmin.text_add_variant')}</div>
			<div class="form-text">{lang('ProductAdmin.help_variant')}</div>
		</div>
	</div>

	{$product_variant_option_row = 0}
	{$product_variant_option_value_row = 0}

	<div class="product-variant-content">

		<div id="product_variant_option" style="display: none;">
{*			<div class="border-bottom lead pb-1 my-3 fw-bold">{lang('ProductAdmin.text_product_classification')}</div>*}

			<div class="product-variant-option-group">

			</div>

			<div id="product_add_variant_option_group" class="rounded bg-light p-3 mb-3">
				<div class="btn btn-sm btn-warning">{lang('ProductAdmin.text_add_variant_group')}</div>
			</div>

			<div id="product_variant_option_info" class="variant-list">

				<div class="table-responsive">
					<table class="table table-bordered second">
						<thead class="table-light">
							<tr class="table-light text-center" data-variant="{lang('ProductAdmin.text_variant_group')}"
								data-price="{lang('ProductAdmin.text_price')}"
								data-quantity="{lang('ProductAdmin.text_quantity')}"
								data-sku="{lang('ProductAdmin.text_variant_sku')}"
								data-published="{lang('Admin.text_published')}"
							>
								<td>{lang('ProductAdmin.text_variant_group')} 1</td>
								<td>{lang('ProductAdmin.text_variant_group')} 2</td>
								<td>{lang('ProductAdmin.text_price')}</td>
								<td>{lang('ProductAdmin.text_quantity')}</td>
								<td>{lang('ProductAdmin.text_variant_sku')}</td>
								<td>{lang('Admin.text_published')}</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>

{/strip}
