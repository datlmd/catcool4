{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">

		<div class="row">
			

			<div class="col-sm-9 col-12">

				<div class="row">
					<div class="col-sm-7 col-12">
						{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryDistrictAdmin.heading_title')}
					</div>
					<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
						<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
						<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('CountryDistrictAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('CountryDistrictAdmin.text_add')}</a>
						<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
						{include file=get_theme_path('views/inc/button_translate.tpl') translate_admin=lang('CountryDistrictAdmin.translate_admin_id')}
					</div>
				</div>
				<div class="row collapse show" id="filter_manage">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="card">
							<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
							{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
							<div class="card-body">
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										<label>{lang('CountryDistrictAdmin.text_name')}</label>
										{form_input('name', old('name', $request->getGet('name'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.text_name')])}
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									<label>{lang('CountryDistrictAdmin.text_province')}</label>
										{form_input('zone', old('name', $request->getGet('zone'))|default:'', ['class' => 'form-control form-control-sm'])}
									</div>

									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										<label>{lang('Admin.text_limit')}</label>
										{form_dropdown('limit', get_list_limit(), old('limit', $request->getGet('limit')), ['class' => 'form-control form-control-sm'])}
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
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CountryDistrictAdmin.text_list')}</h5>
					<div class="card-body">
						{include file=get_theme_path('views/modules/countries/inc/link_list.tpl') active='districts'}
						{if !empty($list)}
							<div class="table-responsive mb-2">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
									<tr class="text-center">
										<th width="50">{form_checkbox('manage_check_all')}</th>
										<th width="50">
											<a href="{site_url($manage_url)}?sort=district_id&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'district_id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>

										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=zone&order={$order}{$url}" class="text-dark">
												{lang('CountryDistrictAdmin.text_province')}
												{if $sort eq 'zone'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>

										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
												{lang('CountryDistrictAdmin.text_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=type&order={$order}{$url}" class="text-dark">
												{lang('CountryDistrictAdmin.text_type')}
												{if $sort eq 'type'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										
										<th>
											<a href="{site_url($manage_url)}?sort=lati_long_tude&order={$order}{$url}" class="text-dark">
												{lang('CountryDistrictAdmin.text_lati_long_tude')}
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
										<th width="120">{lang('Admin.column_published')}</th>
										<th width="130">{lang('Admin.column_function')}</th>
									</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr>
											<td class="text-center">{form_checkbox('manage_ids[]', $item.district_id)}</td>
											<td class="text-center">{anchor("$manage_url/edit/`$item.district_id`", $item.district_id)}</td>
											
											<td>
												{$item.zone}<br/>
												<small>{$item.country}</small>
											</td>

											<td>{anchor("$manage_url/edit/`$item.district_id`", $item.name, 'class="text-primary"')}</td>
											<td>{$item.type}</td>
											
											<td class="text-center">{$item.lati_long_tude}</td>
											<td class="text-center">{$item.sort_order}</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.district_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.district_id, 'data-id' => $item.district_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.district_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.district_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.district_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
												</div>
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

			<div class="col-sm-3 col-12">
				{include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="zones"}
			</div>
			
		</div>
	</div>
{/strip}
