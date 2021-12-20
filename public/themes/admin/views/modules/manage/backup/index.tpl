{strip}
	{form_hidden('manage_url', $manage_url)}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('Backup.heading_title')}

		<div class="card">
			<h5 class="card-header"><i class="fas fa-exchange-alt me-2"></i>{lang('Backup.heading_title')}</h5>
			<div class="card-body py-2">

				<div class="form-group row mt-3">
					<label class="col-12 col-sm-3 col-form-label text-end">
						{lang('Admin.button_import')}
					</label>
					<div class="col-12 col-sm-8 col-lg-6">
						<button class="btn btn-sm btn-secondary"><i class="fa fa-upload me-1"></i>{lang('Admin.button_import')}</button>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-12 col-sm-3 col-form-label text-end">
						{lang('Admin.button_export')}
					</label>
					<div class="col-12 col-sm-8 col-lg-6">
						<button id="btn_backup" class="btn btn-sm btn-outline-light"><i class="fa fa-download me-1"></i>{lang('Admin.button_export')}</button>
					</div>
				</div>
				<div class="form-group row my-3">
					<label class="col-12 col-sm-3 col-form-label text-end"></label>
					<div class="col-12 col-sm-8 col-lg-6">
						<div class="form-check ms-2">
							<input type="checkbox" name="cb_backup_all" id="cb_backup_all" value="all" checked="checked" class="form-check-input">
							<label class="form-check-label me-3 text-secondary" for="cb_backup_all">{lang('Admin.text_select_all')}</label>
						</div>
						<div id="tables" class="bg-light p-2" style="max-height: 350px; overflow-y: scroll;">
							{foreach $tables as $table}
								<div class="form-check">
									<input type="checkbox" name="cb_backup[]" id="cb_backup_{$table}" value="{$table}" checked="checked" class="form-check-input">
									<label class="form-check-label text-dark" for="cb_backup_{$table}">{$table}</label>
								</div>
							{/foreach}
						</div>
					</div>
				</div>

				<div id="progress_backup" class="progress" style="display: none;">
					<div id="progress_bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div id="progress_text" class="mb-3"></div>

			</div>
		</div>

		<div id="backup_history"></div>

	</div>

{/strip}

