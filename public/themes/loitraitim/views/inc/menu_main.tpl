{strip}
	{assign var="menu_main" value=get_menu_by_position()}

	{if !empty($menu_type) && $menu_type eq 'mobile'}
		<ul class="list-group list-group-flush d-flex-row h-100 justify-content-center" id="menu_main_mobile">
			<li class="list-group-item dropdown text-start">
				<a class="dropdown-item" href="{site_url()}">
					{lang('General.text_home')}
				</a>
			</li>
			{if !empty($menu_main)}
				{foreach $menu_main as $key => $item}
					<li class="list-group-item dropdown text-start">
						<a class="dropdown-item" href="{$item.slug}">
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
	{else}
		<ul class="nav nav-pills" id="menu_main">
			<li class="dropdown text-center">
				<a class="dropdown-item" href="{site_url()}">
					<i class="fas fa-home"></i>
				</a>
			</li>
			{if !empty($menu_main)}
				{foreach $menu_main as $key => $item}
					<li class="dropdown text-center">
						<a class="dropdown-item" href="{$item.slug}">
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
	{/if}

{/strip}
