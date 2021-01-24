{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('Dummy.heading_title')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
			<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{lang('GeneralManage.button_delete_all')}"><i class="fas fa-trash-alt"></i></span>
			<a href="{site_url($manage_url)}/add{http_get_query()}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{lang('GeneralManage.button_add')}"><i class="fas fa-plus"></i></a>
			<button type="button" id="btn_search" class="btn btn-sm btn-brand" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{lang('GeneralManage.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
		</div>
	</div>
	<div class="row collapse {if !empty($filter.active)}show{/if}" id="filter_manage">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
                {form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
					<div class="card-header">
						<div class="row">
							<div class="col-6">
								<h5 class="mb-0 mt-1 ms-2"><i class="fas fa-filter me-2"></i>{lang('GeneralManage.filter_header')}</h5>
							</div>
							<div class="col-6 text-end">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('GeneralManage.filter_submit')}</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
								{lang('GeneralManage.filter_name')}
								{form_input('filter_name', set_value('filter_name', $filter.name), ['class' => 'form-control form-control-sm', 'placeholder' => lang('GeneralManage.filter_name')])}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
								{lang('GeneralManage.filter_id')}
								{form_input('filter_id', set_value('filter_id', $filter.id), ['class' => 'form-control form-control-sm', 'placeholder' => lang('GeneralManage.filter_id')])}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
								{lang('GeneralManage.text_limit')}
								{form_dropdown('filter_limit', get_list_limit(), set_value('filter_limit', $filter.limit), ['class' => 'form-control form-control-sm'])}
							</div>
						</div>
					</div>
                {form_close()}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('Dummy.text_list')}</h5>
				<div class="card-body">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">
											<a href="{site_url($manage_url)}?sort=dummy_id&order={$order}{$url}" class="text-dark">
												{lang('GeneralManage.column_id')}
												{if $sort eq 'dummy_id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if}"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
												{lang('GeneralManage.column_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if}"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=description&order={$order}{$url}" class="text-dark">
												{lang('GeneralManage.column_description')}
												{if $sort eq 'description'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if}"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=sort_order&order={$order}{$url}" class="text-dark">
												{lang('GeneralManage.column_sort_order')}
												{if $sort eq 'sort_order'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if}"></i>
												{/if}
											</a>
										</th>
										<th>{lang('GeneralManage.column_published')}</th>
										<th width="160">{lang('GeneralManage.column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{anchor("$manage_url/edit/`$item.dummy_id`", $item.dummy_id, 'class="text-primary"')}</td>
										<td>{anchor("$manage_url/edit/`$item.dummy_id`", $item.name, 'class="text-primary"')}</td>
										<td>{$item.description}</td>
										<td class="text-center">{$item.sort_order}</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.dummy_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.dummy_id, 'data-id' => $item.dummy_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
												<span><label for="published_{$item.dummy_id}"></label></span>
											</div>
										</td>
										<td class="text-center">
											<div class="btn-group ms-auto">
												<a href="{site_url($manage_url)}/edit/{$item.dummy_id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{lang('GeneralManage.button_edit')}"{/if}><i class="fas fa-edit"></i></a>
												<button type="button" data-id="{$item.dummy_id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{lang('GeneralManage.button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.dummy_id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
						{$pager->links('dummy', 'admin')}
					{else}
						{lang('GeneralManage.text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
