{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}
            <input type="hidden" name="product_id" value="{$edit_data.product_id}">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('ProductAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.product_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>

                        <div class="card-body px-0 pb-0 pt-3 bg-light">
                            <div class="tab-regular">
                                <ul class="nav nav-tabs border-bottom ps-3" id="config_tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_general'}active{/if}" id="tab_general" data-bs-toggle="tab" href="#tab_general_content" role="tab" aria-controls="tab_general" aria-selected="{if old('tab_type', $tab_type) eq 'tab_general'}true{else}false{/if}">{lang('Admin.tab_general')}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_image'}active{/if}" id="tab_image" data-bs-toggle="tab" href="#tab_content_image" role="tab" aria-controls="tab_image" aria-selected="{if old('tab_type', $tab_type) eq 'tab_image'}true{else}false{/if}">{lang('Admin.tab_image')}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_local'}active{/if}" id="tab_local" data-bs-toggle="tab" href="#tab_content_local" role="tab" aria-controls="tab_local" aria-selected="{if old('tab_type', $tab_type) eq 'tab_local'}true{else}false{/if}">{lang('Admin.tab_local')}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_option'}active{/if}" id="tab_option" data-bs-toggle="tab" href="#tab_content_option" role="tab" aria-controls="tab_option" aria-selected="{if old('tab_type', $tab_type) eq 'tab_option'}true{else}false{/if}">{lang('Admin.tab_option')}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_mail'}active{/if}" id="tab_mail" data-bs-toggle="tab" href="#tab_content_mail" role="tab" aria-controls="tab_mail" aria-selected="{if old('tab_type', $tab_type) eq 'tab_mail'}true{else}false{/if}">{lang('Admin.tab_mail')}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_server'}active{/if}" id="tab_server" data-bs-toggle="tab" href="#tab_content_server" role="tab" aria-controls="tab_server" aria-selected="{if old('tab_type', $tab_type) eq 'tab_server'}true{else}false{/if}">{lang('Admin.tab_server')}</a>
                                    </li>
                                </ul>
                                <div class="tab-content border-0 p-3" id="tab_content">
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_general'}show active{/if}" role="tabpanel" id="tab_general_content"  aria-labelledby="tab_general">
                                        {include file=get_theme_path('views/modules/products/inc/tab_general.tpl')}
                                    </div>
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_image'}show active{/if}" role="tabpanel" id="tab_content_image"  aria-labelledby="tab_image">
                                        {include file=get_theme_path('views/modules/configs/inc/tab_image.tpl')}
                                    </div>
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_local'}show active{/if}" role="tabpanel" id="tab_content_local"  aria-labelledby="tab_local">
                                        {include file=get_theme_path('views/modules/configs/inc/tab_local.tpl')}
                                    </div>
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_option'}show active{/if}" role="tabpanel" id="tab_content_option"  aria-labelledby="tab_option">
                                        {include file=get_theme_path('views/modules/configs/inc/tab_option.tpl')}
                                    </div>
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_mail'}show active{/if}" role="tabpanel" id="tab_content_mail"  aria-labelledby="tab_mail">
                                        {include file=get_theme_path('views/modules/configs/inc/tab_mail.tpl')}
                                    </div>
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_server'}show active{/if}" role="tabpanel" id="tab_content_server"  aria-labelledby="tab_server">
                                        {include file=get_theme_path('views/modules/configs/inc/tab_server.tpl')}
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
