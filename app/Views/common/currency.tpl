{strip}
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
{/strip}

