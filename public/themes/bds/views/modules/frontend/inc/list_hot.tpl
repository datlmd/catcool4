{strip}
	{if !empty($hot_list)}
		<div class="newspaper mt-3">
			{foreach $hot_list as $news}
				{if $news@iteration neq 1}
					{break}
				{/if}
				<article>
					<h4><a href="{site_url($news.detail_url)}" class="">{$news.name}</a></h4>

					{if !empty($news.category_ids)}
						<div class="d-inline-block me-2">
							{foreach $news.category_ids as $category_id}
								<a href="{base_url($news_category_list[$category_id].slug)}" class="art-category">{$news_category_list[$category_id].name}</a>
							{/foreach}
						</div>
					{/if}
					<div class="d-inline-block art-time">
						 {time_ago($news.publish_date)}
					</div>

					<div class="newspaper-detail">
						<div class="newspaper-image">
							<a href="{site_url($news.detail_url)}">
								<img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" width="100%" alt="{htmlentities($news.name)}">
							</a>
						</div>
						<p class="fst-italic newspaper-description"><i class="fas fa-quote-left me-2"></i>{$news.description}<i class="fas fa-quote-right ms-2"></i></p>
						<div class="newspaper-content">
							{strip_tags($news.content, "<p><br><h1><h2><h3><h4>")|truncate:1000}
						</div>
					</div>
					<a href="{site_url($news.detail_url)}" class="text-end d-block mt-2">{lang('News.text_news_more')}</a>
				</article>
			{/foreach}
		</div>
	{/if}
{/strip}
