{strip}

	{form_hidden('tab_type', 'tab_data')}

	{if empty($edit_data.product_variant_option_list)}
		<div class="form-group row not-variant">
			<div class="col-12 col-sm-2 col-form-label text-sm-end required-label">{lang('ProductAdmin.text_price')}</div>
			<div class="col-12 col-sm-10 col-lg-10">
				<div class="input-group">
					<span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
					<input type="number" step="0.01" name="price" value="{old('price', $edit_data.price)}" id="input_price" class="form-control">
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
	{/if}

	{$product_variant_option_row = 0}
	{$product_variant_option_value_row = 0}

	<div class="product-variant-content">

		<div id="product_variant_option" style="{if empty($edit_data.product_variant_option_list)}display: none;{/if}">
{*			<div class="border-bottom lead pb-1 my-3 fw-bold">{lang('ProductAdmin.text_product_classification')}</div>*}

			<div class="product-variant-option-group">
				{if !empty($edit_data.product_variant_option_list)}
					{foreach $edit_data.product_variant_option_list as $variant_option}
						{include file=get_theme_path('views/modules/products/inc/variant_option_form.tpl')
							vf_variant_option_row=$variant_option.option_id
							data_variant_option=$variant_option
						}
					{/foreach}
				{/if}
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
								{if !empty($edit_data.product_variant_option_list)}
									{foreach $edit_data.product_variant_option_list as $variant_option}
										<td id="td_input_product_variant_option_{$variant_option.product_id}_{$variant_option.option_id}_option_id" class="variant-name">
											{$variant_option.name}
										</td>
									{/foreach}
									<td>{lang('ProductAdmin.text_price')}</td>
									<td>{lang('ProductAdmin.text_quantity')}</td>
									<td>{lang('ProductAdmin.text_variant_sku')}</td>
									<td>{lang('Admin.text_published')}</td>
								{/if}
							</tr>
						</thead>
						<tbody>
							{if !empty($edit_data.product_variant_option_list)}
								{foreach $edit_data.product_variant_option_list as $variant_option_1}
									{foreach $variant_option_1.option_value_list as $variant_option_value_1}
										{if $edit_data.product_variant_option_list|count eq 3}

										{elseif $edit_data.product_variant_option_list|count eq 2}
											{foreach $edit_data.product_variant_option_list as $variant_option_2}
												{if $variant_option_1.option_id eq $variant_option_2.option_id}
													{continue}
												{/if}
												{foreach $variant_option_2.option_value_list as $variant_option_value_2}

													{$variant_option_info_row_id = sprintf('variant_option_info_row_%s_%s', sprintf($variant_option_row_name, $variant_option_value_1.option_value_id), sprintf($variant_option_row_name, $variant_option_value_2.option_value_id))}
													{$variant_option_name_row_1 = sprintf('row_%s_name', $variant_option_value_1.option_value_id)}
													{$variant_option_name_row_2 = sprintf('row_%s_name', $variant_option_value_2.option_value_id)}

													{$create_variant_key = create_variant_key($variant_option_1.product_id, [$variant_option_value_1.option_value_id, $variant_option_value_2.option_value_id])}

													<tr id="{$variant_option_info_row_id}">

														{if $variant_option_value_2@index eq 0}
															<td data-option-name="{$variant_option_name_row_1}" rowspan="{$variant_option_2.option_value_list|count}" class="variant-name">
																{$variant_option_value_1.name}
															</td>
														{/if}
														<td data-option-name="{$variant_option_name_row_2}" class="variant-name">
															{$variant_option_value_2.name}
														</td>
														<td id="{$variant_option_info_row_id}_price">
															<div class="input-group">
																<span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
																<input type="text" name="product_variant_combination[{$variant_option_info_row_id}][price]" value="{$edit_data.product_sku_list[$create_variant_key].price}" id="input_product_variant_combination_{$variant_option_info_row_id}_price" class="form-control">
															</div>
															<div id="error_product_variant_combination_{$variant_option_info_row_id}_price" class="invalid-feedback"></div>
														</td>
														<td id="{$variant_option_info_row_id}_quantity">
															<input type="number" min="0" name="product_variant_combination[{$variant_option_info_row_id}][quantity]" value="{$edit_data.product_sku_list[$create_variant_key].quantity}" id="input_product_variant_combination_{$variant_option_info_row_id}_quantity" class="form-control">
															<div id="error_product_variant_combination_{$variant_option_info_row_id}_quantity" class="invalid-feedback"></div>
														</td>
														<td id="{$variant_option_info_row_id}_sku">
															<input type="text" name="product_variant_combination[{$variant_option_info_row_id}][sku]" value="{$edit_data.product_sku_list[$create_variant_key].sku}" id="input_product_variant_combination_{$variant_option_info_row_id}_sku" class="form-control">
															<div id="error_product_variant_combination_{$variant_option_info_row_id}_sku" class="invalid-feedback"></div>
														</td>
														<td id="{$variant_option_info_row_id}_published">
															<div class="switch-button switch-button-xs catcool-center">
																{form_checkbox("product_variant_combination[{$variant_option_info_row_id}][published]", true, $edit_data.product_sku_list[$create_variant_key].published|default:true, ['id' => "input_product_variant_combination_{$variant_option_info_row_id}_published"])}
																<span><label for="input_product_variant_combination_{$variant_option_info_row_id}_published"></label></span>
															</div>
														</td>
													</tr>
												{/foreach}
											{/foreach}
										{else}
											{$variant_option_info_row_id = sprintf('variant_option_info_row_%s', sprintf($variant_option_row_name, $variant_option_value_1.option_value_id))}
											{$variant_option_name_row = sprintf('row_%s_name', $variant_option_value_1.option_value_id)}
											{$create_variant_key = create_variant_key($variant_option_1.product_id, [$variant_option_value_1.option_value_id])}

											<input type="hidden" name="product_variant_combination[{$variant_option_info_row_id}][product_sku_id]" value="{$edit_data.product_sku_list[$create_variant_key].product_sku_id}">

											<tr id="{$variant_option_info_row_id}">

												<td data-option-name="{$variant_option_name_row}" class="variant-name">
													{$variant_option_value_1.name}
												</td>

												<td id="{$variant_option_info_row_id}_price">
													<div class="input-group">
														<span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
														<input type="number" step="0.01" name="product_variant_combination[{$variant_option_info_row_id}][price]" value="{old("product_variant_combination[{$variant_option_info_row_id}][price]", $edit_data.product_sku_list[$create_variant_key].price)}" id="input_product_variant_combination_{$variant_option_info_row_id}_price" class="form-control">
													</div>
													<div id="error_product_variant_combination_{$variant_option_info_row_id}_price" class="invalid-feedback"></div>
												</td>

												<td id="{$variant_option_info_row_id}_quantity">
													<input type="number" min="0" name="product_variant_combination[{$variant_option_info_row_id}][quantity]" value="{old("product_variant_combination[{$variant_option_info_row_id}][quantity]", $edit_data.product_sku_list[$create_variant_key].quantity)}" id="input_product_variant_combination_{$variant_option_info_row_id}_quantity" class="form-control">
													<div id="error_product_variant_combination_{$variant_option_info_row_id}_quantity" class="invalid-feedback"></div>
												</td>

												<td id="{$variant_option_info_row_id}_sku">
													<input type="text" name="product_variant_combination[{$variant_option_info_row_id}][sku]" value="{old("product_variant_combination[{$variant_option_info_row_id}][sku]", $edit_data.product_sku_list[$create_variant_key].sku)}" id="input_product_variant_combination_{$variant_option_info_row_id}_sku" class="form-control">
													<div id="error_product_variant_combination_{$variant_option_info_row_id}_sku" class="invalid-feedback"></div>
												</td>

												<td id="{$variant_option_info_row_id}_published">
													<div class="switch-button switch-button-xs catcool-center">
														{form_checkbox("product_variant_combination[{$variant_option_info_row_id}][published]", true, $edit_data.product_sku_list[$create_variant_key].published|default:true, ['id' => "input_product_variant_combination_{$variant_option_info_row_id}_published"])}
														<span><label for="input_product_variant_combination_{$variant_option_info_row_id}_published"></label></span>
													</div>
												</td>

											</tr>
										{/if}
									{/foreach}

									{break}
								{/foreach}
							{/if}
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>

{/strip}
