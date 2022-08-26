{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}

            <input type="hidden" name="product_id" value="{$edit_data.product_id}">
            <input type="hidden" name="master_id" value="{$edit_data.master_id|default:0}">
            <input type="hidden" name="variant" value="{$edit_data.variant|default:""}">
            <input type="hidden" name="override" value="{$edit_data.override|default:""}">

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
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_data'}active{/if}" id="tab_data" data-bs-toggle="tab" href="#tab_data_content" role="tab" aria-controls="tab_data" aria-selected="{if old('tab_type', $tab_type) eq 'tab_data'}true{else}false{/if}">{lang('Admin.tab_data')}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link p-2 ps-3 pe-3 {if old('tab_type', $tab_type) eq 'tab_links'}active{/if}" id="tab_links" data-bs-toggle="tab" href="#tab_links_content" role="tab" aria-controls="tab_links" aria-selected="{if old('tab_type', $tab_type) eq 'tab_links'}true{else}false{/if}">{lang('Admin.tab_links')}</a>
                                    </li>
                                </ul>
                                <div class="tab-content border-0 p-3" id="tab_content">
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_general'}show active{/if}" role="tabpanel" id="tab_general_content"  aria-labelledby="tab_general">
                                        {include file=get_theme_path('views/modules/products/inc/tab_general.tpl')}
                                    </div>
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_data'}show active{/if}" role="tabpanel" id="tab_data_content"  aria-labelledby="tab_data">
                                        {include file=get_theme_path('views/modules/products/inc/tab_data.tpl')}
                                    </div>
                                    <div class="tab-pane fade {if old('tab_type', $tab_type) eq 'tab_links'}show active{/if}" role="tabpanel" id="tab_links_content"  aria-labelledby="tab_links">
                                        {include file=get_theme_path('views/modules/products/inc/tab_links.tpl')}
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
<script>
    $(function () {
        Tiny_content.loadTiny(500);
    });
</script>
