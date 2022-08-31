{strip}

	{form_hidden('tab_type', 'tab_links')}

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_manufacturer')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{if !empty($manufacturer_list)}
				<select name="manufacturer_id" id="input_manufacturer_id" class="form-control form-control-sm">
					<option value="0">{lang('Admin.text_select')}</option>
					{foreach $manufacturer_list as $value}
						<option value="{$value.manufacturer_id}" {if old('manufacturer_id', $edit_data.manufacturer_id) eq $value.manufacturer_id}selected="selected"{/if}>{$value.name}</option>
					{/foreach}
				</select>
			{/if}
			<div id="error_manufacturer_id" class="invalid-feedback"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('Admin.text_category')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
			<select name="category_ids[]" id="input_category_ids[]" class="form-control form-control-sm multiselect" multiple="multiple" title="{lang('Admin.text_select')}">
				{draw_tree_output_name(['data' => $categories_tree, 'key_id' => 'category_id'], $output_html, 0, old('category_ids', $edit_data.category_ids))}
			</select>
			<div id="category_review" class="w-100 p-3 bg-light"></div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_filter')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			<select name="filter_ids[]" id="input_filter_ids[]" data-target="#filter_review" class="form-control form-control-sm multiselect" multiple="multiple" title="{lang('Admin.text_select')}">
				{foreach $filter_list as $value}
					<option value="{$value.filter_id}" {if in_array($value.filter_id, old('filter_ids', $edit_data.filter_ids))}selected="selected"{/if}>{$value.name}</option>
				{/foreach}
			</select>
			<div id="filter_review" class="w-100 p-3 bg-light multiselect-review">
				{if !empty($filter_list)}
					<ul class="list-unstyled bullet-check mb-0">
						{foreach $filter_list as $value}
							{if !in_array($value.filter_id, old('filter_ids', $edit_data.filter_ids))}
								{continue}
							{/if}
							<li>{$value.name}</li>
						{/foreach}
					</ul>
				{/if}
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_store')}</div>
		<div class="col-12 col-sm-10 col-lg-10">

		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_download')}</div>
		<div class="col-12 col-sm-10 col-lg-10">

		</div>
	</div>

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_related')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{include file=get_theme_path('views/inc/related.tpl') related_input_name="related" related_url='products/manage/related' related_list_html=$edit_data.related_list_html}
		</div>
	</div>

{/strip}
