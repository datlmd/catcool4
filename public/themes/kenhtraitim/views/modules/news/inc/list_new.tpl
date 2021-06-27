{strip}
	{if !empty($new_list)}
		<ol class="list list-ordened list-ordened-style-3 ps-0">
		{foreach $new_list as $news}
			<li>
				<article>
					<h4 class="pb-2 line-height-4 font-weight-normal text-3 text-dark mb-0 pe-2">
						<a href="{$news.detail_url}" class="text-decoration-none text-color-dark">{$news.name}</a>
					</h4>
			</article>
			</li>
		{/foreach}
		</ol>
	{/if}
{/strip}
