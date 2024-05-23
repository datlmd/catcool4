{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">

        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
                {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="locations"}
            </div>

            <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
        
                {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}
                    <input type="hidden" name="location_id" value="{$edit_data.location_id}">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-7 col-12">
                                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('LocationAdmin.heading_title')}
                                </div>
                                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                                    <a href="{back_to($manage_url)}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                                </div>
                            </div>

                            {if !empty(print_flash_alert())}
                                {print_flash_alert()}
                            {/if}
                            {if !empty($errors)}
                                {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                            {/if}

                            <div class="card">
                                <h5 class="card-header"><i class="fas {if !empty($edit_data.location_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                                <div class="card-body">
                                    <div class="form-group row required has-error pb-3">
                                        <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                            {lang('LocationAdmin.text_name')}
                                        </label>
                                        <div class="col-12 col-sm-8 col-lg-7">
                                            <input type="text" name="name" value="{old('name', $edit_data.name)}" id="input_name" placeholder="{lang('LocationAdmin.text_name')}"
                                                class="form-control {if !empty(validation_show_error('name'))}is-invalid{/if}">
                                            <div id="error_name" class="invalid-feedback">
                                                {validation_show_error('name')}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row border-top py-3">
                                        <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                            {lang('LocationAdmin.text_address')}
                                        </label>
                                        <div class="col-12 col-sm-8 col-lg-7">
                                            <textarea name="address" rows="5" placeholder="{lang('LocationAdmin.text_address')}" id="input_address"
                                                    class="form-control {if !empty(validation_show_error('address'))}is-invalid{/if}">
                                                {old('address', $edit_data.address)}
                                            </textarea>
                                            <div id="error_address" class="invalid-feedback">
                                                {validation_show_error('address')}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row border-top py-3">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                            {lang('LocationAdmin.text_telephone')}
                                        </label>
                                        <div class="col-12 col-sm-8 col-lg-7">
                                            <input type="text" name="telephone" value="{old('telephone', $edit_data.telephone)}" id="input_telephone" placeholder="{lang('LocationAdmin.text_telephone')}"
                                                class="form-control {if !empty(validation_show_error('telephone'))}is-invalid{/if}">
                                            <div id="error_telephone" class="invalid-feedback">
                                                {validation_show_error('telephone')}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row border-top py-3">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                            {lang('LocationAdmin.text_geocode')}
                                        </label>
                                        <div class="col-12 col-sm-8 col-lg-7">
                                            <input type="text" name="geocode" value="{old('geocode', $edit_data.geocode)}" id="input_geocode" placeholder="{lang('LocationAdmin.text_geocode')}"
                                                class="form-control {if !empty(validation_show_error('geocode'))}is-invalid{/if}">
                                            <div id="error_geocode" class="invalid-feedback">
                                                {validation_show_error('geocode')}
                                            </div>
                                            <small>{lang('LocationAdmin.help_geocode')}</small>
                                        </div>
                                    </div>

                                    <div class="form-group row border-top py-3">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                            {lang('LocationAdmin.text_image')}
                                        </label>
                                        <div class="col-12 col-sm-8 col-lg-7">
                                            <a href="javascript:void(0);" id="image" data-target="input_image" data-thumb="load_image" data-type="image" data-bs-toggle="image" class="mx-0 mt-1">
                                                <img src="{if !empty(old('image', $edit_data.image))}{image_thumb_url(old('image', $edit_data.image))}{else}{image_default_url()}{/if}" class="img-thumbnail w-100 me-1 img-fluid" alt="" title="" id="load_image" data-placeholder="{image_default_url()}"/>
                                                <div class="btn-group w-100 mt-1" role="group">
                                                    <button type="button" class="button-image btn btn-xs btn-primary" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_edit')}"><i class="fas fa-pencil-alt"></i></button>
                                                    <button type="button" class="button-clear btn btn-xs btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.text_photo_clear')}"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </a>
                                            <input type="hidden" name="image" value="{old('image', $edit_data.image)}" id="input_image" />

                                            <div id="error_image" class="invalid-feedback">
                                                {validation_show_error('image')}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row border-top py-3">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                            {lang('LocationAdmin.text_open')}
                                        </label>
                                        <div class="col-12 col-sm-8 col-lg-7">
                                            <textarea name="open" rows="5" placeholder="{lang('LocationAdmin.text_open')}" id="input_open"
                                                    class="form-control {if !empty(validation_show_error('open'))}is-invalid{/if}">
                                                {old('open', $edit_data.open)}
                                            </textarea>
                                            <div id="error_open" class="invalid-feedback">
                                                {validation_show_error('open')}
                                            </div>
                                            <small>{lang('LocationAdmin.help_open')}</small>
                                        </div>
                                    </div>

                                    <div class="form-group row border-top py-3">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                            {lang('LocationAdmin.text_comment')}
                                        </label>
                                        <div class="col-12 col-sm-8 col-lg-7">
                                            <textarea name="comment" rows="5" placeholder="{lang('LocationAdmin.text_comment')}" id="input_comment"
                                                    class="form-control {if !empty(validation_show_error('comment'))}is-invalid{/if}">
                                                {old('comment', $edit_data.comment)}
                                            </textarea>
                                            <div id="error_comment" class="invalid-feedback">
                                                {validation_show_error('comment')}
                                            </div>
                                            <small>{lang('LocationAdmin.help_comment')}</small>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                {form_close()}

            </div>
        </div>
        
    </div>
{/strip}
