{strip}
	{foreach $category_list as $category}
		{if !empty($category.list)}

			<div class="row ps-3 ps-md-3 ps-lg-4 pb-2">
				{if !empty($is_mobile)}

					{foreach $category.list as $news}
						{if $news@iteration < 4}

							<article class="row p-3 mb-2 border-top border-bottom bg-white">
								<h4 class="pb-2 line-height-4 font-weight-bold text-4 text-dark mb-0 ps-0 pe-1">
									<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
								</h4>
								<div class="col-4 p-1">
									<a href="{site_url($news.detail_url)}">
										<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 180, 120)}{else}{image_thumb_url($news.images.robot, 180, 120)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
									</a>
								</div>
								<div class="col-8 ps-2 pe-0">
									<p class="text-3">{$news.description|truncate:160}</p>
									{if !empty($news.category_ids)}
										<span>
											{foreach $news.category_ids as $category_id}
												<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none fw-light me-2">{$category_list[$category_id].name}</a>
											{/foreach}
										</span>
									{/if}
									<span class="d-inline-block text-default font-weight-normal text-1">
										 {time_ago($news.publish_date)}
									</span>
								</div>

							</article>

						{else}
							<article class="row px-3 py-2">

								<div class="col-3 p-1">
									<a href="{site_url($news.detail_url)}">
										<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 180, 120)}{else}{image_thumb_url($news.images.robot, 180, 120)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
									</a>
								</div>
								<div class="col-9 ps-2 pe-0">
									<h4 class="line-height-4 font-weight-bold text-3 text-dark mb-0 ps-0 pe-1">
										<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
									</h4>
									{if !empty($news.category_ids)}
										<span>
											{foreach $news.category_ids as $category_id}
												<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none fw-light me-2">{$category_list[$category_id].name}</a>
											{/foreach}
										</span>
									{/if}
									<span class="d-inline-block text-default font-weight-normal text-1">
										 {time_ago($news.publish_date)}
									</span>
								</div>

							</article>
						{/if}

					{/foreach}

				{else}

					{if !empty($style_show) && $style_show eq 'list'}

						<div class="ps-3 ps-md-3 ps-lg-4">
							{foreach $category.list as $news}
								{include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news is_show_category=true}
							{/foreach}
						</div>

					{else}

						{foreach $category.list as $news}
							{if $news@iteration < 3}
								<div class="col-12">
									<article class="border-radius-0 py-4 border-top {if $news@iteration == 1}mt-3{/if}">
										<div class="row">
											<div class="col-5">
												<a href="{site_url($news.detail_url)}">
													<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
												</a>
											</div>
											<div class="col-7">
												<h4 class="d-block line-height-3 text-5 text-dark mb-0 fw-bold">
													<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
												</h4>
												{if !empty($news.category_ids)}
													<span>
														{foreach $news.category_ids as $category_id}
															<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none fw-light me-2">{$category_list[$category_id].name}</a>
														{/foreach}
													</span>
												{/if}
												<span class="d-inline-block text-default text-1 float-none">
													{time_ago($news.publish_date)}
												</span>
												<p>{$news.description|truncate:160}</p>
											</div>
										</div>

									</article>
								</div>
							{/if}
						{/foreach}
						<div class="col-12">
							{foreach $category.list as $news}
								{if $news@iteration < 3}
									{continue}
								{/if}
								<article class="border-radius-0 py-4 border-top">
									<div class="row">
										<div class="col-sm-3">
											<a href="{site_url($news.detail_url)}">
												<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 180, 120)}{else}{image_thumb_url($news.images.robot, 180, 120)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
											</a>
										</div>
										<div class="col-sm-9">
											<div class="thumb-info-caption-text">
												<h4 class="line-height-4 font-weight-normal text-4 text-dark mb-0">
													<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
												</h4>
												{if !empty($news.category_ids)}
													<span>
														{foreach $news.category_ids as $category_id}
															<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none fw-light me-2">{$category_list[$category_id].name}</a>
														{/foreach}
													</span>
												{/if}
												<span class="d-inline-block text-default text-1">
													{time_ago($news.publish_date)}
												</span>
											</div>
										</div>
									</div>
								</article>
							{/foreach}
						</div>

					{/if}

				{/if}
			</div>
		{/if}
	{/foreach}
{/strip}
