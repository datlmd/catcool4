{strip}

	{form_hidden('tab_type', 'tab_images')}



	<ul id="product_image_thumb_list" class="sortable_photos photo-list mt-2">
		{if $edit_data.image_list}
			{counter assign=product_image_row start=1 print=false}

			{foreach $edit_data.image_list as $value_image}
				<li class="photo-item">
					{if stripos($value_image.image, 'root/') !== false}
						<a href="javascript:void(0);" class="ms-0" id="product_image_{$product_image_row}_image" data-target="input_product_image_{$product_image_row}_image" data-thumb="product_image_{'product_image_row_value'}_load_image_url" data-type="image" data-bs-toggle="image">
							<img src="{image_thumb_url($value_image.image)}" style="background-image: url('{image_thumb_url($value_image.image)}')"  alt="" title="" id="product_image_{$product_image_row}_load_image_url" data-is-background="true" data-placeholder="{image_default_url()}"/>
							<div class="btn-group w-100 mt-1" role="group">
								<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-light" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
								<button type="button" onclick="$(this).parent().parent().parent().remove();" class="btn btn-xs btn-light" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
							</div>
						</a>
					{else}
						<a href="{image_url($value_image.image)}" data-lightbox="products">
							<img src="" class="img-backgroud" style="background-image: url('{image_thumb_url($value_image.image)}')" alt="" title="" id="product_image_{$product_image_row}_load_image_url" />
						</a>
						<div class="btn-group w-100 mt-1" role="group">
							<button type="button" id="button-image-crop" class="btn btn-xs btn-light" onclick="Catcool.cropImage('{$value_image.image}', 1, this);"><i class="fas fa-crop"></i></button>
							<button type="button" id="button-image-delete" onclick="$(this).parent().parent().remove();" class="btn btn-xs btn-light"><i class="fas fa-trash"></i></button>
						</div>
					{/if}

					<input type="hidden" name="product_image[{$product_image_row}][product_image_id]" value="{$value_image.product_image_id}" />
					<input type="hidden" name="product_image[{$product_image_row}][image]" value="{$value_image.image}" id="input_product_image_{$product_image_row}_image" />
				</li>
				{counter}
			{/foreach}
		{/if}
	</ul>

	<div class="w-100 text-end">
		<button type="button" onclick="addProductImage();" data-bs-toggle="tooltip" title="{lang('ProductAdmin.text_image_add')}" class="btn btn-xs btn-primary"><i class="fas fa-plus me-1"></i>{lang("Image.select_file_manager")}</button>
	</div>

	<div class="drop-drap-file" data-is-multi="multiple" data-module="products" data-image-id="image_image_thumb" data-input-name="image" data-image-class="rounded-circle shadow-sm img-backgroud img-w-200 img-h-200">
		<input type="file" name="file" id="file" multiple accept="audio/*,video/*,image/*" /> {*multiple*}
		<div class="upload-area dropzone dz-clickable " id="uploadfile">
			<h5 class="dz-message py-3">
				<i class="fas fa-plus me-1 text-success"></i><i class="fas fa-image text-success"></i><br/>
				<small>{lang("Admin.text_upload_drop_drap")}</small>
			</h5>
		</div>
	</div>
	<div id="image_error" class="text-danger"></div>

{/strip}
