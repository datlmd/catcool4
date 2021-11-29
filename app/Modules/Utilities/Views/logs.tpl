{strip}
	{form_hidden('manage_url', $manage_url)}
	<div class="container-fluid  dashboard-content">
		{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UtilityAdmin.heading_title')}
		<div class="row">

			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
				{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active="logs"}
			</div>

			<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-history me-2"></i>Logs</h5>
					<div class="card-body">
						{if !empty($detail)}
							<h4><strong>{$detail.name} ({$detail.size})</strong></h4>
							<textarea rows="20" class="form-control text-danger bg-dark">
								{$detail.content}
							</textarea>
						{else}
							{lang('Admin.text_no_results')}
						{/if}
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						{if !empty(print_flash_alert())}
							{print_flash_alert()}
						{/if}
						{if !empty($list)}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
									<tr class="text-center">
										<th>
											<a href="{site_url($manage_url)}/logs?sort=name&order={$order}" class="text-dark">
												{lang('Admin.text_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}/logs?sort=size&order={$order}" class="text-dark">
												Size
												{if $sort eq 'size'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}/logs?sort=modify&order={$order}" class="text-dark">
												Last Modified
												{if $sort eq 'modify'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th width="160">{lang('Admin.column_function')}</th>
									</tr>
									</thead>
									<tbody>
										{foreach $list as $item}
											<tr>
												<td>
													{anchor("$manage_url/logs?name=`$item.name`", $item.name, 'class="text-primary"')} <small>({$item.permission})</small>
												</td>
												<td class="text-center">{$item.size}</td>
												<td class="text-center">{$item.modify}</td>
												<td class="text-center">
													<div class="btn-group ms-auto">
														<a href="{site_url($manage_url)}/logs?name={$item.name}&type=1" class="btn btn-sm btn-light" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></a>
														{*<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>*}
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
