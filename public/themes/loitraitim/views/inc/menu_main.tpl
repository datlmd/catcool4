{strip}
	{assign var="menu_main" value=get_menu_by_position()}
	<ul class="nav nav-pills" id="menu_main">
		{if !empty($menu_main)}
			{foreach $menu_main as $key => $item}
				<li class="dropdown">
					<a class="dropdown-item dropdown-toggle" href="{$item.slug}">
						{$item.name}
					</a>
					{if !empty($item.subs)}
						<ul class="dropdown-menu">
							{foreach $item.subs as $sub}
								<li>
									<a class="dropdown-item" href="{$sub.slug}">
										{$sub.name}
									</a>
								</li>
							{/foreach}
						</ul>
					{/if}
				</li>
			{/foreach}
		{/if}
	</ul>
{/strip}
