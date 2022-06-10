{strip}
	<div class="container-xxl bg-white py-2 mt-lg-0 mt-xl-3">
		<div class="row fs-small">
			<div class="col text-secondary pt-1">
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
						{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='small' article_class="mb-3 pt-3 border-top" is_hide_datetime=true is_hide_description=true}
					{/foreach}
				{/if}
			</div>

			<div class="col-md-8">
				{if !empty($slide_list)}
					<div class="row">

						<div class="col-md-8">
							{foreach $slide_list as $news}
								{if $news@iteration == 1}

									<article class="home-page overflow-hidden">
										<a href="{site_url($news.detail_url)}" class="mb-2 d-block">
											{if !empty($news.images.thumb)}
												<img src="{image_thumb_url($news.images.thumb, 580, 390)}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
											{else}
												<img src="{image_thumb_url($news.images.robot, 580, 390)}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
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
						</div>

						<div class="col-md-4">
							{foreach $slide_list as $news}
								{if $news@iteration == 1}
									{continue}
								{/if}
								{if $news@iteration > 3}
									{break}
								{/if}
								<article class="mb-3 overflow-hidden">
									<a href="{site_url($news.detail_url)}" class="mb-2 d-block">
										{if !empty($news.images.thumb)}
											<img src="{image_thumb_url($news.images.thumb, 300, 190)}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
										{else}
											<img src="{image_thumb_url($news.images.robot, 300, 190)}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
										{/if}
									</a>
									<h4>
										<a href="{site_url($news.detail_url)}" class="art-title">{$news.name}</a>
									</h4>
								</article>
							{/foreach}
						</div>

					</div>
				{/if}
			</div>

		</div>
		<div class="row">

			<div class="col-lg-7 col-md-8 col-12">
				<div class="w-100">
					<script data-cfasync="false" type="text/javascript" src="//greatdexchange.com/a/display.php?r=5979702"></script>
					<script data-cfasync="false" type="text/javascript" src="//greatdexchange.com/a/display.php?r=5979754"></script>
				</div>

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
									{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='right' article_class="category mb-3 pb-3 border-bottom"}
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

			<aside class="col-lg-5 col-md-4 col-12 ps-lg-4">

				{include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

				<script data-cfasync="false" type="text/javascript" src="//greatdexchange.com/a/display.php?r=5979758"></script>

			</aside>

		</div>

	</div>

	{include file=get_theme_path('views/modules/news/inc/counter_view.tpl')}

{/strip}
