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
		<div class="row collapse {if !empty($filter.active)}show{/if}" id="filter_manage">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
						<div class="card-header">
							<div class="row">
								<div class="col-6">
									<h5 class="mb-0 mt-1 ms-2"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
								</div>
								<div class="col-6 text-end">
									<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('Admin.filter_submit')}</button>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.filter_name')}
									{form_input('name', set_value('name', $filter.name), ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
								</div>
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.filter_id')}
									{form_input('news_id]', set_value('news_id', $filter.news_id), ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}

								</div>
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.text_category')}
									{$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
									<select name="category_id" id="category_id" class="form-control">
										<option value="">{lang('Admin.text_select')}</option>
										{draw_tree_output_name(['data' => $category_list, 'key_id' => 'category_id'], $output_html, 0, $filter.category_id)}
									</select>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
									{lang('Admin.text_limit')}
									{form_dropdown('limit', get_list_limit(), set_value('limit', $filter.limit), ['class' => 'form-control form-control-sm'])}
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
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('NewsAdmin.text_list')}</h5>
					<div class="card-body">
						{if !empty($list)}
							{include file=get_theme_path('views/inc/paging.tpl') pager_name='news'}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											<th width="50">
												<a href="{site_url($manage_url)}?sort=news_id&order={$order}{$url}" class="text-dark">
													{lang('Admin.column_id')}
													{if $sort eq 'news_id'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>{lang('Admin.text_image')}</th>
											<th>
												<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
													{lang('NewsAdmin.text_name')}
													{if $sort eq 'name'}
														<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
													{/if}
												</a>
											</th>
											<th>{lang('Admin.column_published')}</th>
											<th width="160">{lang('Admin.column_function')}</th>
											<th width="50">{form_checkbox('manage_check_all')}</th>
										</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr>
											<td class="text-center">{anchor("$manage_url/edit/`$item.news_id`", $item.news_id, 'class="text-primary"')}</td>
											<td class="text-center">
												<div class="thumbnail">
													{foreach $item.images as $img_key => $img}
														{if !empty($img)}
															<a href="{image_url($img)}" data-lightbox="photos">
																<img src="{image_url($img)}" class="img-thumbnail me-1 img-fluid">
															</a>
															<br/>
															{$img_key}
														{/if}
													{/foreach}
												</div>
											</td>
											<td>
												{anchor("$manage_url/edit/`$item.news_id`", $item.name|unescape:"html", 'class="text-primary"')}<br/>
												<span class="list_datetime">{$item.ctime}</span><br />
												{$item.description}
												{if !empty($item.category_ids)}
													<ul class="list-unstyled bullet-check">
														{foreach $item.category_ids as $val}
															{if isset($category_list[$val])}
																<li class="text-secondary">{$category_list[$val].name}</li>
															{/if}
														{/foreach}
													</ul>
												{/if}
											</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.news_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.news_id, 'data-id' => $item.news_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.news_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.news_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.news_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
												</div>
											</td>
											<td class="text-center">{form_checkbox('manage_ids[]', $item.news_id)}</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>
							{include file=get_theme_path('views/inc/paging.tpl') pager_name='news'}
						{else}
							{lang('Admin.text_no_results')}
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
