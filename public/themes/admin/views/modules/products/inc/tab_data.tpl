{strip}

	{form_hidden('tab_type', 'tab_data')}

	{$product_variant_option_row = 0}
	{$product_variant_option_value_row = 0}

	<div class="border-bottom lead mx-3 pb-1 my-3 fw-bold">{lang('ProductAdmin.text_price')}</div>

	<div class="product-variant-content">
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_product_classification')}</div>
			<div class="col-12 col-sm-10 col-lg-10">

				<div id="product_add_variant" class="btn btn-sm btn-warning">{lang('ProductAdmin.text_add_variant')}</div>

				<div id="product_variant_option" style="display: none;">
					<div class="product-variant-option-group">
						{*
						{include file=get_theme_path('views/modules/products/inc/variant_form.tpl')
						vf_variant_option_row=$product_variant_option_row
						vf_variant_option_value_row=$product_variant_option_value_row
						data_variant_option=[]
						}
						*}
					</div>

{*					<div id="product_variant_option_row_{$product_variant_option_row}" class="product-variant-option rounded bg-light p-3"></div>*}
					<div id="product_add_variant_option_group" class="btn btn-sm btn-warning">{lang('ProductAdmin.text_add_variant')}</div>

					<div id="product_variant_option_info" class="variant-list">

{*						<div class="table-responsive">*}
							<table class="table table-bordered second">
								<thead class="table-light">
									<tr class="table-light text-center" data-variant="{lang('ProductAdmin.text_variant_name')}"
										data-price="{lang('ProductAdmin.text_price')}"
										data-quantity="{lang('ProductAdmin.text_quantity')}"
										data-sku="{lang('ProductAdmin.text_variant_sku')}"
									>
									</tr>
								</thead>
								<tbody>
{*								<tr id="product_variant_option_info_row_1_1">*}
{*								</tr>*}
								</tbody>
							</table>
{*						</div>*}
					</div>
				</div>



				<div id="product_variant_list" class="variant-list">

					<div class="table-responsive">
						<table class="table table-bordered second">
							<thead class="table-light">
								<tr class="table-light text-center">
									<td>Mau</td>
									<td>Size</td>
									<td>{lang('ProductAdmin.text_price')}</td>
									<td>{lang('ProductAdmin.text_quantity')}</td>
									<td>{lang('ProductAdmin.text_variant_sku')}</td>
								</tr>
							</thead>
							<tbody>
							<tr id="variant_option_1_1">
								<td>Vàng</td>
								<td>M</td>

								<td><input type="text" name="price" value="{old('price', $edit_data.price)|number_format:$currency.decimal_place}" id="input_price" class="form-control"></td>
								<td><input type="text" name="price" value="{old('price', $edit_data.price)|number_format:$currency.decimal_place}" id="input_price" class="form-control"></td>
								<td><input type="text" name="price" value="{old('price', $edit_data.price)|number_format:$currency.decimal_place}" id="input_price" class="form-control"></td>
							</tr>
							<tr id="variant_option_1_2">
								<td>Vàng</td>
								<td>L</td>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
							</tr>
							<tr id="variant_option_1_3">
								<td>Vàng</td>
								<td>XL</td>
								<td>3</td>
								<td>Larry the Bird</td>
								<td>@twitter</td>
							</tr>

							<tr>
								<td rowspan="3">DDor</td>
								<td>M</td>

								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
							</tr>
							<tr>
								<td>L</td>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
							</tr>
							<tr>
								<td>XL</td>
								<td>3</td>
								<td>Larry the Bird</td>
								<td>@twitter</td>
							</tr>
							</tbody>
						</table>



						<table id="table1" style="background-color: Lime" class="displayTable">
							<caption>Table 1</caption>
							<thead>
							<tr>
								<th>One</th>
								<th>Two</th>
								<th>Three</th>
							</tr>
							</thead>
							<tbody>
							<tr id="row1">
								<td>R1 C1</td>
								<td>R1 C2</td>
								<td>
									<a href="#" id="row1Link" class="rowLink">Move Me</a> |
									<a href="#" id="row1Up" class="rowUp">Up</a> |
									<a href="#" id="row1Down" class="rowDown">Down</a>
								</td>
							</tr>
							<tr id="row2">
								<td>R2 C1</td>
								<td>R2 C2</td>
								<td>
									<a href="#" id="row2Link" class="rowLink">Move Me</a> |
									<a href="#" id="row2Up" class="rowUp">Up</a> |
									<a href="#" id="row2Down" class="rowDown">Down</a>
								</td>
							</tr>
							<tr id="row3">
								<td>R3 C1</td>
								<td>R3 C2</td>
								<td>
									<a href="#" id="row3Link" class="rowLink">Move Me</a> |
									<a href="#" id="row3Up" class="rowUp">Up</a> |
									<a href="#" id="row3Down" class="rowDown">Down</a>
								</td>
							</tr>
							</tbody>
						</table>
						<table id="table2" style="background-color: Yellow; margin-top: 30px;" class="displayTable">
							<caption>Table 2</caption>
							<thead>
							<tr>
								<th>One</th>
								<th>Two</th>
								<th>Three</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>



					</div>


				</div>

			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_price')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div class="input-group">
				{if !empty($currency.symbol_left)}<span class="input-group-text">{$currency.symbol_left}</span>{/if}
				<input type="text" name="price" value="{old('price', $edit_data.price)|number_format:$currency.decimal_place}" id="input_price" class="form-control">
				{if !empty($currency.symbol_right)}<span class="input-group-text">{$currency.symbol_right}</span>{/if}
			</div>
			<div id="error_price" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_quantity')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="quantity" value="{old('quantity', $edit_data.quantity)}" id="input_quantity" min="0" class="form-control">
			<div id="error_quantity" class="invalid-feedback"></div>
		</div>
	</div>

		{if !empty(config_item('is_show_sku'))}
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_sku')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="sku" value="{old('sku', $edit_data.sku)}" id="input_sku" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_sku')}</div>
				<div id="error_sku" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

	{if !empty(config_item('is_show_model'))}
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_model')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="model" value="{old('model', $edit_data.model)}" id="input_model" class="form-control">
				<div id="error_model" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

	{if !empty(config_item('is_show_upc'))}
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_upc')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="upc" value="{old('upc', $edit_data.upc)}" id="input_upc" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_upc')}</div>
				<div id="error_upc" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

	{if !empty(config_item('is_show_ean'))}
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_ean')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="ean" value="{old('ean', $edit_data.ean)}" id="input_ean" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_ean')}</div>
				<div id="error_ean" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

	{if !empty(config_item('is_show_jan'))}
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_jan')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="jan" value="{old('jan', $edit_data.jan)}" id="input_jan" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_jan')}</div>
				<div id="error_jan" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

	{if !empty(config_item('is_show_isbn'))}
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_isbn')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="isbn" value="{old('isbn', $edit_data.isbn)}" id="input_isbn" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_isbn')}</div>
				<div id="error_isbn" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

	{if !empty(config_item('is_show_mpn'))}
		<div class="form-group row">
			<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_mpn')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<input type="text" name="mpn" value="{old('mpn', $edit_data.mpn)}" id="input_mpn" class="form-control">
				<div class="form-text">{lang('ProductAdmin.help_mpn')}</div>
				<div id="error_mpn" class="invalid-feedback"></div>
			</div>
		</div>
	{/if}

{/strip}

<input type="hidden" name="product_variant_option_row" id="product_variant_option_row" value="{$product_variant_option_row}">
<input type="hidden" name="product_variant_option_value_row" id="product_variant_option_value_row" value="{$product_variant_option_value_row}">
