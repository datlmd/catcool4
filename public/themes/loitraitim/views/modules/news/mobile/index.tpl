{strip}
	<div class="bg-white p-2 pb-4">
		<div class="row fs-small">
			<div class="col text-secondary pt-1">
				{get_today()}
			</div>
			<div class="col-6 text-end">
				{include file=get_theme_path('views/modules/news/inc/weather.tpl')}
			</div>
		</div>

		{if !empty($slide_list)}

			{foreach $slide_list as $news}
				{if $news@iteration == 1}
					{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="home-page mb-3" is_show_category=true}
					{break}
				{/if}
			{/foreach}

			<div class="row">
				{foreach $slide_list as $news}
					{if $news@iteration == 1}
						{continue}
					{/if}
					<div class="col-6">
						{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="mb-3" is_show_category=true is_hide_datetime=true is_hide_description=true}
					</div>
				{/foreach}
			</div>

		{/if}

		{if !empty($category_list)}
			{foreach $category_list as $category}
				{if empty($category.list)}
					{continue}
				{/if}

				<div class="category-name d-block shadow-sm">
					<a href="{base_url($category.slug)}" class="text-decoration-none">{$category.name|upper}</a>
				</div>

				<div class="my-3 overflow-auto">
					{foreach $category.list as $news}
						{if $news@iteration < 3}
							{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='middle_left' article_class="category border-bottom pb-4 mb-4"}
						{/if}
					{/foreach}


					{foreach $category.list as $news}
						{if $news@iteration < 3}
							{continue}
						{/if}
						{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='small' article_class="border-bottom pb-3 mb-3" is_hide_description=true}
					{/foreach}
				</div>

			{/foreach}
		{/if}

		{include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

	</div>

	{include file=get_theme_path('views/modules/news/inc/counter_view.tpl')}

{/strip}
