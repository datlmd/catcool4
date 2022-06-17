{strip}
	<div class="content-seo bg-light p-2">
		<div class="badge badge-info w-100 text-start pt-2 pb-2" data-bs-toggle="collapse" href="#collapse_seo" aria-expanded="true" aria-controls="collapse_seo">
			<span class="fab fa-hubspot me-2"></span>{lang('Admin.text_seo_header_title')}
		</div>
		<div id="collapse_seo" class="collapse show mt-2">
			<div class="preview-meta-seo badge badge-light w-100 text-start my-2 p-3"
				 {if empty($edit_data.lang[$language.id].meta_title) && empty($seo_urls[$language.id].route) && empty($edit_data.lang[$language.id].meta_description)}
					 style="display: none;"
				 {/if}
			>
				<p class="meta-seo-title" id="seo_meta_title_{$language.id}">{old("lang.`$language.id`.meta_title", $edit_data.lang[$language.id].meta_title)}</p>
				<p class="meta-seo-url" >
					{if !empty($name_seo_url)}{site_url($name_seo_url)}{else}{site_url()}{/if}
					<span id="seo_meta_url_{$language.id}">{old("seo_urls.`$language.id`.route", $seo_urls[$language.id].route)}</span>
				</p>
				<p class="meta-seo-description" id="seo_meta_description_{$language.id}">{old("lang.`$language.id`.meta_description", $edit_data.lang[$language.id].meta_description)}</p>
			</div>
			<div class="form-group row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="row">
						<div class="col-12 col-sm-6 ps-3">{lang("Admin.text_seo_title")}</div>
						<div class="col-12 col-sm-6 pe-3 text-end">
							{lang("Admin.text_seo_lenght_input")} <span id="seo_meta_title_{$language.id}_length" data-target="input_meta_title_{$language.id}" class="seo-meta-length"></span>/70
						</div>
					</div>
					<input type="text" name="lang[{$language.id}][meta_title]" data-seo-id="seo_meta_title_{$language.id}" onkeyup="Catcool.setContentSeo(this);" value='{old("lang.`$language.id`.meta_title", $edit_data.lang[$language.id].meta_title)}' placeholder="{$edit_data.lang[$language.id].meta_title}" id="input_meta_title_{$language.id}" class="form-control {if $validator->hasError("lang.`$language.id`.meta_title")}is-invalid{/if}">
					<div class="invalid-feedback">
						{$validator->getError("lang.`$language.id`.meta_title")}
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					{lang('Admin.text_slug')}
					<div class="input-group">
						<span class="input-group-text bg-linght pe-1" id="input_group_slug">{if !empty($name_seo_url)}{site_url($name_seo_url)}{else}{site_url()}{/if}</span>
						<input type="hidden" name="seo_urls[{$language.id}][route_old]" value="{$seo_urls[$language.id].route}">
						<input type="hidden" name="seo_urls[{$language.id}][language_id]" value="{$seo_urls[$language.id].language_id}">
						<input type="text" name="seo_urls[{$language.id}][route]" data-is-slug="false" data-seo-id="seo_meta_url_{$language.id}" onkeyup="Catcool.setContentSeo(this);"  value='{old("seo_urls.`$language.id`.route", $seo_urls[$language.id].route)}' placeholder="{$seo_urls[$language.id].route}" id="input_slug_{$language.id}" aria-describedby="input_group_slug" class="form-control {if $validator->hasError("seo_urls.`$language.id`.route")}is-invalid{/if}">
						<div class="invalid-feedback">
							{$validator->getError("seo_urls.`$language.id`.route")}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="row">
						<div class="col-12 col-sm-6 ps-3">{lang("Admin.text_seo_description")}</div>
						<div class="col-12 col-sm-6 pe-3 text-end">
							{lang("Admin.text_seo_lenght_input")} <span id="seo_meta_description_{$language.id}_length" data-target="input_meta_description_{$language.id}" class="seo-meta-length"></span>/320
						</div>
					</div>
					<textarea name="lang[{$language.id}][meta_description]" cols="40" data-seo-id="seo_meta_description_{$language.id}" onkeyup="Catcool.setContentSeo(this);" rows="2" id="input_meta_description_{$language.id}" type="textarea" class="form-control">{old("lang.`$language.id`.meta_description", $edit_data.lang[$language.id].meta_description)}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					{lang("Admin.text_seo_keyword")}
					<input type="text" name="lang[{$language.id}][meta_keyword]" value='{old("lang.`$language.id`.meta_keyword", $edit_data.lang[$language.id].meta_keyword)}' id="input_meta_keyword_{$language.id}" class="form-control" data-role="tagsinput">
				</div>
			</div>
		</div>
	</div>
{/strip}
