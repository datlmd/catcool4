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

		{if !empty($slide_list)}

			{foreach $slide_list as $news}
				{if $news@iteration == 1}
					<article class="home-page mb-3 overflow-hidden">
						<a href="{site_url($news.detail_url)}" class="mb-2 d-block">
							{if !empty($news.images.thumb)}
								<img src="{image_thumb_url($news.images.thumb, 400, 220)}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
							{else}
								<img src="{$news.images.robot}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
							{/if}
						</a>
						<h4>
							<a href="{site_url($news.detail_url)}" class="art-title">{$news.name}</a>
						</h4>
						{if !empty($news.category_ids)}
							<div class="d-inline-block me-2">
								{foreach $news.category_ids as $category_id}
									<a href="{base_url($news_category_list[$category_id].slug)}" class="art-category">{$news_category_list[$category_id].name}</a>
								{/foreach}
							</div>
						{/if}
						<div class="d-inline-block art-time">
							{time_ago($news.publish_date)}
						</div>
						<p class="art-description">{$news.description|truncate:160}</p>
					</article>
					{break}
				{/if}
			{/foreach}

			<div class="row">
				{foreach $slide_list as $news}
					{if $news@iteration == 1}
						{continue}
					{/if}
					<div class="col-6">
						<article class="mb-3 overflow-hidden">
							<a href="{site_url($news.detail_url)}" class="mb-2 d-block">
								{if !empty($news.images.thumb)}
									<img src="{image_thumb_url($news.images.thumb, 180, 110)}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
								{else}
									<img src="{$news.images.robot}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
								{/if}
							</a>
							<h4>
								<a href="{site_url($news.detail_url)}" class="art-title">{$news.name}</a>
							</h4>
						</article>
					</div>
				{/foreach}
			</div>

		{/if}

		{if !empty($news_category_list)}
			{foreach $news_category_list as $category}
				{if empty($category.list)}
					{continue}
				{/if}

				<div class="category-name d-block shadow-sm">
					<a href="{base_url($category.slug)}" class="text-decoration-none">{$category.name|upper}</a>
				</div>

				<div class="my-3 overflow-auto">
					{foreach $category.list as $news}
						{if $news@iteration < 3}
							{include file=get_theme_path('views/modules/news/inc/article_info_mobile.tpl') article_info=$news article_type='middle_left' article_class="category border-bottom pb-4 mb-4"}
						{/if}
					{/foreach}


					{foreach $category.list as $news}
						{if $news@iteration < 3}
							{continue}
						{/if}
						{include file=get_theme_path('views/modules/news/inc/article_info_mobile.tpl') article_info=$news article_type='small' article_class="border-bottom pb-3 mb-3" is_hide_description=true}
					{/foreach}
				</div>

			{/foreach}
		{/if}

		{include file=get_theme_path('views/inc/shopee_ads.tpl')}

		{include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

	</div>

	{include file=get_theme_path('views/modules/news/inc/counter_view.tpl')}

{/strip}
