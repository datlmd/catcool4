{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}
            <input type="hidden" name="subscription_plan_id" value="{$edit_data.subscription_plan_id}">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('SubscriptionPlanAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.subscription_plan_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group row required has-error">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_plan_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    {foreach $language_list as $language}
                                        <div class="input-group {if !$language@last}mb-2{/if}">
                                            {if $language_list|count > 1}<span class="input-group-text" title="{$language.name}">{$language.icon}</span>{/if}
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_lang_{$language.id}_name" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                            <div id="error_lang_{$language.id}_name" class="invalid-feedback">
                                                {$validator->getError("lang.`$language.id`.name")}
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_sort_order')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="input_sort_order" min="0" class="form-control">
                                    <div id="error_sort_order" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <h3 class="border-bottom pb-2">{lang('SubscriptionPlanAdmin.text_trial')}</h3>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_trial_price')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="trial_price" value="{old('trial_price', $edit_data.trial_price)|default:0}" id="input_trial_price" class="form-control">
                                    <div id="error_trial_price" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_trial_duration')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="trial_duration" value="{old('trial_duration', $edit_data.trial_duration)|default:0}" id="input_trial_duration" class="form-control">
                                    <div id="error_trial_duration" class="invalid-feedback"></div>
                                    <div class="form-text">{lang('SubscriptionPlanAdmin.help_duration')}</div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_trial_cycle')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="trial_cycle" value="{old('trial_cycle', $edit_data.trial_cycle)|default:1}" id="input_trial_cycle" class="form-control">
                                    <div id="error_trial_cycle" class="invalid-feedback"></div>
                                    <div class="form-text">{lang('SubscriptionPlanAdmin.help_cycle')}</div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_trial_frequency')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <select name="trial_frequency" id="input_trial_frequency" class="form-select">
                                        {foreach $frequencie_list as $frequencie_key => $frequencie_name}
                                            <option value="{$frequencie_key}" {if old('trial_frequency', $edit_data.trial_frequency) eq $frequencie_key}selected="selected"{/if}>{$frequencie_name}</option>
                                        {/foreach}
                                    </select>
                                    <div class="form-text">{lang('SubscriptionPlanAdmin.help_frequency')}</div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_trial_published')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <label class="form-check form-check-inline col-form-label ms-2">
                                        <input type="radio" name="trial_published" value="{STATUS_ON}" {if old('trial_published', $edit_data.trial_published)|default:1 eq STATUS_ON}checked="checked"{/if} id="trial_published_on" class="form-check-input">
                                        <label class="form-check-label" for="trial_published_on">{lang('Admin.text_on')}</label>
                                    </label>
                                    <label class="form-check form-check-inline col-form-label me-2">
                                        <input type="radio" name="trial_published" value="{STATUS_OFF}" {if old('trial_published', $edit_data.trial_published)|default:1 eq STATUS_OFF}checked="checked"{/if} id="trial_published_off" class="form-check-input">
                                        <label class="form-check-label" for="trial_published_off">{lang('Admin.text_off')}</label>
                                    </label>
                                </div>
                            </div>

                            <h3 class="border-bottom pb-2">{lang('SubscriptionPlanAdmin.text_subscription')}</h3>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_price')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="price" value="{old('price', $edit_data.price)|default:0}" id="input_price" class="form-control">
                                    <div id="error_price" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_duration')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="duration" value="{old('duration', $edit_data.duration)|default:0}" id="input_duration" class="form-control">
                                    <div id="error_duration" class="invalid-feedback"></div>
                                    <div class="form-text">{lang('SubscriptionPlanAdmin.help_duration')}</div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_cycle')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="cycle" value="{old('cycle', $edit_data.cycle)|default:1}" id="input_cycle" class="form-control">
                                    <div id="error_cycle" class="invalid-feedback"></div>
                                    <div class="form-text">{lang('SubscriptionPlanAdmin.help_cycle')}</div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('SubscriptionPlanAdmin.text_frequency')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <select name="frequency" id="input_frequency" class="form-select">
                                        {foreach $frequencie_list as $frequencie_key => $frequencie_name}
                                            <option value="{$frequencie_key}" {if old('trial_frequency', $edit_data.frequency) eq $frequencie_key}selected="selected"{/if}>{$frequencie_name}</option>
                                        {/foreach}
                                    </select>
                                    <div class="form-text">{lang('SubscriptionPlanAdmin.help_frequency')}</div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_published')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <label class="form-check form-check-inline col-form-label ms-2">
                                        <input type="radio" name="published" value="{STATUS_ON}" {if old('published', $edit_data.published)|default:1 eq STATUS_ON}checked="checked"{/if} id="published_on" class="form-check-input">
                                        <label class="form-check-label" for="published_on">{lang('Admin.text_on')}</label>
                                    </label>
                                    <label class="form-check form-check-inline col-form-label me-2">
                                        <input type="radio" name="published" value="{STATUS_OFF}" {if old('published', $edit_data.published)|default:1 eq STATUS_OFF}checked="checked"{/if} id="published_off" class="form-check-input">
                                        <label class="form-check-label" for="published_off">{lang('Admin.text_off')}</label>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        {form_close()}
    </div>
{/strip}
