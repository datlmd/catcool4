{strip}
	<div class="container-xxl">
		<div class="row">
			<div class="col text-secondary">
				{get_today()}
			</div>
			<div class="col-5 text-end">
				{include file=get_theme_path('views/modules/news/inc/weather.tpl')}
			</div>
		</div>
		<div class="row">

			<div class="col-md-4">
				{if !empty($new_list)}
					{foreach $new_list as $news}
						{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='small' article_class="mb-4" is_hide_datetime=true is_hide_description=true}
					{/foreach}
				{/if}
			</div>

			<div class="col-md-8">
				{if !empty($slide_list)}
					<div class="row">

						<div class="col-md-8">
							{foreach $slide_list as $news}
								{if $news@iteration == 1}
									{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="home-page" is_show_category=true}
									{break}
								{/if}
							{/foreach}
						</div>

						<div class="col-md-4">
							{foreach $slide_list as $news}
								{if $news@iteration == 1}
									{continue}
								{/if}
								{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="mb-3" is_hide_datetime=true is_hide_description=true}
							{/foreach}
						</div>

					</div>
				{/if}
			</div>

		</div>
		<div class="row">

			<div class="col-lg-7 col-md-8">
				{if !empty($category_list)}
					{foreach $category_list as $category}
						{if empty($category.list)}
							{continue}
						{/if}

						<div class="category-name d-block">
							<a href="{base_url($category.slug)}" class="text-decoration-none">{$category.name|upper}</a>
						</div>

						<div class="my-3 overflow-auto">
							{foreach $category.list as $news}
								{if $news@iteration < 3}
									{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='right' article_class="category mb-4"}
								{/if}
							{/foreach}


							{foreach $category.list as $news}
								{if $news@iteration < 3}
									{continue}
								{/if}
								{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='small' article_class="mb-3" is_hide_description=true}
							{/foreach}
						</div>

					{/foreach}
				{/if}
			</div>

			<aside class="col-lg-5 col-md-4">

				{include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

			</aside>

		</div>

	</div>
	{if !empty($counter_list)}
		<div class="container-xxl section-counter-title">
			<h3 class="m-0 p-0">{lang('News.text_popular_post')}</h3>
		</div>
		<section class="section-counter text-white border-top pt-4 pb-2">

			<div class="container-xxl">
				<div class="row">
				{foreach $counter_list as $news}
					<div class="col-lg-2 col-md-4 col-6">
						{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="mb-3" is_show_category=true is_hide_description=true}
					</div>
				{/foreach}
				</div>
			</div>

		</section>
	{/if}
{/strip}
