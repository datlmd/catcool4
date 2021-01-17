<li class="dd-item" data-id="{$menu.menu_id}">
	<div class="dd-handle">
		{*<span class="drag-indicator"></span>*}
		<div>
			<a href="{base_url($manage_url)}/edit/{$menu.menu_id}" class="text-primary">
				<i class="{if !empty($menu.icon)}{$menu.icon}{else}fas fa-angle-double-right{/if} mr-2"></i>{$menu.detail.name}
			</a>
		</div>
		<div class="dd-nodrag btn-group ml-auto">
			<div class="switch-button switch-button-xs catcool-center mt-1 mr-3">
				{form_checkbox("published_`$menu.menu_id`", ($menu.published eq STATUS_ON) ? true : false, ($menu.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$menu.menu_id, 'data-id' => $menu.menu_id, 'data-published' => $menu.published, 'class' => 'change_publish'])}
				<span><label for="published_{$menu.menu_id}"></label></span>
			</div>
			<a href="{base_url($manage_url)}/edit/{$menu.menu_id}{http_get_query()}" class="btn btn-sm btn-outline-light" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"{/if}><i class="fas fa-edit"></i></a>
			<button type="button" data-id="{$menu.menu_id}" class="btn btn-sm btn-outline-light text-danger btn_delete_single" {if count($list) > 1}data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"{/if}><i class="fas fa-trash-alt"></i></button>
		</div>
	</div>
	{if !empty($menu.subs)}
		<ol class="dd-list">
			{foreach $menu.subs as $sub}
				{include file='./inc/list_item.tpl' menu=$sub}
			{/foreach}
		</ol>
	{/if}
</li>