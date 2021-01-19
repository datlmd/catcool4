{assign var="menu_main" value=get_menu_by_position()}
<ul class="nav nav-pills flex-column flex-lg-row" id="menu_main">
	{if !empty($menu_main)}
		{foreach $menu_main as $key => $item}
			<li class="dropdown">
				<a class="dropdown-item dropdown-toggle" href="{site_url({$item.detail.slug})}">
					{$item.detail.name}
				</a>
				{if $item.subs}
					<ul class="dropdown-menu">
						{foreach $item.subs as $sub}
							<li>
								<a class="dropdown-item" href="{site_url({$sub.detail.slug})}">
									{$sub.detail.name}
								</a>
							</li>
						{/foreach}
					</ul>
				{/if}
			</li>
		{/foreach}
	{/if}
</ul>