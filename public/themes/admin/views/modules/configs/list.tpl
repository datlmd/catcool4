{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
			<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete_all')}"><i class="fas fa-trash-alt"></i></span>
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
			<a href="{$manage_url}/write" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_write')}"><i class="fas fa-save"></i></a>
			<a href="{base_url('configs/groups_manage')}" class="btn btn-sm btn-primary"><i class="fas fa-list mr-1"></i>{lang('text_group')}</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=configs}
		</div>
		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list mr-2"></i>{lang('text_list')}</h5>
				<div class="card-body">
					<div class="tab-regular">
						<ul class="nav nav-tabs border-bottom pl-3" id="config_tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link p-2 pl-3 pr-3 {if empty($ses_config_group_id)}active{/if}" id="config_group_id_all" data-toggle="tab" href="#config_content_group_id_all" role="tab" aria-controls="config_group_id_all" aria-selected="{if empty($ses_config_group_id)}true{else}false{/if}">{lang('text_all')}</a>
							</li>
							{foreach $groups as $group}
								<li class="nav-item">
									<a class="nav-link p-2 pl-3 pr-3 {if $group.id eq $ses_config_group_id}active{/if}" id="config_group_id_{$group.id}" data-toggle="tab" href="#config_content_group_id_{$group.id}" role="tab" aria-controls="config_group_id_{$group.id}" aria-selected="{if $group.id eq $ses_config_group_id}true{else}false{/if}">{$group.name}</a>
								</li>
							{/foreach}
						</ul>
						<div class="tab-content border-0 p-3" id="config_tab_content">
							<div class="tab-pane fade {if empty($ses_config_group_id)}show active{/if}" role="tabpanel" id="config_content_group_id_all"  aria-labelledby="config_group_id_all">
								{if !empty($list)}
									<div class="table-responsive">
										<table class="table table-striped table-hover table-bordered second">
											<thead>
											<tr class="text-center">
												<th width="50">{lang('column_id')}</th>
												<th>{lang('column_config_key')}</th>
												<th>{lang('column_config_value')}</th>
												<th>{lang('column_description')}</th>
												<th>{lang('column_published')}</th>
												<th width="160">{lang('column_function')}</th>
												<th width="50">{form_checkbox('manage_check_all')}</th>
											</tr>
											</thead>
											<tbody>
											{foreach $list as $item}
												<tr>
													<td class="text-center">{$item.id}</td>
													<td>{anchor("$manage_url/edit/`$item.id`?tab_group_id=0", $item.config_key, 'class="text-primary"')}</td>
													<td>{$item.config_value|escape}</td>
													<td>{$item.description}</td>
													<td>
														<div class="switch-button switch-button-xs catcool-center">
															{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
															<span><label for="published_{$item.id}"></label></span>
														</div>
													</td>
													<td class="text-center">
														<div class="btn-group ml-auto">
															<a href="{$manage_url}/edit/{$item.id}?tab_group_id=0" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
															<button type="button" data-id="{$item.id}" class="btn btn-sm btn-outline-light btn_delete_single" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
														</div>
													</td>
													<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
												</tr>
											{/foreach}
											</tbody>
										</table>
									</div>
								{else}
									{lang('text_no_results')}
								{/if}
							</div>
							{foreach $groups as $group}
								<div class="tab-pane fade {if $group.id eq $ses_config_group_id}show active{/if}" role="tabpanel" id="config_content_group_id_{$group.id}"  aria-labelledby="config_group_id_{$group.id}">
									{if !empty($list)}
										<div class="table-responsive">
											<table class="table table-striped table-hover table-bordered second">
												<thead>
												<tr class="text-center">
													<th width="50">{lang('column_id')}</th>
													<th>{lang('column_config_key')}</th>
													<th>{lang('column_config_value')}</th>
													<th>{lang('column_description')}</th>
													<th>{lang('column_published')}</th>
													<th width="160">{lang('column_function')}</th>
													<th width="50">{form_checkbox('manage_check_all')}</th>
												</tr>
												</thead>
												<tbody>
													{foreach $list as $item}
														{if $item.group_id eq $group.id}
															<tr>
																<td class="text-center">{$item.id}</td>
																<td>{anchor("$manage_url/edit/`$item.id`?tab_group_id=`$group.id`", $item.config_key, 'class="text-primary"')}</td>
																<td>{$item.config_value|escape}</td>
																<td>{$item.description}</td>
																<td>
																	<div class="switch-button switch-button-xs catcool-center">
																		{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
																		<span><label for="published_{$item.id}"></label></span>
																	</div>
																</td>
																<td class="text-center">
																	<div class="btn-group ml-auto">
																		<a href="{$manage_url}/edit/{$item.id}?tab_group_id={$group.id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
																		<button type="button" data-id="{$item.id}" class="btn btn-sm btn-outline-light btn_delete_single" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
																	</div>
																</td>
																<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
															</tr>
														{/if}
													{/foreach}
												</tbody>
											</table>
										</div>
									{else}
										{lang('text_no_results')}
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
