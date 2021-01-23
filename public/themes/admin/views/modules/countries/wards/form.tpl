{assign var="class_colum_label" value="col-12 col-sm-3 col-form-label required-label text-sm-right"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.ward_id)}
            {form_hidden('id', $edit_data.ward_id)}
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
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.ward_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            {lang('text_name', 'text_name', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="name" value="{set_value('name', $edit_data.name)}" id="name" class="form-control {if !empty($errors["name"])}is-invalid{/if}">
                                {if !empty($errors["name"])}
                                    <div class="invalid-feedback">{$errors["name"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_type', 'text_type', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="type" value="{set_value('type', $edit_data.type)}" id="type" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_lati_long_tude', 'text_lati_long_tude', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="lati_long_tude" value="{set_value('lati_long_tude', $edit_data.lati_long_tude)}" id="lati_long_tude" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_sort_order', 'text_sort_order', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="sort_order" value="{set_value('sort_order', $edit_data.sort_order)}" id="sort_order" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_country', 'text_country', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_dropdown('country_id', $country_list, set_value('country_id', $edit_data.country_id), ['class' => 'form-control country-changed'])}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_province', 'text_province', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_dropdown('province_id', $province_list, set_value('province_id', $edit_data.province_id), ['class' => 'form-control province-changed'])}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_district', 'text_district', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_dropdown('district_id', $district_list, set_value('district_id', $edit_data.district_id), ['class' => 'form-control district-changed'])}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_published', 'text_published', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
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
