{strip}
	{if !empty($categories)}
		{foreach $categories as $category}
			<i class="fas fa-angle-right me-2"></i>
			<a href="{base_url($category.slug)}" class="me-2">{$category.name}</a>
			{if !empty($category.subs)}
				<i class="fas fa-angle-right me-2"></i>
				{include file=get_theme_path('views/inc/category_tree.tpl') categories=$category.subs}
			{/if}
		{/foreach}
	{/if}
{/strip}
