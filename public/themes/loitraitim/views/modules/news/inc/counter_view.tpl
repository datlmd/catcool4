{strip}
	{if !empty($counter_list)}
		<div class="container-xxl section-counter-title bg-white">
			<h3 class="m-0 p-0">{if !empty($text_title)}{$text_title}{else}{lang('News.text_popular_post')}{/if}</h3>
		</div>
		<section class="section-counter text-white border-top pt-4 pb-2">

			<div class="container-xxl">
				<div class="row">
					{foreach $counter_list as $news}
						<div class="col-lg-2 col-md-4 col-6">
							{if !empty($is_mobile)}
								{include file=get_theme_path('views/modules/news/inc/article_info_mobile.tpl') article_info=$news article_class="mb-3" is_show_category=true is_hide_description=true}
							{else}
								{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="mb-3" is_show_category=true is_hide_description=true}
							{/if}
						</div>
					{/foreach}
				</div>
			</div>

		</section>
	{/if}
{/strip}
