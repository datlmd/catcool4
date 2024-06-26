{strip}
{form_hidden('manage_url', site_url($manage_url))}
{csrf_field()}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
			{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserGroupAdmin.heading_title')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
			<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-brand btn-space" title="{lang('UserGroupAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('UserGroupAdmin.text_add')}</a>
			{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('UserGroupAdmin.translate_frontend_id') translate_admin=lang('UserGroupAdmin.translate_admin_id')}
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('Admin.text_list')}</h5>
				<div class="card-body">
					<div class="w-100 text-end mb-2">
						<a href="{site_url("manage/users")}" class="btn btn-sm btn-primary btn-space ">{lang('UserAdmin.heading_title')}</a>
						<a href="{site_url("manage/permissions")}" class="btn btn-sm btn-secondary btn-space me-0">{lang('PermissionAdmin.text_list')}</a>
					</div>
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{form_checkbox('manage_check_all')}</th>
										<th width="50">
											<a href="{site_url($manage_url)}?sort=id&order={$order}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=name&order={$order}}" class="text-dark">
												{lang('UserGroupAdmin.column_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">{lang('Admin.column_description')}</th>
										<th width="130">{lang('Admin.column_function')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
										<td class="text-center">{$item.id}</td>
										<td>{anchor("$manage_url/edit/`$item.id`", htmlspecialchars($item.name, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}</td>
										<td>{$item.description}</td>
										<td class="text-center">
											<div class="btn-group ms-auto">
												<a href="{$manage_url}/edit/{$item.id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
												<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
	</div>
</div>
{/strip}
