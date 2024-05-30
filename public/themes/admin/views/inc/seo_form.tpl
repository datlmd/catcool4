{strip}
	<div class="content-seo">
		<div class="badge badge-primary w-100 text-start pt-2 pb-2 fs-5" data-bs-toggle="collapse" href="#collapse_seo" aria-expanded="true" aria-controls="collapse_seo">
			<span class="fab fa-hubspot me-2"></span>{lang('Admin.text_seo_header_title')}
		</div>
		<div id="collapse_seo" class="collapse show mt-2">

			<div class="preview-meta-seo badge badge-light w-100 text-start my-3 p-3"
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

			<div class="form-group row mb-3">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<label for="input_seo_urls_{$language.id}_route" class="fw-bold">{lang('Admin.text_slug')}</label>
					<div class="input-group">
						<span class="input-group-text bg-linght pe-1" id="input_group_slug">{if !empty($name_seo_url)}{site_url($name_seo_url)}{else}{site_url()}{/if}</span>
						<input type="hidden" name="seo_urls[{$language.id}][route_old]" value="{$seo_urls[$language.id].route}">
						<input type="hidden" name="seo_urls[{$language.id}][language_id]" value="{$seo_urls[$language.id].language_id}">
						<input type="text" name="seo_urls[{$language.id}][route]" id="input_seo_urls_{$language.id}_route" data-is-slug="false" data-seo-id="seo_meta_url_{$language.id}" onkeyup="Catcool.setContentSeo(this);"  value='{old("seo_urls.`$language.id`.route", $seo_urls[$language.id].route)}' placeholder="{$seo_urls[$language.id].route}" aria-describedby="input_group_slug" class="form-control {if validation_show_error("seo_urls.`$language.id`.route")}is-invalid{/if}">
						<div class="invalid-feedback" id="error_seo_urls_{$language.id}_route">
							{validation_show_error("seo_urls.`$language.id`.route")}
						</div>
					</div>
					<small>Extension: {get_seo_extension()}</small><br/>
					<small>Example: {get_seo_extension('seo-url')}</small>
				</div>
			</div>

			<div class="form-group row mb-3">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="row">
						<label class="col-12 col-sm-6 ps-3 fw-bold" for="input_lang_{$language.id}_meta_title">{lang("Admin.text_seo_title")}</label>
						<div class="col-12 col-sm-6 pe-3 text-end">
							{lang("Admin.text_seo_lenght_input")} <span id="seo_meta_title_{$language.id}_length" data-target="input_lang_{$language.id}_meta_title" class="seo-meta-length"></span>/70
						</div>
					</div>
					<input type="text" name="lang[{$language.id}][meta_title]" id="input_lang_{$language.id}_meta_title" data-seo-id="seo_meta_title_{$language.id}" onkeyup="Catcool.setContentSeo(this);" value='{old("lang.`$language.id`.meta_title", $edit_data.lang[$language.id].meta_title)}' placeholder="{$edit_data.lang[$language.id].meta_title}" class="form-control {if validation_show_error("lang.`$language.id`.meta_title")}is-invalid{/if}">
					<div class="invalid-feedback" id="error_lang_{$language.id}_meta_title">
						{validation_show_error("lang.`$language.id`.meta_title")}
					</div>
				</div>
			</div>
			
			<div class="form-group row mb-3">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="row">
						<label class="col-12 col-sm-6 ps-3 fw-bold" for="input_lang_{$language.id}_meta_description">{lang("Admin.text_seo_description")}</label>
						<div class="col-12 col-sm-6 pe-3 text-end">
							{lang("Admin.text_seo_lenght_input")} <span id="seo_meta_description_{$language.id}_length" data-target="input_lang_{$language.id}_meta_description" class="seo-meta-length"></span>/320
						</div>
					</div>
					<textarea name="lang[{$language.id}][meta_description]" id="input_lang_{$language.id}_meta_description" cols="40" data-seo-id="seo_meta_description_{$language.id}" onkeyup="Catcool.setContentSeo(this);" rows="2" type="textarea" class="form-control">{old("lang.`$language.id`.meta_description", $edit_data.lang[$language.id].meta_description)}</textarea>
					<div id="error_lang_{$language.id}_meta_description" class="invalid-feedback"></div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<label class="fw-bold" for="input_lang_{$language.id}_meta_keyword">{lang("Admin.text_seo_keyword")}</label>
					<input type="text" name="lang[{$language.id}][meta_keyword]" id="input_lang_{$language.id}_meta_keyword" value='{old("lang.`$language.id`.meta_keyword", $edit_data.lang[$language.id].meta_keyword)}' class="form-control" data-role="tagsinput">
					<div id="error_lang_{$language.id}_meta_keyword" class="invalid-feedback"></div>
				</div>
			</div>

		</div>
	</div>
{/strip}
