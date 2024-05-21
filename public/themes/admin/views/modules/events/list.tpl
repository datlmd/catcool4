{strip}
	{if !empty($list)}
		<form id="form_event" method="post" data-cc-toggle="ajax" data-cc-load="{site_url("$manage_url")}" data-cc-target="#event">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered second">
					<thead>
					<tr class="text-center">
						<th width="50">{form_checkbox('manage_check_all')}</th>
						<th width="60">
							<a href="{site_url($manage_url)}?sort=event_id&order={$order}{$url}" class="text-dark">
								{lang('Admin.column_id')}
								{if $sort eq 'event_id'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th width="200" class="text-start">
							<a href="{site_url($manage_url)}?sort=code&order={$order}{$url}" class="text-dark">
								{lang('EventAdmin.text_code')}
								{if $sort eq 'code'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th>{lang('EventAdmin.text_action')}</th>
						<th class="text-center">
							<a href="{site_url($manage_url)}?sort=priority&order={$order}{$url}" class="text-dark">
								{lang('EventAdmin.text_priority')}
								{if $sort eq 'priority'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th width="120">{lang('Admin.column_published')}</th>
						<th width="130">{lang('Admin.column_function')}</th>
					</tr>
					</thead>
					<tbody>
					{foreach $list as $item}
						<tr id="item_id_{$item.event_id}">
							<td class="text-center">{form_checkbox('manage_ids[]', $item.event_id)}</td>
							<td class="text-center">{anchor("$manage_url/edit/`$item.event_id`", $item.event_id, 'class="text-primary"')}</td>
							<td>
								{anchor("$manage_url/edit/`$item.event_id`", $item.code, 'class="text-primary"')}
							</td>
							<td>
								{$item.action}
							</td>
							<td>
								{$item.priority}
							</td>
							<td>
								<div class="switch-button switch-button-xs catcool-center">
									{form_checkbox("published_`$item.event_id`", $item.published, $item.published, ['id' => 'published_'|cat:$item.event_id, 'data-id' => $item.event_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
									<span><label for="published_{$item.event_id}"></label></span>
								</div>
							</td>
							<td class="text-center">
								<div class="btn-group ms-auto">
									<a href="{site_url($manage_url)}/edit/{$item.event_id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
									<button type="button" data-id="{$item.event_id}" class="btn btn-sm btn-light text-danger btn_delete_single" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
								</div>
							</td>
						</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
			{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
		</form>
	{else}
		{lang('Admin.text_no_results')}
	{/if}
{/strip}
