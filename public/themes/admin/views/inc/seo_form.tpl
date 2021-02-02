{strip}
<div class="content-seo">
	<div class="badge badge-info w-100 text-start pt-2 pb-2" data-bs-toggle="collapse" data-target="#collapse_seo" aria-expanded="true" aria-controls="collapse_seo">
		<span class="fab fa-hubspot me-2"></span>{lang('text_seo_header_title')}
	</div>
	<div id="collapse_seo" class="collapse show mt-2">
		<div class="preview-meta-seo badge badge-light w-100 text-start my-2 p-3" {if empty($edit_data.details[$language.id].meta_title) && empty($seo_urls[$language.id].route) && empty($edit_data.details[$language.id].meta_description)}style="display: none;"{/if}>
			<p class="meta-seo-title" id="seo_meta_title_{$language.id}">{set_value("manager_description[`$language.id`][meta_title]", $edit_data.details[$language.id].meta_title)}</p>
			<p class="meta-seo-url" id="seo_meta_url_{$language.id}">{set_value("seo_urls[`$language.id`][route]", $seo_urls[$language.id].route)}</p>
			<p class="meta-seo-description" id="seo_meta_description_{$language.id}">{set_value("manager_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}</p>
		</div>
		<div class="form-group row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="row">
					<div class="col-12 col-sm-6 ps-3">{lang("text_seo_title")}</div>
					<div class="col-12 col-sm-6 pe-3 text-end">
                        {lang("text_seo_lenght_input")} <span id="seo_meta_title_{$language.id}_length" data-target="input_meta_title_{$language.id}" class="seo-meta-length"></span>/70
					</div>
				</div>
				<input type="text" name="manager_description[{$language.id}][meta_title]" data-seo-id="seo_meta_title_{$language.id}" onkeyup="Catcool.setContentSeo(this);" value='{set_value("manager_description[`$language.id`][meta_title]", $edit_data.details[$language.id].meta_title)}' placeholder="{$edit_data.details[$language.id].meta_title}" id="input_meta_title_{$language.id}" class="form-control {if !empty(form_error("manager_description[`$language.id`][meta_title]"))}is-invalid{/if}">
                {if !empty(form_error("manager_description[{$language.id}][meta_title]"))}
					<div class="invalid-feedback">{form_error("manager_description[{$language.id}][meta_title]")}</div>
                {/if}
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				{lang('text_slug')}
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text bg-linght pe-0" id="input_group_slug">{site_url($name_seo_url)}</span>
					</div>
					<input type="hidden" name="seo_urls[{$language.id}][id]" value="{$seo_urls[$language.id].id}">
					<input type="text" name="seo_urls[{$language.id}][route]" data-is-slug="true" data-seo-id="seo_meta_url_{$language.id}" onkeyup="Catcool.setContentSeo(this);"  value='{set_value("seo_urls[`$language.id`][route]", $seo_urls[$language.id].route)}' placeholder="{$seo_urls[$language.id].route}" id="input_slug_{$language.id}" describedby="input_group_slug" class="form-control form-control-lg ps-0 border-left-0 {if !empty($errors["seo_url_{$language.id}"])}is-invalid{/if}">
                    {if !empty($errors["seo_url_{$language.id}"])}
						<div class="invalid-feedback">{$errors["seo_url_{$language.id}"]}</div>
                    {/if}
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="row">
					<div class="col-12 col-sm-6 ps-3">{lang("text_seo_description")}</div>
					<div class="col-12 col-sm-6 pe-3 text-end">
                        {lang("text_seo_lenght_input")} <span id="seo_meta_description_{$language.id}_length" data-target="input_meta_description_{$language.id}" class="seo-meta-length"></span>/320
					</div>
				</div>
				<textarea name="manager_description[{$language.id}][meta_description]" cols="40" data-seo-id="seo_meta_description_{$language.id}" onkeyup="Catcool.setContentSeo(this);" rows="2" id="input_meta_description_{$language.id}" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}</textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                {lang("text_seo_keyword")}
				<input type="text" name="manager_description[{$language.id}][meta_keyword]" value='{set_value("manager_description[`$language.id`][meta_keyword]", $edit_data.details[$language.id].meta_keyword)}' id="input_meta_keyword_{$language.id}" class="form-control">
			</div>
		</div>
	</div>
</div>
{/strip}
