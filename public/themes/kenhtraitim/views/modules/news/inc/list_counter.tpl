{strip}
	{if !empty($counter_list)}
		<h3 class="font-weight-bold text-3 mb-2">{lang('News.text_popular_post')}</h3>
		{foreach $slide_list as $news}
			<article>
				<div class="row pb-1">
					<div class="col-4">
						<a href="{$news.detail_url}">
							<img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid border-radius-0" alt="{$news.name}">
						</a>
					</div>
					<div class="col-8 px-0">
						<h4 class="pb-2 line-height-4 font-weight-normal text-3 text-dark mb-0 pe-2">
							<a href="{$news.detail_url}" class="text-decoration-none text-color-dark">{$news.name}</a>
						</h4>
					</div>
				</div>
			</article>

		{/foreach}
	{/if}
{/strip}
