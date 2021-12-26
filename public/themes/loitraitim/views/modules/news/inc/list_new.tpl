{strip}
	{if !empty($new_list)}
		<div class="category-name d-block mt-4 mb-4">
			<span>{lang('News.text_new_post')}</span>
		</div>

		{foreach $new_list as $news}
			{if !empty($is_mobile)}
				{include file=get_theme_path('views/modules/news/inc/article_info_mobile.tpl') article_info=$news article_type='left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
			{else}
				{include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
			{/if}
		{/foreach}
	{/if}
{/strip}
