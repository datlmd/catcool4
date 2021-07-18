{if !empty($tags)}
	<div class="mb-3 pb-1">
		{foreach $tags as $tag}
			<a href="{site_url()}tag/{$tag}">
				<span class="badge badge-light border text-dark text-3 px-3 py-2 me-1 mb-1">
					<i class="fas fa-hashtag"></i>{$tag|strtolower}
				</span>
			</a>
		{/foreach}
	</div>
{/if}