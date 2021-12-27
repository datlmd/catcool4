{strip}
	{if !empty($tags)}
		<div class="tag-list pb-1">
			{foreach $tags as $tag}
				<a href="{site_url()}post-tag/{get_seo_extension($tag|replace:' ':'-')}">
					<i class="fas fa-hashtag"></i>{$tag}
				</a>
			{/foreach}
		</div>
	{/if}
{/strip}
