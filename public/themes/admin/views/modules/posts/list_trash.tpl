{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('NewsAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('NewsAdmin.text_add')}"><i class="fas fa-plus"></i></a>
				<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>

				{if !empty($list)}
					<button type="button" class="btn btn-sm btn-danger btn-space" data-bs-toggle="modal" data-bs-target="#empty_trash"><i class="far fa-trash-alt me-1"></i>{lang('Admin.text_empty_trash')}</button>
				{/if}

				<a href="{site_url($manage_url)}" class="btn btn-sm btn-secondary btn-space" title="{lang('Admin.button_back')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_back')}</a>
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
		<div class="row collapse" id="filter_manage">
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

							</div>
						</div>

						{if !empty($list)}
							{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											<th width="150">
												<a href="{site_url($manage_url)}?sort=post_id&order={$order}{$url}" class="text-dark">
													{lang('Admin.text_image')}
													{if $sort eq 'post_id'}
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
										</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr id="item_id_{$item.post_id}">
											<td class="text-center">
												{anchor("$manage_url/edit/`$item.post_id`", $item.post_id, 'class="text-primary"')}
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
												{anchor("$manage_url/edit/`$item.post_id`", $item.name|unescape:"html", 'class="text-primary"')}<br/>
												<span class="list_datetime">{$item.publish_date}</span><br />
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

												<a href="{site_url($manage_url)}/restore/{$item.post_id}" class="btn btn-sm btn-light text-dark" title="{lang('Admin.button_restore')}"><i class="fas fa-reply"></i>&nbsp;{lang('Admin.button_restore')}</a>
												<button type="button" data-id="{$item.post_id}" class="btn btn-sm btn-danger ms-2 btn_delete_single" title="{lang('Admin.button_delete_permanently')}"><i class="fas fa-trash-alt"></i>&nbsp;{lang('Admin.button_delete_permanently')}</button>

											</td>
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
	<div class="modal fade" id="empty_trash" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addModalLabel">{lang('Admin.text_confirm_delete')}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pt-4">

					<div class="form-group text-center clearfix">
						<a href="{site_url($manage_url)}/empty_trash" class="btn btn-sm btn-space btn-danger"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete')}</a>
						<a href="#" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="fas fa-reply"></i> {lang('Admin.button_cancel')}</span>
						</a>
					</div>

				</div>
			</div>
		</div>
	</div>

{/strip}
