{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}

        {if !empty($edit_data.currency_id)}
            {form_hidden('currency_id', $edit_data.currency_id)}
        {/if}
        <div class="row">

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="currencies"}
            </div>

            <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

                <div class="row">
                    <div class="col-sm-7 col-12">
                        {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('CurrencyAdmin.heading_title')}
                    </div>
                    <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                        <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                        <a href="{back_to($manage_url)}" class="btn btn-sm btn-space btn-secondary me-0 mb-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                    </div>
                </div>

                {if !empty(print_flash_alert())}
                    {print_flash_alert()}
                {/if}
                {if !empty($errors)}
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                {/if}

                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.currency_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('CurrencyAdmin.text_name')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="name" value="{old('name', $edit_data.name)}" id="name" class="form-control {if validation_show_error('name')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("name")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_code')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="code" value="{old('code', $edit_data.code)}" id="code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_symbol_left')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="symbol_left" value="{old('symbol_left', $edit_data.symbol_left)}" id="symbol_left" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_symbol_right')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="symbol_right" value="{old('symbol_right', $edit_data.symbol_right)}" id="symbol_right" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_decimal_place')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="decimal_place" value="{old('decimal_place', $edit_data.decimal_place)}" id="decimal_place" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label">
                                {lang('CurrencyAdmin.text_value')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="value" value="{set_value('value', $edit_data.value)}" id="value" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end col-form-label" for="input_published">
                                {lang('Admin.text_published')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6 form-control-lg py-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="published" id="input_published"
                                        {set_checkbox('published', 1, $edit_data.published|default:true)} value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
{/strip}
