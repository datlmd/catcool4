{strip}
	{form_open(uri_string(), ['id' => 'form_page'])}
	{form_hidden('tab_type', 'tab_page')}
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_site_name">{lang('ConfigAdmin.text_site_name')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="site_name" value="{old('site_name', $settings.site_name)}" id="input_site_name" class="form-control {if validation_show_error("site_name")}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error("site_name")}
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_site_description">{lang('ConfigAdmin.text_site_description')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<textarea type="textarea" name="site_description" id="input_site_description" cols="40" rows="5" class="form-control {if validation_show_error("site_description")}is-invalid{/if}">{old('site_description', $settings.site_description)}</textarea>
			<div class="invalid-feedback">
				{validation_show_error("site_description")}
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_site_keywords">{lang('ConfigAdmin.text_site_keywords')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="site_keywords" value="{old('site_keywords', $settings.site_keywords)}" id="input_site_keywords" class="form-control {if validation_show_error("site_keywords")}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error("site_keywords")}
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_logo')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<a href="javascript:void(0);" id="image_logo_url" data-target="input_image_logo_url" data-thumb="load_image_logo_url" data-type="image" data-bs-toggle="image" class="mx-0 mt-1">
				<img src="{if !empty(old('image_logo_url', $settings.image_logo_url))}{image_url(old('image_logo_url', $settings.image_logo_url))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_image_logo_url" data-placeholder="{image_default_url()}"/>
				<div class="btn-group w-100 mt-1" role="group">
					<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
					<button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
				</div>
			</a>
			<input type="hidden" name="image_logo_url" value="{old('image_logo_url', $settings.image_logo_url)}" id="input_image_logo_url" />
		</div>
	</div>
{*	<div class="form-group row">*}
{*		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_icon')}</div>*}
{*		<div class="col-12 col-sm-8 col-lg-6">*}
{*			<a href="javascript:void(0);" id="image_icon_url" data-target="input_image_icon_url" data-thumb="load_image_icon_url" data-type="image" data-bs-toggle="image" class="mx-0 mt-1">*}
{*				<img src="{if !empty(old('image_icon_url', $settings.image_icon_url))}{image_url(old('image_icon_url', $settings.image_icon_url))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1" alt="" title="" id="load_image_icon_url" data-placeholder="{image_default_url()}"/>*}
{*				<div class="btn-group w-100 mt-1" role="group">*}
{*					<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>*}
{*					<button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>*}
{*				</div>*}
{*			</a>*}
{*			<input type="hidden" name="image_icon_url" value="{old('image_icon_url', $settings.image_icon_url)}" id="input_image_icon_url" />*}
{*		</div>*}
{*	</div>*}
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_pagination_limit">{lang('ConfigAdmin.text_pagination_limit')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="pagination_limit" value="{old('pagination_limit', $settings.pagination_limit)}" id="input_pagination_limit" class="form-control {if validation_show_error("pagination_limit")}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error("pagination_limit")}
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end" for="input_pagination_limit_admin">{lang('ConfigAdmin.text_pagination_limit_admin')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="pagination_limit_admin" value="{old('pagination_limit_admin', $settings.pagination_limit_admin)}" id="input_pagination_limit_admin" class="form-control {if validation_show_error("pagination_limit_admin")}is-invalid{/if}">
			<div class="invalid-feedback">
				{validation_show_error("pagination_limit_admin")}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_enable_scroll_menu_admin">{lang('ConfigAdmin.text_hide_menu')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-0" style="min-height: 25px;">

			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="enable_scroll_menu_admin" id="input_enable_scroll_menu_admin"
					{set_checkbox('enable_scroll_menu_admin', 1, $settings.enable_scroll_menu_admin|default:true)} value="1">
			</div>

		</div>
	</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_enable_icon_menu_admin">{lang('ConfigAdmin.text_enable_icon_menu_admin')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-0" style="min-height: 25px;">

			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="enable_icon_menu_admin" id="input_enable_icon_menu_admin"
					{set_checkbox('enable_icon_menu_admin', 1, $settings.enable_icon_menu_admin|default:true)} value="1">
			</div>

		</div>
	</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_enable_dark_mode">{lang('ConfigAdmin.text_enable_dark_mode')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-0" style="min-height: 25px;">

			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="enable_dark_mode" id="input_enable_dark_mode"
					{set_checkbox('enable_dark_mode', 1, $settings.enable_dark_mode|default:true)} value="1">
			</div>

		</div>
	</div>
	
	<div class="form-group row">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_background_admin_path')}</div>
		<div class="col-12 col-sm-8 col-lg-6 pt-2">
			{if !empty($settings.background_image_admin_path)}
				{assign var="background_image_admin_path" value="`$settings.background_image_admin_path`"}
			{else}
				{assign var="background_image_admin_path" value="auth-bg.jpg"}
			{/if}
			<label class="form-check form-check-inline">
				<input type="radio" name="background_image_admin_path" value="auth-bg.jpg" {if old('background_image_admin_path', $background_image_admin_path) eq 'auth-bg.jpg'}checked="checked"{/if} id="background_image_admin_path_01" class="form-check-input">
				<label class="form-check-label" for="background_image_admin_path_01">
					<img src="{img_url('auth-bg.jpg')}" class="img-thumbnail" width="200">
				</label>
			</label>
			<label class="form-check form-check-inline">
				<input type="radio" name="background_image_admin_path" value="bg-01.jpg" {if old('background_image_admin_path', $background_image_admin_path) eq 'bg-01.jpg'}checked="checked"{/if} id="background_image_admin_path_02" class="form-check-input">
				<label class="form-check-label" for="background_image_admin_path_02">
					<img src="{img_url('bg-01.jpg')}" class="img-thumbnail" width="200">
				</label>
			</label>
			<label class="form-check form-check-inline">
				<input type="radio" name="background_image_admin_path" value="bg-02.jpg" {if old('background_image_admin_path', $background_image_admin_path) eq 'bg-02.jpg'}checked="checked"{/if} id="background_image_admin_path_03" class="form-check-input">
				<label class="form-check-label" for="background_image_admin_path_03">
					<img src="{img_url('bg-02.jpg')}" class="img-thumbnail" width="200">
				</label>
			</label>
			<label class="form-check form-check-inline">
				<input type="radio" name="background_image_admin_path" value="bg-03.jpg" {if old('background_image_admin_path', $background_image_admin_path) eq 'bg-03.jpg'}checked="checked"{/if} id="background_image_admin_path_04" class="form-check-input">
				<label class="form-check-label" for="background_image_admin_path_04">
					<img src="{img_url('bg-03.jpg')}" class="img-thumbnail" width="200">
				</label>
			</label>
			<label class="form-check form-check-inline">
				<input type="radio" name="background_image_admin_path" value="bg-04.jpeg" {if old('background_image_admin_path', $background_image_admin_path) eq 'bg-04.jpeg'}checked="checked"{/if} id="background_image_admin_path_05" class="form-check-input">
				<label class="form-check-label" for="background_image_admin_path_05">
					<img src="{img_url('bg-04.jpeg')}" class="img-thumbnail" width="200">
				</label>
			</label>
			<label class="form-check form-check-inline">
				<input type="radio" name="background_image_admin_path" value="bg-05.jpeg" {if old('background_image_admin_path', $background_image_admin_path) eq 'bg-05.jpeg'}checked="checked"{/if} id="background_image_admin_path_06" class="form-check-input">
				<label class="form-check-label" for="background_image_admin_path_06">
					<img src="{img_url('bg-05.jpeg')}" class="img-thumbnail" width="200">
				</label>
			</label>
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
