{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">

		<div class="row">

			<div class="col-sm-9 col-12">
				<div class="row">
					<div class="col-sm-7 col-12">
						{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryAdmin.heading_title')}
					</div>
					<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
						<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
						<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('CountryAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('CountryAdmin.text_add')}</a>
						<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
						{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('CountryAdmin.translate_frontend_id') translate_admin=lang('CountryAdmin.translate_admin_id')}
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
										<label class="form-label">{lang('Admin.filter_id')}</label>
										{form_input('country_id', set_value('country_id', $request->getGet('country_id'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										<label class="form-label">{lang('CountryAdmin.text_country')}</label>
										{form_input('name', set_value('name', $request->getGet('name'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('CountryAdmin.text_country')])}
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										<label class="form-label">{lang('Admin.text_limit')}</label>
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

				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CountryAdmin.text_list')}</h5>
					<div class="card-body">
						{include file=get_theme_path('views/modules/countries/inc/link_list.tpl') active='countries'}
						{if !empty($list)}
							<div class="table-responsive mb-2">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
									<tr class="text-center">
										<th width="50">{form_checkbox('manage_check_all')}</th>
										<th width="50">
											<a href="{site_url($manage_url)}?sort=country_id&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'country_id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th class="text-start">
											<a href="{site_url($manage_url)}?sort=name&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
						
										<th>
											<a href="{site_url($manage_url)}?sort=iso_code_2&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country_code')}
												{if $sort eq 'iso_code_2'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>	
										<th>
											<a href="{site_url($manage_url)}?sort=iso_code_3&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country_code3')}
												{if $sort eq 'iso_code_3'}
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
											<td class="text-center">{form_checkbox('manage_ids[]', $item.country_id)}</td>
											<td class="text-center">{anchor("$manage_url/edit/`$item.country_id`", $item.country_id, 'class="text-primary"')}</td>
											<td>{anchor("$manage_url/edit/`$item.country_id`", $item.name, 'class="text-primary"')}</td>
											
											<td class="text-center">{$item.iso_code_2}</td>
											<td class="text-center">{$item.iso_code_3}</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.country_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.country_id, 'data-id' => $item.country_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.country_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ms-auto">
													<a href="{site_url($manage_url)}/edit/{$item.country_id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
													<button type="button" data-id="{$item.country_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
												</div>
											</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>

							{include file=get_theme_path('views/inc/paging.tpl') pager_name='default'}
						{else}
							<label class="form-label">{lang('Admin.text_no_results')}</label>
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
