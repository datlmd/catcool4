{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">

		<div class="row">
			<div class="col-12">

				<div class="row">
					<div class="col-sm-6 col-12">
						{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.heading_title')}
					</div>
					<div class="col-sm-6 col-12 mb-2 mb-sm-0 text-end">
						<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('UserAdmin.button_add')}"><i class="fas fa-plus"></i></a>
						<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" data-bs-toggle="tooltip" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
						{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('UserAdmin.translate_frontend_id') translate_admin=lang('UserAdmin.translate_admin_id')}
					</div>
				</div>
				<div class="row collapse {if !empty($filter_active)}show{/if}" id="filter_manage">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="card">
							<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
							{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
							<div class="card-body">
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										<label class="form-label">{lang('UserAdmin.filter_search_user')}</label>
										{form_input('name', set_value('name', $request->getGet('name'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										<label class="form-label">{lang('Admin.filter_id')}</label>
										{form_input('customer_id', set_value('customer_id', $request->getGet('customer_id'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										<label class="form-label">{lang('Admin.text_limit')}</label>
										{form_dropdown('limit', get_list_limit(), set_value('limit', $request->getGet('limit')), ['class' => 'form-control form-control-sm'])}
									</div>
									<div class="col-12 text-end">
										<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('Admin.filter_submit')}</button>
									</div>
								</div>
							</div>
							{form_close()}
						</div>
					</div>
				</div>

				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CustomerAdmin.text_list')}</h5>
					<div id="customer_list" class="card-body">

						{include file=get_theme_path('views/modules/customers/list.tpl')}

					</div>
				</div>
				
			</div>
		</div>
		
	</div>
{/strip}
<script type="text/javascript">
	$('#customer_list').on('click', 'thead a, .pagination a', function (e) {
		e.preventDefault();

		$('#customer_list').load(this.href);
	});
</script>

