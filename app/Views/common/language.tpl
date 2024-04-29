{strip}
	{if $type eq "dropdown"}
		<div class="dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbar_dropdown_language" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{foreach get_list_lang() as $key => $value}
					{if $value.code == session(get_name_session_lang())}
						{$value.icon} <span class="d-none d-md-inline">{lang("General.`$value.code`")}</span>
					{/if}
				{/foreach}
			</a>
			<ul class="dropdown-menu" aria-labelledby="navbar_dropdown_language">
				{foreach get_list_lang() as $key => $value}
					<li>
						<a class="dropdown-item" href="{site_url("languages/switch/`$value.code`")}">
							{$value.icon} {lang("General.`$value.code`")}
						</a>
					</li>
				{/foreach}
			</ul>
		</div>
	{else}
		{assign var=collapse_language_unique_id value=1|mt_rand:500}
		<a class="nav-item icon-collapse collapsed" data-bs-toggle="collapse" href="#collapse_language_list_{$collapse_language_unique_id}" role="button" aria-expanded="false" aria-controls="collapse_language_list_{$collapse_language_unique_id}">
			{foreach get_list_lang() as $key => $value}
				{if $value.code == session(get_name_session_lang())}
					{$value.icon} {lang("General.`$value.code`")}
				{/if}
			{/foreach}
			<span></span>
		</a>
		<div id="collapse_language_list_{$collapse_language_unique_id}" class="collapse multi-collapse">
			<ul  class="list-unstyled">
				{foreach get_list_lang() as $key => $value}
					<li>
						<a class="nav-item" href="{site_url("languages/switch/`$value.code`")}">
							{$value.icon} {lang("General.`$value.code`")}
						</a>
					</li>
				{/foreach}
			</ul>
		</div>
	{/if}
{/strip}

