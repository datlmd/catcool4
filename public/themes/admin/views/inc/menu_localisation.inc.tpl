{strip}
	{if !empty($is_mobile)}
		<div class="mb-2">
			<button class="btn btn-sm btn-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#menu_localisation" aria-expanded="false" aria-controls="menu_localisation">
				{lang('Admin.text_menu_localisation')}
			</button>
		</div>
	{/if}
	<div class="sidebar-nav-fixed {if !empty($is_mobile)}collapse{/if} card" id="menu_localisation">
		<div class="card-body px-2">
		<ul class="list-unstyled">
			<li><a href="{site_url('manage/locations')}" class="{if !empty($active) && $active eq 'locations'}active{/if}">{lang('LocationAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/languages')}" class="{if !empty($active) && $active eq 'languages'}active{/if}">{lang('LanguageAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/currencies')}" class="{if !empty($active) && $active eq 'currencies'}active{/if}">{lang('CurrencyAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/product_stock_statuses')}" class="{if !empty($active) && $active eq 'stock_statuses'}active{/if}">{lang('ProductStockStatusAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/product_order_statuses')}" class="{if !empty($active) && $active eq 'order_statuses'}active{/if}">{lang('ProductOrderStatusAdmin.heading_title')}</a></li>
			<li class="border-bottom pb-1"><a href="{site_url('manage/subscription_statuses')}" class="{if !empty($active) && $active eq 'subscription_statuses'}active{/if}">{lang('SubscriptionStatusAdmin.heading_title')}</a></li>
			<li class="border-bottom pb-1 my-2">
				<a href="{site_url('manage/return_statuses')}" class="{if strpos($active, 'returns') !== false}active{/if} fw-bold">{lang('ReturnAdmin.heading_title')}</a>
				<ul>
					<li>
						<a href="{site_url('manage/return_statuses')}" class="ps-1">{lang('ReturnStatusAdmin.heading_title')}</a>
					</li>
					<li>
						<a href="{site_url('manage/return_actions')}" class="ps-1">{lang('ReturnActionAdmin.heading_title')}</a>
					</li>
					<li>
						<a href="{site_url('manage/return_reasons')}" class="ps-1">{lang('ReturnReasonAdmin.heading_title')}</a>
					</li>
				</ul>
			</li>
			<li><a href="{site_url('manage/product_weight_classes')}" class="{if !empty($active) && $active eq 'weight_classes'}active{/if}">{lang('ProductWeightClassAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/product_length_classes')}" class="{if !empty($active) && $active eq 'length_classes'}active{/if}">{lang('ProductLengthClassAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/countries')}" class="{if !empty($active) && $active eq 'countries'}active{/if}">{lang('CountryAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/country_zones')}" class="{if !empty($active) && $active eq 'zones'}active{/if}">{lang('CountryProvinceAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/geo_zones')}" class="{if !empty($active) && $active eq 'geo_zones'}active{/if}">{lang('GeoZoneAdmin.heading_title')}</a></li>
			<li><a href="{site_url('manage/addresses_format')}" class="{if !empty($active) && $active eq 'addresses_format'}active{/if}">{lang('AddressFormatAdmin.heading_title')}</a></li>
		</ul>
		</div>
	</div>
{/strip}
