{strip}
{form_hidden('manage_url', site_url($manage_url))}
{csrf_field()}
<div class="container-fluid  dashboard-content">

	<div class="row">

		<div class="col-sm-9 col-12">

			<div class="row">
				<div class="col-sm-7 col-12">
					{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CurrencyAdmin.heading_title')}
				</div>
				<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
					<a href="{site_url($manage_url)}/refresh" class="btn btn-sm btn-success btn-space" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('CurrencyAdmin.button_refresh')}"><i class="fas fa-sync me-1"></i>{lang('CurrencyAdmin.button_refresh')}</a>
					<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
					<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space me-0" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_add')}"><i class="fas fa-plus me-1"></i>{lang('CurrencyAdmin.text_add')}</a>
				</div>
			</div>

			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CurrencyAdmin.text_list')}</h5>
				<div class="card-body">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{form_checkbox('manage_check_all')}</th>
										<th width="50">
											<a href="{site_url($manage_url)}?sort=currency_id&order={$order}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=name&order={$order}" class="text-dark">
												{lang('Admin.column_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=value&order={$order}" class="text-dark">
												{lang('CurrencyAdmin.text_value')}
												{if $sort eq 'value'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>{lang('CurrencyAdmin.text_code')}</th>
										<th>{lang('CurrencyAdmin.text_symbol_left')}</th>
										<th>{lang('CurrencyAdmin.text_symbol_right')}</th>
										<th>{lang('CurrencyAdmin.text_decimal_place')}</th>
										<th width="120">{lang('Admin.column_published')}</th>
										<th width="130">{lang('Admin.column_function')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.currency_id)}</td>
										<td class="text-center">{$item.currency_id}</td>
										<td>
											{anchor("$manage_url/edit/`$item.currency_id`", htmlspecialchars($item.name, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}
											{if $item.code == config_item('currency')} <strong>({lang('Admin.text_default')})</strong>{/if}
										</td>
										<td>{$item.value}</td>
										<td class="text-center">{$item.code}</td>
										<td class="text-center">{$item.symbol_left}</td>
										<td class="text-center">{$item.symbol_right}</td>
										<td class="text-center">{$item.decimal_place}</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.currency_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.currency_id, 'data-id' => $item.currency_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
												<span><label for="published_{$item.currency_id}"></label></span>
											</div>
										</td>
										<td class="text-center">
											<div class="btn-group ms-auto">
												<a href="{site_url($manage_url)}/edit/{$item.currency_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
												<button type="button" data-id="{$item.currency_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
					{else}
						{lang('Admin.text_no_results')}
					{/if}
				</div>
			</div>
		</div>

		<div class="col-sm-3 col-12">
			{include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="currencies"}
		</div>
		
	</div>
</div>
{/strip}
