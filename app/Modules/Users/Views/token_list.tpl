{strip}
	{if !empty($user_tokens)}
		<form id="form_user_token_list" method="post" data-cc-toggle="ajax" data-cc-load="{site_url("users/manage/delete_token")}" data-cc-target="#user_token_list">
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
						<th class="text-start">
							{lang('UserAdmin.text_location')}
						</th>
						<th>
							{lang('Admin.text_ctime')}
						</th>
						<th width="90">{lang('Admin.column_function')}</th>
					</tr>
					</thead>
					<tbody>
					{foreach $user_tokens as $user_token}
						<tr id="item_id_{$user_token.user_id}_{$user_token.remember_selector}">
							<td class="text-center">
								<a href="https://whatismyipaddress.com/ip/{$user_token.ip}" target="_blank">{$user_token.ip}</a>
							</td>
							<td>
								{$user_token.agent}
							</td>
							<td>
								{$user_token.location}
							</td>
							<td class="text-center">
								{$user_token.ctime}
							</td>
							<td class="text-center">
								<div class="btn-group ms-auto">
									<button type="button" data-remember-selector="{$user_token.remember_selector}" class="btn btn-sm btn-light text-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
								</div>
							</td>
						</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
			
			{include file=get_theme_path('views/inc/paging.tpl') pager=$user_token_pager pager_name='token'}
		</form>
	{else}
		{lang('Admin.text_no_results')}
	{/if}
{/strip}
