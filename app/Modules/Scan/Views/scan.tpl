{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('Scan.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" data-bs-toggle="tooltip"
					title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i
						class="fas fa-filter"></i></button>
				{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('Scan.translate_frontend_id') translate_admin=lang('Scan.translate_admin_id')}
			</div>
		</div>
		<div class="row collapse show" id="filter_manage">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>

					<div class="card-body">
						<div class="row">
							<div class="col-12 mb-2">
								{lang('Admin.filter_name')}
								{form_input('url', set_value('url', $request->getGet('url'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
							</div>
							{* <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.filter_id')}
									{form_input('dummy_id', set_value('dummy_id', $request->getGet('dummy_id'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.text_limit')}
									{form_dropdown('limit', get_list_limit(), set_value('limit', $request->getGet('limit')), ['class' => 'form-control form-control-sm'])}
								</div> *}
							<div class="col-12 text-end">
								<button type="button" id="btn_scan" class="btn btn-sm btn-primary"><i
										class="fas fa-search me-1"></i>{lang('Admin.filter_submit')}</button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('Scan.text_list')}</h5>
					<div class="card-body" id="scan_list">

					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}


<script type="text/javascript">
	var is_processing = false;

	$(document).on('click', '#scan_list .btn-close', function() {
		$(this).parent().parent().remove();
	});

	$(document).on('click', '#btn_scan', function(e) {

		e.preventDefault();

		$('.image-setting').popover('dispose');
		$('#button_folder').popover('dispose');
		is_disposing = false;

		$('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

		$.ajax({
			url: base_url + '/manage/scan/get_content',
			type: 'post',
			data: {
				url: $("input[name=url]").val(),
				[$("input[name*='" + csrf_token + "']").attr('name')]: $("input[name*='" + csrf_token +
					"']").val()
			},

			beforeSend: function() {
				$('#button-upload i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
				$('#button-upload').prop('disabled', true);
			},
			complete: function() {
				$('#button-upload i').replaceWith('<i class="fas fa-upload"></i>');
				$('#button-upload').prop('disabled', false);
			},
			success: function(json) {
				$('body .loading').remove();
				$('#scan_list').append(json['data']);
				if (json['error']) {
					$.notify(json['error'], {
						'type': 'danger'
					});
					return false;
				}
				if (json['success']) {
					$.notify(json['success']);
					$('#button_refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				$('body .loading').remove();
			}
		});
	});
</script>