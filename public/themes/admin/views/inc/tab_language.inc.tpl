{if count($languages) > 1}
	<ul class="nav nav-tabs border-bottom ps-3" id="tab_multi_language" role="tablist">
		{foreach $languages as $language}
			<li class="nav-item">
				{if !empty($id_content_tab)}
					<a class="nav-link p-2 ps-3 pe-3 {if !empty($language.active)}active{/if}" id="{$id_content_tab}_tab_{$language.id}" data-toggle="tab" href="#{$id_content_tab}_{$language.id}" role="tab" aria-controls="{$id_content_tab}_{$language.id}" aria-selected="{if !empty($language.active)}true{else}false{/if}">{$language.icon}{$language.name}</a>
				{else}
					<a class="nav-link p-2 ps-3 pe-3 {if !empty($language.active)}active{/if}" id="language_tab_{$language.id}" data-toggle="tab" href="#lanuage_content_{$language.id}" role="tab" aria-controls="lanuage_content_{$language.id}" aria-selected="{if !empty($language.active)}true{else}false{/if}">{$language.icon}{$language.name}</a>
				{/if}
			</li>
		{/foreach}
	</ul>
{/if}