{strip}
	<footer id="footer">

		<div class="footer-newsletter container-fluid">
			<div class="container-xxl">
				<div class="row">
					<div class="col-md-6 col-lg-8 mb-3">
						{include file=get_view_path('common/newsletter.tpl')}
					</div>

					<div class="col-md-6 col-lg-4 text-center">
						{include file=get_view_path('common/social_list.tpl')}
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="container-xxl menu-footer">

				{view_cell('Common::menuFooter')}

			</div>
		</div>

		<div class="footer-copyright container-fluid">
			<div class="container-xxl">

				{if !empty(config_item('store_open'))}
					<span class="text-opentime_title" data-type="lang" data-key="Frontend.text_business_hours">{lang('Frontend.text_business_hours')}</span>
					<span class="text-opentime_value">{config_item('store_open')}</span>
					<br/>
				{/if}

				<img src="{img_url('payment-icon.png')}" alt="Payment icons" class="img-fluid mb-2"><br/>

				<span class="text-copyright" data-type="lang" data-key="Frontend.text_copyright">{lang('Frontend.text_copyright')}</span>

			</div>
		</div>

	</footer>

{/strip}
