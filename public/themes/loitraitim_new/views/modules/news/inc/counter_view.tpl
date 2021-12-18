{strip}
	{if !empty($counter_list)}
		<div class="container-xxl section-counter-title bg-white">
			<h3 class="m-0 p-0">{lang('News.text_popular_post')}</h3>
		</div>
		<section class="section-counter text-white border-top pt-4 pb-2">

			<div class="container-xxl">
				<div class="row">
					{foreach $counter_list as $news}
						<div class="col-lg-2 col-md-4 col-6">
							{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="mb-3" is_show_category=true is_hide_description=true}
						</div>
					{/foreach}
				</div>
			</div>

		</section>
	{/if}
{/strip}
