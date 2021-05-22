{form_open(uri_string(), ['id' => 'form_option'])}
{form_hidden('tab_type', 'tab_option')}
<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_product')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_count')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.product_count)}
			{assign var="product_count" value="`$settings.product_count`"}
		{else}
			{assign var="product_count" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="product_count" value="{STATUS_ON}" {if !empty(old('product_count', $product_count))}checked="checked"{/if} id="product_count_on" class="form-check-input">
			<label class="form-check-label" for="product_count_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="product_count" value="{STATUS_OFF}" {if empty(old('product_count', $product_count))}checked="checked"{/if} id="product_count_off" class="form-check-input">
			<label class="form-check-label" for="product_count_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_product_count')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_limit_admin')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.product_limit_admin)}
			{assign var="product_limit_admin" value="`$settings.product_limit_admin`"}
		{else}
			{assign var="product_limit_admin" value=""}
		{/if}
		<input type="number" name="product_limit_admin" value="{old('product_limit_admin', $product_limit_admin)}" id="product_limit_admin" class="form-control">
		<small>{lang('ConfigAdmin.help_product_limit_admin')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_review')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_review_status')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.review_status)}
			{assign var="review_status" value="`$settings.review_status`"}
		{else}
			{assign var="review_status" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="review_status" value="{STATUS_ON}" {if !empty(old('review_status', $review_status))}checked="checked"{/if} id="review_status_on" class="form-check-input">
			<label class="form-check-label" for="review_status_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="review_status" value="{STATUS_OFF}" {if empty(old('review_status', $review_status))}checked="checked"{/if} id="review_status_off" class="form-check-input">
			<label class="form-check-label" for="review_status_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_review_status')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_review_guest')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.review_guest)}
			{assign var="review_guest" value="`$settings.review_guest`"}
		{else}
			{assign var="review_guest" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="review_guest" value="{STATUS_ON}" {if !empty(old('review_guest', $review_guest))}checked="checked"{/if} id="review_guest_on" class="form-check-input">
			<label class="form-check-label" for="review_guest_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="review_guest" value="{STATUS_OFF}" {if empty(old('review_guest', $review_guest))}checked="checked"{/if} id="review_guest_off" class="form-check-input">
			<label class="form-check-label" for="review_guest_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_review_guest')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_voucher')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_voucher_min')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.product_voucher_min)}
			{assign var="product_voucher_min" value="`$settings.product_voucher_min`"}
		{else}
			{assign var="product_voucher_min" value=""}
		{/if}
		<input type="number" name="product_voucher_min" value="{old('product_voucher_min', $product_voucher_min)}" id="product_voucher_min" class="form-control">
		<small>{lang('ConfigAdmin.help_product_voucher_min')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_voucher_max')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.product_voucher_max)}
			{assign var="product_voucher_max" value="`$settings.product_voucher_max`"}
		{else}
			{assign var="product_voucher_max" value=""}
		{/if}
		<input type="number" name="product_voucher_max" value="{old('product_voucher_max', $product_voucher_max)}" id="product_voucher_max" class="form-control">
		<small>{lang('ConfigAdmin.help_product_voucher_max')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_title_tax')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_tax')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.tax)}
			{assign var="tax" value="`$settings.tax`"}
		{else}
			{assign var="tax" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="tax" value="{STATUS_ON}" {if !empty(old('tax', $tax))}checked="checked"{/if} id="tax_on" class="form-check-input">
			<label class="form-check-label" for="tax_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="tax" value="{STATUS_OFF}" {if empty(old('tax', $tax))}checked="checked"{/if} id="tax_off" class="form-check-input">
			<label class="form-check-label" for="tax_off">OFF</label>
		</label>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_tax_default')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.tax_default)}
			{assign var="tax_default" value="`$settings.tax_default`"}
		{else}
			{assign var="tax_default" value=""}
		{/if}
		{form_dropdown('tax_default', $timezone_list, old('tax_default', $tax_default), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_tax_default')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_tax_customer')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.tax_customer)}
			{assign var="tax_customer" value="`$settings.tax_customer`"}
		{else}
			{assign var="tax_customer" value=""}
		{/if}
		{form_dropdown('tax_customer', $timezone_list, old('tax_customer', $tax_customer), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_tax_customer')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_customer')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_online')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.customer_online)}
			{assign var="customer_online" value="`$settings.customer_online`"}
		{else}
			{assign var="customer_online" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="customer_online" value="{STATUS_ON}" {if !empty(old('customer_online', $customer_online))}checked="checked"{/if} id="customer_online_on" class="form-check-input">
			<label class="form-check-label" for="customer_online_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="customer_online" value="{STATUS_OFF}" {if empty(old('customer_online', $customer_online))}checked="checked"{/if} id="customer_online_off" class="form-check-input">
			<label class="form-check-label" for="customer_online_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_customer_online')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_activity')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.customer_activity)}
			{assign var="customer_activity" value="`$settings.customer_activity`"}
		{else}
			{assign var="customer_activity" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="customer_activity" value="{STATUS_ON}" {if !empty(old('customer_activity', $customer_activity))}checked="checked"{/if} id="customer_activity_on" class="form-check-input">
			<label class="form-check-label" for="customer_activity_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="customer_activity" value="{STATUS_OFF}" {if empty(old('customer_activity', $customer_activity))}checked="checked"{/if} id="customer_activity_off" class="form-check-input">
			<label class="form-check-label" for="customer_activity_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_customer_activity')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_search')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.customer_search)}
			{assign var="customer_search" value="`$settings.customer_search`"}
		{else}
			{assign var="customer_search" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="customer_search" value="{STATUS_ON}" {if !empty(old('customer_search', $customer_search))}checked="checked"{/if} id="customer_search_on" class="form-check-input">
			<label class="form-check-label" for="customer_search_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="customer_search" value="{STATUS_OFF}" {if empty(old('customer_search', $customer_search))}checked="checked"{/if} id="customer_search_off" class="form-check-input">
			<label class="form-check-label" for="customer_search_off">OFF</label>
		</label>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_group_id')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.customer_group_id)}
			{assign var="customer_group_id" value="`$settings.customer_group_id`"}
		{else}
			{assign var="customer_group_id" value=""}
		{/if}
		{form_dropdown('customer_group_id', $timezone_list, old('customer_group_id', $customer_group_id), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_customer_group_id')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_group_display')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.customer_group_display)}
			{assign var="customer_group_display" value="`$settings.customer_group_display`"}
		{else}
			{assign var="customer_group_display" value=""}
		{/if}
		{form_dropdown('customer_group_display', $timezone_list, old('customer_group_display', $customer_group_display), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_customer_group_display')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_price')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.customer_price)}
			{assign var="customer_price" value="`$settings.customer_price`"}
		{else}
			{assign var="customer_price" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="customer_price" value="{STATUS_ON}" {if !empty(old('customer_price', $customer_price))}checked="checked"{/if} id="customer_price_on" class="form-check-input">
			<label class="form-check-label" for="customer_price_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="customer_price" value="{STATUS_OFF}" {if empty(old('customer_price', $customer_price))}checked="checked"{/if} id="customer_price_off" class="form-check-input">
			<label class="form-check-label" for="customer_price_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_customer_price')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_login_attempts')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.login_attempts)}
			{assign var="login_attempts" value="`$settings.login_attempts`"}
		{else}
			{assign var="login_attempts" value=""}
		{/if}
		<input type="number" name="login_attempts" value="{old('login_attempts', $login_attempts)}" id="login_attempts" class="form-control">
		<small>{lang('ConfigAdmin.help_login_attempts')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_account_terms')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.account_terms)}
			{assign var="account_terms" value="`$settings.account_terms`"}
		{else}
			{assign var="account_terms" value=""}
		{/if}
		{form_dropdown('account_terms', $timezone_list, old('account_terms', $account_terms), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_account_terms')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_checkout')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_invoice_prefix')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.invoice_prefix)}
			{assign var="invoice_prefix" value="`$settings.invoice_prefix`"}
		{else}
			{assign var="invoice_prefix" value=""}
		{/if}
		<input type="text" name="invoice_prefix" value="{old('invoice_prefix', $invoice_prefix)}" id="invoice_prefix" class="form-control">
		<small>{lang('ConfigAdmin.help_invoice_prefix')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_cart_weight')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.cart_weight)}
			{assign var="cart_weight" value="`$settings.cart_weight`"}
		{else}
			{assign var="cart_weight" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="cart_weight" value="{STATUS_ON}" {if !empty(old('cart_weight', $cart_weight))}checked="checked"{/if} id="cart_weight_on" class="form-check-input">
			<label class="form-check-label" for="cart_weight_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="cart_weight" value="{STATUS_OFF}" {if empty(old('cart_weight', $cart_weight))}checked="checked"{/if} id="cart_weight_off" class="form-check-input">
			<label class="form-check-label" for="cart_weight_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_cart_weight')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_checkout_guest')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.checkout_guest)}
			{assign var="checkout_guest" value="`$settings.checkout_guest`"}
		{else}
			{assign var="checkout_guest" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="checkout_guest" value="{STATUS_ON}" {if !empty(old('checkout_guest', $checkout_guest))}checked="checked"{/if} id="checkout_guest_on" class="form-check-input">
			<label class="form-check-label" for="checkout_guest_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="checkout_guest" value="{STATUS_OFF}" {if empty(old('checkout_guest', $checkout_guest))}checked="checked"{/if} id="checkout_guest_off" class="form-check-input">
			<label class="form-check-label" for="checkout_guest_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_checkout_guest')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_checkout_terms')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.checkout_terms)}
			{assign var="checkout_terms" value="`$settings.checkout_terms`"}
		{else}
			{assign var="checkout_terms" value=""}
		{/if}
		{form_dropdown('checkout_terms', $timezone_list, old('checkout_terms', $checkout_terms), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_checkout_terms')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_order_status_id')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.order_status_id)}
			{assign var="order_status_id" value="`$settings.order_status_id`"}
		{else}
			{assign var="order_status_id" value=""}
		{/if}
		{form_dropdown('order_status_id', $timezone_list, old('order_status_id', $order_status_id), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_order_status_id')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_processing_status')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.processing_status)}
			{assign var="processing_status" value="`$settings.processing_status`"}
		{else}
			{assign var="processing_status" value=""}
		{/if}
		{form_dropdown('processing_status', $timezone_list, old('processing_status', $processing_status), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_processing_status')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_complete_status')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.complete_status)}
			{assign var="complete_status" value="`$settings.complete_status`"}
		{else}
			{assign var="complete_status" value=""}
		{/if}
		{form_dropdown('complete_status', $timezone_list, old('complete_status', $complete_status), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_pcomplete_status')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_fraud_status_id')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.fraud_status_id)}
			{assign var="fraud_status_id" value="`$settings.fraud_status_id`"}
		{else}
			{assign var="fraud_status_id" value=""}
		{/if}
		{form_dropdown('fraud_status_id', $timezone_list, old('fraud_status_id', $fraud_status_id), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_fraud_status_id')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_order_api_id')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.order_api_id)}
			{assign var="order_api_id" value="`$settings.order_api_id`"}
		{else}
			{assign var="order_api_id" value=""}
		{/if}
		{form_dropdown('order_api_id', $timezone_list, old('order_api_id', $order_api_id), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_order_api_id')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_stock')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_stock_display')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.stock_display)}
			{assign var="stock_display" value="`$settings.stock_display`"}
		{else}
			{assign var="stock_display" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="stock_display" value="{STATUS_ON}" {if !empty(old('stock_display', $stock_display))}checked="checked"{/if} id="stock_display_on" class="form-check-input">
			<label class="form-check-label" for="stock_display_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="stock_display" value="{STATUS_OFF}" {if empty(old('stock_display', $stock_display))}checked="checked"{/if} id="stock_display_off" class="form-check-input">
			<label class="form-check-label" for="stock_display_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_stock_display')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_stock_warning')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.stock_warning)}
			{assign var="stock_warning" value="`$settings.stock_warning`"}
		{else}
			{assign var="stock_warning" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="stock_warning" value="{STATUS_ON}" {if !empty(old('stock_warning', $stock_warning))}checked="checked"{/if} id="stock_warning_on" class="form-check-input">
			<label class="form-check-label" for="stock_warning_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="stock_warning" value="{STATUS_OFF}" {if empty(old('stock_warning', $stock_warning))}checked="checked"{/if} id="stock_warning_off" class="form-check-input">
			<label class="form-check-label" for="stock_warning_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_stock_warning')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_stock_checkout')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.stock_checkout)}
			{assign var="stock_checkout" value="`$settings.stock_checkout`"}
		{else}
			{assign var="stock_checkout" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="stock_checkout" value="{STATUS_ON}" {if !empty(old('stock_checkout', $stock_checkout))}checked="checked"{/if} id="stock_checkout_on" class="form-check-input">
			<label class="form-check-label" for="stock_checkout_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="stock_checkout" value="{STATUS_OFF}" {if empty(old('stock_checkout', $stock_checkout))}checked="checked"{/if} id="stock_checkout_off" class="form-check-input">
			<label class="form-check-label" for="stock_checkout_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_stock_checkout')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_affiliate')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_group_id')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.affiliate_group_id)}
			{assign var="affiliate_group_id" value="`$settings.affiliate_group_id`"}
		{else}
			{assign var="affiliate_group_id" value=""}
		{/if}
		{form_dropdown('affiliate_group_id', $timezone_list, old('affiliate_group_id', $affiliate_group_id), ['class' => 'form-control'])}
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_approval')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.affiliate_approval)}
			{assign var="affiliate_approval" value="`$settings.affiliate_approval`"}
		{else}
			{assign var="affiliate_approval" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="affiliate_approval" value="{STATUS_ON}" {if !empty(old('affiliate_approval', $affiliate_approval))}checked="checked"{/if} id="affiliate_approval_on" class="form-check-input">
			<label class="form-check-label" for="affiliate_approval_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="affiliate_approval" value="{STATUS_OFF}" {if empty(old('affiliate_approval', $affiliate_approval))}checked="checked"{/if} id="affiliate_approval_off" class="form-check-input">
			<label class="form-check-label" for="affiliate_approval_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_affiliate_approval')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_auto')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.affiliate_auto)}
			{assign var="affiliate_auto" value="`$settings.affiliate_auto`"}
		{else}
			{assign var="affiliate_auto" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="affiliate_auto" value="{STATUS_ON}" {if !empty(old('affiliate_auto', $affiliate_auto))}checked="checked"{/if} id="affiliate_auto_on" class="form-check-input">
			<label class="form-check-label" for="affiliate_auto_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="affiliate_auto" value="{STATUS_OFF}" {if empty(old('affiliate_auto', $affiliate_auto))}checked="checked"{/if} id="affiliate_auto_off" class="form-check-input">
			<label class="form-check-label" for="affiliate_auto_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_affiliate_auto')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_commission')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.affiliate_commission)}
			{assign var="affiliate_commission" value="`$settings.affiliate_commission`"}
		{else}
			{assign var="affiliate_commission" value=""}
		{/if}
		<input type="number" name="affiliate_commission" value="{old('affiliate_commission', $affiliate_commission)}" id="affiliate_commission" class="form-control">
		<small>{lang('ConfigAdmin.help_affiliate_commission')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_terms')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.affiliate_terms)}
			{assign var="affiliate_terms" value="`$settings.affiliate_terms`"}
		{else}
			{assign var="affiliate_terms" value=""}
		{/if}
		{form_dropdown('affiliate_terms', $timezone_list, old('affiliate_terms', $affiliate_terms), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_affiliate_terms')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_return')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_return_terms')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.return_terms)}
			{assign var="return_terms" value="`$settings.return_terms`"}
		{else}
			{assign var="return_terms" value=""}
		{/if}
		{form_dropdown('return_terms', $timezone_list, old('return_terms', $return_terms), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_return_terms')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_return_status_id')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.return_status_id)}
			{assign var="return_status_id" value="`$settings.return_status_id`"}
		{else}
			{assign var="return_status_id" value=""}
		{/if}
		{form_dropdown('return_status_id', $timezone_list, old('return_status_id', $return_status_id), ['class' => 'form-control'])}
		<small>{lang('ConfigAdmin.help_return_status_id')}</small>
	</div>
</div>

<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('Admin.text_captcha')}</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_is_captcha')}</div>
	<div class="col-12 col-sm-8 col-lg-6 pt-2">
		{if !empty($settings.is_captcha)}
			{assign var="is_captcha" value="`$settings.is_captcha`"}
		{else}
			{assign var="is_captcha" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="is_captcha" value="{STATUS_ON}" {if !empty(old('is_captcha', $is_captcha))}checked="checked"{/if} id="is_captcha_on" class="form-check-input">
			<label class="form-check-label" for="is_captcha_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="is_captcha" value="{STATUS_OFF}" {if empty(old('is_captcha', $is_captcha))}checked="checked"{/if} id="is_captcha_off" class="form-check-input">
			<label class="form-check-label" for="is_captcha_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_is_captcha')}</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_captcha_page')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.captcha_page)}
			{assign var="captcha_page" value="`$settings.captcha_page`"}
		{else}
			{assign var="captcha_page" value=""}
		{/if}
		{form_dropdown('captcha_page', $timezone_list, old('captcha_page', $captcha_page), ['class' => 'form-control'])}
	</div>
</div>

<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
	<div class="col-12 col-sm-8 col-lg-6 ms-0">
		<button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
	</div>
</div>
{form_close()}
