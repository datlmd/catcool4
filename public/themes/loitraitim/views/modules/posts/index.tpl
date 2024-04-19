{strip}
	<div class="container-xxl bg-white mt-lg-0 mt-xl-3 p-4">
		<div class="row fs-small">
			<div class="col text-secondary pt-1">
				{get_today()}
			</div>
			<div class="col-5 text-end">
				{include file=get_theme_path('views/inc/weather.tpl')}
			</div>
		</div>

		<div class="row">

			<div class="col-lg-7 col-md-8 col-12">

				{if !empty($post_list)}
					<div class="row">
						{foreach $post_list as $post}
							{if $post@iteration > 2}
								{break}
							{/if}
							<div class="col-sm-6 col-12">
								{include file=get_theme_path('views/modules/posts/inc/article_info.tpl') article_info=$post article_class="mb-3 home-page"}
							</div>
						{/foreach}
					</div>

					{foreach $post_list as $post}
						{if $post@iteration <= 2}
							{continue}
						{/if}
						{include file=get_theme_path('views/modules/posts/inc/article_info.tpl') article_info=$post article_type='left' article_class="mb-4 pt-4 border-top category"}
					{/foreach}

					{if !empty($post_list) && !empty($pager->links('default', 'frontend'))}
						{$pager->links('default', 'frontend')}
					{/if}
					
				{/if}

			</div>

			<aside class="col-lg-5 col-md-4 col-12 ps-lg-4">

				{if !empty($hot_list)}
					{foreach $hot_list as $post}
						{include file=get_theme_path('views/modules/posts/inc/article_info.tpl') article_info=$post article_type='left' article_class="mb-3" is_show_category=true is_hide_description=true}
					{/foreach}
				{/if}

			</aside>

		</div>

	</div>

	{include file=get_theme_path('views/modules/posts/inc/counter_view.tpl') counter_list=$counter_list}

{/strip}
