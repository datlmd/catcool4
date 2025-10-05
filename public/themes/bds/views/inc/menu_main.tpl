{strip}
	{assign var="menu_main" value=get_menu_by_position()}

	{if !empty($menu_type) && $menu_type eq 'mobile'}
		<ul class="list-group list-group-flush d-flex-row h-100 justify-content-center" id="menu_main_mobile">

			<li class="list-group-item text-start">
				<a href="{site_url()}">
					{lang('General.text_home')}
				</a>
			</li>
			{if !empty($menu_main)}
				{foreach $menu_main as $key => $item}
						{if !empty($item.subs)}
							<li class="list-group-item text-start" data-bs-toggle="collapse" data-bs-target="#menu_main_{$item.menu_id}" aria-controls="menu_main_{$item.menu_id}" aria-expanded="false">
								{$item.name}
								<span><i class="fas fa-chevron-down float-end"></i></span>
							</li>
							<ul class="collapse item-sub" id="menu_main_{$item.menu_id}">
						
								{foreach $item.subs as $sub}
									<li class="list-group-item text-start">
										<a href="{$sub.slug}">
											<i class="fas fa-angle-right mx-2"></i>{$sub.name}
										</a>
									</li>
								{/foreach}
							
							</ul>
						{else}
							<li class="list-group-item text-start">
								<a href="{$item.slug}">
									{$item.name}
								</a>
							</li>
						{/if}

				{/foreach}
			{/if}
		</ul>
	{else}
		<ul class="nav nav-pills" id="menu_main">
			<li class="nav-item text-center">
				<a class="nav-link" href="{site_url()}">
					<i class="fas fa-home"></i>
				</a>
			</li>
			{if !empty($menu_main)}
				{foreach $menu_main as $key => $item}
					<li class="nav-item text-center {if !empty($item.subs)}dropdown{/if}">
						{if !empty($item.subs)}
							<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
								{$item.name}
							</a>
							<ul class="dropdown-menu shadow">
								{foreach $item.subs as $sub}
									<li>
										<a class="dropdown-item" href="{$sub.slug}">
											{$sub.name}
										</a>
									</li>
								{/foreach}
							</ul>
						{else}
							<a class="nav-link" href="{$item.slug}">
								{$item.name}
							</a>
						{/if}
					</li>
				{/foreach}
			{/if}
		</ul>
	{/if}

{/strip}
