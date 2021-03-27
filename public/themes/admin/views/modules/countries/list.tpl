{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CountryAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
				<a href="{site_url($manage_url)}/add{http_get_query()}" class="btn btn-sm btn-primary btn-space" title="{lang('CountryAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('CountryAdmin.text_add')}</a>
				<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space me-0" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
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
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									<label class="form-label">{lang('Admin.filter_id')}</label>
									{form_input('country_id', set_value('country_id', $filter.country_id), ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									<label class="form-label">{lang('CountryAdmin.text_country')}</label>
									{form_input('name', set_value('name', $filter.name), ['class' => 'form-control form-control-sm', 'placeholder' => lang('CountryAdmin.text_country')])}
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
									<label class="form-label">{lang('Admin.text_limit')}</label>
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
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('CountryAdmin.text_list')}</h5>
					<div class="card-body">
						{include file=get_theme_path('views/modules/countries/inc/link_list.tpl') active='countries'}
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
												{lang('CountryAdmin.text_country')}
												{if $sort eq 'name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=formal_name&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_formal_name')}
												{if $sort eq 'formal_name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=country_code&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country_code')}
												{if $sort eq 'country_code'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=country_code3&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country_code3')}
												{if $sort eq 'country_code3'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=country_type&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country_type')}
												{if $sort eq 'country_type'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=country_sub_type&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country_sub_type')}
												{if $sort eq 'country_sub_type'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=sovereignty&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_sovereignty')}
												{if $sort eq 'sovereignty'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=capital&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_capital')}
												{if $sort eq 'capital'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=currency_code&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_currency_code')}
												{if $sort eq 'currency_code'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=currency_name&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_currency_name')}
												{if $sort eq 'currency_name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=telephone_code&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_telephone_code')}
												{if $sort eq 'telephone_code'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=country_number&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_country_number')}
												{if $sort eq 'country_number'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=internet_country_code&order={$order}{$url}" class="text-dark">
												{lang('CountryAdmin.text_internet_country_code')}
												{if $sort eq 'internet_country_code'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>{lang('CountryAdmin.text_flags')}</th>
										<th>
											<a href="{site_url($manage_url)}?sort=sort_order&order={$order}{$url}" class="text-dark">
												{lang('Admin.text_sort_order')}
												{if $sort eq 'sort_order'}
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
											<td class="text-center">{anchor("$manage_url/edit/`$item.country_id`", $item.country_id, 'class="text-primary"')}</td>
											<td>{anchor("$manage_url/edit/`$item.country_id`", $item.name, 'class="text-primary"')}</td>
											<td class="text-center">{$item.formal_name}</td>
											<td class="text-center">{$item.country_code}</td>
											<td class="text-center">{$item.country_code3}</td>
											<td class="text-center">{$item.country_type}</td>
											<td class="text-center">{$item.country_sub_type}</td>
											<td class="text-center">{$item.sovereignty}</td>
											<td class="text-center">{$item.capital}</td>
											<td class="text-center">{$item.currency_code}</td>
											<td class="text-center">{$item.currency_name}</td>
											<td class="text-center">{$item.telephone_code}</td>
											<td class="text-center">{$item.country_number}</td>
											<td class="text-center">{$item.internet_country_code}</td>
											<td class="text-center">{$item.flags}</td>
											<td class="text-center">{$item.sort_order}</td>
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
											<td class="text-center">{form_checkbox('manage_ids[]', $item.country_id)}</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>
							<div class="row mt-2">
								<div class="col-sm-4 col-12 my-auto">
									{pager_string($pager->getTotal('countries'), $pager->getPerPage('countries'), $pager->getCurrentPage('countries'))}
								</div>
								<div class="col-sm-8 col-12">
									{$pager->links('countries', 'admin')}
								</div>
							</div>
						{else}
							<label class="form-label">{lang('Admin.text_no_results')}</label>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
