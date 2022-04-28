{strip}
{form_hidden('manage_url', site_url($manage_url))}
{csrf_field()}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-6 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UserAdmin.heading_title')}
		</div>
		<div class="col-sm-6 col-12 mb-2 mb-sm-0 text-end">
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary btn-space" data-bs-toggle="tooltip" title="{lang('UserAdmin.button_add')}"><i class="fas fa-plus"></i></a>
			<button type="button" id="btn_search" class="btn btn-sm btn-brand btn-space" data-bs-toggle="tooltip" title="{lang('Admin.filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
			<a href="{site_url("users_admin/groups_manage")}" class="btn btn-sm btn-primary btn-space"><i class="fas fa-list me-1"></i> {lang('Admin.module_group')}</a>
			{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('UserAdmin.translate_frontend_id') translate_admin=lang('UserAdmin.translate_admin_id')}
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
								<label class="form-label">{lang('UserAdmin.filter_search_user')}</label>
								{form_input('name', set_value('name', $request->getGet('name'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
								<label class="form-label">{lang('Admin.filter_id')}</label>
								{form_input('id', set_value('id', $request->getGet('id'))|default:'', ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
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
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr id="item_id_{$item.id}">
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
										<td class="text-center">{$item.first_name}</td>
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
												<a href="{$manage_url}/edit/{$item.id}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
												<a href="{$manage_url}/change_password/{$item.id}" class="btn btn-sm btn-light text-primary" data-bs-toggle="tooltip" title="{lang('UserAdmin.text_change_password')}"><i class="fas fa-key"></i></a>

												<a href="{$manage_url}/permission/{$item.id}" class="btn btn-sm btn-light text-dark" data-bs-toggle="tooltip" title="{lang('UserAdmin.text_permission_select')}"><i class="fas fa-lock-open"></i></a>

												<button type="button" data-id="{$item.id}" class="btn btn-sm btn-light btn_delete_single text-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
	</div>
</div>
{/strip}
