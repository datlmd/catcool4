{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
	<div class="row">
		<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
			{lang('Admin.filter_name')}
			{form_input('name', set_value('name', $filter.name), ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_name')])}
		</div>
		<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
			{lang('Admin.filter_id')}
			{form_input('post_id', set_value('post_id', $filter.post_id), ['class' => 'form-control form-control-sm', 'placeholder' => lang('Admin.filter_id')])}
		</div>
		<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
			{lang('Admin.text_category')}
			{$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
			<select name="category_id" id="category_id" class="form-control">
				<option value="">{lang('Admin.text_select')}</option>
				{draw_tree_output_name(['data' => $category_list, 'key_id' => 'category_id'], $output_html, 0, $filter.category_id)}
			</select>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
			{lang('Admin.text_limit')}
			{form_dropdown('limit', get_list_limit(), set_value('limit', $filter.limit), ['class' => 'form-control form-control-sm'])}
		</div>
		<div class="col-12 text-end">
			{if !empty($is_trash) && $is_trash == 1}
				<input type="hidden" name="is_trash" value="1">
			{/if}
			<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>{lang('Admin.filter_submit')}</button>
		</div>
	</div>
{form_close()}