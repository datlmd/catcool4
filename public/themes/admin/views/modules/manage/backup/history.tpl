{strip}
	<div class="card">
		<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('Backup.text_history')}</h5>
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
								{lang('Backup.column_filename')}
							</th>
							<th>
								{lang('Backup.column_size')}
							</th>
							<th>
								{lang('Backup.column_date_added')}
							</th>
							<th width="130">{lang('Admin.column_function')}</th>
						</tr>
						</thead>
						<tbody>
						{foreach $list as $key => $item}
							<tr id="{md5($key)}">
								<td>
									{$item.name}
								</td>
								<td class="text-center">{$item.size}</td>
								<td class="text-center">{$item.modify}</td>
								<td class="text-center">
									<div class="btn-group ms-auto">
										<a href="{site_url($manage_url)}/restore?filename={$item.name}" data-id="{$key}" class="btn btn-sm btn-light restore" data-bs-toggle="tooltip" title="{lang('Admin.button_restore')}"><i class="fas fa-sync text-primary"></i></a>
										<button onclick="location = '{$item.download}'" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_download')}"><i class="fas fa-download"></i></button>
										<a href="{site_url($manage_url)}/delete?filename={$item.name}" data-id="{md5($key)}" class="btn btn-sm btn-light delete" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt text-danger"></i></a>
									</div>
								</td>
							</tr>
						{/foreach}
						</tbody>
					</table>
				</div>

				<nav aria-label="Page navigation" class="table-responsive"><ul class="pagination justify-content-end my-2">{$pagination}</ul></nav>

			{else}
				{lang('Admin.text_no_results')}
			{/if}

		</div>
	</div>
{/strip}
