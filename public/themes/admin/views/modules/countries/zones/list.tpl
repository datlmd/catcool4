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
				<div class="row collapse show" id="filter_manage">
					<div class="col-12">
						<div class="card">
							<h5 class="card-header"><i class="fas fa-filter me-2"></i>{lang('Admin.filter_header')}</h5>
							{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
							<div class="card-body">
								<div class="row">
									
									<div class="col-lg-3 col-md-4 col-sm-4 col-12 mb-2">
										<label>{lang('CountryProvinceAdmin.text_country')}</label>
										{form_input('country', old('country', $request->getGet('country'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('CountryProvinceAdmin.text_country')])}
									</div>

									<div class="col-lg-3 col-md-4 col-sm-4 col-12 mb-2">
										<label>{lang('CountryProvinceAdmin.text_zone_name')}</label>
										{form_input('zone', old('zone', $request->getGet('zone'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('CountryProvinceAdmin.text_zone_name')])}
									</div>

									<div class="col-lg-3 col-md-2 col-sm-4 col-12 mb-2">
										<label>{lang('CountryProvinceAdmin.text_code')}</label>
										{form_input('code', old('code', $request->getGet('code'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('CountryProvinceAdmin.text_code')])}
									</div>

									<div class="col-lg-3 col-md-2 col-sm-4 col-12 mb-2">
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
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CountryProvinceAdmin.text_list')}</h5>
					<div class="card-body">
						{include file=get_theme_path('views/modules/countries/inc/link_list.tpl') active='provinces'}
						{if !empty($list)}
							<div class="table-responsive mb-2">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
									<tr class="text-center">
										<th width="50">{form_checkbox('manage_check_all')}</th>
										<th width="50">
											<a href="{site_url($manage_url)}?sort=zone_id&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'zone_id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>

										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=c.name&order={$order}{$url}" class="text-dark">
												{lang('CountryProvinceAdmin.text_country')}
												{if $sort eq 'c.name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>

										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=z.name&order={$order}{$url}" class="text-dark">
												{lang('CountryProvinceAdmin.text_zone_name')}
												{if $sort eq 'z.name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=code&order={$order}{$url}" class="text-dark">
												{lang('CountryProvinceAdmin.text_code')}
												{if $sort eq 'code'}
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
										
										<th width="120">{lang('Admin.column_published')}</th>
										<th width="130">{lang('Admin.column_function')}</th>
									</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr id="item_{$item.zone_id}">
											<td class="text-center">{form_checkbox('manage_ids[]', $item.zone_id)}</td>
											<td class="text-center">{anchor("$manage_url/edit/`$item.zone_id`", $item.zone_id)}</td>
											<td class="text-start">{$item.country}</td>
											<td>{anchor("$manage_url/edit/`$item.zone_id`", $item.name, 'class="text-primary"')}</td>
											<td>{$item.code}</td>
											<td class="text-center">{$item.telephone_code}</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.zone_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.zone_id, 'data-id' => $item.zone_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.zone_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.zone_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.zone_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
