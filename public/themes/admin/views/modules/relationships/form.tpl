{strip}
{form_hidden('manage_url', site_url($manage_url))}
<div class="container-fluid  dashboard-content">

    {form_open(uri_string(), ['id' => 'validationform'])}

        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
        {/if}
        <div class="row">

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                {include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="relationships"}
            </div>

            <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

                <div class="row">
                    <div class="col-sm-7 col-12">
                        {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('RelationshipAdmin.heading_title')}
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
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('RelationshipAdmin.text_candidate_table')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="candidate_table" value="{old('candidate_table', $edit_data.candidate_table)}" id="candidate_table" class="form-control {if validation_show_error('candidate_table')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("candidate_table")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('RelationshipAdmin.text_candidate_key')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="candidate_key" value="{old('candidate_key', $edit_data.candidate_key)}" id="candidate_key" class="form-control {if validation_show_error('candidate_key')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("candidate_key")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('RelationshipAdmin.text_foreign_table')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="foreign_table" value="{old('foreign_table', $edit_data.foreign_table)}" id="foreign_table" class="form-control {if validation_show_error('foreign_table')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("foreign_table")}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                {lang('RelationshipAdmin.text_foreign_key')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="foreign_key" value="{old('foreign_key', $edit_data.foreign_key)}" id="foreign_key" class="form-control {if validation_show_error('foreign_key')}is-invalid{/if}">
                                <div class="invalid-feedback">{validation_show_error("foreign_key")}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
{/strip}
