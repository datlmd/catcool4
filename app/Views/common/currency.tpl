{strip}
	{if $type eq "dropdown"}
		<div class="dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbar_dropdown_currency" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{foreach $currency_list as $key => $value}
					{if $value.code == config_item('currency')}
						{if !empty($value.symbol_left)}{$value.symbol_left}{else}{$value.symbol_right}{/if} <span class="d-none d-md-inline">{$value.code}</span>
					{/if}
				{/foreach}
			</a>
			<ul class="dropdown-menu" aria-labelledby="navbar_dropdown_currency">
				{foreach $currency_list as $key => $value}
					<li>
						<a class="dropdown-item" href="{site_url("")}">
							{if !empty($value.symbol_left)}{$value.symbol_left}{else}{$value.symbol_right}{/if} {$value.name}
						</a>
					</li>
				{/foreach}
			</ul>
		</div>
	{else}
		{assign var=collapse_currency_unique_id value=1|mt_rand:500}
		<a class="nav-item icon-collapse collapsed" data-bs-toggle="collapse" href="#collapse_currency_list_{$collapse_currency_unique_id}" role="button" aria-expanded="false" aria-controls="collapse_currency_list_{$collapse_currency_unique_id}">
			{foreach $currency_list as $key => $value}
				{if $value.code == config_item('currency')}
					{if !empty($value.symbol_left)}{$value.symbol_left}{else}{$value.symbol_right}{/if} {$value.code}
				{/if}
			{/foreach}
			<span></span>
		</a>
		<div id="collapse_currency_list_{$collapse_currency_unique_id}" class="collapse multi-collapse">
			<ul  class="list-unstyled">
				{foreach $currency_list as $key => $value}
					<li>
						<a class="nav-item" href="{site_url("")}">
							{if !empty($value.symbol_left)}{$value.symbol_left}{else}{$value.symbol_right}{/if} {$value.code}
						</a>
					</li>
				{/foreach}
			</ul>
		</div>
	{/if}
{/strip}

