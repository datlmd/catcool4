{strip}
	{if !empty($slide_list)}
		{if !empty($is_mobile)}
			<div class="row px-2">
				{foreach $slide_list as $news}
					{if $news@iteration == 1}
						<div class="col-12 mb-2">
							<article>
								<a href="{site_url($news.detail_url)}">
									<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="img-fluid border-radius-0 w-100" width="100%" alt="{htmlentities($news.name)}">
								</a>
								<h4 class="pb-2 line-height-4 font-weight-bold text-4 text-dark my-0 pe-1">
									<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
								</h4>
								{if !empty($news.category_ids)}
									<span>
										{foreach $news.category_ids as $category_id}
											<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none text-dark fw-bold me-2">{$category_list[$category_id].name}</a>
										{/foreach}
									</span>
								{/if}
								<span class="d-inline-block text-default text-1">
									{time_ago($news.publish_date)}
								</span>
								<p class="mt-2">{$news.description|truncate:160}</p>
							</article>
						</div>
					{else}
						{include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news is_show_category=true}
					{/if}
				{/foreach}
			</div>
		{else}
			<div class="row ps-4">

				<div class="col-lg-8 mb-4 pb-2">
					{foreach $slide_list as $news}
						{if $news@iteration == 1}
							<div class="row">
								<div class="col">
									<a href="{site_url($news.detail_url)}">
										<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 450, 320)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
									</a>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="thumb-info-caption-text">
										<h4 class="d-block line-height-3 text-5 text-dark mb-0 fw-bold mt-2">
											<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
										</h4>
										{if !empty($news.category_ids)}
											<span>
												{foreach $news.category_ids as $category_id}
													<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none text-dark fw-bold me-2">{$category_list[$category_id].name}</a>
												{/foreach}
											</span>
										{/if}
										<span class="d-inline-block text-default text-1 float-none">
											<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-default">{time_ago($news.publish_date)}</a>
										</span>
										<p class="mt-2">{$news.description|truncate:160}</p>
									</div>
								</div>
							</div>

							{break}
						{/if}
					{/foreach}
				</div>

				<div class="col-lg-4 d-none">
					{foreach $slide_list as $news}
						{if $news@iteration == 1}
							{continue}
						{/if}
						<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-1 mb-2">
							<div class="row pb-1">
								<div class="col-12">
									<a href="{site_url($news.detail_url)}">
										<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
									</a>
									<div class="thumb-info-caption-text mt-2">
										<h2 class="d-block line-height-3 font-weight-bold text-4 text-dark mb-0">
											<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
										</h2>
									</div>
								</div>
							</div>
						</article>
					{/foreach}
				</div>

			</div>
		{/if}
	{/if}
{/strip}
