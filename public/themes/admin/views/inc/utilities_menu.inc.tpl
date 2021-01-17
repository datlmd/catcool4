<div class="sidebar-nav-fixed">
	<ul class="list-unstyled">
		<li><a href="{base_url('configs/manage')}" {if $active eq 'configs'}class="active"{/if}>Confgs</a></li>
		<li><a href="{base_url('utilities/manage/list_file')}" {if $active eq 'file_browser'}class="active"{/if}>File Browser</a></li>
		<li><a href="{base_url('modules/manage')}" {if $active eq 'modules'}class="active"{/if}>Modules</a></li>
		<li><a href="{base_url('manage/builder')}" {if $active eq 'create_module'}class="active"{/if}>Create Module</a></li>
		<li><a href="{base_url('relationships/manage')}" {if $active eq 'relationships'}class="active"{/if}>Relationships</a></li>
		<li><a href="{base_url('dummy/manage')}" target="_blank">Dummy</a></li>
		<li><a href="{base_url('user_guide/theme')}" target="_blank">Template</a></li>
		<li><a href="{base_url('utilities/manage/php_info')}" {if $active eq 'php_info'}class="active"{/if}>PHP Info</a></li>
	</ul>
</div>