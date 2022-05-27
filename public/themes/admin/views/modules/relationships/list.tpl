{strip}
{form_hidden('manage_url', site_url($manage_url))}
{csrf_field()}
<div class="container-fluid  dashboard-content">

	<div class="row">

		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="relationships"}
		</div>

		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

			<div class="row">
				<div class="col-sm-7 col-12">
					{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('RelationshipAdmin.heading_title')}
				</div>
				<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
					<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
					<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('RelationshipAdmin.text_add')}"><i class="fas fa-plus me-1"></i>{lang('RelationshipAdmin.text_add')}</a>
					<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
					{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('RelationshipAdmin.translate_frontend_id') translate_admin=lang('RelationshipAdmin.translate_admin_id')}
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
										{lang('RelationshipAdmin.text_candidate_table')}
										{form_input('candidate_table', set_value('candidate_table', $request->getGet('candidate_table'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('RelationshipAdmin.text_candidate_table')])}
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
										{lang('RelationshipAdmin.text_foreign_table')}
										{form_input('foreign_table', set_value('foreign_table', $request->getGet('foreign_table'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('RelationshipAdmin.text_foreign_table')])}
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
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('RelationshipAdmin.text_list')}</h5>
				<div class="card-body">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">
											<a href="{site_url($manage_url)}?sort=id&order={$order}{$url}" class="text-dark">
												{lang('Admin.column_id')}
												{if $sort eq 'id'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=candidate_table&order={$order}{$url}" class="text-dark">
												{lang('RelationshipAdmin.text_candidate_table')}
												{if $sort eq 'candidate_table'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=foreign_table&order={$order}{$url}" class="text-dark">
												{lang('RelationshipAdmin.text_foreign_table')}
												{if $sort eq 'foreign_table'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th width="130">{lang('Admin.column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{anchor("$manage_url/edit/`$item.id`", $item.id, 'class="text-primary"')}</td>
										<td class="text-center">
											{$item.candidate_table} - ID: {$item.candidate_key}
										</td>
										<td class="text-center">{$item.foreign_table} - ID: {$item.foreign_key}</td>
										<td class="text-center">
											<div class="btn-group ms-auto">
												<a href="{site_url($manage_url)}/edit/{$item.id}" class="btn btn-sm btn-light" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="{lang('Admin.button_edit')}" data-original-title="{lang('Admin.button_edit')}"{/if}><i class="fas fa-edit"></i></a>
												<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light text-danger btn_delete_single" {if count($list) > 1}data-bs-toggle="tooltip" data-placement="top" title="{lang('Admin.button_delete')}" data-original-title="{lang('Admin.button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
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
