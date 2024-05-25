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
			<li><a href="{site_url('manage/configs')}" {if !empty($active) && $active eq 'configs'}class="active"{/if}>{lang('ConfigAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/modules')}" {if !empty($active) && $active eq 'modules'}class="active"{/if}>{lang('ModuleAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/builder')}" {if !empty($active) && $active eq 'create_module'}class="active"{/if}>Create Module</a></li>
			<li><a href="{site_url('manage/relationships')}" {if !empty($active) && $active eq 'relationships'}class="active"{/if}>{lang('RelationshipAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/events')}" {if !empty($active) && $active eq 'events'}class="active"{/if}>{lang('EventAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/utility_list_file')}" {if !empty($active) && $active eq 'file_browser'}class="active"{/if}>File Browser</a></li>
			<li><a href="{site_url('manage/utility_email')}" {if !empty($active) && $active eq 'email'}class="active"{/if}>Email</a>
			{if ENVIRONMENT !== 'production'}
				<li><a href="{site_url('dummy/manage')}" target="_blank">Dummy</a></li>
				<li><a href="/dev/template" target="_blank">Template</a></li>
			{/if}
			<li><a href="{site_url('manage/backup')}" {if !empty($active) && $active eq 'backup'}class="active"{/if}>{lang('Backup.heading_title')}</a></li>
			<li><a href="{site_url('manage/utility_php_info')}" {if !empty($active) && $active eq 'php_info'}class="active"{/if}>PHP Info</a></li>
			<li><a href="{site_url('manage/utility_logs')}" {if !empty($active) && $active eq 'logs'}class="active"{/if}>Logs</a></li>
		</ul>
	</div>
{/strip}
