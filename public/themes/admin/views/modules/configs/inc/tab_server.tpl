{strip}
    {form_open(uri_string(), ['id' => 'form_server'])}
    {form_hidden('tab_type', 'tab_server')}
    <div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang('ConfigAdmin.text_general')}</div>
    <div class="form-group row">
        <div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_maintenance')}</div>
        <div class="col-12 col-sm-8 col-lg-6 pt-2">
            <label class="form-check form-check-inline">
                <input type="radio" name="maintenance" value="{STATUS_ON}" {if !empty(old('maintenance', $settings.maintenance))}checked="checked"{/if} id="maintenance_on" class="form-check-input">
                <label class="form-check-label" for="maintenance_on">{lang('Admin.text_on')}</label>
            </label>
            <label class="form-check form-check-inline me-2">
                <input type="radio" name="maintenance" value="{STATUS_OFF}" {if empty(old('maintenance', $settings.maintenance))}checked="checked"{/if} id="maintenance_off" class="form-check-input">
                <label class="form-check-label" for="maintenance_off">{lang('Admin.text_off')}</label>
            </label>
            <br/>
            <small>{lang('ConfigAdmin.help_maintenance')}</small>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_seo_url')}</div>
        <div class="col-12 col-sm-8 col-lg-6 pt-2">
            <label class="form-check form-check-inline">
                <input type="radio" name="seo_url" value="{STATUS_ON}" {if !empty(old('seo_url', $settings.seo_url))}checked="checked"{/if} id="seo_url_on" class="form-check-input">
                <label class="form-check-label" for="seo_url_on">{lang('Admin.text_on')}</label>
            </label>
            <label class="form-check form-check-inline me-2">
                <input type="radio" name="seo_url" value="{STATUS_OFF}" {if empty(old('seo_url', $settings.seo_url))}checked="checked"{/if} id="seo_url_off" class="form-check-input">
                <label class="form-check-label" for="seo_url_off">{lang('Admin.text_off')}</label>
            </label>
            <br/>
            <small>{lang('ConfigAdmin.help_seo_url')}</small>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_robots')}</div>
        <div class="col-12 col-sm-8 col-lg-6">
            <textarea type="textarea" name="robots" id="robots" cols="40" rows="5" class="form-control {if validation_show_error("robots")}is-invalid{/if}">{str_replace('|', PHP_EOL, old('robots', $settings.robots))}</textarea>
            <div class="invalid-feedback">
                {validation_show_error("robots")}
            </div>
            <small>{lang('ConfigAdmin.help_robots')}</small>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_compression')}</div>
        <div class="col-12 col-sm-8 col-lg-6">
            <input type="number" name="compression" value="{old('compression', $settings.compression)|default:0}" id="compression" class="form-control">
            <small>{lang('ConfigAdmin.help_compression')}</small>
        </div>
    </div>

    <div class="border-bottom mx-3 lead pb-1 my-3 fw-bold">{lang(lang('ConfigAdmin.text_security'))}</div>
    <div class="form-group row">
        <div class="col-12 col-sm-3 col-form-label text-sm-end">{lang('ConfigAdmin.text_enable_ssl')}</div>
        <div class="col-12 col-sm-8 col-lg-6 pt-2">
            <label class="form-check form-check-inline">
                <input type="radio" name="force_global_secure_requests" value="{STATUS_ON}" {if !empty(old('force_global_secure_requests', $settings.force_global_secure_requests))}checked="checked"{/if} id="force_global_secure_requests_on" class="form-check-input">
                <label class="form-check-label" for="force_global_secure_requests_on">{lang('Admin.text_on')}</label>
            </label>
            <label class="form-check form-check-inline me-2">
                <input type="radio" name="force_global_secure_requests" value="{STATUS_OFF}" {if empty(old('force_global_secure_requests', $settings.force_global_secure_requests))}checked="checked"{/if} id="force_global_secure_requests_off" class="form-check-input">
                <label class="form-check-label" for="force_global_secure_requests_off">{lang('Admin.text_off')}</label>
            </label>
            <br/>
            <small>{lang('ConfigAdmin.help_enable_ssl')}</small>
        </div>
    </div>
    <div class="form-group row mt-3">
        <div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
        <div class="col-12 col-sm-8 col-lg-6 ms-0">
            <button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
        </div>
    </div>
    {form_close()}
{/strip}
