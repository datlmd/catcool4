{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">

		<div class="row">

			<div class="col-sm-9 col-12">

				<div class="row">
					<div class="col-sm-7 col-12">
						{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryProvinceAdmin.heading_title')}
					</div>
					<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
						<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
						<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('CountryProvinceAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('CountryProvinceAdmin.text_add')}</a>
						<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
						{include file=get_theme_path('views/inc/button_translate.tpl') translate_admin=lang('CountryProvinceAdmin.translate_admin_id')}
					</div>
				</div>
				<div class="row collapse {if !empty($filter_active)}show{/if}" id="filter_manage">
					<div class="col-12">
						<div class="card">
							<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
							{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
							<div class="card-body">
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										{lang('Admin.filter_name')}
										{form_input('name', old('name', $request->getGet('name'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										{lang('CountryProvinceAdmin.text_country')}
										{form_dropdown('country_id', $country_list, old('country_id', $request->getGet('country_id'))|default:'', ['class' => 'form-control'])}
									</div>

									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										{lang('Admin.text_limit')}
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
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CountryProvinceAdmin.text_list')}</h5>
					<div class="card-body">
						{include file=get_theme_path('views/modules/countriesold/inc/link_list.tpl') active='provinces'}
						{if !empty($list)}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
									<tr class="text-center">
										<th width="50">{form_checkbox('manage_check_all')}</th>
										<th width="50">
											<a href="{site_url($manage_url)}?sort=province_id&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'province_id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
												{lang('Admin.text_name')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=type&order={$order}{$url}" class="text-dark">
												{lang('CountryProvinceAdmin.text_type')}
												{if $sort eq 'type'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=telephone_code&order={$order}{$url}" class="text-dark">
												{lang('CountryProvinceAdmin.text_telephone_code')}
												{if $sort eq 'telephone_code'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
{*										<th>*}
{*											<a href="{site_url($manage_url)}?sort=zip_code&order={$order}{$url}" class="text-dark">*}
{*												{lang('CountryProvinceAdmin.text_code')}*}
{*												{if $sort eq 'zip_code'}*}
{*													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>*}
{*												{/if}*}
{*											</a>*}
{*										</th>*}
										<th>
											<a href="{site_url($manage_url)}?sort=country_code&order={$order}{$url}" class="text-dark">
												{lang('CountryProvinceAdmin.text_country_code')}
												{if $sort eq 'country_code'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=country_id&order={$order}{$url}" class="text-dark">
												{lang('CountryProvinceAdmin.text_country')}
												{if $sort eq 'country_id'}
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
											<td class="text-center">{form_checkbox('manage_ids[]', $item.province_id)}</td>
											<td class="text-center">{$item.province_id}</td>
											<td>{anchor("$manage_url/edit/`$item.province_id`", htmlspecialchars($item.name, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}</td>
											<td>{$item.type}</td>
											<td class="text-center">{$item.telephone_code}</td>
{*											<td class="text-center">{$item.zip_code}</td>*}
											<td class="text-center">{$item.country_code}</td>
											<td class="text-center">{$country_list[$item.country_id]}</td>
											<td class="text-center">{$item.sort_order}</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.province_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.province_id, 'data-id' => $item.province_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.province_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.province_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.province_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
				{include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="countries"}
			</div>
			
		</div>
	</div>
{/strip}
