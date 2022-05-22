{strip}
	{form_hidden('manage_url', $manage_url)}
	<div class="container-fluid  dashboard-content">

		<div class="row">

			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
				{include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="logs"}
			</div>

			<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

				<div class="row">
					<div class="col-sm-7 col-12">
						{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UtilityAdmin.heading_title')}
					</div>
					<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
						<a href="{site_url($manage_url)}/logs" class="btn btn-sm btn-primary me-2" title="Log Access">System Logs</a>
						<a href="{site_url($manage_url)}/logs?dir=access" class="btn btn-sm btn-primary me-2" title="Log Access">Access Logs</a>
						<a href="{site_url($manage_url)}/logs?dir={$dir}&type=2" class="btn btn-sm btn-secondary me-0 mb-0" title="Clear">Clear</a>
					</div>
				</div>

				<div class="card">
					<h5 class="card-header"><i class="fas fa-history me-2"></i>Logs {if !empty($detail)}<strong>: {$detail.name} ({$detail.size})</strong>{/if}</h5>
					<div class="card-body">
						{if !empty($detail)}
							<textarea rows="20" class="form-control text-danger bg-dark">
								{$detail.content}
							</textarea>
						{else}
							{lang('Admin.text_no_results')}
						{/if}
					</div>
				</div>
				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{if !empty($dir)}{$dir|ucfirst}{/if} Logs</h5>
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
											<a href="{site_url($manage_url)}/logs?sort=name&order={$order}&dir={$dir}" class="text-dark">
												{lang('Admin.text_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}/logs?sort=size&order={$order}&dir={$dir}" class="text-dark">
												Size
												{if $sort eq 'size'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}/logs?sort=modify&order={$order}&dir={$dir}" class="text-dark">
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
													{if !empty($item.is_active)}
														{anchor("$manage_url/logs?name=`$item.name`&dir={$dir}", $item.name, 'class="text-danger"')} <small>({$item.permission})</small>
													{else}
														{anchor("$manage_url/logs?name=`$item.name`&dir={$dir}", $item.name, 'class="text-primary"')} <small>({$item.permission})</small>
													{/if}
												</td>
												<td class="text-center">{$item.size}</td>
												<td class="text-center">{$item.modify}</td>
												<td class="text-center">
													<div class="btn-group ms-auto">
														<a href="{site_url($manage_url)}/logs?name={$item.name}&dir={$dir}&type=1" class="btn btn-sm btn-light" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></a>
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
