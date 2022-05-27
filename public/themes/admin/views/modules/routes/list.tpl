{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('RouteAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
				<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('RouteAdmin.text_add')}"><i class="fas fa-plus"></i></a>
				<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" data-bs-toggle="tooltip" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
				<a href="{site_url($manage_url)}/write" class="btn btn-sm btn-light btn-space"><i class="fas fa-sync me-1"></i>{lang('Admin.button_write')}</a>
				{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('RouteAdmin.translate_frontend_id') translate_admin=lang('RouteAdmin.translate_admin_id')}
			</div>
		</div>
		<div class="row collapse {if !empty($filter_active)}show{/if}" id="filter_manage">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
					{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
						<div class="card-body">
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									<label class="form-label">{lang('RouteAdmin.text_module')}</label>
									{form_input('module', set_value('module', $request->getGet('module'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('RouteAdmin.text_module')])}
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									<label class="form-label">{lang('RouteAdmin.text_resource')}</label>
									{form_input('resource', set_value('resource', $request->getGet('resource'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('RouteAdmin.text_resource')])}
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									<label class="form-label">{lang('Admin.text_limit')}</label>
									{form_dropdown('limit', get_list_limit(), set_value('limit', $request->getGet('limit')), ['class' => 'form-control form-control-sm'])}
								</div>
								<div class="col-12 text-end">
									<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('Admin.filter_submit')}</button>
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
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('RouteAdmin.text_list')}</h5>
					<div class="card-body">
						{if !empty($list)}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											<th width="50">
												<a href="{site_url($manage_url)}?sort=id&order={$order}{$url}" class="text-dark">
													{lang('Admin.column_id')}
													{if $sort eq 'id'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>
												<a href="{site_url($manage_url)}?sort=route&order={$order}{$url}" class="text-dark">
													{lang('RouteAdmin.text_route')}
													{if $sort eq 'route'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>
												<a href="{site_url($manage_url)}?sort=module&order={$order}{$url}" class="text-dark">
													{lang('RouteAdmin.text_module')}
													{if $sort eq 'module'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>
												<a href="{site_url($manage_url)}?sort=resource&order={$order}{$url}" class="text-dark">
													{lang('RouteAdmin.text_resource')}
													{if $sort eq 'resource'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>{lang('Admin.text_language')}</th>
											<th width="120">{lang('Admin.column_published')}</th>
											<th width="130">{lang('Admin.column_function')}</th>
											<th width="50">{form_checkbox('manage_check_all')}</th>
										</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr id="item_id_{$item.id}">
											<td class="text-center">{anchor("$manage_url/edit/`$item.id`", $item.id, 'class="text-primary"')}</td>
											<td>{anchor("$manage_url/edit/`$item.id`", $item.route, 'class="text-primary"')}</td>
											<td class="text-center">{anchor("$manage_url/edit/`$item.id`", $item.module, 'class="text-primary"')}</td>
											<td class="text-center">{$item.resource}</td>
											<td class="text-center">{$languages[$item.language_id]}</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light text-danger btn_delete_single" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
												</div>
											</td>
											<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
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

