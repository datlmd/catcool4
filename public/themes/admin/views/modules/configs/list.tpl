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
					{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ConfigAdmin.heading_title')}
				</div>
				<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
					<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
					<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('ConfigAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('ConfigAdmin.text_add')}</a>
					<a href="{$manage_url}/write" class="btn btn-sm btn-light btn-space" title="{lang('Admin.button_write')}"><i class="fas fa-sync me-1"></i>{lang('Admin.button_write')}</a>
					<button id="btn_group_drop_setting" type="button" class="btn btn-sm btn-light btn-space me-0" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fas fa-cog"></i>
					</button>
					<ul class="dropdown-menu" aria-labelledby="btn_group_drop_setting">
						<li><a class="dropdown-item" href="{site_url('configs/groups_manage')}">{lang('Admin.text_group')}</a></li>
						<li><a class="dropdown-item" href="{site_url('translations/manage')}?module_id={lang('ConfigAdmin.translate_frontend_id')}">{lang("Admin.text_translate")}</a></li>
						<li><a class="dropdown-item" href="{site_url('translations/manage')}?module_id={lang('ConfigAdmin.translate_admin_id')}">{lang("Admin.text_translate_admin")}</a></li>
					</ul>
				</div>
			</div>

			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('ConfigAdmin.text_list')} {if !empty($file_permissions)}(<small>{$file_permissions}</small>){/if}</h5>
				<div class="card-body">
					<div class="tab-regular">
						<ul class="nav nav-tabs border-bottom ps-3" id="config_tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link p-2 ps-3 pe-3 {if empty($config_group_id)}active{/if}" id="config_group_id_all" data-bs-toggle="tab" href="#config_content_group_id_all" role="tab" aria-controls="config_group_id_all" aria-selected="{if empty($config_group_id)}true{else}false{/if}">{lang('Admin.text_all')}</a>
							</li>
							{foreach $groups as $group}
								<li class="nav-item">
									<a class="nav-link p-2 ps-3 pe-3 {if $group.id eq $config_group_id}active{/if}" id="config_group_id_{$group.id}" data-bs-toggle="tab" href="#config_content_group_id_{$group.id}" role="tab" aria-controls="config_group_id_{$group.id}" aria-selected="{if $group.id eq $config_group_id}true{else}false{/if}">{$group.name}</a>
								</li>
							{/foreach}
						</ul>
						<div class="tab-content border-0 p-3" id="config_tab_content">
							<div class="tab-pane fade {if empty($config_group_id)}show active{/if}" role="tabpanel" id="config_content_group_id_all"  aria-labelledby="config_group_id_all">
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
													<a href="{site_url($manage_url)}?sort=config_key&order={$order}" class="text-dark">
														{lang('ConfigAdmin.column_config_key')}
														{if $sort eq 'config_key'}
															<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
														{/if}
													</a>
												</th>
												<th class="text-start">
													<a href="{site_url($manage_url)}?sort=config_value&order={$order}" class="text-dark">
														{lang('ConfigAdmin.column_config_value')}
														{if $sort eq 'config_value'}
															<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
														{/if}
													</a>
												</th>
												<th class="text-start">{lang('Admin.column_description')}</th>
												<th width="120">{lang('Admin.column_published')}</th>
												<th width="130">{lang('Admin.column_function')}</th>
											</tr>
											</thead>
											<tbody>
											{foreach $list as $item}
												<tr>
													<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
													<td class="text-center">{$item.id}</td>
													<td>{anchor("$manage_url/edit/`$item.id`?tab_group_id=0", $item.config_key, 'class="text-primary"')}</td>
													<td title="{$item.config_value|escape}">{$item.config_value|truncate:40|escape}</td>
													<td>{$item.description}</td>
													<td>
														<div class="switch-button switch-button-xs catcool-center">
															{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'all_published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
															<span><label for="all_published_{$item.id}"></label></span>
														</div>
													</td>
													<td class="text-center">
														<div class="btn-group ms-auto">
															<a href="{$manage_url}/edit/{$item.id}?tab_group_id=0" class="btn btn-sm btn-light" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
															<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light text-danger btn_delete_single" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
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
							{foreach $groups as $group}
								<div class="tab-pane fade {if $group.id eq $config_group_id}show active{/if}" role="tabpanel" id="config_content_group_id_{$group.id}"  aria-labelledby="config_group_id_{$group.id}">
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
														<a href="{site_url($manage_url)}?sort=config_key&order={$order}" class="text-dark">
															{lang('ConfigAdmin.column_config_key')}
															{if $sort eq 'config_key'}
																<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
															{/if}
														</a>
													</th>
													<th class="text-start">
														<a href="{site_url($manage_url)}?sort=config_value&order={$order}" class="text-dark">
															{lang('ConfigAdmin.column_config_value')}
															{if $sort eq 'config_value'}
																<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
															{/if}
														</a>
													</th>
													<th class="text-start">{lang('Admin.column_description')}</th>
													<th width="120">{lang('Admin.column_published')}</th>
													<th width="130">{lang('Admin.column_function')}</th>
												</tr>
												</thead>
												<tbody>
													{foreach $list as $item}
														{if $item.group_id eq $group.id}
															<tr>
																<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
																<td class="text-center">{$item.id}</td>
																<td>{anchor("$manage_url/edit/`$item.id`?tab_group_id=`$group.id`", $item.config_key, 'class="text-primary"')}</td>
																<td title="{$item.config_value|escape}">{$item.config_value|truncate:40|escape}</td>
																<td>{$item.description}</td>
																<td>
																	<div class="switch-button switch-button-xs catcool-center">
																		{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
																		<span><label for="published_{$item.id}"></label></span>
																	</div>
																</td>
																<td class="text-center">
																	<div class="btn-group ms-auto">
																		<a href="{$manage_url}/edit/{$item.id}?tab_group_id={$group.id}" class="btn btn-sm btn-light" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_edit')}"{/if}><i class="fas fa-edit"></i></a>
																		<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light text-danger btn_delete_single" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
																	</div>
																</td>
															</tr>
														{/if}
													{/foreach}
												</tbody>
											</table>
										</div>
									{else}
										{lang('Admin.text_no_results')}
									{/if}
								</div>
							{/foreach}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{/strip}
