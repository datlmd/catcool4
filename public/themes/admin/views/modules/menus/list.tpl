{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-sm-7 col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
		</div>
		<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
			{if !$filter_active}
				<button type="button" id="btn_category_sort" onclick="submitSort();" style="display: none;" class="btn btn-sm btn-secondary"><i class="fas fa-save mr-1"></i>{lang('button_save_sort')}</button>
			{/if}

			<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete_all')}"><i class="fas fa-trash-alt"></i></span>
			<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list mr-2"></i>{lang('text_list')} {if !empty($this->session->is_menu_admin)}(Admin){else}(Frontend){/if}</h5>
				<div class="card-body">
					{if !empty($this->session->super_admin)}
						<div class="mb-3">
							<a href="{base_url($manage_url|cat:"?is_admin=1")}" class="btn btn-sm btn-light {if $is_admin eq 1}active{/if}">Admin</a>
							<a href="{base_url($manage_url|cat:"?is_admin=0")}" class="btn btn-sm btn-light ml-2 {if $is_admin eq 0}active{/if}">Frontend</a>
						</div>
					{/if}
                    {if !empty($list)}
						<div class="dd" id="list_category_sort">
							<ol class="dd-list">
								{foreach $list as $item}
									{include file='./inc/list_item.tpl' menu=$item}
								{/foreach}
							</ol>
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