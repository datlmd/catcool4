{strip}
	{if !empty($list)}
		<form id="form_plan" method="post" data-cc-toggle="ajax" data-cc-load="{site_url("$manage_url")}" data-cc-target="#plan">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered second">
					<thead>
					<tr class="text-center">
						<th width="50">{form_checkbox('manage_check_all')}</th>
						<th width="60">
							<a href="{site_url($manage_url)}?sort=subscription_plan_id&order={$order}{$url}" class="text-dark">
								{lang('Admin.column_id')}
								{if $sort eq 'subscription_plan_id'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th class="text-start">
							<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
								{lang('SubscriptionPlanAdmin.text_plan_name')}
								{if $sort eq 'name'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th width="180">{lang('Admin.text_sort_order')}</th>
						<th width="130">{lang('Admin.column_function')}</th>
					</tr>
					</thead>
					<tbody>
					{foreach $list as $item}
						<tr id="item_id_{$item.subscription_plan_id}">
							<td class="text-center">{form_checkbox('manage_ids[]', $item.subscription_plan_id)}</td>
							<td class="text-center">{anchor("$manage_url/edit/`$item.subscription_plan_id`", $item.subscription_plan_id, 'class="text-primary"')}</td>
							<td>{anchor("$manage_url/edit/`$item.subscription_plan_id`", $item.name, 'class="text-primary"')}</td>
							<td class="text-center">
								{$item.sort_order}
							</td>
							<td class="text-center">
								<div class="btn-group ms-auto">
									<a href="{site_url($manage_url)}/edit/{$item.subscription_plan_id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
									<button type="button" data-id="{$item.subscription_plan_id}" class="btn btn-sm btn-light text-danger btn_delete_single" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
