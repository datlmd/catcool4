{strip}
	{if !empty($hot_list)}

		{foreach $hot_list as $news}
			<article class="border-bottom mb-4 pb-4 article-hot pe-3">
				<h4 class="font-weight-normal text-5 mb-2 fw-light"><a href="{site_url($news.detail_url)}" class="text-dark text-uppercase text-decoration-none">{$news.name}</a></h4>
				<div class="row">
					<div class="d-inline-block text-default text-1 float-none">
						 {time_ago($news.publish_date)}
					</div>
					<p class="col-8 fst-italic">{$news.description}</p>
					<div class="col-4">
						<a href="{site_url($news.detail_url)}l">
							<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" width="100%" alt="{$news.name}" class="image-grayscale">
						</a>
					</div>
				</div>
			</article>
		{/foreach}

	{/if}
{/strip}