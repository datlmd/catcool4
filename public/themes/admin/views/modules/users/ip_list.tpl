{strip}
	{if !empty($user_ips)}
		<form id="form_user_token_list" method="post" data-cc-toggle="ajax" data-cc-load="{site_url("users/manage/user_ip_list")}" data-cc-target="#user_ip_list">
			<div class="table-responsive mb-3">
				<table class="table table-striped table-hover table-bordered second">
					<thead>
					<tr class="text-center">
						<th width="100">
							{lang('UserAdmin.text_ip')}
						</th>
						<th class="text-start">
							{lang('UserAdmin.text_agent')}
						</th>
						<th>
							{lang('Admin.text_ctime')}
						</th>
					</tr>
					</thead>
					<tbody>
					{foreach $user_ips as $user_ip}
						<tr id="item_id_{$user_ip.user_ip_id}">
							<td class="text-center">
								<a href="https://whatismyipaddress.com/ip/{$user_ip.ip}" target="_blank">{$user_ip.ip}</a>
							</td>
							<td>
								{$user_ip.agent}
							</td>
							<td class="text-center">
								{$user_ip.ctime}
							</td>
						</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
			
			{include file=get_theme_path('views/inc/paging.tpl') pager=$user_ip_pager pager_name='user_ip'}
		</form>
	{else}
		{lang('Admin.text_no_results')}
	{/if}
{/strip}
