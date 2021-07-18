{strip}
	{if !empty($slide_list)}
		<div class="row d-md-none d-sm-block px-2">
			{foreach $slide_list as $news}
				<div class="col-12 mb-2">
					<article>
						<a href="{$news.detail_url}">
							<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid border-radius-0 w-100" alt="{$news.name}">
						</a>
						<div class="d-inline-block text-default text-1">
							{time_ago($news.publish_date)}
						</div>
						<h4 class="pb-2 line-height-4 font-weight-bold text-3 text-dark my-0 pe-1">
							<a href="{$news.detail_url}" class="text-decoration-none text-color-dark">{$news.name}</a>
						</h4>
					</article>
				</div>
			{/foreach}
		</div>
		<div class="row ps-4">
			<div class="col-lg-7 mb-4 pb-2 d-none d-md-block">
				{foreach $slide_list as $news}
					{if $news@iteration == 1}
						<a href="{site_url($news.detail_url)}">
							<article class="thumb-info thumb-info-no-borders thumb-info-bottom-info thumb-info-bottom-info-dark thumb-info-bottom-info-show-more thumb-info-no-zoom border-radius-0">
								<div class="thumb-info-wrapper thumb-info-wrapper-opacity-6">
									<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid" alt="{$news.name}">
									<div class="thumb-info-title bg-transparent p-4">
										{*							<div class="thumb-info-type bg-color-dark px-2 mb-1">Photography</div>*}
										<div class="thumb-info-inner mt-1">
											<h2 class="font-weight-bold text-color-light line-height-2 text-4 mb-0">{$news.name}</h2>
										</div>
										<div class="thumb-info-show-more-content">
											<span class="d-inline-block text-default text-1">
												 {time_ago($news.publish_date)}
											</span>
											<p class="mb-0 text-1 line-height-4 mb-1 text-light opacity-7">
												{$news.description}
											</p>
										</div>
									</div>
								</div>
							</article>
						</a>
						{break}
					{/if}
				{/foreach}
			</div>

			<div class="col-lg-5 d-none d-md-block">
				{foreach $slide_list as $news}
					{if $news@iteration == 1}
						{continue}
					{/if}
					<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-1 mb-2">
						<div class="row pb-1">
							<div class="col-sm-5">
								<a href="{site_url($news.detail_url)}">
									<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name}">
								</a>
							</div>
							<div class="col-sm-7 ps-0">
								<div class="thumb-info-caption-text">
		{*							<div class="thumb-info-type text-light text-uppercase d-inline-block bg-color-dark px-2 m-0 mb-1 float-none">*}
		{*								<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-light">Photography</a>*}
		{*							</div>*}
									<h2 class="d-block line-height-3 font-weight-normal text-3 text-dark mb-0">
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
{/strip}
