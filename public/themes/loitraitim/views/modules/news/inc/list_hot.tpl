{strip}
	{if !empty($hot_list)}

		{foreach $hot_list as $news}
			<article class="border-bottom mb-4 pb-4 article-hot pe-3">
				<h4 class="font-weight-normal text-5 mb-2 fw-light"><a href="{site_url($news.detail_url)}" class="text-dark text-uppercase text-decoration-none">{$news.name}</a></h4>
				{if !empty($news.category_ids)}
					<span>
						{foreach $news.category_ids as $category_id}
							<a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none text-dark fw-bold me-2">{$category_list[$category_id].name}</a>
						{/foreach}
					</span>
				{/if}
				<span class="d-inline-block text-default text-1 float-none">
					 {time_ago($news.publish_date)}
				</span>
				<div class="row">
					<p class="col-8 fst-italic">{$news.description}</p>
					<div class="col-4">
						<a href="{site_url($news.detail_url)}l">
							<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" width="100%" alt="{htmlentities($news.name)}" class="image-grayscale">
						</a>
					</div>
				</div>
			</article>
		{/foreach}

	{/if}
{/strip}
