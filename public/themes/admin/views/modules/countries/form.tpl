{assign var="class_colum_label" value="col-12 col-sm-3 col-form-label required-label text-sm-end"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.country_id)}
            {form_hidden('id', $edit_data.country_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.country_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            {lang('text_name', 'text_name', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="name" value="{set_value('name', $edit_data.name)}" id="name" class="form-control {if !empty($errors["name"])}is-invalid{/if}">
                                {if !empty($errors["name"])}
                                    <div class="invalid-feedback">{$errors["name"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_formal_name', 'text_formal_name', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="formal_name" value="{set_value('formal_name', $edit_data.formal_name)}" id="formal_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_country_code', 'text_country_code', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="country_code" value="{set_value('country_code', $edit_data.country_code)}" id="country_code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_country_code3', 'text_country_code3', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="country_code3" value="{set_value('country_code3', $edit_data.country_code3)}" id="country_code3" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_country_type', 'text_country_type', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="country_type" value="{set_value('country_type', $edit_data.country_type)}" id="country_type" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_country_sub_type', 'text_country_sub_type', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="country_sub_type" value="{set_value('country_sub_type', $edit_data.country_sub_type)}" id="country_sub_type" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_sovereignty', 'text_sovereignty', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="sovereignty" value="{set_value('sovereignty', $edit_data.sovereignty)}" id="sovereignty" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_capital', 'text_capital', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="capital" value="{set_value('capital', $edit_data.capital)}" id="capital" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_currency_code', 'text_currency_code', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="currency_code" value="{set_value('currency_code', $edit_data.currency_code)}" id="currency_code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_currency_name', 'text_currency_name', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="currency_name" value="{set_value('currency_name', $edit_data.currency_name)}" id="currency_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_telephone_code', 'text_telephone_code', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="telephone_code" value="{set_value('telephone_code', $edit_data.telephone_code)}" id="telephone_code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_country_number', 'text_country_number', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="country_number" value="{set_value('country_number', $edit_data.country_number)}" id="country_number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_internet_country_code', 'text_internet_country_code', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="internet_country_code" value="{set_value('internet_country_code', $edit_data.internet_country_code)}" id="internet_country_code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_flags', 'text_flags', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="flags" value="{set_value('flags', $edit_data.flags)}" id="flags" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_sort_order', 'text_sort_order', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="sort_order" value="{set_value('sort_order', $edit_data.sort_order)}" id="sort_order" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_published', 'text_published', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button switch-button-xs mt-2">
                                    {if isset($edit_data.published)}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, ($edit_data.published == STATUS_ON))} id="published">
                                    {else}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, true)} id="published">
                                    {/if}
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
