{strip}
	{foreach $category_list as $category}
		{if !empty($category.list)}
			<div class="heading heading-border heading-middle-border">
				<h3 class="text-5 p-0"><strong class="font-weight-bold shadow text-1 px-4 text-light py-2 {$bg_color[array_rand($bg_color)]}">{$category.name}</strong></h3>
			</div>
			<div class="row ps-3 ps-md-3 ps-lg-4 pb-2">
				{foreach $category.list as $news}
					<div class="col-sm-12 d-md-none d-sm-block mb-4">
						<article>

							<div class="row pb-1 pe-3">
								<div class="col-4 p-0">
									<a href="{$news.detail_url}">
										<img src="{if !empty($news.images.root)}{image_thumb_url($news.images.root)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name}">
									</a>
								</div>
								<div class="col-8 ps-2 pe-0">
									<h4 class="pb-2 line-height-4 font-weight-bold text-3 text-dark mb-0 pe-1">
										<a href="{$news.detail_url}" class="text-decoration-none text-color-dark">{$news.name}</a>
										<span class="d-inline-block text-default font-weight-normal text-1 ms-2">
											 {time_ago($news.publish_date)}
										</span>
									</h4>
								</div>
							</div>
						</article>
					</div>
				{/foreach}

				{foreach $category.list as $news}
					{if $news@iteration == 1}
						<div class="col-md-5 mb-4 pb-1 d-none d-md-block">
							<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
								<div class="row">
									<div class="col">
										<a href="{$news.detail_url}">
											<img src="{if !empty($news.images.root)}{image_thumb_url($news.images.root)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name}">
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="thumb-info-caption-text">
											<h4 class="d-block line-height-3 text-3 text-dark mb-0 fw-bold mt-2">
												<a href="{$news.detail_url}" class="text-decoration-none text-color-dark">{$news.name}</a>
											</h4>
											<div class="d-inline-block text-default text-1 float-none">
												<a href="{$news.detail_url}" class="text-decoration-none text-color-default">{time_ago($news.publish_date)}</a>
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
									<a href="{$news.detail_url}">
										<img src="{if !empty($news.images.root)}{image_thumb_url($news.images.root)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name}">
									</a>
								</div>
								<div class="col-sm-8 ps-0">
									<div class="thumb-info-caption-text">
										<h4 class="pb-2 line-height-4 font-weight-normal text-3 text-dark mb-0">
											<a href="{$news.detail_url}" class="text-decoration-none text-color-dark">{$news.name}</a>
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
			</div>
		{/if}
	{/foreach}
{/strip}
