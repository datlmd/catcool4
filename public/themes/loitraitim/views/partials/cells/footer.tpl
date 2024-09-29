{strip}
	{* <footer id="footer">

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

	</footer> *}
	<footer id="footer" class="m-0 border-0">
		<div class="container-xxl py-2">
			<div class="row">
				<div class="col-12 col-md-6">
					{*<ul class="footer-social-icons social-icons social-icons-clean social-icons-icon-light mb-3">*}
						{*<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>*}
						{*<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>*}
						{*<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>*}
					{*</ul>*}
					<p class="text-center text-md-start ms-md-2">{lang('News.text_copyright')}</p>
				</div>
				<div class="col-12 col-md-6 text-center text-md-end">
					{include file=get_theme_path('views/inc/facebook_box.tpl')}
				</div>
			</div>
		</div>
	</footer>
{/strip}
