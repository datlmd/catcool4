{strip}
{form_hidden('manage_url', $manage_url)}
{csrf_field('cc_token')}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ModuleAdmin.heading_title')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
			<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
			<a href="{site_url($manage_url)}/add{http_get_query()}" class="btn btn-sm btn-primary btn-space" title="{lang('ModuleAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('ModuleAdmin.text_add')}</a>
			<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space me-0" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=modules}
		</div>
		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
			<div class="collapse {if !empty($filter.active)}show{/if}" id="filter_manage">
				<div class="card">
					{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
					<div class="card-header">
						<div class="row">
							<div class="col-6">
								<h5 class="mb-0 mt-1 ms-2"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
							</div>
							<div class="col-6 text-end">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('Admin.filter_submit')}</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
								{lang('ModuleAdmin.text_module')}
								{form_input('module', old('module', $filter.module), ['class' => 'form-control form-control-sm', 'placeholder' => lang('ModuleAdmin.text_module')])}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
								{lang('ModuleAdmin.text_sub_module')}
								{form_input('sub_module', old('sub_module', $filter.sub_module), ['class' => 'form-control form-control-sm', 'placeholder' => lang('ModuleAdmin.text_sub_module')])}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
								{lang('Admin.text_limit')}
								{form_dropdown('limit', get_list_limit(), old('limit', $filter.limit), ['class' => 'form-control form-control-sm'])}
							</div>
						</div>
					</div>
					{form_close()}
				</div>
			</div>
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('ModuleAdmin.text_list')}</h5>
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
											<a href="{site_url($manage_url)}?sort=module&order={$order}{$url}" class="text-dark">
												{lang('ModuleAdmin.text_module')}
												{if $sort eq 'module'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=sub_module&order={$order}{$url}" class="text-dark">
												{lang('ModuleAdmin.text_sub_module')}
												{if $sort eq 'sub_module'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>{lang('Admin.column_published')}</th>
										<th>Language</th>
										<th width="160">{lang('Admin.column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{$item.id}</td>
										<td>
											{anchor("$manage_url/edit/`$item.id`", $item.module, 'class="text-primary"')}
											{if !empty($item.sub_module)}
												<br /> ---- {$item.sub_module}
											{/if}
										</td>
										<td>{$item.sub_module}</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
												<span><label for="published_{$item.id}"></label></span>
											</div>
										</td>
										<td class="text-center">{anchor("translations/manage?module_id=`$item.id`", 'Translation')}</td>
										<td class="text-center">
											<div class="btn-group ms-auto">
												<a href="{site_url($manage_url)}/edit/{$item.id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_edit')}"{/if}><i class="fas fa-edit"></i></a>
												<button type="button" data-id="{$item.id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
						{$pager->links('modules', 'admin')}
					{else}
						{lang('Admin.text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
{/strip}
