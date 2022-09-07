{strip}

	{form_hidden('tab_type', 'tab_images')}

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_image')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<a href="javascript:void(0);" id="image" class="ms-0" data-target="input_image" data-thumb="load_image_url" data-type="image" data-bs-toggle="image">
				<img src="{if !empty($edit_data.image)}{image_thumb_url($edit_data.image)}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_image_url" data-placeholder="{image_default_url()}"/>
				<div class="btn-group w-100 mt-1" role="group">
					<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
					<button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
				</div>

			</a>
			<input type="hidden" name="image" value="{$edit_data.image}" id="input_image" />
		</div>
	</div>

	<div id="product_image_list" class="card">
		<h5 class="card-header">{lang('ProductAdmin.text_images')}</h5>
		<div class="card-body">
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-start">{lang('Admin.text_image')}</th>
					<th class="text-start">{lang('Admin.text_sort_order')}</th>
					<th width="70"></th>
				</tr>
				</thead>
				<tbody>
				{if !empty($edit_data.image_list)}
					{counter assign=product_image_row start=1 print=false}

					{foreach $edit_data.image_list as $value}
						<tr id="product_image_row_{$product_image_row}">
							<td class="text-start">

								<input type="hidden" name="product_image[{$product_image_row}][product_image_id]" value="{$value.product_image_id}" />

								<a href="javascript:void(0);" class="ms-0" id="product_image_{$product_image_row}_image" data-target="input_product_image_{$product_image_row}_image" data-thumb="product_image_{$product_image_row}_load_image_url" data-type="image" data-bs-toggle="image">
									<img src="{if !empty($value.image)}{image_thumb_url($value.image)}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="product_image_{$product_image_row}_load_image_url" data-placeholder="{image_default_url()}"/>
									<div class="btn-group w-100 mt-1" role="group">
										<button type="button" id="button-image-logo" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
										<button type="button" id="button-clear-logo" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
									</div>

								</a>
								<input type="hidden" name="product_image[{$product_image_row}][image]" value="{$value.image}" id="input_product_image_{$product_image_row}_image" />

							</td>
							<td class="text-start">
								<input type="number" name="product_image[{$product_image_row}][sort_order]" value="{$value.sort_order}" id="input_product_image_{$product_image_row}_sort_order" min="0" placeholder="{lang('Admin.text_sort_order')}" class="form-control"/>
								<div id="error_product_image_{$product_image_row}_sort_order" class="invalid-feedback"></div>
							</td>
							<td class="text-end">
								<button type="button" onclick="$('#product_image_row_{$product_image_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
							</td>
						</tr>

						{counter}

					{/foreach}
				{/if}

				</tbody>
				<tfoot>
				<tr>
					<td colspan="2"></td>
					<td class="text-center"><button type="button" onclick="addProductImage();" data-bs-toggle="tooltip" title="{lang('ProductAdmin.text_image_add')}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button></td>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>

{/strip}
