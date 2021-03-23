{strip}
{form_hidden('manage_url', $manage_url)}
{csrf_field()}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-6 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.heading_title')}
		</div>
		<div class="col-sm-6 col-12 mb-2 mb-sm-0 text-end">
			<span id="delete_multiple" class="btn btn-sm btn-danger btn-space" style="display: none;" title="{lang('Admin.button_delete_all')}"><i class="fas fa-trash-alt me-1"></i>{lang('Admin.button_delete_all')}</span>
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary btn-space" title="{lang('UserAdmin.button_add')}"><i class="fas fa-plus me-1"></i>{lang('UserAdmin.button_add')}</a>
			<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter me-1"></i>{lang('Admin.filter_header')}</button>
			<a href="{site_url("users/groups_manage")}" class="btn btn-sm btn-primary btn-space me-0"><i class="fas fa-list me-1"></i> {lang('Admin.module_group')}</a>
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
							<label class="form-label">{lang('UserAdmin.filter_search_user')}</label>
							{form_input('name', set_value('name', $filter.name), ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
							<label class="form-label">{lang('Admin.filter_id')}</label>
							{form_input('id', set_value('id', $filter.id), ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
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
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('UserAdmin.text_list')}</h5>
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
											<a href="{site_url($manage_url)}?sort=username&order={$order}{$url}" class="text-dark">
												{lang('Admin.text_username')}
												{if $sort eq 'username'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=first_name&order={$order}{$url}" class="text-dark">
												{lang('Admin.text_full_name')}
												{if $sort eq 'first_name'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>
											<a href="{site_url($manage_url)}?sort=email&order={$order}{$url}" class="text-dark">
												{lang('UserAdmin.text_email')}
												{if $sort eq 'email'}
													<i class="fas {if $order eq 'DESC'}fa-angle-up{else}fa-angle-down{/if} ms-1"></i>
												{/if}
											</a>
										</th>
										<th>{lang('UserAdmin.text_phone')}</th>
										<th>{lang('Admin.text_active')}</th>
										<th width="160">{lang('Admin.column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{$item.id}</td>
										<td>
											{if !empty($item.image)}
												<a href="{image_url($item.image)}" data-lightbox="users"><img src="{image_url($item.image)}" class="avatar"></a>
											{/if}
											{if $item.active eq true}
												<span class="badge-dot badge-success mx-1"></span>
											{else}
												<span class="badge-dot border border-dark mx-1"></span>
											{/if}
											{anchor("$manage_url/edit/`$item.id`", htmlspecialchars($item.username, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}
										</td>
										<td class="text-center">{$item.first_name} {$item.last_name}</td>
										<td>{htmlspecialchars($item.email, ENT_QUOTES,'UTF-8')}</td>
										<td>{htmlspecialchars($item.phone, ENT_QUOTES,'UTF-8')}</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.id`", $item.active, $item.active, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.active, 'class' => 'change_publish'])}
												<span><label for="published_{$item.id}"></label></span>
											</div>
										</td>
										<td class="text-center">
											<div class="btn-group ms-auto">
												<a href="{$manage_url}/edit/{$item.id}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
												<a href="{$manage_url}/change_password/{$item.id}" class="btn btn-sm btn-light" title="{lang('UserAdmin.text_change_password')}"><i class="fas fa-key"></i></a>
												<a href="{$manage_url}/permission/{$item.id}" class="btn btn-sm btn-light text-brand" title="{lang('UserAdmin.text_permission_select')}"><i class="fas fa-lock-open"></i></a>
												<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light btn_delete_single text-danger" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
						{$pager->links('users', 'admin')}
					{else}
						{lang('Admin.text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
{/strip}
