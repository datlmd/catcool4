{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		<div class="row">

			<div class="col-sm-9 col-12">

				<div class="row">
					<div class="col-sm-7 col-12">
						{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('GeoZoneAdmin.heading_title')}
					</div>
					<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
						<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
						<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_add')}"><i class="fas fa-plus"></i></a>
						{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('GeoZoneAdmin.translate_frontend_id') translate_admin=lang('GeoZoneAdmin.translate_admin_id')}
					</div>
				</div>

				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('GeoZoneAdmin.text_list')}</h5>
					<div id="geo_zone" class="card-body">

						{include file=get_theme_path('views/modules/geozones/list.tpl')}

					</div>
				</div>
			</div>

			<div class="col-sm-3 col-12">
				{include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="geo_zones"}
			</div>

		</div>
	</div>
{/strip}
<script type="text/javascript">
	$('#geo_zone').on('click', 'thead a, .pagination a', function (e) {
		e.preventDefault();

		$('#geo_zone').load(this.href);
	});
</script>

