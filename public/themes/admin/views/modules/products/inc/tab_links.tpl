{strip}

	{form_hidden('tab_type', 'tab_links')}


	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_filter')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{$filter_ids = old('filter_ids', $edit_data.filter_ids)|default:[]}
			<select name="filter_ids[]" id="input_filter_ids[]" data-target="#filter_review" class="form-select form-select-sm cc-form-select-multi" multiple="multiple" data-placeholder="{lang('Admin.text_select')}">
				{foreach $filter_list as $value}
					<option value="{$value.filter_id}" {if in_array($value.filter_id, $filter_ids)}selected="selected"{/if}>{$value.name}</option>
				{/foreach}
			</select>
		</div>
	</div>

{*	<div class="form-group row">*}
{*		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_store')}</div>*}
{*		<div class="col-12 col-sm-10 col-lg-10">*}
{*		</div>*}
{*	</div>*}

{*	<div class="form-group row">*}
{*		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_download')}</div>*}
{*		<div class="col-12 col-sm-10 col-lg-10">*}

{*		</div>*}
{*	</div>*}

	<div class="form-group row">
		<div class="col-12 col-sm-2 col-form-label text-sm-end">{lang('ProductAdmin.text_related')}</div>
		<div class="col-12 col-sm-10 col-lg-10">
			{include file=get_theme_path('views/inc/related.tpl') related_input_name="related" id="{$edit_data.product_id}" related_url='products/manage/related' related_list_html=$edit_data.related_list_html}
		</div>
	</div>

{/strip}
