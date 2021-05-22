{if !empty($news_list)}
	<div class="blog-posts">
		<div class="row">
			{foreach $news_list as $news}
				{if $news@iteration > 6}
					{break}
				{/if}
				{if !empty($news_id_not) && $news.news_id eq $news_id_not}
					{continue}
				{/if}
				{assign var="detail_url" value="`$news.slug`.`$news.news_id`"}


				<div class="col-md-3 col-lg-4">
					<article class="post post-medium border-0 pb-0 mb-5">
						<div class="post-image">
							<a href="{site_url($detail_url)}">
								<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0 w-100" alt="{$news.name|unescape:"html"}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" />
							</a>
						</div>

						<div class="post-content">
							<h2 class="font-weight-semibold text-3 line-height-6 mt-3 mb-2"><a href="{site_url($detail_url)}">{$news.name|unescape:"html"}</a></h2>
						</div>
					</article>
				</div>

			{/foreach}
		</div>
	</div>
{/if}