{form_open(uri_string(), ['id' => 'form_page'])}
{create_input_token($csrf)}
{form_hidden('tab_type', 'tab_page')}
<div class="form-group row">
	{lang('text_site_name', 'text_site_name', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="site_name" value="{set_value('site_name', $settings.site_name)}" id="site_name" class="form-control {if !empty(form_error("site_name"))}is-invalid{/if}">
		{if !empty(form_error("site_name"))}
			<div class="invalid-feedback">{form_error("site_name")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_site_description', 'text_site_description', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<textarea type="textarea" name="site_description" id="site_description" cols="40" rows="5" class="form-control {if !empty(form_error("site_description"))}is-invalid{/if}">{set_value('site_description', $settings.site_description)}</textarea>
		{if !empty(form_error("site_description"))}
			<div class="invalid-feedback">{form_error("site_description")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_site_keywords', 'text_site_keywords', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="site_keywords" value="{set_value('site_keywords', $settings.site_keywords)}" id="site_keywords" class="form-control {if !empty(form_error("site_keywords"))}is-invalid{/if}">
	</div>
</div>
<div class="form-group row">
	{lang('text_logo', 'text_logo', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<a href="javascript:void(0);" id="image_logo_url" data-target="input_image_logo_url" data-thumb="load_image_logo_url" data-toggle="image" class="mx-0 mt-1">
			<img src="{if !empty(set_value('image_logo_url', $settings.image_logo_url))}{image_thumb_url(set_value('image_logo_url', $settings.image_logo_url))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 mr-1 img-fluid" alt="" title="" id="load_image_logo_url" data-placeholder="{image_default_url()}"/>
			<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt mr-1"></i>{lang('text_photo_edit')}</button>
			<button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash mr-1"></i>{lang('text_photo_clear')}</button>
		</a>
		<input type="hidden" name="image_logo_url" value="{set_value('image_logo_url', $settings.image_logo_url)}" id="input_image_logo_url" />
	</div>
</div>
<div class="form-group row">
	{lang('text_icon', 'text_icon', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<a href="javascript:void(0);" id="image_icon_url" data-target="input_image_icon_url" data-thumb="load_image_icon_url" data-toggle="image" class="mx-0 mt-1">
			<img src="{if !empty(set_value('image_icon_url', $settings.image_icon_url))}{image_thumb_url(set_value('image_icon_url', $settings.image_icon_url))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 mr-1 img-fluid" alt="" title="" id="load_image_icon_url" data-placeholder="{image_default_url()}"/>
			<button type="button" id="button-image-icon" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt mr-1"></i>{lang('text_photo_edit')}</button>
			<button type="button" id="button-clear-icon" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash mr-1"></i>{lang('text_photo_clear')}</button>
		</a>
		<input type="hidden" name="image_icon_url" value="{set_value('image_icon_url', $settings.image_icon_url)}" id="input_image_icon_url" />
	</div>
</div>
<div class="form-group row">
	{lang('text_pagination_limit', 'text_pagination_limit', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="pagination_limit" value="{set_value('pagination_limit', $settings.pagination_limit)}" id="pagination_limit" class="form-control {if !empty(form_error("pagination_limit"))}is-invalid{/if}">
		{if !empty(form_error("pagination_limit"))}
			<div class="invalid-feedback">{form_error("pagination_limit")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_pagination_limit_admin', 'text_pagination_limit_admin', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="pagination_limit_admin" value="{set_value('pagination_limit_admin', $settings.pagination_limit_admin)}" id="pagination_limit_admin" class="form-control {if !empty(form_error("pagination_limit_admin"))}is-invalid{/if}">
		{if !empty(form_error("pagination_limit_admin"))}
			<div class="invalid-feedback">{form_error("pagination_limit_admin")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_hide_menu', 'text_hide_menu', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="enable_scroll_menu_admin" value="{STATUS_ON}" {set_checkbox('enable_scroll_menu_admin', STATUS_ON, ($settings.enable_scroll_menu_admin|lower eq 'true'))} id="enable_scroll_menu_admin">
			<span><label for="enable_scroll_menu_admin"></label></span>
		</div>
	</div>
</div>
<div class="form-group row">
	{lang('text_enable_icon_menu_admin', 'text_enable_icon_menu_admin', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="enable_icon_menu_admin" value="{STATUS_ON}" {set_checkbox('enable_icon_menu_admin', STATUS_ON, ($settings.enable_icon_menu_admin|lower eq 'true'))} id="enable_icon_menu_admin">
			<span><label for="enable_icon_menu_admin"></label></span>
		</div>
	</div>
</div>
<div class="form-group row">
	{lang('text_enable_dark_mode', 'text_enable_dark_mode', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="enable_dark_mode" value="{STATUS_ON}" {set_checkbox('enable_dark_mode', STATUS_ON, ($settings.enable_dark_mode|lower eq 'true'))} id="enable_dark_mode">
			<span><label for="enable_dark_mode"></label></span>
		</div>
	</div>
</div>
<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-right"></div>
	<div class="col-12 col-sm-8 col-lg-6">
		<button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save mr-1"></i>{lang('button_save')}</button>
	</div>
</div>
{form_close()}