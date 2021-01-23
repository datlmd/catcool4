{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.dummy_id)}
            {form_hidden('dummy_id', $edit_data.dummy_id)}
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
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.dummy_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
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
                            {lang('text_description', 'text_description', ['class' => 'col-12 col-sm-3 col-form-label text-sm-end'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <textarea name="description" cols="20" rows="2" id="description" type="textarea" class="form-control">{set_value("description", $edit_data.description)}</textarea>
                            </div>
                        </div>
                        {*TPL_DUMMY_ROOT*}
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
