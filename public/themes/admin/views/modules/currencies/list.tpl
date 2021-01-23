{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
			<a href="{$manage_url}/refresh" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_refresh')}"><i class="fas fa-sync"></i></a>
			<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete_all')}"><i class="fas fa-trash-alt"></i></span>
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('text_list')}</h5>
				<div class="card-body">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('column_id')}</th>
										<th>{lang('column_name')}</th>
										<th>{lang('text_value')}</th>
										<th>{lang('text_code')}</th>
										<th>{lang('text_symbol_left')}</th>
										<th>{lang('text_symbol_right')}</th>
										<th>{lang('text_decimal_place')}</th>
										<th>{lang('column_published')}</th>
										<th width="160">{lang('column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{$item.currency_id}</td>
										<td>
											{anchor("$manage_url/edit/`$item.currency_id`", htmlspecialchars($item.name, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}
											{if $item.code == config_item('currency')} <strong>({lang('text_default')})</strong>{/if}
										</td>
										<td class="text-center">{$item.value}</td>
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
												<a href="{$manage_url}/edit/{$item.currency_id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
												<button type="button" data-id="{$item.currency_id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.currency_id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
						{include file=get_theme_path('views/inc/paging.inc.tpl')}
					{else}
						{lang('text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
