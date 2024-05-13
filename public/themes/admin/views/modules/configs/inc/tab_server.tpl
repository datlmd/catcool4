{strip}
    {form_open(uri_string(), ['id' => 'form_server'])}
    {form_hidden('tab_type', 'tab_server')}
    <div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_general')}</div>
    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_maintenance">{lang('ConfigAdmin.text_maintenance')}</label>
        <div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">

            <div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="maintenance" id="input_maintenance"
					{set_checkbox('maintenance', 1, $settings.maintenance|default:false)} value="1">
			</div>

        </div>
    </div>
    <div class="row" style="margin-top: -5px;">
		<div class="col-12 col-sm-3"></div>
		<label class="col-12 col-sm-8 col-lg-6 form-text">{lang('ConfigAdmin.help_maintenance')}</label>
	</div>

    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_seo_url">{lang('ConfigAdmin.text_seo_url')}</label>
        <div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">

            <div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="seo_url" id="input_seo_url"
					{set_checkbox('seo_url', 1, $settings.seo_url|default:false)} value="1">
			</div>

        </div>
    </div>
    <div class="row" style="margin-top: -5px;">
        <div class="col-12 col-sm-3"></div>
        <label class="col-12 col-sm-8 col-lg-6 form-text">{lang('ConfigAdmin.help_seo_url')}</label>
    </div>

    <div class="form-group row mb-3">
        <label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_robots">{lang('ConfigAdmin.text_robots')}</label>
        <div class="col-12 col-sm-8 col-lg-6">
            <textarea type="textarea" name="robots" id="input_robots" cols="40" rows="5" class="form-control {if validation_show_error("robots")}is-invalid{/if}">{str_replace('|', PHP_EOL, old('robots', $settings.robots))}</textarea>
            <div class="invalid-feedback">
                {validation_show_error("robots")}
            </div>
            <small>{lang('ConfigAdmin.help_robots')}</small>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_compression">{lang('ConfigAdmin.text_compression')}</label>
        <div class="col-12 col-sm-8 col-lg-6">
            <input type="number" name="compression" value="{old('compression', $settings.compression)|default:0}" id="input_compression" class="form-control">
            <small>{lang('ConfigAdmin.help_compression')}</small>
        </div>
    </div>

    <div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang(lang('ConfigAdmin.text_security'))}</div>
    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-end" for="input_force_global_secure_requests">{lang('ConfigAdmin.text_enable_ssl')}</label>
        <div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1" style="min-height: 25px;">

            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="force_global_secure_requests" id="input_force_global_secure_requests"
                    {set_checkbox('force_global_secure_requests', 1, $settings.force_global_secure_requests|default:false)} value="1">
            </div>
        
        </div>
    </div>
    <div class="row" style="margin-top: -5px;">
        <div class="col-12 col-sm-3"></div>
        <label class="col-12 col-sm-8 col-lg-6 form-text">{lang('ConfigAdmin.help_enable_ssl')}</label>
    </div>

    <div class="form-group row mt-3">
        <div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
        <div class="col-12 col-sm-8 col-lg-6 ms-0">
            <button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
        </div>
    </div>
    {form_close()}
{/strip}
