{strip}
	<div class="sidebar-nav-fixed">
		<ul class="list-unstyled">
			<li><a href="{site_url('configs/manage')}" {if !empty($active) && $active eq 'configs'}class="active"{/if}>Confgs</a></li>
			<li><a href="{site_url('modules/manage')}" {if !empty($active) && $active eq 'modules'}class="active"{/if}>Modules</a></li>
			<li><a href="{site_url('manage/builder')}" {if !empty($active) && $active eq 'create_module'}class="active"{/if}>Create Module</a></li>
			<li><a href="{site_url('relationships/manage')}" {if !empty($active) && $active eq 'relationships'}class="active"{/if}>Relationships</a></li>
			<li><a href="{site_url('dummy/manage')}" target="_blank">Dummy</a></li>
			<li><a href="{site_url('user_guide/theme')}" target="_blank">Template</a></li>
			<li><a href="{site_url('utilities/manage/list_file')}" {if !empty($active) && $active eq 'file_browser'}class="active"{/if}>File Browser</a></li>
			<li><a href="{site_url('utilities/manage/logs')}" {if !empty($active) && $active eq 'logs'}class="active"{/if}>Logs</a></li>
			<li><a href="{site_url('utilities/manage/php_info')}" {if !empty($active) && $active eq 'php_info'}class="active"{/if}>PHP Info</a></li>
		</ul>
	</div>
{/strip}
