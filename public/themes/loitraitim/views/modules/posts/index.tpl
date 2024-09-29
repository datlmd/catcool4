{strip}
	<div class="container-xxl bg-white mt-lg-0 mt-xl-3 p-4">
		<div class="row fs-small">
			<div class="col text-secondary pt-1">
				{get_today()}
			</div>
			<div class="col-5 text-end">
				{include file=get_theme_path('views/inc/weather.tpl')}
			</div>
		</div>

		<div class="row mb-4">

			<div class="col-lg-7 col-md-8 col-12 pe-5">

				<div class="category-name d-block mt-3 mb-4">
                    <span>{lang("Post.text_latest_post")}</span>
                </div>
				<div id="list_latest_post">
					{include file=get_theme_path('views/modules/posts/list_latest.tpl')}
				</div>

			</div>

			<aside class="col-lg-5 col-md-4 col-12 ps-lg-4">

				{foreach $category_tree as $category}
					{if empty($post_group_category_list[$category.category_id]) || stripos($category.slug, 'blog') === false}
						{continue}
					{/if}
					<div class="category-name d-block mt-3 mb-4">
						<span>
							<a href="{site_url($category.slug)}">{$category.name}</a>
						</span>
					</div>
					{foreach $post_group_category_list[$category.category_id] as $post}
						{include 
							file=get_theme_path('views/modules/posts/inc/article_info.tpl') 
							article_info=$post 
							article_type='small' 
							article_class="mb-4"
							is_show_tag = false
						}
					{/foreach}
				{/foreach}
			</aside>

		</div>


		<div class="row">
		{if !empty($post_group_category_list)}
			{foreach $category_tree as $category}
				{if empty($post_group_category_list[$category.category_id]) || stripos($category.slug, 'blog') !== false}
					{continue}
				{/if}
				<div class="col-md-6 col-12 pe-4 mb-4">
					<div class="category-name d-block mt-3 mb-4">
						<span>
							<a href="{site_url($category.slug)}">{$category.name}</a>
						</span>
					</div>
					{foreach $post_group_category_list[$category.category_id] as $post}
						{if $post.post_format eq 4}{assign var="is_lesson" value=true}{else}{assign var="is_lesson" value=false}{/if}
						
						{include 
							file=get_theme_path('views/modules/posts/inc/article_info.tpl') 
							article_info=$post 
							article_type='small' 
							article_class="mb-4"
							is_hide_image = $is_lesson
							is_show_tag = false
						}
					{/foreach}
				</div>
			{/foreach}
		{/if}
		</div>

	</div>

	{include file=get_theme_path('views/modules/posts/inc/counter_view.tpl') counter_list=$counter_list}

{/strip}

<script type="text/javascript">
	$('#list_latest_post').on('click', 'thead a, .pagination a', function (e) {
		e.preventDefault();

		$('#list_latest_post').load(this.href);
	});
</script>

