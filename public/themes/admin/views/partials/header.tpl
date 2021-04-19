{strip}
<div class="dashboard-header">
	<nav class="navbar navbar-expand-lg fixed-top">
		{*<div class="logo-bg">*}
			{*<div class="logo-block block-one"></div>*}
			{*<div class="logo-block block-two"></div>*}
			{*<div class="logo-block block-three"></div>*}
			{*<div class="logo-block block-four"></div>*}
		{*</div>*}
		{include file=get_theme_path('views/inc/logo.tpl')}
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse " id="navbarSupportedContent">
			<ul class="navbar-nav ms-auto navbar-right-top">
				<li class="nav-item">
					<div id="custom-search" class="top-search-bar">
						{if is_multi_lang() == true}
							<select onchange="javascript:window.location.href='{site_url()}languages/manage/switch/' + this.value;" class="form-control form-control-sm">
								{foreach get_list_lang(true) as $key => $value}
									<option value={$value.code}  {if $value.code == session(get_name_session_lang(true))}selected="selected"{/if}>
										{lang("General.`$value.code`")}
									</option>
								{/foreach}
							</select>
						{/if}
					</div>
				</li>
				<li class="nav-item dropdown notification">
					<a class="nav-link nav-icons icon-animation" href="#" id="navbarDropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
					<ul class="dropdown-menu dropdown-menu-end notification-dropdown">
						<li>
							<div class="notification-title"> Notification</div>
							<div class="notification-list">
								<div class="list-group">
									<a href="#" class="list-group-item list-group-item-action active">
										<div class="notification-info">
											<div class="notification-list-user-img"><img src="{theme_url('assets/images/avatar-2.jpg')}" alt="" class="user-avatar-md rounded-circle"></div>
											<div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
												<div class="notification-date">2 min ago</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</li>
						<li>
							<div class="list-footer"> <a href="#">View all notifications</a></div>
						</li>
					</ul>
				</li>
				<li class="nav-item dropdown connection">
					<a class="nav-link icon-animation" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
					<ul class="dropdown-menu dropdown-menu-end connection-dropdown">
						<li class="connection-list">
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="{theme_url('assets/images/github.png')}" alt="" > <span>Github</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="{theme_url('assets/images/dribbble.png')}" alt="" > <span>Dribbble</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="{theme_url('assets/images/dropbox.png')}" alt="" > <span>Dropbox</span></a>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="{theme_url('assets/images/bitbucket.png')}" alt=""> <span>Bitbucket</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="{theme_url('assets/images/mail_chimp.png')}" alt="" ><span>Mail chimp</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="{theme_url('assets/images/slack.png')}" alt="" > <span>Slack</span></a>
								</div>
							</div>
						</li>
						<li>
							<div class="conntection-footer"><a href="#">More</a></div>
						</li>
					</ul>
				</li>
				<li class="nav-item dropdown nav-user">
					<a class="nav-link nav-user-img icon-animation" href="#" id="navbar_dropdown_user_info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{get_avatar()}" alt="" class="user-avatar-md rounded-circle"></a>
					<div class="dropdown-menu dropdown-menu-end nav-user-dropdown" aria-labelledby="navbar_dropdown_user_info">
						<div class="nav-user-info">
							<h5 class="mb-0 text-white nav-user-name">{session('full_name')}</h5>
							<span class="status"></span><span class="ms-2">{session('username')}</span>
						</div>
						<a class="dropdown-item" href="{site_url('users/manage/edit/'|cat:session('user_id'))}"><i class="fas fa-user-circle me-2"></i>{lang('text_profile')}</a>
						<a class="dropdown-item" href="{site_url('users/manage/logout')}"><i class="fas fa-sign-out-alt me-2"></i>{lang('text_logout')}</a>
					</div>
				</li>
				{if config_item('enable_icon_menu_admin')}
					<li class="nav-item dropdown nav-more">
						<a class="px-3 icon-animation nav-link" href="#" id="navbar_dropdown_menu_all" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-angle-double-down"></i></a>
						<div class="dropdown-menu dropdown-menu-end nav-user-dropdown navbar-dropdown-menu-top" aria-labelledby="navbar_dropdown_menu_all">
							{*hien thi menu all*}
							{foreach $menu_admin as $key => $item}
								<a class="dropdown-item" href="{$item.slug}" {$item.attributes}>
									{if !empty($item.icon)}<i class="{$item.icon} me-2"></i>{/if}{$item.name}
								</a>
								{if !empty($item.subs)}
									{foreach $item.subs as $sub}
										<a class="dropdown-item py-2" href="{site_url($sub.slug)}" {$sub.attributes}><i class="fas fa-angle-double-right ms-3 me-2"></i>{$sub.name}</a>
									{/foreach}
								{/if}
							{/foreach}
						</div>
					</li>
				{/if}
			</ul>
		</div>
	</nav>
</div>
{/strip}
