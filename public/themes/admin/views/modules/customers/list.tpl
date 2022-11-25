{strip}
	{if !empty($list)}
		<form id="form_customer_list" method="post" data-cc-toggle="ajax" data-cc-load="{site_url("$manage_url")}" data-cc-target="#customer_list">
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
						<th></th>
						<th class="text-start">
							<a href="{site_url($manage_url)}?sort=username&order={$order}{$url}" class="text-dark">
								{lang('Admin.text_username')}
								{if $sort eq 'username'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th class="text-start">
							<a href="{site_url($manage_url)}?sort=first_name&order={$order}{$url}" class="text-dark">
								{lang('Admin.text_full_name')}
								{if $sort eq 'first_name'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th class="text-start">
							<a href="{site_url($manage_url)}?sort=email&order={$order}{$url}" class="text-dark">
								{lang('CustomerAdmin.text_email')}
								{if $sort eq 'email'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th class="text-end">{lang('CustomerAdmin.text_phone')}</th>
						<th>{lang('Admin.text_active')}</th>
						<th width="130">{lang('Admin.column_function')}</th>
					</tr>
					</thead>
					<tbody>
					{foreach $list as $item}
						<tr id="item_id_{$item.customer_id}">
							<td class="text-center">
								<a href="{$manage_url}/edit/{$item.customer_id}" class="text-primary">{$item.customer_id}</a>
							</td>
							<td>
								{if !empty($item.image)}
									<a href="{image_url($item.image)}" data-lightbox="users"><img src="{image_url($item.image)}" class="avatar"></a>
								{/if}
							</td>
							<td>
								{if $item.active eq true}
									<span class="badge-dot badge-success mx-1"></span>
								{else}
									<span class="badge-dot border border-dark mx-1"></span>
								{/if}
								{$item.username}
							</td>
							<td class="text-start">{full_name($item.first_name, $item.last_name)}</td>
							<td>{htmlspecialchars($item.email, ENT_QUOTES,'UTF-8')}</td>
							<td class="text-end">{htmlspecialchars($item.phone, ENT_QUOTES,'UTF-8')}</td>
							<td>
								<div class="switch-button switch-button-xs catcool-center">
									{form_checkbox("published_`$item.customer_id`", $item.active, $item.active, ['id' => 'published_'|cat:$item.customer_id, 'data-id' => $item.customer_id, 'data-published' => $item.active, 'class' => 'change_publish'])}
									<span><label for="published_{$item.customer_id}"></label></span>
								</div>
							</td>
							<td class="text-center">
								<div class="btn-group ms-auto">
									<a href="{$manage_url}/edit/{$item.customer_id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
									<button type="button" data-id="{$item.customer_id}" class="btn btn-sm btn-light btn_delete_single text-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
