{strip}
	{form_hidden('manage_url', $manage_url)}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
				{include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="list"}
			</div>
			<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UtilityAdmin.heading_title')}
				
				<div class="card">
					<div class="card-body vh-100">

					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
