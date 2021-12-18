{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductLengthClassAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
				<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_add')}"><i class="fas fa-plus"></i></a>
				{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('ProductLengthClassAdmin.translate_frontend_id') translate_admin=lang('ProductLengthClassAdmin.translate_admin_id')}
			</div>
		</div>

		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('Admin.text_list')}</h5>
					<div class="card-body">
						{if !empty($list)}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											<th width="50">
												<a href="{site_url($manage_url)}?sort=length_class_id&order={$order}{$url}" class="text-dark">
													{lang('Admin.column_id')}
													{if $sort eq 'length_class_id'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>
												<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
													{lang('Admin.column_name')}
													{if $sort eq 'name'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>
												{lang('ProductLengthClassAdmin.text_unit')}
											</th>
											<th>
												{lang('ProductLengthClassAdmin.text_value')}
											</th>
											<th width="160">{lang('Admin.column_function')}</th>
											<th width="50">{form_checkbox('manage_check_all')}</th>
										</tr>
									</thead>
									<tbody>
										{foreach $list as $item}
											<tr id="item_id_{$item.length_class_id}">
												<td class="text-center">{anchor("$manage_url/edit/`$item.length_class_id`", $item.length_class_id, 'class="text-primary"')}</td>
												<td>
													{anchor("$manage_url/edit/`$item.length_class_id`", $item.name, 'class="text-primary"')}
													{if $item.length_class_id eq config_item('length_class')}
														&nbsp{lang('Admin.text_default')}
													{/if}
												</td>
												<td class="text-center">{$item.unit}</td>
												<td class="text-center">{$item.value}</td>
												<td class="text-center">
													<div class="btn-group ms-auto">
														<a href="{site_url($manage_url)}/edit/{$item.length_class_id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
														<button type="button" data-id="{$item.length_class_id}" class="btn btn-sm btn-light text-danger btn_delete_single" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
													</div>
												</td>
												<td class="text-center">{form_checkbox('manage_ids[]', $item.length_class_id)}</td>
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