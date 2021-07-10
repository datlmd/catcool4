{if !empty($tags)}
	<div class="mb-3 pb-1">
		{foreach $tags as $tag}
			<a href="{site_url()}tags/{$tag}"><span class="badge badge-info text-light badge-pill text-uppercase px-3 py-2 me-1 mb-1">{$tag}</span></a>
		{/foreach}
	</div>
{/if}