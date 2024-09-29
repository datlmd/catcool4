{strip}
	
	{if !empty($latest_post_list)}

		{foreach $latest_post_list as $post}
			{if !empty($is_mobile)}
				{include 
					file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') 
					article_info=$post 
					article_type='small' 
					is_show_category=true
					is_show_tag=false 
					article_class="mb-4"
					is_hide_description=false
				}
			{else}
				{include 
					file=get_theme_path('views/modules/posts/inc/article_info.tpl') 
					article_info=$post 
					article_type='small' 
					is_show_category=true
					is_show_tag=false 
					article_class="mb-4"
					is_hide_description=false
				}
			{/if}
		{/foreach}
		
	{/if}

{/strip}


