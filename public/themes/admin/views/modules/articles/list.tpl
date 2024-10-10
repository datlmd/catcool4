{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ArticleAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				{if !empty($is_trash)}
					{if !empty($list)}
						<button type="button" class="btn btn-sm btn-danger btn-space" data-bs-toggle="modal" data-bs-target="#empty_trash"><i class="far fa-trash-alt me-1"></i>{lang('Admin.text_empty_trash')}</button>
					{/if}
					<a href="{site_url($manage_url)}" class="btn btn-sm btn-secondary btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_back')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_back')}</a>
				{else}
					<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
					<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('ArticleAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('ArticleAdmin.text_add')}</a>
					<a href="{site_url($manage_url)}?is_trash=1" class="btn btn-sm btn-secondary btn-space" data-bs-toggle="tooltip" title="{lang('Admin.button_trash')}"><i class="fas fa-trash me-1"></i>({$count_trash})</a>
					<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
				{/if}

				{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('ArticleAdmin.translate_frontend_id') translate_admin=lang('ArticleAdmin.translate_admin_id')}
			</div>
		</div>
		<div class="row collapse {if !empty($filter_active)}show{/if}" id="filter_manage">
			<div class="col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
					{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
						<div class="card-body">
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.filter_name')}
									{form_input('name', set_value('name', $request->getGet('name'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
								</div>
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.filter_id')}
									{form_input('article_id', set_value('article_id', $request->getGet('article_id'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
								</div>
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.text_category')}
									{$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
									<select name="category" id="category" class="form-control">
										<option value="">{lang('Admin.text_select')}</option>
										{draw_tree_output_name(['data' => $category_list, 'key_id' => 'category_id'], $output_html, 0, $request->getGet('category')|default:'')}
									</select>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.text_limit')}
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
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header">
						<i class="fas fa-list me-2"></i>
						{lang('ArticleAdmin.text_list')}
						{if !empty($is_trash)} - {lang('Admin.text_trash')}{/if}
					</h5>
					<div class="card-body">
						{if !empty($list)}

							{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}

							<div class="table-responsive my-2">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											{if empty($is_trash)}
												<th width="50">{form_checkbox('manage_check_all')}</th>
											{/if}
											<th width="50">
												<a href="{site_url($manage_url)}?sort=article_id&order={$order}{$url}" class="text-dark">
													{lang('Admin.column_id')}
													{if $sort eq 'article_id'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th width="120">{lang('Admin.text_image')}</th>
											<th class="text-start">
												<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
													{lang('ArticleAdmin.text_name')}
													{if $sort eq 'name'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											{if empty($is_trash)}
												<th width="120">{lang('Admin.column_published')}</th>
												<th width="130">{lang('Admin.column_function')}</th>
											{else}
												<th>{lang('Admin.column_function')}</th>
											{/if}
											
										</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr id="item_id_{$item.article_id}">
											{if empty($is_trash)}	
												<td class="text-center">{form_checkbox('manage_ids[]', $item.article_id)}</td>
											{/if}
											<td class="text-center">{anchor("$manage_url/edit/`$item.article_id`", $item.article_id, 'class="text-primary"')}</td>
											<td class="text-center">
												<div class="thumbnail">
													<a href="{image_url($item.images)}" data-lightbox="photos">
														<img src="{$item.image}" class="img-thumbnail me-1 img-fluid">
													</a>
												</div>
											</td>
											<td>
												{anchor("$manage_url/edit/`$item.article_id`", htmlspecialchars($item.name, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}<br/>
												<span class="list_datetime">{$item.created_at}</span><br />
												{$item.description}
												{if !empty($item.relationship)}
													<ul class="list-unstyled bullet-check">
														{foreach $item.relationship as $val}
															{if isset($list_category[$val.category_id])}
																<li class="text-secondary">{$list_category[$val.category_id].detail.name}</li>
															{/if}
														{/foreach}
													</ul>
												{/if}

												
											</td>
											{if empty($is_trash)}
												<td>
													<div class="switch-button switch-button-xs catcool-center">
														{form_checkbox("published_`$item.article_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.article_id, 'data-id' => $item.article_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
														<span><label for="published_{$item.article_id}"></label></span>
													</div>
												</td>
											{/if}

											<td class="text-center">

												{if !empty($is_trash)}
													<a href="{site_url($manage_url)}/restore/{$item.article_id}" class="btn btn-sm btn-light text-dark" title="{lang('Admin.button_restore')}"><i class="fas fa-reply"></i>&nbsp;{lang('Admin.button_restore')}</a>
													<button type="button" data-id="{$item.article_id}" data-is-trash="1" class="btn btn-sm btn-danger ms-2 btn_delete_single" title="{lang('Admin.button_delete_permanently')}"><i class="fas fa-trash-alt"></i>&nbsp;{lang('Admin.button_delete_permanently')}</button>
												{else}
													<div class="btn-group ms-auto">
														<a href="{site_url($manage_url)}/edit/{$item.article_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
														<button type="button" data-id="{$item.article_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
													</div>
												{/if}
												
											</td>
								
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>

							{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
						{else}
							<label class="fs-5">{lang('Admin.text_no_results')}</label>
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
