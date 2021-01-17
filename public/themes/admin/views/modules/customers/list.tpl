{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
			<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete_all')}"><i class="fas fa-trash-alt"></i></span>
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
			<button type="button" id="btn_search" class="btn btn-sm btn-brand" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
			<a href="{base_url("users/groups_manage")}" class="btn btn-sm btn-primary"><i class="fas fa-list mr-1"></i> {lang('module_group')}</a>
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
						<div class="col-xl-6 col-lg-6 col-md-4 col-sm-6 col-12 mb-2">
							{lang('filter_search_user')}
							{form_input('filter[search_user]', $this->input->get('filter[search_user]'), ['class' => 'form-control form-control-sm', 'placeholder' => lang('text_search_user')])}
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
							{lang('filter_id')}
							{form_input('filter[id]', $this->input->get('filter[id]'), ['class' => 'form-control form-control-sm', 'placeholder' => lang('filter_id')])}
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
										<th>{lang('text_username')}</th>
										<th>{lang('text_full_name')}</th>
										<th>{lang('text_email')}</th>
										<th>{lang('text_phone')}</th>
										<th>{lang('text_active')}</th>
										<th width="160">{lang('column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{$item.customer_id}</td>
										<td>
											{if !empty($item.image)}
												<a href="{image_url($item.image)}" data-lightbox="users"><img src="{image_url($item.image)}" class="avatar"></a>
											{/if}
											{if $item.active eq true}
												<span class="badge-dot badge-success mx-1"></span>
											{else}
												<span class="badge-dot border border-dark mx-1"></span>
											{/if}
											{anchor("$manage_url/edit/`$item.customer_id`", htmlspecialchars($item.username, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}
										</td>
										<td class="text-center">{$item.first_name} {$item.last_name}</td>
										<td>{htmlspecialchars($item.email, ENT_QUOTES,'UTF-8')}</td>
										<td>{htmlspecialchars($item.phone, ENT_QUOTES,'UTF-8')}</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.customer_id`", $item.active, $item.active, ['id' => 'published_'|cat:$item.customer_id, 'data-id' => $item.customer_id, 'data-published' => $item.active, 'class' => 'change_publish'])}
												<span><label for="published_{$item.customer_id}"></label></span>
											</div>
										</td>
										<td class="text-center">
											<div class="btn-group ml-auto">
												<a href="{$manage_url}/edit/{$item.customer_id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
												<a href="{$manage_url}/change_password/{$item.customer_id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('text_change_password')}"{/if}><i class="fas fa-key"></i></a>
												<a href="{$manage_url}/permission/{$item.customer_id}" class="btn btn-sm btn-outline-light text-brand" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('text_permission_select')}"{/if}><i class="fas fa-lock-open"></i></a>
												<button type="button" data-id="{$item.customer_id}" class="btn btn-sm btn-outline-light btn_delete_single text-danger" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.customer_id)}</td>
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
