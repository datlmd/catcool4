{form_open(uri_string(), ['id' => 'form_image'])}
{form_hidden('tab_type', 'tab_image')}
<div class="border-bottom mx-3 lead pb-1 my-3">Uploads</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_file_max_size')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.file_max_size)}
			{assign var="file_max_size" value="`$settings.file_max_size`"}
		{else}
			{assign var="file_max_size" value="0"}
		{/if}
		<input type="number" name="file_max_size" value="{old('file_max_size', $file_max_size)}" id="file_max_size" class="form-control {if $validator->hasError("file_max_size")}is-invalid{/if}">
		<small>{lang('ConfigAdmin.help_file_max_size')}</small>
		<div class="invalid-feedback">
			{$validator->getError("file_max_size")}
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_file_ext_allowed')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.file_ext_allowed)}
			{assign var="file_ext_allowed" value="`$settings.file_ext_allowed`"}
		{else}
			{assign var="file_ext_allowed" value=""}
		{/if}
		<textarea type="textarea" name="file_ext_allowed" id="file_ext_allowed" cols="40" rows="5" class="form-control {if $validator->hasError("file_ext_allowed")}is-invalid{/if}">{str_replace('|', PHP_EOL, old('file_ext_allowed', $file_ext_allowed))}</textarea>
		<div class="invalid-feedback">
			{$validator->getError("file_ext_allowed")}
		</div>
	</div>
