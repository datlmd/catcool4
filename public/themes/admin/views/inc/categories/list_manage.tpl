<tr>
	<td class="text-center">{$category.category_id}</td>
	<td>
		<a href="{$manage_url}/edit/{$category.category_id}" class="text-primary">
			{if !empty($parent_name)}{$parent_name} > {/if}
			{$category.detail.name}
		</a>
    </td>
	<td>
		{$category.detail.slug}<br />
		<em>{$category.detail.description}</em>
	</td>
	<td class="text-center">{$category.sort_order}</td>
	<td>
		<div class="switch-button switch-button-xs catcool-center">
			{form_checkbox("published_`$category.category_id`", STATUS_ON, ($category.published eq STATUS_ON) ? STATUS_ON : STATUS_OFF, ['id' => 'published_'|cat:$category.category_id, 'data-id' => $category.category_id, 'data-published' => $category.published, 'class' => 'change_publish'])}
			<span><label for="published_{$category.category_id}"></label></span>
		</div>
	</td>
	<td class="text-center">
		<div class="btn-group ml-auto">
			<a href="{$manage_url}/edit/{$category.category_id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
			<button type="button" data-id="{$category.category_id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
		</div>
	</td>
	<td class="text-center">{form_checkbox('manage_ids[]', $category.category_id)}</td>
</tr>
{if !empty($category.subs)}
	{if !empty($parent_name)}
		{assign var="parent_name" value="`$parent_name` > `$category.detail.name`"}
	{else}
		{assign var="parent_name" value="`$category.detail.name`"}
	{/if}

	{foreach $category.subs as $sub}
		{include file=get_theme_path('views/inc/categories/list_manage.tpl') category=$sub parent_name=$parent_name}
	{/foreach}
{/if}
