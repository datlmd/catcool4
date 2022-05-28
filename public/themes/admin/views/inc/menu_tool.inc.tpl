{strip}
	{if !empty($is_mobile)}
		<div class="mb-2">
			<button class="btn btn-sm btn-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#menu_utilities" aria-expanded="false" aria-controls="menu_utilities">
				{lang('Admin.text_menu_utilities')}
			</button>
		</div>
	{/if}
	<div class="sidebar-nav-fixed {if !empty($is_mobile)}collapse{/if}" id="menu_utilities">
		<ul class="list-unstyled">
			<li><a href="{site_url('manage/backup')}" {if !empty($active) && $active eq 'backup'}class="active"{/if}>{lang('Backup.heading_title')}</a></li>
			<li><a href="{site_url('utilities/manage/logs')}" {if !empty($active) && $active eq 'logs'}class="active"{/if}>Logs</a></li>
			<li><a href="{site_url('utilities/manage/logs')}" {if !empty($active) && $active eq 'uploads'}class="active"{/if}>Uploads</a>
		</ul>
	</div>
{/strip}
