{form_open(uri_string(), ['id' => 'form_option'])}
{create_input_token($csrf)}
{form_hidden('tab_type', 'tab_option')}
<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_product')}</div>
<div class="form-group row">
	{lang('text_product_count', 'text_product_count', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="product_count" value="{STATUS_ON}" {set_checkbox('product_count', STATUS_ON, ($settings.product_count|lower eq 'true'))} id="product_count">
			<span><label for="product_count"></label></span>
		</div><br/>
		<small>{lang('help_product_count')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_product_limit_admin', 'text_product_limit_admin', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="product_limit_admin" value="{set_value('product_limit_admin', $settings.product_limit_admin)}" id="product_limit_admin" class="form-control">
		<small>{lang('help_product_limit_admin')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_review')}</div>
<div class="form-group row">
	{lang('text_review_status', 'text_review_status', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="review_status" value="{STATUS_ON}" {set_checkbox('review_status', STATUS_ON, ($settings.review_status|lower eq 'true'))} id="review_status">
			<span><label for="review_status"></label></span>
		</div><br/>
		<small>{lang('help_review_status')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_review_guest', 'text_review_guest', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="review_guest" value="{STATUS_ON}" {set_checkbox('review_guest', STATUS_ON, ($settings.review_guest|lower eq 'true'))} id="review_guest">
			<span><label for="review_guest"></label></span>
		</div><br/>
		<small>{lang('help_review_guest')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_voucher')}</div>
<div class="form-group row">
	{lang('text_product_voucher_min', 'text_product_voucher_min', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="product_voucher_min" value="{set_value('product_voucher_min', $settings.product_voucher_min)}" id="product_voucher_min" class="form-control">
		<small>{lang('help_product_voucher_min')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_product_voucher_max', 'text_product_voucher_max', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="product_voucher_max" value="{set_value('product_voucher_max', $settings.product_voucher_max)}" id="product_voucher_max" class="form-control">
		<small>{lang('help_product_voucher_max')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_title_tax')}</div>
<div class="form-group row">
	{lang('text_tax', 'text_tax', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="tax" value="{STATUS_ON}" {set_checkbox('tax', STATUS_ON, ($settings.tax|lower eq 'true'))} id="tax">
			<span><label for="tax"></label></span>
		</div>
	</div>
</div>
<div class="form-group row">
	{lang('text_tax_default', 'text_tax_default', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('tax_default', $timezone_list, set_value('tax_default', $settings.tax_default), ['class' => 'form-control'])}
		<small>{lang('help_tax_default')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_tax_customer', 'text_tax_customer', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('tax_customer', $timezone_list, set_value('tax_customer', $settings.tax_customer), ['class' => 'form-control'])}
		<small>{lang('help_tax_customer')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_customer')}</div>
<div class="form-group row">
	{lang('text_customer_online', 'text_customer_online', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="customer_online" value="{STATUS_ON}" {set_checkbox('customer_online', STATUS_ON, ($settings.customer_online|lower eq 'true'))} id="customer_online">
			<span><label for="customer_online"></label></span>
		</div>
		<br/>
		<small>{lang('help_customer_online')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_customer_activity', 'text_customer_activity', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="customer_activity" value="{STATUS_ON}" {set_checkbox('customer_activity', STATUS_ON, ($settings.customer_activity|lower eq 'true'))} id="customer_activity">
			<span><label for="customer_activity"></label></span>
		</div>
		<br/>
		<small>{lang('help_customer_activity')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_customer_search', 'text_customer_search', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="customer_search" value="{STATUS_ON}" {set_checkbox('customer_search', STATUS_ON, ($settings.customer_search|lower eq 'true'))} id="customer_search">
			<span><label for="customer_search"></label></span>
		</div>
	</div>
</div>
<div class="form-group row">
	{lang('text_customer_group_id', 'text_customer_group_id', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('customer_group_id', $timezone_list, set_value('customer_group_id', $settings.customer_group_id), ['class' => 'form-control'])}
		<small>{lang('help_customer_group_id')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_customer_group_display', 'text_customer_group_display', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('customer_group_display', $timezone_list, set_value('customer_group_display', $settings.customer_group_display), ['class' => 'form-control'])}
		<small>{lang('help_customer_group_display')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_customer_price', 'text_customer_price', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="customer_price" value="{STATUS_ON}" {set_checkbox('customer_price', STATUS_ON, ($settings.customer_price|lower eq 'true'))} id="customer_price">
			<span><label for="customer_price"></label></span>
		</div>
		<br/>
		<small>{lang('help_customer_price')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_login_attempts', 'text_login_attempts', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="login_attempts" value="{set_value('login_attempts', $settings.login_attempts)}" id="login_attempts" class="form-control">
		<small>{lang('help_login_attempts')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_account_terms', 'text_account_terms', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('account_terms', $timezone_list, set_value('account_terms', $settings.account_terms), ['class' => 'form-control'])}
		<small>{lang('help_account_terms')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_checkout')}</div>
<div class="form-group row">
	{lang('text_invoice_prefix', 'text_invoice_prefix', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="invoice_prefix" value="{set_value('invoice_prefix', $settings.invoice_prefix)}" id="invoice_prefix" class="form-control">
		<small>{lang('help_invoice_prefix')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_cart_weight', 'text_cart_weight', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="cart_weight" value="{STATUS_ON}" {set_checkbox('cart_weight', STATUS_ON, ($settings.cart_weight|lower eq 'true'))} id="cart_weight">
			<span><label for="cart_weight"></label></span>
		</div>
		<br/>
		<small>{lang('help_cart_weight')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_checkout_guest', 'text_checkout_guest', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="checkout_guest" value="{STATUS_ON}" {set_checkbox('checkout_guest', STATUS_ON, ($settings.checkout_guest|lower eq 'true'))} id="checkout_guest">
			<span><label for="checkout_guest"></label></span>
		</div>
		<br/>
		<small>{lang('help_checkout_guest')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_checkout_terms', 'text_checkout_terms', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('checkout_terms', $timezone_list, set_value('checkout_terms', $settings.checkout_terms), ['class' => 'form-control'])}
		<small>{lang('help_checkout_terms')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_order_status_id', 'text_order_status_id', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('order_status_id', $timezone_list, set_value('order_status_id', $settings.order_status_id), ['class' => 'form-control'])}
		<small>{lang('help_order_status_id')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_processing_status', 'text_processing_status', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('processing_status', $timezone_list, set_value('processing_status', $settings.processing_status), ['class' => 'form-control'])}
		<small>{lang('help_processing_status')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_complete_status', 'text_complete_status', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('processing_status', $timezone_list, set_value('complete_status', $settings.complete_status), ['class' => 'form-control'])}
		<small>{lang('help_pcomplete_status')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_fraud_status_id', 'text_fraud_status_id', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('fraud_status_id', $timezone_list, set_value('fraud_status_id', $settings.fraud_status_id), ['class' => 'form-control'])}
		<small>{lang('help_fraud_status_id')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_order_api_id', 'text_order_api_id', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('order_api_id', $timezone_list, set_value('order_api_id', $settings.order_api_id), ['class' => 'form-control'])}
		<small>{lang('help_order_api_id')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_stock')}</div>
<div class="form-group row">
	{lang('text_stock_display', 'text_stock_display', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="stock_display" value="{STATUS_ON}" {set_checkbox('stock_display', STATUS_ON, ($settings.stock_display|lower eq 'true'))} id="stock_display">
			<span><label for="stock_display"></label></span>
		</div>
		<br/>
		<small>{lang('help_stock_display')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_stock_warning', 'text_checkout_guest', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="stock_warning" value="{STATUS_ON}" {set_checkbox('stock_warning', STATUS_ON, ($settings.stock_warning|lower eq 'true'))} id="stock_warning">
			<span><label for="stock_warning"></label></span>
		</div>
		<br/>
		<small>{lang('help_stock_warning')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_stock_checkout', 'text_stock_checkout', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="stock_checkout" value="{STATUS_ON}" {set_checkbox('stock_checkout', STATUS_ON, ($settings.stock_checkout|lower eq 'true'))} id="stock_checkout">
			<span><label for="stock_checkout"></label></span>
		</div>
		<br/>
		<small>{lang('help_stock_checkout')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_affiliate')}</div>
<div class="form-group row">
	{lang('text_affiliate_group_id', 'text_affiliate_group_id', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('affiliate_group_id', $timezone_list, set_value('affiliate_group_id', $settings.affiliate_group_id), ['class' => 'form-control'])}
	</div>
</div>
<div class="form-group row">
	{lang('text_affiliate_approval', 'text_affiliate_approval', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="affiliate_approval" value="{STATUS_ON}" {set_checkbox('affiliate_approval', STATUS_ON, ($settings.affiliate_approval|lower eq 'true'))} id="affiliate_approval">
			<span><label for="affiliate_approval"></label></span>
		</div>
		<br/>
		<small>{lang('help_affiliate_approval')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_affiliate_auto', 'text_affiliate_auto', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="affiliate_auto" value="{STATUS_ON}" {set_checkbox('affiliate_auto', STATUS_ON, ($settings.affiliate_auto|lower eq 'true'))} id="affiliate_auto">
			<span><label for="affiliate_auto"></label></span>
		</div>
		<br/>
		<small>{lang('help_affiliate_auto')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_affiliate_commission', 'text_affiliate_commission', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="affiliate_commission" value="{set_value('affiliate_commission', $settings.affiliate_commission)}" id="affiliate_commission" class="form-control">
		<small>{lang('help_affiliate_commission')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_affiliate_terms', 'text_affiliate_terms', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('affiliate_terms', $timezone_list, set_value('affiliate_terms', $settings.affiliate_terms), ['class' => 'form-control'])}
		<small>{lang('help_affiliate_terms')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_return')}</div>
<div class="form-group row">
	{lang('text_return_terms', 'text_return_terms', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('return_terms', $timezone_list, set_value('return_terms', $settings.return_terms), ['class' => 'form-control'])}
		<small>{lang('help_return_terms')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_return_status_id', 'text_return_status_id', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('return_status_id', $timezone_list, set_value('return_status_id', $settings.return_status_id), ['class' => 'form-control'])}
		<small>{lang('help_return_status_id')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3">{lang('text_captcha')}</div>
<div class="form-group row">
	{lang('text_is_captcha', 'text_is_captcha', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="is_captcha" value="{STATUS_ON}" {set_checkbox('is_captcha', STATUS_ON, ($settings.is_captcha|lower eq 'true'))} id="is_captcha">
			<span><label for="is_captcha"></label></span>
		</div>
		<br/>
		<small>{lang('help_is_captcha')}</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_captcha_page', 'text_captcha_page', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('captcha_page', $timezone_list, set_value('captcha_page', $settings.captcha_page), ['class' => 'form-control'])}
	</div>
</div>

<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-right"></div>
	<div class="col-12 col-sm-8 col-lg-6">
		<button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save mr-1"></i>{lang('button_save')}</button>
	</div>
</div>
{form_close()}
