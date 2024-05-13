{strip}
	{form_open(uri_string(), ['id' => 'form_image'])}
	{form_hidden('tab_type', 'tab_image')}
	<div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">Uploads</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_file_max_size')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="file_max_size" value="{old('file_max_size', $settings.file_max_size)|default:0}" id="file_max_size" class="form-control {if validation_show_error("file_max_size")}is-invalid{/if}">
			<small>
				{lang('ConfigAdmin.help_file_max_size')}<br/>
				upload_max_filesize: {ini_get('upload_max_filesize')}
			</small>
			<div class="invalid-feedback">
				{validation_show_error("file_max_size")}
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_file_ext_allowed')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<textarea type="textarea" name="file_ext_allowed" id="file_ext_allowed" cols="40" rows="5" class="form-control {if validation_show_error("file_ext_allowed")}is-invalid{/if}">{str_replace('|', PHP_EOL, old('file_ext_allowed', $settings.file_ext_allowed))}</textarea>
			<div class="invalid-feedback">
				{validation_show_error("file_ext_allowed")}
			</div>
		</div>
	</div>
	<div class="form-group row d-none mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_file_mime_allowed')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<textarea type="textarea" name="file_mime_allowed" id="file_mime_allowed" cols="40" rows="5" class="form-control {if validation_show_error("file_mime_allowed")}is-invalid{/if}">{str_replace('|', PHP_EOL, old('file_mime_allowed', $settings.file_mime_allowed))}</textarea>
			<div class="invalid-feedback">
				{validation_show_error("file_mime_allowed")}
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_file_max_width')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="file_max_width" value="{old('file_max_width', $settings.file_max_width)|default:0}" id="file_max_width" class="form-control {if validation_show_error("file_max_width")}is-invalid{/if}">
			<small>{lang('ConfigAdmin.help_file_max_width')}</small>
			<div class="invalid-feedback">
				{validation_show_error("file_max_width")}
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label required-label text-sm-end">{lang('ConfigAdmin.text_file_max_height')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="number" name="file_max_height" value="{old('file_max_height', $settings.file_max_height)}" id="file_max_height" class="form-control {if validation_show_error("file_max_height")}is-invalid{/if}">
			<small>{lang('ConfigAdmin.help_file_max_height')}</small>
			<div class="invalid-feedback">
				{validation_show_error("file_max_height")}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_file_encrypt_name">{lang('ConfigAdmin.text_file_encrypt_name')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="file_encrypt_name" id="input_file_encrypt_name"
					{set_checkbox('file_encrypt_name', 1, $settings.file_encrypt_name|default:true)} value="1">
			</div>
		</div>
		
	</div>
	<div class="row" style="margin-top: -5px;">
		<div class="col-12 col-sm-3"></div>
		<div class="col-12 col-sm-8 col-lg-6 form-text">{lang('ConfigAdmin.help_file_encrypt_name')}</div>
	</div>
	

	<div class="border-bottom lead mx-3 pb-1 my-3 fw-bold">Image</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_none')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<a href="javascript:void(0);" id="image_none" data-target="input_image_none" data-thumb="load_image_none" data-bs-toggle="image" data-type="image" class="mx-0 mt-1">
				<img src="{if !empty(old('image_none', $settings.image_none))}{image_thumb_url(old('image_none', $settings.image_none))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1" alt="" title="" id="load_image_none" data-placeholder="{image_default_url()}"/>
				<div class="btn-group w-100 mt-1" role="group">
					<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
					<button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
				</div>
			</a>
			<input type="hidden" name="image_none" value="{old('image_none', $settings.image_none)}" id="input_image_none" />
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_quality')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<span id="image_quality_text">{old('image_quality', $settings.image_quality)|default:0}</span>%
			<input type="range" name="image_quality" class="form-range" min="0" max="100" value="{old('image_quality', $settings.image_quality)|default:0}" id="image_quality" data-target="#image_quality_text" onchange="Catcool.showRangeValue(this)">
		</div>
	</div>

	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_enable_resize_image">{lang('ConfigAdmin.text_enable_resize_image')}</label>
		<div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="enable_resize_image" id="input_enable_resize_image"
					{set_checkbox('enable_resize_image', 1, $settings.enable_resize_image|default:true)} value="1">
			</div>
		</div>
		
	</div>

	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_thumbnail_large')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<div class="input-group">
				<input type="text" name="image_thumbnail_large_width" value="{old('image_thumbnail_large_width', $settings.image_thumbnail_large_width)}" id="image_thumbnail_large_width" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_width')}">
				<input type="text" name="image_thumbnail_large_height" value="{old('image_thumbnail_large_height', $settings.image_thumbnail_large_height)}" id="image_thumbnail_large_height" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_height')}">
			</div>
		</div>
	</div>
	<div class="form-group row mb-3">
		<label class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_image_thumbnail_small')}</label>
		<div class="col-12 col-sm-8 col-lg-6">
			<div class="input-group">
				<input type="text" name="image_thumbnail_small_width" value="{old('image_thumbnail_small_width', $settings.image_thumbnail_small_width)}" id="image_thumbnail_small_width" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_width')}">
				<input type="text" name="image_thumbnail_small_height" value="{old('image_thumbnail_small_height', $settings.image_thumbnail_small_height)}" id="image_thumbnail_small_height" class="form-control" placeholder="{lang('ConfigAdmin.text_image_thumbnail_large_height')}">
			</div>
			<small>
				(160x120) - (240x160) - (320x240) - (400x240) - (480x320) - (640x480) - (768x480) - (854x480)
			</small>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_image_watermar_enable">{lang('ConfigAdmin.text_image_watermark')}</label>
		<div class="col-12 col-sm-8 col-lg-6">

			<div class="form-control-lg py-1" style="min-height: 25px;">
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" name="image_watermar_enable" id="input_image_watermar_enable"
						{set_checkbox('image_watermar_enable', 1, $settings.image_watermar_enable|default:false)} value="1">
				</div>
			</div>

			<div class="bg-light mt-2 p-2">
				{if !empty(old('image_watermark_text', $settings.image_watermark_text)) || !empty(old('image_watermark_path', $settings.image_watermark_path))}
					<a href="{$watermark_bg}?{time()}" data-lightbox="photos"><img src="{$watermark_bg}?{time()}" style="width: 150px;"></a>
				{/if}
				<div class="form-group my-3">
					{form_dropdown('image_watermark', $watermark_list, old('image_watermark', $settings.image_watermark), ['class' => 'form-control'])}
				</div>
				<div class="form-group mb-3">
					{lang('ConfigAdmin.text_image_watermark_hor_offset')}<br/>
					<input type="number" name="image_watermark_hor_offset" value="{old('image_watermark_hor_offset', $settings.image_watermark_hor_offset)|default:0}" id="image_watermark_hor_offset" class="form-control {if validation_show_error("image_watermark_hor_offset")}is-invalid{/if}">
				</div>
				<div class="form-group mb-3">
					{lang('ConfigAdmin.text_image_watermark_vrt_offset')}<br/>
					<input type="number" name="image_watermark_vrt_offset" value="{old('image_watermark_vrt_offset', $settings.image_watermark_vrt_offset)|default:0}" id="image_watermark_vrt_offset" class="form-control {if validation_show_error("image_watermark_vrt_offset")}is-invalid{/if}">
				</div>
				<div class="form-group mb-3">
					{lang('ConfigAdmin.text_image_watermark_opacity')}
					<span id="image_watermark_opacity_text">{old('image_watermark_opacity', $settings.image_watermark_opacity)|default:60}</span>
					<input type="range" name="image_watermark_opacity" class="form-range" min="0" max="100" value="{old('image_watermark_opacity', $settings.image_watermark_opacity)|default:60}" id="image_watermark_opacity" data-target="#image_watermark_opacity_text" onchange="Catcool.showRangeValue(this)">
				</div>
				<div class="form-group mt-2 fw-bold">

					{assign var="image_watermark_type_default" value="image"}

					<label class="form-check form-check-inline">
						<input type="radio" name="image_watermark_type" value="image" {if old('image_watermark_type', $settings.image_watermark_type)|default:$image_watermark_type_default eq 'image'}checked="checked"{/if} id="image_watermark_type_image" class="form-check-input">
						<label class="form-check-label" for="image_watermark_type_image">{lang('ConfigAdmin.text_image_watermark_path')}</label>
					</label>

					<a href="javascript:void(0);" id="image_watermark_path" data-target="input_image_watermark_path" data-thumb="load_image_watermark_path" data-bs-toggle="image" data-type="image" class="mx-0 mt-1">
						<img src="{if !empty(old('image_watermark_path', $settings.image_watermark_path))}{image_thumb_url(old('image_watermark_path', $settings.image_watermark_path))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1" alt="" title="" id="load_image_watermark_path" data-placeholder="{image_default_url()}"/>
						<div class="btn-group w-100 mt-1" role="group">
							<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
							<button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
						</div>
					</a>
					<input type="hidden" name="image_watermark_path" value="{old('image_watermark_path', $settings.image_watermark_path)}" id="input_image_watermark_path" />
				</div>
				<hr>
				<div class="form-group mt-4 fw-bold">
					<label class="form-check form-check-inline">
						<input type="radio" name="image_watermark_type" value="text" {if old('image_watermark_type', $settings.image_watermark_type)|default:$image_watermark_type_default eq 'text'}checked="checked"{/if} id="image_watermark_type_text" class="form-check-input">
						<label class="form-check-label" for="image_watermark_type_text">{lang('ConfigAdmin.text_image_watermark_text')}</label>
					</label>
					<input type="text" name="image_watermark_text" value="{old('image_watermark_text', $settings.image_watermark_text)}" id="image_watermark_text" class="form-control {if validation_show_error("image_watermark_text")}is-invalid{/if}">
				</div>
				<div class="form-group mb-3">
					{lang('ConfigAdmin.text_image_watermark_font_path')}
					<select name="image_watermark_font_path" class="form-control">
						<option value="" {if empty(old('image_watermark_font_path', $settings.image_watermark_font_path))}selected="selected"{/if}>{lang('Admin.text_none')}</option>
						{foreach get_fonts() as $key => $value}
							<option value="{$value}" {if old('image_watermark_font_path', $settings.image_watermark_font_path) eq $value}selected="selected"{/if}>{$key}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group mb-3">
					{lang('ConfigAdmin.text_image_watermark_font_size')}
					<input type="number" name="image_watermark_font_size" value="{old('image_watermark_font_size', $settings.image_watermark_font_size)}" id="image_watermark_font_size" class="form-control">
				</div>
				<div class="form-group mb-3">
					{lang('ConfigAdmin.text_image_watermark_font_color')}
					<input type="text" name="image_watermark_font_color" value="{old('image_watermark_font_color', $settings.image_watermark_font_color)}" id="image_watermark_font_color" autocomplete="off" data-control="hue" class="form-control color-picker">
				</div>
				<div class="row my-3">

					<label class="col-auto" for="input_image_watermark_is_shadow">{lang('ConfigAdmin.text_image_watermark_is_shadow')}</label>
					<div class="col-5 form-control-lg py-0" style="min-height: 25px; margin-top: -3px;">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" name="image_watermark_is_shadow" id="input_image_watermark_is_shadow"
								{set_checkbox('image_watermark_is_shadow', 1, $settings.image_watermark_is_shadow|default:false)} value="1">
						</div>
					</div>

				</div>
				<div class="form-group mb-3">
					{lang('ConfigAdmin.text_image_watermark_shadow_color')}
					<input type="text" name="image_watermark_shadow_color" value="{old('image_watermark_shadow_color', $settings.image_watermark_shadow_color)}" id="image_watermark_shadow_color" autocomplete="off" class="form-control color-picker">
				</div>
				<div class="form-group">
					{lang('ConfigAdmin.text_image_watermark_shadow_distance')}
					<input type="number" name="image_watermark_shadow_distance" value="{old('image_watermark_shadow_distance', $settings.image_watermark_shadow_distance)}" id="image_watermark_shadow_distance" class="form-control">
				</div>
			</div>
		</div>
	</div>
	<div class="form-group row d-none">
		<div class="col-12 col-sm-3 col-form-label text-sm-end">File demo get link</div>
		<div class="col-12 col-sm-8 col-lg-6">
			<input type="text" name="file_pdf" value="{old('file_pdf', $settings.file_pdf)}" id="input_file_pdf" class="form-control" />
			<a href="javascript:void(0);" id="file_pdf" data-target="input_file_pdf" data-bs-toggle="image" class="mx-0 mt-1">
				<div class="btn-group w-100 mt-1" role="group">
					<button type="button" id="button-image-pdf" class="button-image btn btn-xs btn-primary w-100" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i> {lang('Admin.text_photo_edit')}</button>
				</div>
			</a>
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
