{strip}
	<footer id="footer" class="footer dark-background">
		<div class="container">
			<a href="{site_url()}" class="navbar-brand">
				<img alt="{config_item('site_name')}" width="80" style="margin: auto 0;"
					data-change-src="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}"
					data-change-src-root="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}" class="image-change"
					src="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}">
				<span class="d-none">{config_item('site_name')}</span>
			</a>
			<h3 class="sitename mt-2">VINHOMES CẦN GIỜ</h3>
			<p>
				Địa chỉ: {lang('FrontendBd.text_contact_address')}<br />
				Email: {lang('FrontendBd.text_contact_email')}
			</p>

			<div class="container">
				<div class="copyright">
					<span>© Bản Quyền: Vinhomes Cần Giờ</span>
				</div>
			</div>
		</div>
	</footer>

	<div class="call-ring" title="{lang('FrontendBd.text_contact_phone')}">
		<!-- Icon điện thoại SVG -->
		<a href="tel:{lang('FrontendBd.text_contact_phone')}" class="nav-link">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
				<path
					d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21c1.21.49 2.53.76 3.88.76a1 1 0 011 1v3.5a1 1 0 01-1 1C9.16 21.84 2.16 14.84 2.16 6.5a1 1 0 011-1H6.5a1 1 0 011 1c0 1.35.27 2.67.76 3.88a1 1 0 01-.21 1.11l-2.43 2.3z" />
			</svg>
		</a>
	</div>

	<!-- Scroll Top -->
	<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
			class="bi bi-arrow-up-short"></i></a>
{/strip}