{literal}
	<script type="text/javascript">

		var is_processing = false;

		$(document).on('change', 'input[name="cb_backup_all"]', function() {
			$('input[name="cb_backup[]"]').prop('checked', $(this).prop("checked"));
		});

		$(document).on('click', '#btn_backup', function() {
			if (is_processing) {
				return false;
			}
			is_processing = true;
			$('#progress_backup').show();

			var next_url = base_url + '/manage/backup/export?table=' + $('input[name="cb_backup[]"]:checked').first().val();
			backup(next_url);
		});

		function backup(next_url) {
			var boxes = [];
			$('input[name="cb_backup[]"]:checked').each(function(){
				boxes.push($(this).val());
			});

			$.ajax({
				url: next_url,
				data: {
					'backup' : boxes,
					[$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
				},
				type: 'post',
				beforeSend: function () {
					$('#btn_backup').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
				},

				success: function (data) {
					var response = JSON.stringify(data);
					response     = JSON.parse(response);

					if (response.token) {
						// Update CSRF hash
						$("input[name*='" + csrf_token + "']").val(response.token);
					}

					if (response.error) {
						is_processing = false;

						$('#progress_bar').addClass('progress_bar-danger');
						$('#progress_text').html('<div class="text-danger">' + response.error + '</div>');

						$('#btn_backup').find('i').replaceWith('<i class="fa fa-download me-1"></i>');
						$('#progress_backup').hide();
					}
					if (response.success) {
						is_processing = false;
						$('#progress_bar').css('width', '100%').addClass('progress_bar-success');
                        $('#progress_bar').attr('aria-valuenow', '100');
                        $('#progress_bar').html('100%');

						$('#progress_text').html('<div class="text-success">' + response.success + '</div>');

						$('#btn_backup').find('i').replaceWith('<i class="fa fa-download me-1"></i>');
						$('#progress_backup').hide();

						history(base_url + "/manage/backup/history");
					}
					if (response.progress) {
						$('#progress_bar').css('width', response.progress + '%');
						$('#progress_bar').attr('aria-valuenow', response.progress);
						$('#progress_bar').html(response.progress + '%');
					}
					if (response.text) {
						$('#progress_text').html(response.text);
					}
					if (response.next) {
						backup(response.next);
					}
				},
				error: function (xhr, errorType, error) {
					console.log(error + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

					$('#btn_backup').find('i').replaceWith('<i class="fa fa-download me-1"></i>');
					is_processing = false;
					$('#progress_backup').hide();

					$.notify({
							message: xhr.responseJSON.message + " Please reload the page!!!",
							url: window.location.href,
							target: "_self",
						},
						{'type': 'danger'},
					);
				}
			});
		}

		function history(history_url) {
			if (is_processing) {
				return false;
			}
			is_processing = true;

			$.ajax({
				url: history_url,
				type: 'get',
				success: function (data) {
					is_processing = false;
					$('.loading').remove();

					var response = JSON.stringify(data);
					response     = JSON.parse(response);

					if (response.token) {
						// Update CSRF hash
						$("input[name*='" + csrf_token + "']").val(response.token);
					}

					if (response.data) {
						$('#backup_history').html(response.data);
					}

					if ($('[data-bs-toggle=\'tooltip\']').length) {
						$('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
						$('[data-bs-toggle=\'tooltip\']').tooltip();
					}
				},
				error: function (xhr, errorType, error) {
					console.log(error + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					$('.loading').remove();
					is_processing = false;
					$.notify({
							message: xhr.responseJSON.message + " Please reload the page!!!",
							url: window.location.href,
							target: "_self",
						},
						{'type': 'danger'},
					);
				}
			});
		}

		$(document).on('click', '#backup_history .pagination a', function(e) {
			e.preventDefault();

			$('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

			history($(this).attr('href'));

			return false;
		});

		$(document).on('click', '#backup_history a.restore', function(e) {

            if (is_processing) {
                return false;
            }
            is_processing = true;

            e.preventDefault();

            $('#progress_bar').css('width', '0%');
            $('#progress_bar').removeClass('progress-bar-danger progress-bar-success');

            $('#progress_backup').show();

            $('#progress_text').html('');

			restore($(this).attr('href'), this);

            return false;
        });

        function restore(next_url, obj) {
			return $.ajax({
				url: next_url,
				data: {
					[$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
				},
				type: 'post',
				beforeSend: function () {
					$(obj).find('i').replaceWith('<i class="fas fa-spinner fa-spin text-primary"></i>');
				},
				success: function (data) {
					var response = JSON.stringify(data);
					response     = JSON.parse(response);

					if (response.token) {
						// Update CSRF hash
						$("input[name*='" + csrf_token + "']").val(response.token);
					}

					if (response.error) {
						is_processing = false;

						$('#progress_bar').addClass('progress_bar-danger');
						$('#progress_text').html('<div class="invalid-feedback">' + response.error + '</div>');

                        $(obj).find('i').replaceWith('<i class="fas fa-sync text-primary"></i>');
						$('#progress_backup').hide();
					}
					if (response.success) {
						is_processing = false;

						$('#progress_bar').css('width', '100%').addClass('progress_bar-success');
                        $('#progress_bar').attr('aria-valuenow', '100');
                        $('#progress_bar').html('100%');

						$('#progress_text').html('<div class="text-success">' + response.success + '</div>');

                        $(obj).find('i').replaceWith('<i class="fas fa-sync text-primary"></i>');
						$('#progress_backup').hide();
					}
					if (response.progress) {
						$('#progress_bar').css('width', response.progress + '%');
						$('#progress_bar').attr('aria-valuenow', response.progress);
						$('#progress_bar').html(response.progress + '%');
					}
					if (response.text) {
						$('#progress_text').html(response.text);
					}
					if (response.next) {
						restore(response.next, obj);
					}
				},
				error: function (xhr, errorType, error) {
					console.log(error + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                    $(obj).find('i').replaceWith('<i class="fas fa-sync text-primary"></i>');
					is_processing = false;
					$('#progress_backup').hide();

					$.notify({
                            message: xhr.responseJSON.message + " Please reload the page!!!",
                            url: window.location.href,
                            target: "_self",
                        },
                        {'type': 'danger'},
					);
				}
			});
		}

		$(document).on('click', '#backup_history a.delete', function(e) {
			e.preventDefault();

			if (is_processing) {
				return false;
			}
			is_processing = true;

			$('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

			var tr_id = $(this).data('id');
			$.ajax({
				url: $(this).attr('href'),
				type: 'get',
				success: function (data) {
					is_processing = false;
					$('.loading').remove();

					var response = JSON.stringify(data);
					response     = JSON.parse(response);

					if (response.token) {
						// Update CSRF hash
						$("input[name*='" + csrf_token + "']").val(response.token);
					}

					if (response.status == 'ng') {
						$.notify(response.msg, {
							'type':'danger'
						});
						return false;
					}

					$.notify(response.msg);

					$('tr#' + tr_id).remove();
				},
				error: function (xhr, errorType, error) {
					console.log(error + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					$('.loading').remove();
					is_processing = false;
					$.notify({
							message: xhr.responseJSON.message + " Please reload the page!!!",
							url: window.location.href,
							target: "_self",
						},
						{'type': 'danger'},
					);
				}
			});

			return false;
		});

		$(function () {
			history(base_url + "/manage/backup/history");
		});
	</script>
{/literal}