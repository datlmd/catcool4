{strip}
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbar_dropdown_language" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			{foreach get_list_lang(true) as $key => $value}
				{if $value.code == session(get_name_session_lang())}
					{$value.icon} <span class="d-none d-md-inline">{lang("General.`$value.code`")}</span>
				{/if}
			{/foreach}
		</a>
		<ul class="dropdown-menu" aria-labelledby="navbar_dropdown_language">
			{foreach get_list_lang(true) as $key => $value}
				<li>
					<a class="dropdown-item" href="{site_url("languages/switch/`$value.code`")}">
						{$value.icon} {lang("General.`$value.code`")}
					</a>
				</li>
			{/foreach}
		</ul>
	</div>
{/strip}

