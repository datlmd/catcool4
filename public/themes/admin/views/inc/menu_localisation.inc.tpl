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
			<li><a href="{site_url('products/weight_classes_manage')}" {if !empty($active) && $active eq 'weight_classes'}class="active"{/if}>{lang('ProductWeightClassAdmin.heading_title')}</a></li>
			<li><a href="{site_url('products/length_classes_manage')}" {if !empty($active) && $active eq 'length_classes'}class="active"{/if}>{lang('ProductLengthClassAdmin.heading_title')}</a></li>
			<li><a href="{site_url('products/stock_statuses_manage')}" {if !empty($active) && $active eq 'stock_statuses'}class="active"{/if}>{lang('ProductStockStatusAdmin.heading_title')}</a></li>
		</ul>
	</div>
{/strip}