</div>
<div class="form-group row d-none">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_file_mime_allowed')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.file_mime_allowed)}
			{assign var="file_mime_allowed" value="`$settings.file_mime_allowed`"}
		{else}
			{assign var="file_mime_allowed" value=""}
		{/if}
		<textarea type="textarea" name="file_mime_allowed" id="file_mime_allowed" cols="40" rows="5" class="form-control {if $validator->hasError("file_mime_allowed")}is-invalid{/if}">{str_replace('|', PHP_EOL, old('file_mime_allowed', $file_mime_allowed))}</textarea>
		<div class="invalid-feedback">
			{$validator->getError("file_mime_allowed")}
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_file_max_width')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.file_max_width)}
			{assign var="file_max_width" value="`$settings.file_max_width`"}
		{else}
			{assign var="file_max_width" value="0"}
		{/if}
		<input type="number" name="file_max_width" value="{old('file_max_width', $file_max_width)}" id="file_max_width" class="form-control {if $validator->hasError("file_max_width")}is-invalid{/if}">
		<small>{lang('ConfigAdmin.help_file_max_width')}</small>
		<div class="invalid-feedback">
			{$validator->getError("file_max_width")}
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_file_max_height')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.file_max_height)}
			{assign var="file_max_height" value="`$settings.file_max_height`"}
		{else}
			{assign var="file_max_height" value="0"}
		{/if}
		<input type="number" name="file_max_height" value="{old('file_max_height', $file_max_height)}" id="file_max_height" class="form-control {if $validator->hasError("file_max_height")}is-invalid{/if}">
		<small>{lang('ConfigAdmin.help_file_max_height')}</small>
		<div class="invalid-feedback">
			{$validator->getError("file_max_height")}
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_file_encrypt_name')}</div>
	<div class="col-12 col-sm-8 col-lg-6 mt-2 mb-0">
		{if !empty($settings.file_encrypt_name)}
			{assign var="file_encrypt_name" value="`$settings.file_encrypt_name`"}
		{else}
			{assign var="file_encrypt_name" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="file_encrypt_name" value="{STATUS_ON}" {if !empty(old('file_encrypt_name', $file_encrypt_name))}checked="checked"{/if} id="file_encrypt_name_on" class="form-check-input">
			<label class="form-check-label" for="file_encrypt_name_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="file_encrypt_name" value="{STATUS_OFF}" {if empty(old('file_encrypt_name', $file_encrypt_name))}checked="checked"{/if} id="file_encrypt_name_off" class="form-check-input">
			<label class="form-check-label" for="file_encrypt_name_off">OFF</label>
		</label>
		<br/>
		<small>{lang('ConfigAdmin.help_file_encrypt_name')}</small>
	</div>
</div>
<div class="border-bottom lead mx-3 pb-1 my-3">Image</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_none')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.image_none)}
			{assign var="image_none" value="`$settings.image_none`"}
		{else}
			{assign var="image_none" value=""}
		{/if}
		<a href="javascript:void(0);" id="image_none" data-target="input_image_none" data-thumb="load_image_none" data-bs-toggle="image" class="mx-0 mt-1">
			<img src="{if !empty(old('image_none', $image_none))}{image_thumb_url(old('image_none', $image_none))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_image_none" data-placeholder="{image_default_url()}"/>
			<button type="button" id="button-image-none" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('Admin.text_photo_edit')}</button>
			<button type="button" id="button-clear-none" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('Admin.text_photo_clear')}</button>
		</a>
		<input type="hidden" name="image_none" value="{old('image_none', $image_none)}" id="input_image_none" />
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_quality')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.image_quality)}
			{assign var="image_quality" value="`$settings.image_quality`"}
		{else}
			{assign var="image_quality" value="0"}
		{/if}
		<span id="image_quality_text">{old('image_quality', $image_quality)}</span>%
		<input type="range" name="image_quality" class="form-range" min="0" max="100" value="{old('image_quality', $image_quality)}" id="image_quality" data-target="#image_quality_text" onchange="Catcool.showRangeValue(this)">
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_enable_resize_image')}</div>
	<div class="col-12 col-sm-8 col-lg-6 mt-2 mb-0">
		{if !empty($settings.enable_resize_image)}
			{assign var="enable_resize_image" value="`$settings.enable_resize_image`"}
		{else}
			{assign var="enable_resize_image" value=""}
		{/if}
		<label class="form-check form-check-inline">
			<input type="radio" name="enable_resize_image" value="{STATUS_ON}" {if !empty(old('enable_resize_image', $enable_resize_image))}checked="checked"{/if} id="enable_resize_image_on" class="form-check-input">
			<label class="form-check-label" for="enable_resize_image_on">ON</label>
		</label>
		<label class="form-check form-check-inline me-2">
			<input type="radio" name="enable_resize_image" value="{STATUS_OFF}" {if empty(old('enable_resize_image', $enable_resize_image))}checked="checked"{/if} id="enable_resize_image_off" class="form-check-input">
			<label class="form-check-label" for="enable_resize_image_off">OFF</label>
		</label>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_thumbnail_large')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.image_thumbnail_large_width)}
			{assign var="image_thumbnail_large_width" value="`$settings.image_thumbnail_large_width`"}
		{else}
			{assign var="image_thumbnail_large_width" value=""}
		{/if}
		{if !empty($settings.image_thumbnail_large_height)}
			{assign var="image_thumbnail_large_height" value="`$settings.image_thumbnail_large_height`"}
		{else}
			{assign var="image_thumbnail_large_height" value=""}
		{/if}
		<div class="input-group">
			<input type="text" name="image_thumbnail_large_width" value="{old('image_thumbnail_large_width', $image_thumbnail_large_width)}" id="image_thumbnail_large_width" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_width')}">
			<input type="text" name="image_thumbnail_large_height" value="{old('image_thumbnail_large_height', $image_thumbnail_large_height)}" id="image_thumbnail_large_height" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_height')}">
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_thumbnail_small')}</div>
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="input-group">
			{if !empty($settings.image_thumbnail_small_width)}
				{assign var="image_thumbnail_small_width" value="`$settings.image_thumbnail_small_width`"}
			{else}
				{assign var="image_thumbnail_small_width" value=""}
			{/if}
			{if !empty($settings.image_thumbnail_small_height)}
				{assign var="image_thumbnail_small_height" value="`$settings.image_thumbnail_small_height`"}
			{else}
				{assign var="image_thumbnail_small_height" value=""}
			{/if}
			<input type="text" name="image_thumbnail_small_width" value="{old('image_thumbnail_small_width', $image_thumbnail_small_width)}" id="image_thumbnail_small_width" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_width')}">
			<input type="text" name="image_thumbnail_small_height" value="{old('image_thumbnail_small_height', $image_thumbnail_small_height)}" id="image_thumbnail_small_height" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_height')}">
		</div>
		<small>
			(160x120) - (240x160) - (320x240) - (400x240) - (480x320) - (640x480) - (768x480) - (854x480)
		</small>
	</div>
