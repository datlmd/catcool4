{strip}
{form_hidden('manage_url', site_url($manage_url))}
{csrf_field()}
<div class="container-fluid  dashboard-content">

	<div class="row">

		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="configs"}
		</div>

		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

			<div class="row">
				<div class="col-sm-7 col-12">
					{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ConfigGroupAdmin.heading_title')}
				</div>
				<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
					<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
					<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('ConfigGroupAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('ConfigGroupAdmin.text_add')}</a>

					<button id="btn_group_drop_setting" type="button" class="btn btn-sm btn-light btn-space me-0" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fas fa-cog"></i>
					</button>
					<ul class="dropdown-menu" aria-labelledby="btn_group_drop_setting">
						<li><a class="dropdown-item" href="{site_url("manage/configs")}">{lang('ConfigGroupAdmin.module_configs')}</a></li>
						<li><a class="dropdown-item" href="{site_url('manage/translations')}?module_id={lang('ConfigGroupAdmin.translate_frontend_id')}">{lang("Admin.text_translate")}</a></li>
						<li><a class="dropdown-item" href="{site_url('manage/translations')}?module_id={lang('ConfigGroupAdmin.translate_admin_id')}">{lang("Admin.text_translate_admin")}</a></li>
					</ul>
				</div>
			</div>

			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('Admin.text_list')}</h5>
				<div class="card-body">
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
										<th>
											<a href="{site_url($manage_url)}?sort=name&order={$order}" class="text-dark">
												{lang('ConfigGroupAdmin.column_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>{lang('Admin.column_description')}</th>
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
