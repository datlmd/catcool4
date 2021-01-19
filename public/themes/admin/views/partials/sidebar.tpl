<div class="nav-left-sidebar sidebar-dark {if empty(config_item('enable_scroll_menu_admin'))}nav-left-sidebar-scrolled{/if} {if empty(config_item('enable_icon_menu_admin'))}navbar-full-text{/if}">
	<div class="menu-list">
		<button type="button" class="btn btn-xs {if empty(config_item('enable_scroll_menu_admin'))}btn-warning{else}btn-light{/if} border-0 d-xl-block d-lg-block d-none navbar-light btn-scroll" onclick="Catcool.scrollMenu(this);"><i class="{if empty(config_item('enable_scroll_menu_admin'))}fas fa-angle-double-right font-20 text-dark{else}fas fa-angle-double-left font-22{/if}"></i></button>
		{* su dung cho thiet bi di dong *}
		<nav class="navbar navbar-expand-lg navbar-light {if config_item('enable_icon_menu_admin')}d-xl-none d-lg-none{/if}">
            {if empty(config_item('image_logo_url'))}
				<a class="d-xl-none d-lg-none logo-image-mobile logo-text logo-text-mobile" href="{site_url(CATCOOL_DASHBOARD)}">
					<span class="logo-main">{LOGO_TEXT}</span>
					<span class="logo-sub">{LOGO_TEXT_SUB}</span>
				</a>
            {else}
				<a class="d-xl-none d-lg-none logo-image-mobile" href="{site_url(CATCOOL_DASHBOARD)}">
					<img src="{image_url(config_item('image_logo_url'))}" alt="logo">
				</a>
            {/if}
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu_admin" aria-controls="menu_admin" aria-expanded="false" aria-label="Menu Admin">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="menu_admin">
				<ul class="navbar-nav flex-column">
					<li class="nav-divider pb-0 d-xl-none d-lg-none">
						<a class="" href="{site_url('users/manage/edit/'|cat:session('user_id'))}">
							<span class="badge badge-info"><i class="fas fa-user-circle mr-1"></i>{session('full_name')} ({session('username')})</span>
						</a>
					</li>
					<li class="nav-item mt-xl-2 mt-lg-2">
						<a class="nav-link" href="{site_url(CATCOOL_DASHBOARD)}"><i class="fas fa-home"></i>{lang('catcool_dashboard')}</a>
					</li>
					{foreach $menu_admin as $key => $item}
						<li class="nav-item">
							<a class="nav-link {if $item.selected|strstr:$this->uri->segment(1,'none')}collapsed active show{/if}" href="{$item.detail.slug}" {$item.attributes} {if $item.subs}data-toggle="collapse" aria-expanded="true"{/if} data-target="#submenu-{$key}" aria-controls="submenu-{$key}">
								{if !empty($item.icon)}<i class="{$item.icon}"></i>{/if}{$item.detail.name}
							</a>
							{if $item.subs}
								<div id="submenu-{$key}" class="collapse submenu pb-2 {if $item.selected|strstr:$this->uri->segment(1,'none')}show{/if}" style="">
									<ul class="nav flex-column">
										{foreach $item.subs as $sub}
											<li class="nav-item">
												<a class="nav-link {if $sub.selected eq $this->uri->uri_string()}active{/if}" href="{site_url($sub.detail.slug)}" {$sub.attributes}><i class="fas fa-angle-double-right mr-2"></i>{$sub.detail.name}</a>
											</li>
										{/foreach}
									</ul>
								</div>
							{/if}
						</li>
					{/foreach}
					<li class="nav-item d-xl-none d-lg-none">
						<a class="nav-link" href="{site_url('users/manage/logout')}"><i class="fas fa-power-off"></i>{lang('text_logout')}</a>
					</li>
				</ul>
			</div>
		</nav>
		{* end su dung cho thiet bi di dong *}
		{* su dung cho pc *}
		{if config_item('enable_icon_menu_admin')}
			<div class="d-xl-block d-lg-block d-none">
				{foreach $menu_admin as $key => $item}
					<a href="{$item.detail.slug}" {$item.attributes} {if $item.subs}data-toggle="modal" data-target="#popup_menu_left_{$key}"{/if}>
						<div class="menu-left-icon {if strpos($item.selected, $this->uri->segment(1,'none')) !== false}active{/if}">
							<i class="{if !empty($item.icon)}{$item.icon}{else}fas fa-angle-double-right{/if}"></i>
							<div class="tooltiptext">{$item.detail.name}</div>
						</div>
					</a>
				{/foreach}
			</div>
		{/if}
	</div>
</div>
{if config_item('enable_icon_menu_admin')}
<!-- Modal popup submenu -->
	{foreach $menu_admin as $key => $item}
		{if $item.subs}
			<div class="popup-sub-menu-left modal left fade" id="popup_menu_left_{$key}" tabindex="-1" role="dialog" aria-labelledby="modal_label_{$key}" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modal_label_{$key}"><i class="mr-2 {if !empty($item.icon)}{$item.icon}{else}fas fa-angle-double-right{/if}"></i>{$item.detail.name}</h4>
							<a href="#" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</a>
						</div>
						<div class="modal-body">
							<div class="row">
							{foreach $item.subs as $sub}
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center mt-2 mb-4">
									<a href="{site_url($sub.detail.slug)}" class="menu-sub-left-icon {if $sub.selected eq $this->uri->uri_string()}active{/if}" {$sub.attributes}>
										<i class="{if !empty($sub.icon)}{$sub.icon}{else}fas fa-angle-double-right{/if}"></i>
									</a>
									<p class="text-dark mt-2">{$sub.detail.name}</p>
								</div>
							{/foreach}
							</div>
						</div>
					</div>
				</div>
			</div>
		{/if}
	{/foreach}
{/if}