{strip}
	{if !empty($list)}
		<form id="form_geo_zone" method="post" data-cc-toggle="ajax" data-cc-load="{site_url("$manage_url")}" data-cc-target="#geo_zone">
			<div class="table-responsive mb-2">
				<table class="table table-striped table-hover table-bordered second">
					<thead>
					<tr class="text-center">
						<th width="50">{form_checkbox('manage_check_all')}</th>
						
						<th class="text-start">
							<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
								{lang('GeoZoneAdmin.text_name')}
								{if $sort eq 'name'}
									<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
								{/if}
							</a>
						</th>
						<th class="text-start">{lang('GeoZoneAdmin.text_description')}</th>
						<th width="130">{lang('Admin.column_function')}</th>
					</tr>
					</thead>
					<tbody>
					{foreach $list as $item}
						<tr id="item_id_{$item.geo_zone_id}">
							<td class="text-center">{form_checkbox('manage_ids[]', $item.geo_zone_id)}</td>
							
							<td>{anchor("$manage_url/edit/`$item.geo_zone_id`", $item.name, 'class="text-primary"')}</td>
							
							<td>
								{$item.description}
							</td>
		
							<td class="text-center">
								<div class="btn-group ms-auto">
									<a href="{site_url($manage_url)}/edit/{$item.geo_zone_id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
									<button type="button" data-id="{$item.geo_zone_id}" class="btn btn-sm btn-light text-danger btn_delete_single" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
