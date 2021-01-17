<footer id="footer">
	<div class="container">
		<div class="row py-5 my-2">
			<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
				<div class="contact-details">
					<h5 class="text-3 mb-3">CONTACT US</h5>
					<ul class="list list-icons list-icons-lg">
						<li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i><p class="m-0">234 Street Name, City Name</p></li>
						<li class="mb-1"><i class="fab fa-whatsapp text-color-primary"></i><p class="m-0"><a href="tel:8001234567">(800) 123-4567</a></p></li>
						<li class="mb-1"><i class="far fa-envelope text-color-primary"></i><p class="m-0"><a href="mailto:mail@example.com">mail@example.com</a></p></li>
					</ul>
				</div>
			</div>
			<div class="col-md-6 col-lg-5 mb-4 mb-lg-0">
				<div class="row">
                    {assign var="menu_footer" value=get_menu_by_position(MENU_POSITION_FOOTER)}
					{if !empty($menu_footer)}
						{foreach $menu_footer as $key => $item}
							<div class="col-md-6 mb-0">
								<h5 class="text-4 text-color-light mb-3 mt-4 mt-lg-0">{$item.detail.name}</h5>
								{if $item.subs}
									<ul class="dropdown-menu">
										{foreach $item.subs as $sub}
											<p class="mb-1"><a href="{base_url({$sub.detail.slug})}" class="text-3 link-hover-style-1">{$sub.detail.name}</a></p>>
										{/foreach}
									</ul>
								{/if}
							</div>
						{/foreach}
					{/if}
				</div>
			</div>
			<div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
				<h5 class="text-4 text-color-light mb-3">SUBSCRIBE NEWSLETTER</h5>
				<p class="text-3 mb-0">Get all the latest informaton on Events, Sales and Offfers.</p>
				<p class="text-3 mb-0">Sign up for newsletter today.</p>

				<div class="alert alert-danger d-none" id="newsletterError"></div>
				<form id="newsletterForm" action="php/newsletter-subscribe.php" method="POST" class="mw-100">
					<div class="input-group input-group-rounded">
						<input class="form-control form-control-sm bg-light px-4 text-3" placeholder="Email Address..." name="newsletterEmail" id="newsletterEmail" type="text">
						<span class="input-group-append">
											<button class="btn btn-primary  text-color-light text-2 py-3 px-4" type="submit"><strong>SUBSCRIBE!</strong></button>
										</span>
					</div>
				</form>
				<h5 class="text-3 mt-4">FOLLOW US</h5>
				<ul class="footer-social-icons social-icons social-icons-clean social-icons-big social-icons-opacity-light social-icons-icon-light mt-0 mt-lg-3">
					<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
					<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
					<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container py-2">
			<div class="row py-2">
				<div class="col-lg-5 text-center text-md-left">
					<p class="text-2 mt-1">© Copyright 2019. All Rights Reserved.</p>
				</div>
				<div class="col-lg-3 text-center text-md-left">
					<p class="text-3 mb-0 font-weight-semibold text-color-light opacity-8">BUSINESS HOURS</p>
					<p class="text-3 mb-0">Mon - Sun /9:00AM -8:00PM</p>
				</div>
				<div class="col-lg-4 text-center text-md-left">
					<img src="{img_url('assets/img/payment-icon.png')}" alt="Payment icons" class="img-fluid mt-4 mt-lg-2">
				</div>
			</div>
		</div>
	</div>
</footer>