</div>
<div class="form-group row">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_watermark')}</div>
	<div class="col-12 col-sm-8 col-lg-6 bg-light p-4">
		{if !empty($settings.image_watermark_text)}
			{assign var="image_watermark_text" value="`$settings.image_watermark_text`"}
		{else}
			{assign var="image_watermark_text" value=""}
		{/if}
		{if !empty($settings.image_watermark_path)}
			{assign var="image_watermark_path" value="`$settings.image_watermark_path`"}
		{else}
			{assign var="image_watermark_path" value=""}
		{/if}
		{if !empty(old('image_watermark_text', $image_watermark_text)) || !empty(old('image_watermark_path', $image_watermark_path))}
			<a href="{$watermark_bg}?{time()}" data-lightbox="photos"><img src="{$watermark_bg}?{time()}" style="width: 150px;"></a>
		{/if}
		<div class="form-group mt-2">
			{if !empty($settings.image_watermark)}
				{assign var="image_watermark" value="`$settings.image_watermark`"}
			{else}
				{assign var="image_watermark" value=""}
			{/if}
			{form_dropdown('image_watermark', $watermark_list, old('image_watermark', $image_watermark), ['class' => 'form-control'])}
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_hor_offset')}<br/>
			{if !empty($settings.image_watermark_hor_offset)}
				{assign var="image_watermark_hor_offset" value="`$settings.image_watermark_hor_offset`"}
			{else}
				{assign var="image_watermark_hor_offset" value="0"}
			{/if}
			<input type="number" name="image_watermark_hor_offset" value="{old('image_watermark_hor_offset', $image_watermark_hor_offset)}" id="image_watermark_hor_offset" class="form-control {if $validator->hasError("image_watermark_hor_offset")}is-invalid{/if}">
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_vrt_offset')}<br/>
			{if !empty($settings.image_watermark_vrt_offset)}
				{assign var="image_watermark_vrt_offset" value="`$settings.image_watermark_vrt_offset`"}
			{else}
				{assign var="image_watermark_vrt_offset" value="0"}
			{/if}
			<input type="number" name="image_watermark_vrt_offset" value="{old('image_watermark_vrt_offset', $image_watermark_vrt_offset)}" id="image_watermark_vrt_offset" class="form-control {if $validator->hasError("image_watermark_vrt_offset")}is-invalid{/if}">
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_opacity')}
			{if isset($settings.image_watermark_opacity)}
				{assign var="image_watermark_opacity" value="`$settings.image_watermark_opacity`"}
			{else}
				{assign var="image_watermark_opacity" value="60"}
			{/if}
			<span id="image_watermark_opacity_text">{old('image_watermark_opacity', $image_watermark_opacity)}</span>
			<input type="range" name="image_watermark_opacity" class="form-range" min="0" max="100" value="{old('image_watermark_opacity', $image_watermark_opacity)}" id="image_watermark_opacity" data-target="#image_watermark_opacity_text" onchange="Catcool.showRangeValue(this)">
		</div>
		<div class="form-group mt-2 fw-bold">
			{if !empty($settings.image_watermark_type)}
				{assign var="image_watermark_type" value="`$settings.image_watermark_type`"}
			{else}
				{assign var="image_watermark_type" value="image"}
			{/if}
			<label class="form-check form-check-inline">
				<input type="radio" name="image_watermark_type" value="image" {if old('image_watermark_type', $image_watermark_type) eq 'image'}checked="checked"{/if} id="image_watermark_type_image" class="form-check-input">
				<label class="form-check-label" for="image_watermark_type_image">{lang('ConfigAdmin.text_image_watermark_path')}</label>
			</label>
			<a href="javascript:void(0);" id="image_watermark_path" data-target="input_image_watermark_path" data-thumb="load_image_watermark_path" data-bs-toggle="image" class="mx-0 mt-1">
				<img src="{if !empty(old('image_watermark_path', $image_watermark_path))}{image_thumb_url(old('image_watermark_path', $image_watermark_path))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_image_watermark_path" data-placeholder="{image_default_url()}"/>
				<button type="button" id="button-image-watemark" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('Admin.text_photo_edit')}</button>
				<button type="button" id="button-clear-watemark" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash me-1"></i>{lang('Admin.text_photo_clear')}</button>
			</a>
			<input type="hidden" name="image_watermark_path" value="{old('image_watermark_path', $image_watermark_path)}" id="input_image_watermark_path" />
		</div>
		<div class="form-group mt-4 fw-bold">
			<label class="form-check form-check-inline">
				<input type="radio" name="image_watermark_type" value="text" {if old('image_watermark_type', $image_watermark_type) eq 'text'}checked="checked"{/if} id="image_watermark_type_text" class="form-check-input">
				<label class="form-check-label" for="image_watermark_type_text">{lang('ConfigAdmin.text_image_watermark_text')}</label>
			</label>
			<input type="text" name="image_watermark_text" value="{old('image_watermark_text', $image_watermark_text)}" id="image_watermark_text" class="form-control {if $validator->hasError("image_watermark_text")}is-invalid{/if}">
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_font_path')}
			<select name="image_watermark_font_path" class="form-control">
				{if !empty($settings.image_watermark_font_path)}
					{assign var="image_watermark_font_path" value="`$settings.image_watermark_font_path`"}
				{else}
					{assign var="image_watermark_font_path" value=""}
				{/if}
				<option value="" {if empty(old('image_watermark_font_path', $image_watermark_font_path))}selected="selected"{/if}>{lang('Admin.text_none')}</option>
				{foreach get_fonts() as $key => $value}
					<option value="{$value}" {if old('image_watermark_font_path', $image_watermark_font_path) eq $value}selected="selected"{/if}>{$key}</option>
				{/foreach}
			</select>
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_font_size')}
			{if !empty($settings.image_watermark_font_size)}
				{assign var="image_watermark_font_size" value="`$settings.image_watermark_font_size`"}
			{else}
				{assign var="image_watermark_font_size" value=""}
			{/if}
			<input type="number" name="image_watermark_font_size" value="{old('image_watermark_font_size', $image_watermark_font_size)}" id="image_watermark_font_size" class="form-control">
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_font_color')}
			{if !empty($settings.image_watermark_font_color)}
				{assign var="image_watermark_font_color" value="`$settings.image_watermark_font_color`"}
			{else}
				{assign var="image_watermark_font_color" value=""}
			{/if}
			<input type="text" name="image_watermark_font_color" value="{old('image_watermark_font_color', $image_watermark_font_color)}" id="image_watermark_font_color" autocomplete="off" data-control="hue" class="form-control color-picker">
		</div>
		<div class="form-group mt-3">
			{lang('ConfigAdmin.text_image_watermark_is_shadow')}
			{if !empty($settings.image_watermark_is_shadow)}
				{assign var="image_watermark_is_shadow" value="`$settings.image_watermark_is_shadow`"}
			{else}
				{assign var="image_watermark_is_shadow" value="0"}
			{/if}
			<label class="form-check form-check-inline ms-2">
				<input type="radio" name="image_watermark_is_shadow" value="{STATUS_ON}" {if !empty(old('image_watermark_is_shadow', $image_watermark_is_shadow))}checked="checked"{/if} id="image_watermark_is_shadow_on" class="form-check-input">
				<label class="form-check-label" for="image_watermark_is_shadow_on">ON</label>
			</label>
			<label class="form-check form-check-inline me-2">
				<input type="radio" name="image_watermark_is_shadow" value="{STATUS_OFF}" {if empty(old('image_watermark_is_shadow', $image_watermark_is_shadow))}checked="checked"{/if} id="image_watermark_is_shadow_off" class="form-check-input">
				<label class="form-check-label" for="image_watermark_is_shadow_off">OFF</label>
			</label>
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_shadow_color')}
			{if !empty($settings.image_watermark_shadow_color)}
				{assign var="image_watermark_shadow_color" value="`$settings.image_watermark_shadow_color`"}
			{else}
				{assign var="image_watermark_shadow_color" value=""}
			{/if}
			<input type="text" name="image_watermark_shadow_color" value="{old('image_watermark_shadow_color', $image_watermark_shadow_color)}" id="image_watermark_shadow_color" autocomplete="off" class="form-control color-picker">
		</div>
		<div class="form-group">
			{lang('ConfigAdmin.text_image_watermark_shadow_distance')}
			{if !empty($settings.image_watermark_shadow_distance)}
				{assign var="image_watermark_shadow_distance" value="`$settings.image_watermark_shadow_distance`"}
			{else}
				{assign var="image_watermark_shadow_distance" value=""}
			{/if}
			<input type="number" name="image_watermark_shadow_distance" value="{old('image_watermark_shadow_distance', $image_watermark_shadow_distance)}" id="image_watermark_shadow_distance" class="form-control">
		</div>
	</div>
</div>
<div class="form-group row d-none">
	<div class="col-12 col-sm-3 col-form-label text-sm-end">File demo get link</div>
	<div class="col-12 col-sm-8 col-lg-6">
		{if !empty($settings.file_pdf)}
			{assign var="file_pdf" value="`$settings.file_pdf`"}
		{else}
			{assign var="file_pdf" value=""}
		{/if}
		<input type="text" name="file_pdf" value="{old('file_pdf', $file_pdf)}" id="input_file_pdf" class="form-control" />
		<a href="javascript:void(0);" id="file_pdf" data-target="input_file_pdf" data-bs-toggle="image" class="mx-0 mt-1">
			<button type="button" id="button-image-pdf" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt me-1"></i>{lang('ConfigAdmin.text_photo_edit')}</button>
		</a>
	</div>
</div>
<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
	<div class="col-12 col-sm-8 col-lg-6">
		<button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
	</div>
</div>
{form_close()}
