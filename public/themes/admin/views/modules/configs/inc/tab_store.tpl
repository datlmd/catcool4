{strip}
	{form_open(uri_string(), ['id' => 'form_store'])}
	{form_hidden('tab_type', 'tab_store')}

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_store_name')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="store_name" value="{old('store_name', $settings.store_name)}" id="input_store_name"
				placeholder="{lang('ConfigAdmin.text_store_name')}"
				class="form-control {if !empty(validation_show_error('store_name'))}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error('store_name')}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_store_owner')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="store_owner" value="{old('store_owner', $settings.store_owner)}" id="input_store_owner"
				placeholder="{lang('ConfigAdmin.text_store_owner_holder')}"
				class="form-control {if !empty(validation_show_error('store_owner'))}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error('store_owner')}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_store_address')}
		</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<textarea name="store_address" rows="5" placeholder="{lang('ConfigAdmin.text_store_address')}"
				id="input_store_address"
				class="form-control {if !empty(validation_show_error('store_address'))}is-invalid{/if}">
					{old('store_address', $settings.store_address)}
				</textarea>
			<div class="invalid-feedback">
				{validation_show_error('store_address')}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_store_geocode')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="store_geocode" value="{old('store_geocode', $settings.store_geocode)}"
				id="input_store_geocode" placeholder="{lang('ConfigAdmin.text_store_geocode')}"
				class="form-control {if !empty(validation_show_error('store_geocode'))}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error("store_geocode")}
			</div>
			<small>{lang('ConfigAdmin.help_store_geocode')}</small>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_store_email')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="store_email" value="{old('store_email', $settings.store_email)}" id="input_store_email"
				placeholder="{lang('ConfigAdmin.text_store_email')}"
				class="form-control {if !empty(validation_show_error('store_email'))}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error("store_email")}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_store_phone')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="store_phone" value="{old('store_phone', $settings.store_phone)}" id="input_store_phone"
				placeholder="{lang('ConfigAdmin.text_store_phone')}"
				class="form-control {if !empty(validation_show_error('store_phone'))}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error("store_phone")}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_store_image')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<a href="javascript:void(0);" id="store_image" data-target="input_store_image" data-thumb="load_store_image"
				data-type="image" data-bs-toggle="image" class="mx-0 mt-1">
				<img src="{if !empty(old('store_image', $settings.store_image))}{image_url(old('store_image', $settings.store_image))}{else}{image_default_url()}{/if}"
					class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_store_image"
					data-placeholder="{image_default_url()}" />
				<div class="btn-group w-100 mt-1" role="group">
					<button type="button" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip"
						title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
					<button type="button" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip"
						title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
				</div>
			</a>
			<input type="hidden" name="store_image" value="{old('store_image', $settings.store_image)}"
				id="input_store_image" />
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_store_open')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<textarea name="store_open" rows="5" placeholder="{lang('ConfigAdmin.text_store_open')}" id="input_store_open"
				class="form-control {if !empty(validation_show_error('store_open'))}is-invalid{/if}">
					{old('store_open', $settings.store_open)}
				</textarea>
			<div class="invalid-feedback">
				{validation_show_error("store_open")}
			</div>
			<small>{lang('ConfigAdmin.help_store_open')}</small>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_store_comment')}</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<textarea name="store_comment" rows="5" placeholder="{lang('ConfigAdmin.text_store_comment')}"
				id="input_store_comment"
				class="form-control {if !empty(validation_show_error('store_comment'))}is-invalid{/if}">
					{old('store_comment', $settings.store_comment)}
				</textarea>
			<div class="invalid-feedback">
				{validation_show_error("store_comment")}
			</div>
			<small>{lang('ConfigAdmin.help_store_comment')}</small>
		</div>
	</div>

	{if !empty($location_list)}
		<div class="form-group row">
			<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_store_location')}</div>
			<div class="col-12 col-sm-8 col-lg-6">
				<div class="form-control" style="height: 150px; overflow: auto;">
					{foreach $location_list as $location}
						<div class="form-check">
							<input type="checkbox" name="store_location[]" value="{$location.location_id}"
								id="input_location_{$location.location_id}" class="form-check-input"
								{if in_array($location.location_id, $settings.store_location|default:[])}checked{/if} /> <label for="input_location_{$location.location_id}" class="form-check-label">{$location.name}</label>
						</div>
					{/foreach}
				</div>
				<div class="invalid-feedback">
					{validation_show_error("store_location")}
				</div>
				<div class="form-text">{lang('ConfigAdmin.help_store_location')}</div>
			</div>
		</div>
	{/if}

	<div class="form-group row mt-3">
		<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
		<div class="col-12 col-sm-8 col-lg-6 ms-0">
			<button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title=""
				data-original-title="{lang('Admin.button_save')}"><i
					class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
		</div>
	</div>
	{form_close()}
{/strip}
