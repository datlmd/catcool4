{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid dashboard-content">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('Admin.dashboard_heading')}
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('Admin.dashboard_heading')}</h5>
				<div class="card-body">
					Dashboard
				</div>
			</div>
		</div>
	</div>
</div>
