{form_open(uri_string(), ['id' => 'form_image'])}
{create_input_token($csrf)}
{form_hidden('tab_type', 'tab_image')}
<div class="border-bottom mx-3 lead pb-1 my-3">Uploads</div>
<div class="form-group row">
	{lang('text_file_max_size', 'text_file_max_size', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="file_max_size" value="{set_value('file_max_size', $settings.file_max_size)}" id="file_max_size" class="form-control {if !empty(form_error("file_max_size"))}is-invalid{/if}">
		<small>{lang('help_file_max_size')}</small>
		{if !empty(form_error("file_max_size"))}
			<div class="invalid-feedback">{form_error("file_max_size")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_file_ext_allowed', 'text_file_ext_allowed', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<textarea type="textarea" name="file_ext_allowed" id="file_ext_allowed" cols="40" rows="5" class="form-control {if !empty(form_error("file_ext_allowed"))}is-invalid{/if}">{str_replace('|', PHP_EOL, set_value('file_ext_allowed', $settings.file_ext_allowed))}</textarea>
		{if !empty(form_error("file_ext_allowed"))}
			<div class="invalid-feedback">{form_error("file_ext_allowed")}</div>
		{/if}
	</div>
</div>
<div class="form-group row d-none">
	{lang('text_file_mime_allowed', 'text_file_mime_allowed', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<textarea type="textarea" name="file_mime_allowed" id="file_mime_allowed" cols="40" rows="5" class="form-control {if !empty(form_error("file_mime_allowed"))}is-invalid{/if}">{str_replace('|', PHP_EOL, set_value('file_mime_allowed', $settings.file_mime_allowed))}</textarea>
		{if !empty(form_error("file_mime_allowed"))}
			<div class="invalid-feedback">{form_error("file_mime_allowed")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_file_max_width', 'text_file_max_width', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="file_max_width" value="{set_value('file_max_width', $settings.file_max_width)}" id="file_max_width" class="form-control {if !empty(form_error("file_max_width"))}is-invalid{/if}">
		<small>{lang('help_file_max_width')}</small>
		{if !empty(form_error("file_max_width"))}
			<div class="invalid-feedback">{form_error("file_max_width")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_file_max_height', 'text_file_max_height', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="number" name="file_max_height" value="{set_value('file_max_height', $settings.file_max_height)}" id="file_max_height" class="form-control {if !empty(form_error("file_max_height"))}is-invalid{/if}">
		<small>{lang('help_file_max_height')}</small>
		{if !empty(form_error("file_max_height"))}
			<div class="invalid-feedback">{form_error("file_max_height")}</div>
		{/if}
	</div>
</div>
<div class="form-group row">
	{lang('text_file_encrypt_name', 'text_file_encrypt_name', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="file_encrypt_name" value="{STATUS_ON}" {set_checkbox('file_encrypt_name', STATUS_ON, ($settings.file_encrypt_name|lower eq 'true'))} id="file_encrypt_name">
			<span><label for="file_encrypt_name"></label></span>
		</div><br/>
		<small>{lang('help_file_encrypt_name')}</small>
	</div>
</div>
<div class="border-bottom lead mx-3 pb-1 my-3">Image</div>
<div class="form-group row">
	{lang('text_image_none', 'text_image_none', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<a href="javascript:void(0);" id="image_none" data-target="input_image_none" data-thumb="load_image_none" data-toggle="image" class="mx-0 mt-1">
			<img src="{if !empty(set_value('image_none', $settings.image_none))}{image_thumb_url(set_value('image_none', $settings.image_none))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 mr-1 img-fluid" alt="" title="" id="load_image_none" data-placeholder="{image_default_url()}"/>
			<button type="button" id="button-image-none" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt mr-1"></i>{lang('text_photo_edit')}</button>
			<button type="button" id="button-clear-none" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash mr-1"></i>{lang('text_photo_clear')}</button>
		</a>
		<input type="hidden" name="image_none" value="{set_value('image_none', $settings.image_none)}" id="input_image_none" />
	</div>
</div>
<div class="form-group row">
	{lang('text_image_quality', 'text_image_quality', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		{form_dropdown('image_quality', $image_quality_list, set_value('image_quality', $settings.image_quality), ['class' => 'form-control'])}
	</div>
</div>
<div class="form-group row">
	{lang('text_enable_resize_image', 'text_enable_resize_image', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="switch-button switch-button-xs mt-2">
			<input type="checkbox" name="enable_resize_image" value="{STATUS_ON}" {set_checkbox('enable_resize_image', STATUS_ON, ($settings.enable_resize_image|lower eq 'true'))} id="enable_resize_image">
			<span><label for="enable_resize_image"></label></span>
		</div>
	</div>
</div>
<div class="form-group row">
	{lang('text_image_thumbnail_large', 'text_image_thumbnail_large', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6 input-group">
		<input type="text" name="image_thumbnail_large_width" value="{set_value('image_thumbnail_large_width', $settings.image_thumbnail_large_width)}" id="image_thumbnail_large_width" class="form-control" placeholder="{lang('text_image_thumbnail_large_width')}">
		<input type="text" name="image_thumbnail_large_height" value="{set_value('image_thumbnail_large_height', $settings.image_thumbnail_large_height)}" id="image_thumbnail_large_height" class="form-control" placeholder="{lang('text_image_thumbnail_large_height')}">
	</div>
</div>
<div class="form-group row">
	{lang('text_image_thumbnail_small', 'text_image_thumbnail_small', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6">
		<div class="input-group">
			<input type="text" name="image_thumbnail_small_width" value="{set_value('image_thumbnail_small_width', $settings.image_thumbnail_small_width)}" id="image_thumbnail_small_width" class="form-control" placeholder="{lang('text_image_thumbnail_large_width')}">
			<input type="text" name="image_thumbnail_small_height" value="{set_value('image_thumbnail_small_height', $settings.image_thumbnail_small_height)}" id="image_thumbnail_small_height" class="form-control" placeholder="{lang('text_image_thumbnail_large_height')}">
		</div>
		<small>
			(160x120) - (240x160) - (320x240) - (400x240) - (480x320) - (640x480) - (768x480) - (854x480)
		</small>
	</div>
</div>
<div class="form-group row">
	{lang('text_image_watermark', 'text_image_watermark', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
	<div class="col-12 col-sm-8 col-lg-6 bg-light p-4">
		{if !empty(set_value('image_watermark_text', $settings.image_watermark_text)) || !empty(set_value('image_watermark_path', $settings.image_watermark_path))}
			<a href="{$watermark_bg}?{time()}" data-lightbox="photos"><img src="{$watermark_bg}?{time()}" style="width: 150px;"></a>
		{/if}
		<div class="form-group mt-2">
			{form_dropdown('image_watermark', $watermark_list, set_value('image_watermark', $settings.image_watermark), ['class' => 'form-control'])}
		</div>
		<div class="form-group">
			{lang('text_image_watermark_hor_offset')}<br/>
			<input type="number" name="image_watermark_hor_offset" value="{set_value('image_watermark_hor_offset', $settings.image_watermark_hor_offset)}" id="image_watermark_hor_offset" class="form-control {if !empty(form_error("image_watermark_hor_offset"))}is-invalid{/if}">
		</div>
		<div class="form-group">
			{lang('text_image_watermark_vrt_offset')}<br/>
			<input type="number" name="image_watermark_vrt_offset" value="{set_value('image_watermark_vrt_offset', $settings.image_watermark_vrt_offset)}" id="image_watermark_vrt_offset" class="form-control {if !empty(form_error("image_watermark_vrt_offset"))}is-invalid{/if}">
		</div>
		<ul class="nav nav-tabs border-bottom pl-3 mt-4" id="image_watermark_tab" role="tablist">
			<li class="nav-item">
				<a class="nav-link p-2 pl-3 pr-3 {if empty($settings.image_watermark_path)}active{/if}" id="tab_image_watermark_text" data-toggle="tab" href="#tab_content_image_watermark_text" role="tab" aria-controls="tab_image_watermark_text" aria-selected="{if empty($settings.image_watermark_path)}true{else}false{/if}">{lang('text_image_watermark_text')}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link p-2 pl-3 pr-3 {if !empty($settings.image_watermark_path)}active{/if}" id="tab_image_watermark_path" data-toggle="tab" href="#tab_content_image_watermark_path" role="tab" aria-controls="tab_image_watermark_path" aria-selected="{if !empty($settings.image_watermark_path)}true{else}false{/if}">{lang('text_image_watermark_path')}</a>
			</li>
		</ul>
		<div class="tab-content border-0 p-3" id="tab_image_watermark_content">
			<div class="tab-pane fade {if empty($settings.image_watermark_path)}show active{/if}" role="tabpanel" id="tab_content_image_watermark_text"  aria-labelledby="tab_image_watermark_text">
				<div class="form-group">
					{lang('text_image_watermark_text')}
					<input type="text" name="image_watermark_text" value="{set_value('image_watermark_text', $settings.image_watermark_text)}" id="image_watermark_text" class="form-control {if !empty(form_error("image_watermark_text"))}is-invalid{/if}">
				</div>
				<div class="form-group">
					{lang('text_image_watermark_font_path')}
					<select name="image_watermark_font_path" class="form-control">
						<option value="" {if empty(set_value('image_watermark_font_path', $settings.image_watermark_font_path))}selected="selected"{/if}>{lang('text_none')}</option>
						{foreach get_fonts() as $key => $value}
							<option value="{$value}" {if set_value('image_watermark_font_path', $settings.image_watermark_font_path) eq $value}selected="selected"{/if}>{$key}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group">
					{lang('text_image_watermark_font_size')}
					<input type="number" name="image_watermark_font_size" value="{set_value('image_watermark_font_size', $settings.image_watermark_font_size)}" id="image_watermark_font_size" class="form-control">
				</div>
				<div class="form-group">
					{lang('text_image_watermark_font_color')}
					<input type="text" name="image_watermark_font_color" value="{set_value('image_watermark_font_color', $settings.image_watermark_font_color)}" id="image_watermark_font_color"  data-control="hue" class="form-control color-picker">
				</div>
				<div class="form-group">
					{lang('text_image_watermark_shadow_color')}
					<input type="text" name="image_watermark_shadow_color" value="{set_value('image_watermark_shadow_color', $settings.image_watermark_shadow_color)}" id="image_watermark_shadow_color" class="form-control color-picker">
				</div>
				<div class="form-group">
					{lang('text_image_watermark_shadow_distance')}
					<input type="number" name="image_watermark_shadow_distance" value="{set_value('image_watermark_shadow_distance', $settings.image_watermark_shadow_distance)}" id="image_watermark_shadow_distance" class="form-control">
				</div>
			</div>
			<div class="tab-pane fade {if !empty($settings.image_watermark_path)}show active{/if}" role="tabpanel" id="tab_content_image_watermark_path"  aria-labelledby="tab_image_watermark_path">
				<div class="form-group">
					<a href="javascript:void(0);" id="image_watermark_path" data-target="input_image_watermark_path" data-thumb="load_image_watermark_path" data-toggle="image" class="mx-0 mt-1">
						<img src="{if !empty(set_value('image_watermark_path', $settings.image_watermark_path))}{image_thumb_url(set_value('image_watermark_path', $settings.image_watermark_path))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 mr-1 img-fluid" alt="" title="" id="load_image_watermark_path" data-placeholder="{image_default_url()}"/>
						<button type="button" id="button-image-watemark" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt mr-1"></i>{lang('text_photo_edit')}</button>
						<button type="button" id="button-clear-watemark" class="button-clear btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash mr-1"></i>{lang('text_photo_clear')}</button>
					</a>
					<input type="hidden" name="image_watermark_path" value="{set_value('image_watermark_path', $settings.image_watermark_path)}" id="input_image_watermark_path" />
				</div>
				<div class="form-group">
					{lang('text_image_watermark_opacity')}
					{form_dropdown('image_watermark_opacity', $image_quality_list, set_value('image_watermark_opacity', $settings.image_watermark_opacity), ['class' => 'form-control'])}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group row d-none">
	<div class="col-12 col-sm-3 col-form-label text-sm-right">File demo get link</div>
	<div class="col-12 col-sm-8 col-lg-6">
		<input type="text" name="file_pdf" value="{set_value('file_pdf', $settings.file_pdf)}" id="input_file_pdf" class="form-control" />
		<a href="javascript:void(0);" id="file_pdf" data-target="input_file_pdf" data-toggle="image" class="mx-0 mt-1">
			<button type="button" id="button-image-pdf" class="button-image btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt mr-1"></i>{lang('text_photo_edit')}</button>
		</a>
	</div>
</div>
<div class="form-group row mt-3">
	<div class="col-12 col-sm-3 col-form-label text-sm-right"></div>
	<div class="col-12 col-sm-8 col-lg-6">
		<button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save mr-1"></i>{lang('button_save')}</button>
	</div>
</div>
{form_close()}