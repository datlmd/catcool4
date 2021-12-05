{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('NewsAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
				<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('NewsAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('NewsAdmin.text_add')}</a>
				<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
				<a href="{site_url($manage_url)}" class="btn btn-sm btn-primary btn-space" title="{lang('Admin.button_back')}"><i class="fas fa-list me-1"></i>{lang('Admin.button_back')}</a>
				<button id="btn_group_drop_setting" type="button" class="btn btn-sm btn-light btn-space me-0" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="fas fa-cog"></i>
				</button>
				<ul class="dropdown-menu" aria-labelledby="btn_group_drop_setting">
					<li><a class="dropdown-item" href="{site_url('news/categories_manage')}">{lang('CategoryAdmin.heading_title')}</a></li>
					<li><a class="dropdown-item" href="{site_url('translations/manage')}?module_id={lang('NewsAdmin.translate_frontend_id')}">{lang("Admin.text_translate")}</a></li>
					<li><a class="dropdown-item" href="{site_url('translations/manage')}?module_id={lang('NewsAdmin.translate_admin_id')}">{lang("Admin.text_translate_admin")}</a></li>
				</ul>
			</div>
		</div>
		<div class="row collapse show" id="filter_manage">
			<div class="col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
					<div class="card-body">
						{include file=get_theme_path('views/modules/news/inc/filter_form.tpl')}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('NewsAdmin.text_list')} - {lang('Admin.text_trash')}</h5>
					<div class="card-body">
						<div class="row">
							<div class="col-12 text-end mb-2">
								<button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#robot_news"><i class="far fa-newspaper me-1"></i>{lang('NewsAdmin.text_empty_transh')}</button>
							</div>
						</div>

						{if !empty($list)}
							{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											<th width="150">
												<a href="{site_url($manage_url)}?sort=news_id&order={$order}{$url}" class="text-dark">
													{lang('Admin.text_image')}
													{if $sort eq 'news_id'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th style="min-width: 450px;">
												<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
													{lang('NewsAdmin.text_name')}
													{if $sort eq 'name'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th width="50">{form_checkbox('manage_check_all')}</th>
										</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr id="item_id_{$item.news_id}">
											<td class="text-center">
												{anchor("$manage_url/edit/`$item.news_id`", $item.news_id, 'class="text-primary"')}
												<div class="thumbnail">
													{if !empty($item.images.thumb)}
														<a href="{image_url($item.images.thumb)}" data-lightbox="photos">
															<img src="{image_url($item.images.thumb, 200, 120)}" class="img-thumbnail me-1 img-fluid w-100">
														</a>
													{elseif !empty($item.images.robot)}
														<a href="{image_url($item.images.robot)}" data-lightbox="photos">
															<img src="{image_url($item.images.robot, 200, 120)}" class="img-thumbnail me-1 img-fluid w-100">
														</a>
													{/if}
												</div>
											</td>
											<td>
												{anchor("$manage_url/edit/`$item.news_id`", $item.name|unescape:"html", 'class="text-primary"')}<br/>
												<span class="list_datetime">{$item.ctime}</span><br />
												{$item.description}
												{if !empty($item.category_ids)}
													<ul class="list-unstyled bullet-check mb-0">
														{foreach $item.category_ids as $val}
															{if isset($category_list[$val])}
																<li class="text-secondary">{$category_list[$val].name}</li>
															{/if}
														{/foreach}
													</ul>
												{/if}
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.news_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_restore')}"><i class="fas fa-reply"></i>&nbsp;{lang('Admin.button_restore')}</a>
													<button type="button" data-id="{$item.news_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete_permanently')}"><i class="fas fa-trash-alt"></i>&nbsp;{lang('Admin.button_delete_permanently')}</button>
												</div>
											</td>
											<td class="text-center">{form_checkbox('manage_ids[]', $item.news_id)}</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>
							{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
						{else}
							{lang('Admin.text_no_results')}
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal add -->
	<div class="modal fade" id="robot_news" tabindex="-1" role="dialog" aria-labelledby="robotNewsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addModalLabel">Robot- Scan News</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="robot_validation_error" class="text-danger mb-2"></div>

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						{form_open('news/manage/robot', ['id' => 'robot_news_form'])}

						<div class="form-group mb-4">
							<label class="form-label">Url</label>
							<input type="text" name="url" value="" id="source" class="form-control">
						</div>

						<div class="form-group">
							<label class="form-check">
								<input type="radio" name="robot_type" value="kenh14" checked="checked" id="robot_type_kenh14" class="form-check-input">
								<label class="form-check-label fw-bold" for="robot_type_kenh14">Kênh 14</label>
							</label>
							{if !empty($kenh14_list['attribute_menu'])}
								{foreach $kenh14_list['attribute_menu'] as $key => $value}
									<div class="form-check form-check-inline me-2">
										<input class="form-check-input" type="checkbox" name="robot_href[]" value="{$value.href}" id="robot_href_{$key}">
										<label class="form-check-label" for="robot_href_{$key}">
											{$value.title}
										</label>
									</div>
								{/foreach}
							{/if}
						</div>

						<div class="form-group row text-center">
							<div class="col-12 col-sm-3"></div>
							<div class="col-12 col-sm-8 col-lg-6">
								<button type="button" onclick="robotNewsScan()" class="btn btn-sm btn-space btn-primary btn-robot-news"><i class="far fa-newspaper me-1"></i>{lang('NewsAdmin.text_robot_news')}</button>
								<a href="#" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close">
									<span aria-hidden="true"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</span>
								</a>
							</div>
						</div>
						{form_close()}
					</div>
				</div>
			</div>
		</div>
	</div>

{literal}
	<script>
		var is_robot_processing = false;

		function robotNewsScan() {
			if (is_robot_processing) {
				return false;
			}
			is_robot_processing = true;

			$("#robot_validation_error").html('');

			if ($('#robot_news input[name="url"]').val() != "") {
				window.location.href = 'news/manage/add?url=' + $('#robot_news input[name="url"]').val();

				return;
			} else {

				$.ajax({
					url: $("#robot_news_form").attr('action'),
					type: 'POST',
					data: $("#robot_news_form").serialize(),
					beforeSend: function () {
						$('.btn-robot-news').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
					},
					complete: function () {
						$('.btn-robot-news').find('i').replaceWith('<i class="far fa-newspaper me-1"></i>');
					},
					success: function (data) {
						is_robot_processing = false;

						var response = JSON.stringify(data);
						response = JSON.parse(response);

						if (response.token) {
							// Update CSRF hash
							$("input[name*='" + csrf_token + "']").val(response.token);
						}

						if (response.status == 'ng') {
							$("#robot_validation_error").html(response.msg);
							return false;
						}

						if (response.status == 'ok') {
							location.reload();
						}
					},
					error: function (xhr, errorType, error) {
						$("#robot_validation_error").html(xhr.responseJSON.message + " Please reload the page!!!");
						is_robot_processing = false;
					}
				});
			}
		}

		function changeStatus(obj, type) {
			if (is_processing) {
				return false;
			}
			if (!$('input[name="manage_url"]').length) {
				return false;
			}

			var manage   = $('input[name="manage_url"]').val();
			var id       = $(obj).data("id");
			var is_check = 0;
			var url_api  = manage + '/status';

			if ($(obj).is(':checked')) {
				is_check = 1;
			}

			is_processing = true;
			$.ajax({
				url: url_api,
				data: {
					'id' : id,
					'status': is_check,
					'type': type,
					[$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
				},
				type:'POST',
				success: function (data) {
					is_processing = false;

					var response = JSON.stringify(data);
					response = JSON.parse(response);

					if (response.token) {
						// Update CSRF hash
						$("input[name*='" + csrf_token + "']").val(response.token);
					}

					if (response.status == 'ng') {
						$.notify(response.msg, {'type':'danger'});
						$(obj).prop("checked", $(obj).attr("value"));
						return false;
					}
					$.notify(response.msg);
				},
				error: function (xhr, errorType, error) {
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

		$(function () {
			$(document).on('change', '.change_hot', function(e) {
				e.preventDefault();
				changeStatus(this, 'is_hot');
			});

			$(document).on('change', '.change_homepage', function(e) {
				e.preventDefault();
				changeStatus(this, 'is_homepage');
			});
		});
	</script>
{/literal}

{/strip}
