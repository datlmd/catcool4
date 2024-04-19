{strip}
	<div class="bg-white p-2 pb-4">
		<div class="row fs-small">
			<div class="col text-secondary pt-1">
				{get_today()}
			</div>
			<div class="col-6 text-end">
				{include file=get_theme_path('views/inc/weather.tpl')}
			</div>
		</div>

		{if !empty($post_list)}

			{foreach $post_list as $post}
				{if $post@iteration eq 1}
					{include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_class="mb-3 home-page"}
				{else}
					{include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-4 pt-4 border-top category"}
				{/if}
			{/foreach}

			{if !empty($post_list) && !empty($pager->links('default', 'frontend'))}
				{$pager->links('default', 'frontend')}
			{/if}
		{/if}

		{if !empty($hot_list)}
			<div class="category-name d-block mt-2 mb-4">
				<span>{lang('News.text_hot_post')}</span>
			</div>
			{foreach $hot_list as $post}
				{include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
			{/foreach}
		{/if}

	</div>

	{include file=get_theme_path('views/modules/posts/inc/counter_view.tpl') counter_list=$counter_list}

{/strip}
