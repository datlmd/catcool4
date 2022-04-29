{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryWardAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
				<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('CountryWardAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('CountryWardAdmin.text_add')}</a>
				<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
				{include file=get_theme_path('views/inc/button_translate.tpl') translate_admin=lang('CountryWardAdmin.translate_admin_id')}
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
									{lang('Admin.text_name')}
									{form_input('name', set_value('name', $request->getGet('name'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.text_name')])}
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									{lang('CountryWardAdmin.text_district')}
									{form_dropdown('district_id', $district_list, set_value('district_id', $request->getGet('district_id'))|default:'', ['class' => 'form-control'])}
								</div>

								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
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
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CountryWardAdmin.text_list')}</h5>
					<div class="card-body">
						{include file=get_theme_path('views/modules/countries/inc/link_list.tpl') active='wards'}
						{if !empty($list)}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
									<tr class="text-center">
										<th width="50">
											<a href="{site_url($manage_url)}?sort=country_id&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'country_id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
												{lang('Admin.text_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=type&order={$order}{$url}" class="text-dark">
												{lang('CountryWardAdmin.text_type')}
												{if $sort eq 'type'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=lati_long_tude&order={$order}{$url}" class="text-dark">
												{lang('CountryWardAdmin.text_lati_long_tude')}
												{if $sort eq 'lati_long_tude'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=sort_order&order={$order}{$url}" class="text-dark">
												{lang('Admin.text_sort_order')}
												{if $sort eq 'sort_order'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=province&order={$order}{$url}" class="text-dark">
												{lang('CountryWardAdmin.text_province')}
												{if $sort eq 'province'}
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
											<td class="text-center">{$item.ward_id}</td>
											<td>{anchor("$manage_url/edit/`$item.ward_id`", htmlspecialchars($item.name, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}</td>
											<td class="text-center">{$item.type}</td>
											<td class="text-center">{$item.lati_long_tude}</td>
											<td class="text-center">{$item.sort_order}</td>
											<td class="text-center">{$district_list[$item.district_id]}</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.ward_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.ward_id, 'data-id' => $item.ward_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.ward_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.ward_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.ward_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
												</div>
											</td>
											<td class="text-center">{form_checkbox('manage_ids[]', $item.ward_id)}</td>
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
{/strip}
