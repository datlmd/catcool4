<li class="dd-item" data-id="{$category.category_id}">
	<div class="dd-handle">
		<span class="drag-indicator"></span>
		<div>
			{$category.detail.name} (ID = {$category.category_id})
		</div>
		<div class="dd-nodrag btn-group ml-auto">
			<div class="switch-button switch-button-xs catcool-center mt-1 mr-3">
				{form_checkbox("published_`$category.category_id`", ($category.published eq STATUS_ON) ? true : false, ($category.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$category.category_id, 'data-id' => $category.category_id, 'data-published' => $category.published, 'class' => 'change_publish'])}
				<span><label for="published_{$category.category_id}"></label></span>
			</div>
			<a href="{base_url($manage_url)}/edit/{$category.category_id}{http_get_query()}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
			<button type="button" data-id="{$category.category_id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
		</div>
	</div>
	{if !empty($category.subs)}
		<ol class="dd-list">
			{foreach $category.subs as $sub}
				{include file=get_theme_path('views/inc/categories/list_item.tpl') category=$sub}
			{/foreach}
		</ol>
	{/if}
</li>