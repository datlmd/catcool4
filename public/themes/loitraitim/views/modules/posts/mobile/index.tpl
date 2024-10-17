{strip}
	<div class="bg-white p-2 pb-4">
		<div class="row fs-small">
			<div class="col text-secondary pt-1">
				{get_today()}
			</div>
			<div class="col-6 text-end">
				{include file=get_theme_path('views/inc/weather.tpl')}
			</div>
		</div>

		<div class="category-name d-block mt-2 mb-4">
			<span>{lang("Post.text_latest_post")}</span>
		</div>
		{include file=get_theme_path('views/modules/posts/list_latest.tpl')}

		<div class="my-4">
			{foreach $category_tree as $category}
				{if !empty($post_group_category_list[$category.category_id]) && stripos($category.slug, 'blog') !== false}
					<div class="category-name d-block mt-2 mb-3">
						<span>
							<a href="{site_url($category.slug)}">{$category.name}</a>
						</span>
					</div>
					{foreach $post_group_category_list[$category.category_id] as $post}
						{include 
							file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') 
							article_info=$post 
							article_type='middle_left' 
							article_class="mb-3 pb-3 border-bottom"
							is_show_tag = false
						}
					{/foreach}
				{/if}
			{/foreach}
		</div>

		{if !empty($post_group_category_list)}
			{foreach $category_tree as $category}
				{if empty($post_group_category_list[$category.category_id]) || stripos($category.slug, 'blog') !== false}
					{continue}
				{/if}
				<div class="col-md-6 col-12 pe-2 mb-4">
					<div class="category-name d-block mt-3 mb-4">
						<span>
							<a href="{site_url($category.slug)}">{$category.name}</a>
						</span>
					</div>
					{foreach $post_group_category_list[$category.category_id] as $post}
						{if $post.post_format eq 4}{assign var="is_lesson" value=true}{else}{assign var="is_lesson" value=false}{/if}
						
						{include 
							file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') 
							article_info=$post 
							article_type='middle_left' 
							article_class="mb-3 pb-3 border-bottom"
							is_hide_image = $is_lesson
							is_show_tag = false
						}
					{/foreach}
				</div>
			{/foreach}
		{/if}

	</div>

	{include file=get_theme_path('views/modules/posts/inc/counter_view.tpl') counter_list=$counter_list}

{/strip}
