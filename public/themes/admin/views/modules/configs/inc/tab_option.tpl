{strip}
	{form_open(uri_string(), ['id' => 'form_option'])}
	{form_hidden('tab_type', 'tab_option')}
	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_product')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_count')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<label class="form-check form-check-inline">
				<input type="radio" name="product_count" value="{STATUS_ON}" {if !empty(old('product_count', $settings.product_count))}checked="checked"{/if} id="product_count_on" class="form-check-input">
				<label class="form-check-label" for="product_count_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="product_count" value="{STATUS_OFF}" {if empty(old('product_count', $settings.product_count))}checked="checked"{/if} id="product_count_off" class="form-check-input">
				<label class="form-check-label" for="product_count_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_product_count')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_limit_admin')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="product_limit_admin" value="{old('product_limit_admin', $settings.product_limit_admin)}" id="product_limit_admin" class="form-control">
			<small>{lang('ConfigAdmin.help_product_limit_admin')}</small>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_attribute_default')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('attribute_default', $attribute_group_list, old('attribute_default', $settings.attribute_default), ['class' => 'form-control'])}
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_review')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_review_status')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<label class="form-check form-check-inline">
				<input type="radio" name="review_status" value="{STATUS_ON}" {if !empty(old('review_status', $settings.review_status))}checked="checked"{/if} id="review_status_on" class="form-check-input">
				<label class="form-check-label" for="review_status_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="review_status" value="{STATUS_OFF}" {if empty(old('review_status', $settings.review_status))}checked="checked"{/if} id="review_status_off" class="form-check-input">
				<label class="form-check-label" for="review_status_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_review_status')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_review_guest')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<label class="form-check form-check-inline">
				<input type="radio" name="review_guest" value="{STATUS_ON}" {if !empty(old('review_guest', $settings.review_guest))}checked="checked"{/if} id="review_guest_on" class="form-check-input">
				<label class="form-check-label" for="review_guest_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="review_guest" value="{STATUS_OFF}" {if empty(old('review_guest', $settings.review_guest))}checked="checked"{/if} id="review_guest_off" class="form-check-input">
				<label class="form-check-label" for="review_guest_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_review_guest')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_voucher')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_voucher_min')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="product_voucher_min" value="{old('product_voucher_min', $settings.product_voucher_min)}" id="product_voucher_min" class="form-control">
			<small>{lang('ConfigAdmin.help_product_voucher_min')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_product_voucher_max')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="product_voucher_max" value="{old('product_voucher_max', $settings.product_voucher_max)}" id="product_voucher_max" class="form-control">
			<small>{lang('ConfigAdmin.help_product_voucher_max')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_title_tax')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_tax')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="tax" value="{STATUS_ON}" {if !empty(old('tax', $settings.tax))}checked="checked"{/if} id="tax_on" class="form-check-input">
				<label class="form-check-label" for="tax_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="tax" value="{STATUS_OFF}" {if empty(old('tax', $settings.tax))}checked="checked"{/if} id="tax_off" class="form-check-input">
				<label class="form-check-label" for="tax_off">{lang('Admin.text_off')}</label>
			</label>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_tax_default')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('tax_default', $timezone_list, old('tax_default', $settings.tax_default), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_tax_default')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_tax_customer')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('tax_customer', $timezone_list, old('tax_customer', $settings.tax_customer), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_tax_customer')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_customer')}</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_customer_online">{lang('ConfigAdmin.text_customer_online')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">

			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="customer_online" id="input_customer_online"
					{set_checkbox('customer_online', 1, $settings.customer_online|default:false)} value="1">
			</div>

		</div>
	</div>
	<div class="row" style="margin-top: -5px;">
		<div class="col-12 col-sm-3"></div>
		<div class="col-12 col-sm-8 col-lg-6 form-text">{lang('ConfigAdmin.help_customer_online')}</div>
	</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_customer_activity">{lang('ConfigAdmin.text_customer_activity')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">

			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="customer_activity" id="input_customer_activity"
					{set_checkbox('customer_activity', 1, $settings.customer_activity|default:false)} value="1">
			</div>

		</div>
	</div>
	<div class="row" style="margin-top: -5px;">
		<div class="col-12 col-sm-3"></div>
		<div class="col-12 col-sm-8 col-lg-6 form-text">{lang('ConfigAdmin.help_customer_activity')}</div>
	</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_customer_search">{lang('ConfigAdmin.text_customer_search')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">

			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="customer_search" id="input_customer_search"
					{set_checkbox('customer_search', 1, $settings.customer_search|default:false)} value="1">
			</div>

		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_group_id')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<select name="customer_group_id" class="form-control">
				{foreach $customer_group_list as $customer_group}
					<option value="{$customer_group.customer_group_id}" {set_select('customer_group_id', $customer_group.customer_group_id, ($customer_group.customer_group_id == $settings.customer_group_id))}>{$customer_group.name}</option>
				{/foreach}
			</select>

			<small>{lang('ConfigAdmin.help_customer_group_id')}</small>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_customer_group_display')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<div class="form-control" style="height: 150px; overflow: auto;">
				{foreach $customer_group_list as $customer_group}
					<div class="form-check">
						<input type="checkbox" name="customer_group_display[]" value="{$customer_group.customer_group_id}"
							id="input_customer_group_display_{$location.location_id}" class="form-check-input"
							{if in_array($customer_group.customer_group_id, $settings.customer_group_display|default:[])}checked{/if} /> <label for="input_customer_group_display_{$customer_group.customer_group_id}" class="form-check-label">{$customer_group.name}</label>
					</div>
				{/foreach}
			</div>
			<div class="invalid-feedback">
				{validation_show_error("customer_group_display")}
			</div>

			<small>{lang('ConfigAdmin.help_customer_group_display')}</small>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_customer_price">{lang('ConfigAdmin.text_customer_price')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">

			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="customer_price" id="input_customer_price"
					{set_checkbox('customer_price', 1, $settings.customer_price|default:false)} value="1">
			</div>

		</div>
	</div>
	<div class="row" style="margin-top: -5px;">
		<div class="col-12 col-sm-3"></div>
		<div class="col-12 col-sm-8 col-lg-6 form-text">{lang('ConfigAdmin.help_customer_price')}</div>
	</div>
	
	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_maximum_login_attempts">{lang('ConfigAdmin.text_login_attempts')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="maximum_login_attempts" value="{old('maximum_login_attempts', $settings.maximum_login_attempts)}" id="input_maximum_login_attempts" class="form-control">
			<small>{lang('ConfigAdmin.help_login_attempts')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_account_terms')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<select name="account_terms" class="form-control">
				{foreach $page_list as $page}
					<option value="{$page.page_id}" {set_select('account_terms', $page.page_id, ($page.page_id == $settings.account_terms))}>{$page.name}</option>
				{/foreach}
			</select>
			<small>{lang('ConfigAdmin.help_account_terms')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_checkout')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_invoice_prefix')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="invoice_prefix" value="{old('invoice_prefix', $settings.invoice_prefix)}" id="invoice_prefix" class="form-control">
			<small>{lang('ConfigAdmin.help_invoice_prefix')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_cart_weight')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="cart_weight" value="{STATUS_ON}" {if !empty(old('cart_weight', $settings.cart_weight))}checked="checked"{/if} id="cart_weight_on" class="form-check-input">
				<label class="form-check-label" for="cart_weight_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="cart_weight" value="{STATUS_OFF}" {if empty(old('cart_weight', $settings.cart_weight))}checked="checked"{/if} id="cart_weight_off" class="form-check-input">
				<label class="form-check-label" for="cart_weight_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_cart_weight')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_checkout_guest')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<label class="form-check form-check-inline">
				<input type="radio" name="checkout_guest" value="{STATUS_ON}" {if !empty(old('checkout_guest', $settings.checkout_guest))}checked="checked"{/if} id="checkout_guest_on" class="form-check-input">
				<label class="form-check-label" for="checkout_guest_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="checkout_guest" value="{STATUS_OFF}" {if empty(old('checkout_guest', $settings.checkout_guest))}checked="checked"{/if} id="checkout_guest_off" class="form-check-input">
				<label class="form-check-label" for="checkout_guest_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_checkout_guest')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_checkout_terms')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('checkout_terms', $timezone_list, old('checkout_terms', $settings.checkout_terms), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_checkout_terms')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_order_status_id')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('order_status_id', $timezone_list, old('order_status_id', $settings.order_status_id), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_order_status_id')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_processing_status')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('processing_status', $timezone_list, old('processing_status', $settings.processing_status), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_processing_status')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_complete_status')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('complete_status', $timezone_list, old('complete_status', $settings.complete_status), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_pcomplete_status')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_fraud_status_id')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('fraud_status_id', $timezone_list, old('fraud_status_id', $settings.fraud_status_id), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_fraud_status_id')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_order_api_id')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('order_api_id', $timezone_list, old('order_api_id', $settings.order_api_id), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_order_api_id')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_stock')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_stock_display')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="stock_display" value="{STATUS_ON}" {if !empty(old('stock_display', $settings.stock_display))}checked="checked"{/if} id="stock_display_on" class="form-check-input">
				<label class="form-check-label" for="stock_display_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="stock_display" value="{STATUS_OFF}" {if empty(old('stock_display', $settings.stock_display))}checked="checked"{/if} id="stock_display_off" class="form-check-input">
				<label class="form-check-label" for="stock_display_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_stock_display')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_stock_warning')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="stock_warning" value="{STATUS_ON}" {if !empty(old('stock_warning', $settings.stock_warning))}checked="checked"{/if} id="stock_warning_on" class="form-check-input">
				<label class="form-check-label" for="stock_warning_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="stock_warning" value="{STATUS_OFF}" {if empty(old('stock_warning', $settings.stock_warning))}checked="checked"{/if} id="stock_warning_off" class="form-check-input">
				<label class="form-check-label" for="stock_warning_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_stock_warning')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_stock_checkout')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="stock_checkout" value="{STATUS_ON}" {if !empty(old('stock_checkout', $settings.stock_checkout))}checked="checked"{/if} id="stock_checkout_on" class="form-check-input">
				<label class="form-check-label" for="stock_checkout_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="stock_checkout" value="{STATUS_OFF}" {if empty(old('stock_checkout', $settings.stock_checkout))}checked="checked"{/if} id="stock_checkout_off" class="form-check-input">
				<label class="form-check-label" for="stock_checkout_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_stock_checkout')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_affiliate')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_group_id')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('affiliate_group_id', $timezone_list, old('affiliate_group_id', $settings.affiliate_group_id), ['class' => 'form-control'])}
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_approval')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="affiliate_approval" value="{STATUS_ON}" {if !empty(old('affiliate_approval', $settings.affiliate_approval))}checked="checked"{/if} id="affiliate_approval_on" class="form-check-input">
				<label class="form-check-label" for="affiliate_approval_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="affiliate_approval" value="{STATUS_OFF}" {if empty(old('affiliate_approval', $settings.affiliate_approval))}checked="checked"{/if} id="affiliate_approval_off" class="form-check-input">
				<label class="form-check-label" for="affiliate_approval_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_affiliate_approval')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_auto')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<label class="form-check form-check-inline">
				<input type="radio" name="affiliate_auto" value="{STATUS_ON}" {if !empty(old('affiliate_auto', $settings.affiliate_auto))}checked="checked"{/if} id="affiliate_auto_on" class="form-check-input">
				<label class="form-check-label" for="affiliate_auto_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="affiliate_auto" value="{STATUS_OFF}" {if empty(old('affiliate_auto', $settings.affiliate_auto))}checked="checked"{/if} id="affiliate_auto_off" class="form-check-input">
				<label class="form-check-label" for="affiliate_auto_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_affiliate_auto')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_commission')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="affiliate_commission" value="{old('affiliate_commission', $settings.affiliate_commission)}" id="affiliate_commission" class="form-control">
			<small>{lang('ConfigAdmin.help_affiliate_commission')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_affiliate_terms')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('affiliate_terms', $timezone_list, old('affiliate_terms', $settings.affiliate_terms), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_affiliate_terms')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_return')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_return_terms')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('return_terms', $timezone_list, old('return_terms', $settings.return_terms), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_return_terms')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_return_status_id')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('return_status_id', $timezone_list, old('return_status_id', $settings.return_status_id), ['class' => 'form-control'])}
			<small>{lang('ConfigAdmin.help_return_status_id')}</small>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('Admin.text_captcha')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_is_captcha')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			<label class="form-check form-check-inline">
				<input type="radio" name="is_captcha" value="{STATUS_ON}" {if !empty(old('is_captcha', $settings.is_captcha))}checked="checked"{/if} id="is_captcha_on" class="form-check-input">
				<label class="form-check-label" for="is_captcha_on">{lang('Admin.text_on')}</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="is_captcha" value="{STATUS_OFF}" {if empty(old('is_captcha', $settings.is_captcha))}checked="checked"{/if} id="is_captcha_off" class="form-check-input">
				<label class="form-check-label" for="is_captcha_off">{lang('Admin.text_off')}</label>
			</label>
			<br/>
			<small>{lang('ConfigAdmin.help_is_captcha')}</small>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_captcha_page')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			{form_dropdown('captcha_page', $timezone_list, old('captcha_page', $settings.captcha_page), ['class' => 'form-control'])}
		</div>
	</div>

	<div class="form-group row mt-3">
		<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
		<div class="col-12 col-sm-8 col-lg-6 ms-0">
			<button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
		</div>
	</div>
	{form_close()}
{/strip}
