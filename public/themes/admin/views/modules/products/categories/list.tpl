{strip}
	{form_hidden('manage_url', site_url($manage_url))}
	{csrf_field()}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-sm-7 col-12">
				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductCategoryAdmin.heading_title')}
			</div>
			<div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
				<button type="button" id="btn_category_sort" onclick="submitSort();" style="display: none;" class="btn btn-sm btn-space btn-secondary"><i class="fas fa-save me-1"></i>{lang('Admin.button_save_sort')}</button>
				<a href="{site_url($manage_url)}/add" class="btn btn-sm btn-primary btn-space" title="{lang('Admin.button_add')}"><i class="fas fa-plus me-1"></i>{lang('Admin.button_add')}</a>
				{include file=get_theme_path('views/inc/button_translate.tpl') translate_frontend=lang('ProductCategoryAdmin.translate_frontend_id') translate_admin=lang('ProductCategoryAdmin.translate_admin_id')}
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('ProductCategoryAdmin.text_list')}</h5>
					<div class="card-body">
						{if !empty($list)}
							<div class="dd" id="list_category_sort">
								<ol class="dd-list">
									{foreach $list as $item}
										{include file=get_theme_path('views/inc/categories/list_item.tpl') category=$item}
									{/foreach}
								</ol>
							</div>
						{else}
							{lang('Admin.text_no_results')}
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
