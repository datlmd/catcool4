<div class="row pb-1 mt-4">
	<div class="col-lg-7 mb-4 pb-2">
		{foreach $slide_list as $news}
			{if $news@iteration == 1}
				{assign var="detail_url" value="`$news.slug`.`$news.news_id`"}
				<a href="{site_url($detail_url)}">
					<article class="thumb-info thumb-info-no-borders thumb-info-bottom-info thumb-info-bottom-info-dark thumb-info-bottom-info-show-more thumb-info-no-zoom border-radius-0">
						<div class="thumb-info-wrapper thumb-info-wrapper-opacity-6">
							<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid" alt="{$news.name|unescape:"html"}">
							<div class="thumb-info-title bg-transparent p-4">
								{*							<div class="thumb-info-type bg-color-dark px-2 mb-1">Photography</div>*}
								<div class="thumb-info-inner mt-1">
									<h2 class="font-weight-bold text-color-light line-height-2 text-5 mb-0">{$news.name|unescape:"html"}</h2>
								</div>
								<div class="thumb-info-show-more-content">
									<p class="mb-0 text-1 line-height-9 mb-1 mt-2 text-light opacity-5">{$news.description|unescape:"html"}</p>
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
			{assign var="detail_url" value="`$news.slug`.`$news.news_id`"}
			<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-4 mb-2">
				<div class="row align-items-center pb-1">
					<div class="col-sm-5">
						<a href="{site_url($detail_url)}">
							<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name|unescape:"html"}">
						</a>
					</div>
					<div class="col-sm-7 pl-sm-1">
						<div class="thumb-info-caption-text">
{*							<div class="thumb-info-type text-light text-uppercase d-inline-block bg-color-dark px-2 m-0 mb-1 float-none">*}
{*								<a href="{site_url($detail_url)}" class="text-decoration-none text-color-light">Photography</a>*}
{*							</div>*}
							<h2 class="d-block line-height-2 text-4 text-dark font-weight-bold mt-1 mb-0">
								<a href="{site_url($detail_url)}" class="text-decoration-none text-color-dark">{$news.name|unescape:"html"}</a>
							</h2>
						</div>
					</div>
				</div>
			</article>
		{/foreach}
	</div>
</div>
