{strip}
	<li class="dd-item" data-id="{$menu.menu_id}">
		<div class="dd-handle">
			<div>
				<a href="{site_url($manage_url)}/edit/{$menu.menu_id}" class="text-primary">
					<i class="{if !empty($menu.icon)}{$menu.icon}{else}fas fa-angle-double-right{/if} me-2"></i>{$menu.name} 
				</a>
				<span class="ms-2">({lang('Admin.column_id')}: {$menu.menu_id} / {$menu.context})</span>
			</div>
			<div class="dd-nodrag btn-group ms-auto">
				<div class="switch-button switch-button-xs catcool-center my-auto me-3">
					{form_checkbox("published_`$menu.menu_id`", ($menu.published eq STATUS_ON) ? true : false, ($menu.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$menu.menu_id, 'data-id' => $menu.menu_id, 'data-published' => $menu.published, 'class' => 'change_publish'])}
					<span><label for="published_{$menu.menu_id}"></label></span>
				</div>
				<a href="{site_url($manage_url)}/edit/{$menu.menu_id}{http_get_query()}" class="btn btn-sm btn-light" title="{lang('Admin.button_edit')}"><i class="fas fa-edit"></i></a>
				<button type="button" data-id="{$menu.menu_id}" class="btn btn-sm btn-light text-danger btn_delete_single" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
			</div>
		</div>
		{if !empty($menu.subs)}
			<ol class="dd-list">
				{foreach $menu.subs as $sub}
					{include file=get_theme_path('views/modules/menus/inc/list_item.tpl') menu=$sub}
				{/foreach}
			</ol>
		{/if}
	</li>
{/strip}
