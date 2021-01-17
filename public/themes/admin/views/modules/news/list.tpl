{form_hidden('manage_url', $manage_url)}
<div class="container-fluid dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
			{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
			<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete_all')}"><i class="fas fa-trash-alt"></i></span>
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
			<button type="button" id="btn_search" class="btn btn-sm btn-brand" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
		</div>
	</div>
	<div class="row collapse {if $filter_active}show{/if}" id="filter_manage">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
                {form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
					<div class="card-header">
						<div class="row">
							<div class="col-6">
								<h5 class="mb-0 mt-1 ml-2"><i class="fas fa-filter mr-2"></i>{lang('filter_header')}</h5>
							</div>
							<div class="col-6 text-right">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>{lang('filter_submit')}</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
								{lang('filter_name')}
								{form_input('filter[name]', $this->input->get('filter[name]'), ['class' => 'form-control form-control-sm', 'placeholder' => lang('filter_name')])}
							</div>
							<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
								{lang('filter_id')}
								{form_input('filter[id]', $this->input->get('filter[id]'), ['class' => 'form-control form-control-sm', 'placeholder' => lang('filter_id')])}

							</div>
							<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
								{lang('text_category')}
								<select name="filter[category]" id="filter[category]" class="form-control">
									<option value="">{lang('text_select')}</option>
                                    {draw_tree_output_name(['data' => $list_category_filter, 'key_id' => 'category_id'], $output_html, 0, $this->input->get('filter[category]'))}
								</select>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
								{lang('text_limit')}
								{form_dropdown('filter_limit', get_list_limit(), $this->input->get('filter_limit'), ['class' => 'form-control form-control-sm'])}
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
				<h5 class="card-header"><i class="fas fa-list mr-2"></i>{lang('text_list')}</h5>
				<div class="card-body">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('column_id')}</th>
										<th>Thumb</th>
										<th>{lang('column_name')}</th>
										<th>{lang('column_published')}</th>
										<th width="160">{lang('column_function')}</th>
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
															<img src="{image_url($img)}" class="img-thumbnail mr-1 img-fluid">
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
											{$item.description|unescape:"html"}<br/>
											<small><a href="{$item.source}" target="_blank">{$item.source}</a></small>
											{if !empty($item.category_ids)}
												<ul class="list-unstyled bullet-check">
													{foreach $item.category_ids as $val}
														{if isset($list_category[$val])}
															<li class="text-secondary">{$list_category[$val].name}</li>
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
											<div class="btn-group ml-auto">
												<a href="{$manage_url}/edit/{$item.news_id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
												<button type="button" data-id="{$item.news_id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.news_id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
						{include file=get_theme_path('views/inc/paging.inc.tpl')}
					{else}
						{lang('text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
