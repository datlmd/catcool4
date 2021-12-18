{strip}
	{if !empty($news_list)}
		<div class="category-name d-block mt-2 mb-4">
			<span>{lang('News.text_same_category')}</span>
		</div>
		{foreach $news_list as $news}
			{if !empty($news_id_not) && $news.news_id eq $news_id_not}
				{continue}
			{/if}
			{if !empty($article_type)}
				{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type=$article_type article_class="mb-3 pb-3 border-bottom" is_show_category=true is_hide_description=true}
			{else}
				{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='small' article_class="mb-3 pb-3 border-bottom" is_show_category=true is_hide_description=true}
			{/if}

		{/foreach}
	{/if}
{/strip}