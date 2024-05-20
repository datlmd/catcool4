{strip}
	{if !empty($list)}
		<form id="form_product" method="post" data-cc-toggle="ajax" data-cc-load="{site_url("$manage_url")}" data-cc-target="#product">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered second" style="min-width: 600px">
					<thead>
					<tr class="text-center">
						<th width="50">{form_checkbox('manage_check_all')}</th>
						<th width="60">
							<a href="{site_url($manage_url)}?sort=product_id&order={$order}{$url}" class="text-dark">
								{lang('Admin.column_id')}
								{if $sort eq 'product_id'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th width="100" style="min-width: 80px">{lang('Admin.text_image')}</th>
						<th class="text-start" style="min-width: 200px">
							<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
								{lang('ProductAdmin.text_name')}
								{if $sort eq 'name'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>

						<th width="120">{lang('ProductAdmin.text_sku')}</th>
						<th width="110">{lang('ProductAdmin.text_quantity')}</th>
						<th width="110">{lang('ProductAdmin.text_price')}</th>
						<th width="120">{lang('Admin.column_published')}</th>
						<th width="130">{lang('Admin.column_function')}</th>
					</tr>
					</thead>
					<tbody>
					{foreach $list as $item}
						<tr id="item_id_{$item.product_id}">
							<td class="text-center">{form_checkbox('manage_ids[]', $item.product_id)}</td>
							<td class="text-center">{anchor("$manage_url/edit/`$item.product_id`", $item.product_id, 'class="text-primary"')}</td>
							<td>
								<a href="{image_root($item.image)}" data-lightbox="photos">
									<img src="{image_root($item.image)}" class="img-thumbnail me-1 img-fluid w-100">
								</a>
							</td>
							<td>
								{anchor("$manage_url/edit/`$item.product_id`", $item.name, 'class="text-primary"')}
								<br/>
								<small class="fst-italic">{$item.created_at}</small><br/>

								{if !empty($item.is_out_of_stock)}
									<span class="text-danger">*{lang('ProductAdmin.text_sku_out_of_stock_warning')}</span>
								{elseif $item.quantity <= 0}
									<span class="text-danger">*{lang('ProductAdmin.text_sku_out_of_stock')}</span>
								{elseif $item.quantity < 10}
									<span class="text-danger">*{lang('ProductAdmin.text_sku_few_product_left')}</span>
								{/if}

							</td>
							<td class="text-center">
								{if !empty($item.variant)}
									<div title="{lang('ProductAdmin.text_sku_total')}: {$item.sku_list|count}" onclick="editProductSku('{$item.product_id}')">
										{$item.sku_list|count} {lang('ProductAdmin.text_variant')}
										<i class="fa fa-eye ms-1"></i>
									</div>
								{/if}
							</td>
							<td class="text-center">
								<span id="product_{$item.product_id}_quantity" onclick="editProductSku('{$item.product_id}')">
									<span>{$item.quantity}</span>
									<i class="fa fa-edit ms-1"></i>
								</span>
							</td>
							<td class="text-center">
								<span id="product_{$item.product_id}_price" onclick="editProductSku('{$item.product_id}')">
									<span>{$item.price}</span>
									<i class="fa fa-edit ms-1"></i>
								</span>
							</td>
							<td>
								<div class="switch-button switch-button-xs catcool-center">
									{form_checkbox("published_`$item.product_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.product_id, 'data-id' => $item.product_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
									<span><label for="published_{$item.product_id}"></label></span>
								</div>
							</td>
							<td class="text-center">
								<div class="btn-group ms-auto">
									<a href="{site_url($manage_url)}/edit/{$item.product_id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
									<button type="button" data-id="{$item.product_id}" class="btn btn-sm btn-light text-danger btn_delete_single" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
								</div>
							</td>
						</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
			{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
		</form>
	{else}
		{lang('Admin.text_no_results')}
	{/if}
{/strip}
