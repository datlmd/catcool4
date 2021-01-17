{if !empty($tags)}
	<div class="mb-3 pb-1">
		{foreach $tags as $tag}
			<a href="{base_url()}tags/{$tag}"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">{$tag}</span></a>
		{/foreach}
	</div>
{/if}