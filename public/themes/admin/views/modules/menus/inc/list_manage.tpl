<tr>
	<td class="text-center"><a href="{$manage_url}/edit/{$menu.menu_id}" class="text-primary">{$menu.menu_id}</a></td>
	<td>
		<a href="{$manage_url}/edit/{$menu.menu_id}" class="text-primary">
            {if !empty($menu.icon)}<i class="{$menu.icon} me-1"></i>{/if}
			{if !empty($parent_name)}{$parent_name} > {/if}
			{$menu.detail.name}
		</a>
	</td>
	<td>
		{$menu.slug}<br />
		<em>{$menu.detail.description}</em>
	</td>
	<td class="text-center">{$menu.sort_order}</td>
	<td>{$menu.is_admin}</td>
	<td>
		<div class="switch-button switch-button-xs catcool-center">
			{form_checkbox("published_`$menu.menu_id`", ($menu.published eq STATUS_ON) ? true : false, ($menu.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$menu.menu_id, 'data-id' => $menu.menu_id, 'data-published' => $menu.published, 'class' => 'change_publish'])}
			<span><label for="published_{$menu.menu_id}"></label></span>
		</div>
	</td>
	<td class="text-center">
		<div class="btn-group ms-auto">
			<a href="{$manage_url}/edit/{$menu.menu_id}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
			<button type="button" data-id="{$menu.menu_id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
		</div>
	</td>
	<td class="text-center">{form_checkbox('manage_ids[]', $menu.menu_id)}</td>
</tr>
{if !empty($menu.subs)}
	{if !empty($parent_name)}
		{assign var="parent_name" value="`$parent_name` > `$menu.detail.name`"}
	{else}
		{assign var="parent_name" value="`$menu.detail.name`"}
	{/if}
	{foreach $menu.subs as $sub}
		{include file='./inc/list_manage.tpl' menu=$sub parent_name=$parent_name}
	{/foreach}
{/if}
