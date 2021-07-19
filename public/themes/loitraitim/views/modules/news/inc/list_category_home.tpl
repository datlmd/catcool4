{strip}
	{foreach $category_list as $category}
		{if !empty($category.list)}

			{if !empty($style_show) && $style_show eq 'list'}
			{else}
				<div class="heading heading-border heading-middle-border">
					<a href="{site_url($category.slug)}">
						<h3 class="text-5 p-0"><strong class="font-weight-bold shadow text-1 px-4 text-light py-2 {$bg_color[array_rand($bg_color)]}">{$category.name}</strong></h3>
					</a>
				</div>
			{/if}
			<div class="row ps-3 ps-md-3 ps-lg-4 pb-2">
				{foreach $category.list as $news}
					{if $news@iteration > 4}
						{break}
					{/if}
					<div class="col-sm-12 d-md-none d-sm-block mb-4">
						<article>

							<div class="row pb-1 pe-3">
								<div class="col-12 p-0">
									<h4 class="pb-2 line-height-4 font-weight-bold text-4 text-dark mb-0 pe-1">
										<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
									</h4>
								</div>
								<div class="col-4 p-0">
									<a href="{site_url($news.detail_url)}">
										<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 180, 120)}{else}{image_thumb_url($news.images.robot, 180, 120)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
									</a>
								</div>
								<div class="col-8 ps-2 pe-0">
									{if !empty($news.category_ids)}
										<span>
											{foreach $news.category_ids as $category_id}
												<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none text-dark fw-bold me-2">{$category_list[$category_id].name}</a>
											{/foreach}
										</span>
									{/if}
									<span class="d-inline-block text-default font-weight-normal text-1">
										 {time_ago($news.publish_date)}
									</span>
									<p class="text-3">{$news.description|truncate:160}</p>
								</div>
							</div>
						</article>
					</div>
				{/foreach}

				{if !empty($style_show) && $style_show eq 'list'}

					<div class="ps-3 ps-md-3 ps-lg-4 d-none d-md-block">
						{foreach $category.list as $news}
							{include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news is_show_category=true}
						{/foreach}
					</div>

				{else}

					{foreach $category.list as $news}
						{if $news@iteration == 1}
							<div class="col-md-5 mb-4 pb-1 d-none d-md-block">
								<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
									<div class="row">
										<div class="col">
											<a href="{site_url($news.detail_url)}">
												<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
											</a>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="thumb-info-caption-text">
												<h4 class="d-block line-height-3 text-4 text-dark mb-0 fw-bold mt-2">
													<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
												</h4>
												<div class="d-inline-block text-default text-1 float-none">
													<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-default">{time_ago($news.publish_date)}</a>
												</div>
												<p class="mt-2">{$news.description|truncate:160}</p>
											</div>
										</div>
									</div>
								</article>
							</div>
							{break}
						{/if}
					{/foreach}
					<div class="col-md-7 d-none d-md-block">
						{foreach $category.list as $news}
							{if $news@iteration == 1}
								{continue}
							{/if}
							<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
								<div class="row pb-1">
									<div class="col-sm-4">
										<a href="{site_url($news.detail_url)}">
											<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 180, 120)}{else}{image_thumb_url($news.images.robot, 180, 120)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
										</a>
									</div>
									<div class="col-sm-8 ps-0">
										<div class="thumb-info-caption-text">
											<h4 class="pb-2 line-height-4 font-weight-normal text-3 text-dark mb-0">
												<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
												<span class="d-inline-block text-default text-1 ps-2">
													{time_ago($news.publish_date)}
												</span>
											</h4>
										</div>
									</div>
								</div>
							</article>
						{/foreach}
					</div>

				{/if}
			</div>
		{/if}
	{/foreach}
{/strip}
