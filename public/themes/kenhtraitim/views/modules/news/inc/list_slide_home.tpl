{strip}
	{if !empty($slide_list)}
		<div class="row ps-4">
			<div class="col-lg-7 mb-4 pb-2">
				{foreach $slide_list as $news}
					{if $news@iteration == 1}
						<a href="{site_url($news.detail_url)}">
							<article class="thumb-info thumb-info-no-borders thumb-info-bottom-info thumb-info-bottom-info-dark thumb-info-bottom-info-show-more thumb-info-no-zoom border-radius-0">
								<div class="thumb-info-wrapper thumb-info-wrapper-opacity-6">
									<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid" alt="{$news.name}">
									<div class="thumb-info-title bg-transparent p-4">
										{*							<div class="thumb-info-type bg-color-dark px-2 mb-1">Photography</div>*}
										<div class="thumb-info-inner mt-1">
											<h2 class="font-weight-bold text-color-light line-height-2 text-4 mb-0">{$news.name}</h2>
										</div>
										<div class="thumb-info-show-more-content">
											<p class="mb-0 text-1 line-height-9 mb-1 mt-2 text-light opacity-5">{$news.description}</p>
										</div>
									</div>
								</div>
							</article>
						</a>
						{break}
					{/if}
				{/foreach}
			</div>
			<div class="col-lg-5">
				{foreach $slide_list as $news}
					{if $news@iteration == 1}
						{continue}
					{/if}
					<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-1 mb-2">
						<div class="row pb-1">
							<div class="col-sm-5">
								<a href="{site_url($news.detail_url)}">
									<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name}">
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
