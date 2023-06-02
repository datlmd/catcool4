{strip}

	{form_hidden('tab_type', 'tab_data')}

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_published')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check form-check-inline ms-2">
				<input type="radio" name="published" value="{STATUS_ON}" {if old('published', $edit_data.published)|default:1 eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
				<label class="form-check-label" for="published_on">ON</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $edit_data.published)|default:1 eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
				<label class="form-check-label" for="published_off">OFF</label>
			</label>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_is_comment')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check ms-2">
				<input type="radio" name="is_comment" id="is_comment_off" class="form-check-input" value="{COMMENT_STATUS_OFF}" {set_radio('is_comment', COMMENT_STATUS_OFF, ($edit_data.is_comment == COMMENT_STATUS_OFF))}>
				<label class="form-check-label" for="is_comment_off">{lang('Admin.text_comment_status_off')}</label>
			</label>
			<label class="form-check ms-2">
				<input type="radio" name="is_comment" id="is_comment_confirm" class="form-check-input" value="{COMMENT_STATUS_CONFIRM}" {set_radio('is_comment', COMMENT_STATUS_CONFIRM, ($edit_data.is_comment == COMMENT_STATUS_CONFIRM))}>
				<label class="form-check-label" for="is_comment_confirm">{lang('Admin.text_comment_status_confirm')}</label>
			</label>
			<label class="form-check ms-2">
				{if isset($edit_data.is_comment)}
					<input type="radio" name="is_comment" id="is_comment_on" class="form-check-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, ($edit_data.is_comment == COMMENT_STATUS_ON))}>
				{else}
					<input type="radio" name="is_comment" id="is_comment_on" class="form-check-input" value="{COMMENT_STATUS_ON}" {set_radio('is_comment', COMMENT_STATUS_ON, true)}>
				{/if}
				<span class="form-check-label" for="is_comment_on">{lang('Admin.text_comment_status_on')}</span>
			</label>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_sort_order')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="input_sort_order" min="0" class="form-control">
			<div id="error_sort_order" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_viewed')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="viewed" value="{old('viewed', $edit_data.viewed)|default:0}" id="input_viewed" min="0" class="form-control">
			<div id="error_viewed" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ProductAdmin.text_model')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label required-label text-sm-end">{lang('ProductAdmin.text_model')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="model" value="{old('model', $edit_data.model)}" id="input_model" class="form-control">
			<div id="error_model" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_sku')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="sku" value="{old('sku', $edit_data.sku)}" id="input_sku" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_sku')}</div>
			<div id="error_sku" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_upc')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="upc" value="{old('upc', $edit_data.upc)}" id="input_upc" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_upc')}</div>
			<div id="error_upc" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_ean')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="ean" value="{old('ean', $edit_data.ean)}" id="input_ean" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_ean')}</div>
			<div id="error_ean" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_jan')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="jan" value="{old('jan', $edit_data.jan)}" id="input_jan" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_jan')}</div>
			<div id="error_jan" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_isbn')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="isbn" value="{old('isbn', $edit_data.isbn)}" id="input_isbn" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_isbn')}</div>
			<div id="error_isbn" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_mpn')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="mpn" value="{old('mpn', $edit_data.mpn)}" id="input_mpn" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_mpn')}</div>
			<div id="error_mpn" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_location')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="location" value="{old('location', $edit_data.location)}" id="input_location" class="form-control">
			<div id="error_location" class="invalid-feedback"></div>
		</div>
	</div>



	<div class="border-bottom lead mx-3 pb-1 my-3 fw-bold">{lang('ProductAdmin.text_price')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_price')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="price" value="{old('price', $edit_data.price)}" id="input_price" class="form-control">
			<div id="error_price" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_tax_class_id')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="tax_class_id" value="{old('tax_class_id', $edit_data.tax_class_id)}" id="input_tax_class_id" class="form-control">
			<div id="error_tax_class_id" class="invalid-feedback"></div>
		</div>
	</div>




	<div class="border-bottom lead mx-3 pb-1 my-3 fw-bold">{lang('ProductAdmin.text_stock')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_quantity')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="quantity" value="{old('quantity', $edit_data.quantity)}" id="input_quantity" min="0" class="form-control">
			<div id="error_quantity" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_minimum')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="number" name="minimum" value="{old('minimum', $edit_data.minimum)}" id="input_minimum" min="0" class="form-control">
			<div class="form-text">{lang('ProductAdmin.help_minimum')}</div>
			<div id="error_minimum" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_subtract')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check form-check-inline ms-2">
				<input type="radio" name="subtract" value="{STATUS_ON}" {if old('subtract', $edit_data.subtract)|default:1 eq STATUS_ON}checked="checked"{/if} id="subtract_on" class="form-check-input">
				<label class="form-check-label" for="subtract_on">ON</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="subtract" value="{STATUS_OFF}" {if old('subtract', $edit_data.subtract)|default:1 eq STATUS_OFF}checked="checked"{/if} id="subtract_off" class="form-check-input">
				<label class="form-check-label" for="subtract_off">OFF</label>
			</label>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_stock_status_id')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{if !empty($stock_status_list)}
				<select name="stock_status_id" id="input_stock_status_id" class="form-control form-control-sm">
					{foreach $stock_status_list as $value}
						<option value="{$value.stock_status_id}" {if old('stock_status_id', $edit_data.stock_status_id) eq $value.stock_status_id}selected="selected"{/if}>{$value.name}</option>
					{/foreach}
				</select>
			{/if}
			<div id="error_stock_status_id" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_date_available')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div class="input-group date show-date-picker" id="show_date_available" data-target-input="nearest" data-date-format="{get_date_format_ajax()|upper}" data-date-locale="{get_lang(true)}">
				<input type="text" name="date_available" id="input_date_available" class="form-control datetimepicker-input" value="{old('date_available', $edit_data.date_available|default:get_date())|date_format:{get_date_format(true)}}" placeholder="{get_date_format_ajax()}" data-target="#show_date_available" />
				<div class="input-group-text" data-target="#show_date_available" data-toggle="datetimepicker"><i class="fa fa-calendar-alt"></i></div>
			</div>
			<div id="error_date_available" class="invalid-feedback"></div>
		</div>
	</div>


	<div class="border-bottom lead mx-3 pb-1 my-3 fw-bold">{lang('ProductAdmin.text_specification')}</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_shipping')}</div>
		<div class="col-12 col-sm-10 col-lg-10 mt-2 mb-0">
			<label class="form-check form-check-inline ms-2">
				<input type="radio" name="shipping" value="{STATUS_ON}" {if old('shipping', $edit_data.shipping)|default:1 eq STATUS_ON}checked="checked"{/if} id="shipping_on" class="form-check-input">
				<label class="form-check-label" for="shipping_on">ON</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="shipping" value="{STATUS_OFF}" {if old('shipping', $edit_data.shipping)|default:1 eq STATUS_OFF}checked="checked"{/if} id="shipping_off" class="form-check-input">
				<label class="form-check-label" for="shipping_off">OFF</label>
			</label>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_dimension')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<div class="input-group">
				<input type="text" name="length" value="{old('length', $edit_data.length)}" id="input_length" class="form-control" placeholder="{lang('ProductAdmin.text_length')}">
				<input type="text" name="width" value="{old('width', $edit_data.width)}" id="input_width" class="form-control" placeholder="{lang('ProductAdmin.text_width')}">
				<input type="text" name="height" value="{old('height', $edit_data.height)}" id="input_width" class="form-control" placeholder="{lang('ProductAdmin.text_height')}">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_length_class_id')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{if !empty($length_class_list)}
				<select name="length_class_id" id="input_length_class_id" class="form-control form-control-sm">
					{foreach $length_class_list as $value}
						<option value="{$value.length_class_id}" {if old('length_class_id', $edit_data.length_class_id) eq $value.length_class_id}selected="selected"{/if}>{$value.name}</option>
					{/foreach}
				</select>
			{/if}
			<div id="error_length_class_id" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_weight')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<input type="text" name="weight" value="{old('weight', $edit_data.weight)}" id="input_weight" class="form-control">
			<div id="error_weight" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_weight_class_id')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{if !empty($weight_class_list)}
				<select name="weight_class_id" id="input_weight_class_id" class="form-control form-control-sm">
					{foreach $weight_class_list as $value}
						<option value="{$value.weight_class_id}" {if old('weight_class_id', $edit_data.weight_class_id) eq $value.weight_class_id}selected="selected"{/if}>{$value.name}</option>
					{/foreach}
				</select>
			{/if}
			<div id="error_weight_class_id" class="invalid-feedback"></div>
		</div>
	</div>
{/strip}
