{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">

		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ManufacturerAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
				<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_add')}"><i class="fas fa-plus"></i></a>
				{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('ManufacturerAdmin.translate_frontend_id') translate_admin=lang('ManufacturerAdmin.translate_admin_id')}
			</div>
		</div>

		<div class="row">
			<div class="col-12">

				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('ManufacturerAdmin.text_list')}</h5>
					<div class="card-body">
						{if !empty($list)}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
									<tr class="text-center">
										<th width="50">
											<a href="{site_url($manage_url)}?sort=manufacturer_id&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'manufacturer_id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-end" width="120">
											<a href="{site_url($manage_url)}?sort=sort_order&order={$order}{$url}" class="text-dark">
												{lang('Admin.text_sort_order')}
												{if $sort eq 'sort_order'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th width="120">{lang('Admin.column_published')}</th>
										<th width="130">{lang('Admin.column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr id="item_id_{$item.manufacturer_id}">
											<td class="text-center">{anchor("$manage_url/edit/`$item.manufacturer_id`", $item.manufacturer_id, 'class="text-primary"')}</td>
											<td>{anchor("$manage_url/edit/`$item.manufacturer_id`", $item.name, 'class="text-primary"')}</td>
											<td class="text-end">{$item.sort_order}</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.manufacturer_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.manufacturer_id, 'data-id' => $item.manufacturer_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.manufacturer_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.manufacturer_id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.manufacturer_id}" class="btn btn-sm btn-light text-danger btn_delete_single" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
												</div>
											</td>
											<td class="text-center">{form_checkbox('manage_ids[]', $item.manufacturer_id)}</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>
							{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
						{else}
							{lang('Admin.text_no_results')}
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}