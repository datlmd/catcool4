{strip}
	{if !empty($counter_list)}
		<h3 class="font-weight-bold mt-2 text-4 mb-2">{lang('News.text_popular_post')}</h3>
		{foreach $counter_list as $news}
			<article>
				<a href="{site_url($news.detail_url)}">
					<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="img-fluid border-radius-0 w-100 mb-1" width="100%" alt="{htmlentities($news.name)}">
				</a>
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
				<h4 class="pb-2 line-height-4 font-weight-normal text-4 text-dark mt-0 pe-2">
					<a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
				</h4>
			</article>

		{/foreach}
	{/if}
{/strip}
