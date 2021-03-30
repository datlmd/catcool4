{*<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>*}
<div id="page_loading" style="width: 100vw; height: 3px; top:0; left: 0;position: fixed; z-index: 2000;">
	<div class="progress" style="height: 3px;">
		<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
	</div>
</div>
<div class="dashboard-main-wrapper">
	{$header}
	{$sidebar}
	<div class="dashboard-wrapper {if empty(config_item('enable_scroll_menu_admin'))}nav-left-sidebar-content-scrolled{/if} {if empty(config_item('enable_icon_menu_admin'))}navbar-full-text-content{/if}">
		{$content}
		{$footer}
	</div>
</div>
{print_flash_alert('alert_popup')}