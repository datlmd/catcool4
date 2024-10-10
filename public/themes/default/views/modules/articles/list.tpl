{strip}
    <h2 class="mb-4 text-start">
		{if !empty($category_list[$category_id])}
			{$category_list[$category_id].name}
		{else}
			{lang('Article.text_article_list')}
		{/if}       
    </h2>

	{if !empty($article_list)}
		<div class="article-list">
			{foreach $article_list as $item}
				<article class="row mb-3 {if !$item@last}border-bottom pb-3{/if}">
					
				<div class="{if $item@iteration < 2}col-sm-4{else}col-sm-3{/if}">
						<a href="{$item.href}">
							<img src="{$item.image}" class="img-fluid img-thumbnail rounded-0" alt="{$item.name}" />
						</a>
					</div>
					<div class="{if $item@iteration < 2}col-sm-8{else}col-sm-9{/if}">
							
						<h3 class=""><a href="{$item.href}">{$item.name}</a></h3>

						<div class="article-meta">
							<span class="article-datetime"><i class="far fa-calendar-alt me-1"></i>{$item.publish_date|date_format:config_item('date_format')}</span>
							
							{if !empty($item.category_ids)}
								<span>
									<i class="far fa-folder ms-2 me-1"></i> 
									{foreach $item.category_ids as $category_id}
										<a href="{$category_list[$category_id].href}" class="">{$category_list[$category_id].name}</a>
										{if !$category_id@last}, {/if}
									{/foreach}
								</span>
							{/if}

							{if !empty($item.counter_view) && $item.counter_view > 0}
								<span><i class="fas fa-eye ms-2 me-1"></i>{$item.counter_view}</span>
							{/if}
					
							{if !empty($item.counter_comment) && $item.counter_comment > 0}
								<span><i class="far fa-comments ms-2 me-1"></i>{$item.counter_comment|default:0} {lang('Article.text_comment')}</span>
							{/if}
							
						</div>

						<p class="mb-0">{$item.description}</p>
						<span class="d-block w-100 text-end">
							<a href="{$item.href}" rel="nofollow" class="btn btn-xs btn-light">{lang('Article.text_read_more')}</a>
						</span>
					</div>
					
				</article>
			{/foreach}

			{if !empty($article_list) && !empty($page_list->links('default', 'frontend'))}
				{$page_list->links('default', 'frontend')}
			{/if}
		</div>
	{/if}
{/strip}
