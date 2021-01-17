{foreach $category_list as $category}
	<div class="heading heading-border heading-middle-border">
		<h3 class="text-4"><strong class="font-weight-bold text-1 px-3 text-light py-2 bg-secondary">{$category.detail.name}</strong></h3>
	</div>
	<div class="row pb-1">
		{foreach $category.list as $news}
			{if $news@iteration == 1}
				{assign var="detail_url" value="`$news.slug`.`$news.news_id`"}
				<div class="col-lg-6 mb-4 pb-1">
					<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
						<div class="row">
							<div class="col">
								<a href="{$detail_url}">
									<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name|unescape:"html"}">
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="thumb-info-caption-text">
									<div class="d-inline-block text-default text-1 mt-2 float-none">
										<a href="{$detail_url}" class="text-decoration-none text-color-default">{$news.publish_date}</a>
									</div>
									<h4 class="d-block line-height-2 text-4 text-dark font-weight-bold mb-0">
										<a href="{$detail_url}" class="text-decoration-none text-color-dark">{$news.name|unescape:"html"}</a>
									</h4>
								</div>
							</div>
						</div>
					</article>
				</div>
				{break}
			{/if}
		{/foreach}
		<div class="col-lg-6">
			{foreach $category.list as $news}
				{if $news@iteration == 1}
					{continue}
				{/if}
				{assign var="detail_url" value="`$news.slug`.`$news.news_id`"}
				<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-4 mb-2">
					<div class="row align-items-center pb-1">
						<div class="col-sm-4">
							<a href="{$detail_url}">
								<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name|unescape:"html"}">
							</a>
						</div>
						<div class="col-sm-8 pl-sm-0">
							<div class="thumb-info-caption-text">
								<h4 class="d-block pb-2 line-height-2 text-3 text-dark font-weight-bold mb-0">
									<a href="{$detail_url}" class="text-decoration-none text-color-dark">{$news.name|unescape:"html"}</a>
								</h4>
							</div>
						</div>
					</div>
				</article>
			{/foreach}
		</div>
	</div>
{/foreach}