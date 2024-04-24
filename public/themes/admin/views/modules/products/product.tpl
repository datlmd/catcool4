{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">

		<div class="row">
			<div class="col-12">

				<div class="row">
					<div class="col-sm-7 col-12">
						{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductAdmin.heading_title')}
					</div>
					<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
						<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
						<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_add')}"><i class="fas fa-plus"></i></a>
						{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('ProductAdmin.translate_frontend_id') translate_admin=lang('ProductAdmin.translate_admin_id')}
					</div>
				</div>

				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('ProductAdmin.text_list')}</h5>
					<div id="product" class="card-body">

						{include file=get_theme_path('views/modules/products/list.tpl')}

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit_product_sku" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editModalLabel">{lang('ProductAdmin.text_sku_edit')}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="edit_validation_error" class="text-danger"></div>
					{form_open('products/manage/edit_sku', ['id' => 'edit_product_sku_form'])}
						<div id="load_product_sku" style="max-width: 600px; margin: 0 auto;"></div>
					{form_close()}
				</div>
				<div class="modal-footer text-center">
					<button type="button" onclick="submitEditProductSku()" class="btn btn-sm btn-space btn-primary btn-edit-sku"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
					<button type="button" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</button>
				</div>
			</div>
		</div>
	</div>
{/strip}
<script type="text/javascript">
	var is_product_processing = false;

	$('#product').on('click', 'thead a, .pagination a', function (e) {
		e.preventDefault();

		$('#product').load(this.href);
	});

	function editProductSku(product_id) {

		if (is_product_processing) {
			return false;
		}
		is_product_processing = true;

		$('#edit_product_sku .modal-body #load_product_sku').html("");

		$('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

		$.ajax({
			url: 'products/manage/get_sku_list',
			//type: 'POST',
			//dataType: 'html',
			data: {
				product_id: product_id
			},
			success: function (html) {
				is_product_processing = false;
				$('.loading').remove().fadeOut();

				var response = JSON.stringify(html);
				response = JSON.parse(response);
				if (response.status == 'ng') {
					$.notify(response.msg, {
						'type': 'danger'
					});
					return false;
				}

				$('#edit_product_sku .modal-body #load_product_sku').html(html)

				$('#edit_product_sku').modal('show');
			},
			error: function (xhr, errorType, error) {
				is_product_processing = false;
				$('.loading').remove().fadeOut();
				$.notify({
							message: xhr.responseJSON.message + " Please reload the page!!!",
							url: window.location.href,
							target: "_self",
						},
						{
							'type': 'danger'
						},
				);
			}
		});
	}

	function submitEditProductSku() {

		if (is_product_processing) {
			return false;
		}
		is_product_processing = true;

		$('#edit_validation_error').html('');

		$.ajax({
			url: $("#edit_product_sku_form").attr('action'),
			type: 'POST',
			data: $("#edit_product_sku_form").serialize(),
			beforeSend: function () {
				$(this).find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
			},
			complete: function () {
				$(this).find('i').replaceWith('<i class="fas fa-save me-1"></i>');
			},
			success: function (data) {
				is_product_processing = false;
				var response = JSON.stringify(data);
				response     = JSON.parse(response);

				if (response.token) {
					// Update CSRF hash
					$("input[name*='" + csrf_token + "']").val(response.token);
				}

				if (response.status == 'ng') {
					$('#edit_validation_error').html(response.msg);

					for (key in response.error) {
						$('#input_' + key.replaceAll('.', '_')).addClass('is-invalid').find('.form-control, .form-select, .form-check-input, .form-check-label').addClass('is-invalid');
						$('#error_' + key.replaceAll('.', '_')).html(response.error[key]).addClass('d-block');

						$.notify(response.error[key], {
							'type': 'danger'
						});
					}

					return false;
				}

				$.notify(response.msg);
				$('#edit_product_sku').modal('hide');

				$('#product_' + response.data.product_id + '_price span').html(response.data.price);
				$('#product_' + response.data.product_id + '_quantity span').html(response.data.quantity);
			},
			error: function (xhr, errorType, error) {
				is_product_processing = false;
				$.notify({
							message: xhr.responseJSON.message + " Please reload the page!!!",
							url: window.location.href,
							target: "_self",
						},
						{
							'type': 'danger'
						},
				);
			}
		});
	}
</script>

