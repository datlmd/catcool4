{strip}
	{if !empty($is_mobile)}
		<div class="mb-2">
			<button class="btn btn-sm btn-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#menu_localisation" aria-expanded="false" aria-controls="menu_localisation">
				{lang('Admin.text_menu_localisation')}
			</button>
		</div>
	{/if}
	<div class="sidebar-nav-fixed {if !empty($is_mobile)}collapse{/if}" id="menu_localisation">
		<ul class="list-unstyled">
			<li><a href="{site_url('languages/manage')}" {if !empty($active) && $active eq 'languages'}class="active"{/if}>{lang('LanguageAdmin.heading_title')}</a></li>
			<li><a href="{site_url('currencies/manage')}" {if !empty($active) && $active eq 'currencies'}class="active"{/if}>{lang('CurrencyAdmin.heading_title')}</a></li>
			<li><a href="{site_url('products/stock_statuses_manage')}" {if !empty($active) && $active eq 'stock_statuses'}class="active"{/if}>{lang('ProductStockStatusAdmin.heading_title')}</a></li>
			<li><a href="{site_url('products/order_statuses_manage')}" {if !empty($active) && $active eq 'order_statuses'}class="active"{/if}>{lang('ProductOrderStatusAdmin.heading_title')}</a></li>
			<li>
				<a href="javascript:void(0);" class="{if !empty($active) && $active eq 'returns'}active{/if}">{lang('ReturnAdmin.heading_title')}</a>
				<ul>
					<li>
						<a href="{site_url('returns/statuses_manage')}" class="ps-1">{lang('ReturnStatusAdmin.heading_title')}</a>
					</li>
					<li>
						<a href="{site_url('returns/actions_manage')}" class="ps-1">{lang('ReturnActionAdmin.heading_title')}</a>
					</li>
					<li>
						<a href="{site_url('returns/reasons_manage')}" class="ps-1">{lang('ReturnReasonAdmin.heading_title')}</a>
					</li>
				</ul>
			</li>
			<li><a href="{site_url('countries/manage')}" {if !empty($active) && $active eq 'countries'}class="active"{/if}>{lang('CountryAdmin.heading_title')}</a></li>
			<li><a href="{site_url('products/weight_classes_manage')}" {if !empty($active) && $active eq 'weight_classes'}class="active"{/if}>{lang('ProductWeightClassAdmin.heading_title')}</a></li>
			<li><a href="{site_url('products/length_classes_manage')}" {if !empty($active) && $active eq 'length_classes'}class="active"{/if}>{lang('ProductLengthClassAdmin.heading_title')}</a></li>
		</ul>
	</div>
{/strip}
