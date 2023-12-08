{strip}

    {if !empty($data_variant_option)}
        {assign var="vf_variant_option_row" value=sprintf($variant_option_row_name, $data_variant_option.option_id)}
    {else}
        {assign var="vf_variant_option_row" value="product_variant_option_row_value"}
    {/if}

    <div id="product_variant_option_row_{$vf_variant_option_row}" data-row="{$vf_variant_option_row}" class="product-variant-option rounded bg-light p-3 mb-3">
        <div class="d-flex mb-2">
            <div class="flex-grow-1 fs-6 text-primary">
{*                {lang('ProductAdmin.text_variant_group')} {$vf_variant_option_row}*}
            </div>
            <div class="text-end product-variant-close">
                <button type="button" class="btn-close" aria-label="Close"></button>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-md-2 col-form-label text-sm-end">{lang('ProductAdmin.text_variant_name')}</label>
            <div class="col-sm-8 col-md-9">
                <select name="product_variant_option[{$vf_variant_option_row}][option_id]" id="input_product_variant_option_{$vf_variant_option_row}_option_id" class="form-select">
                    <option value="">{lang('Admin.text_select')}</option>
                    {foreach $option_list as $option}
                        <option value="{$option.option_id}"{if $data_variant_option.option_id eq $option.option_id}selected="selected"{/if}>{$option.name}</option>
                    {/foreach}
                </select>
                <div id="error_product_variant_option_{$vf_variant_option_row}_option_id" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="product-variant-option-list">
            <div class="row product-variant-option-item">
                <label class="col-sm-3 col-md-2 col-form-label text-sm-end">{lang('ProductAdmin.text_variant_option')}</label>
                <div class="col-sm-8 col-md-9">

                    <div class="d-flex flex-wrap">
                        {if !empty($data_variant_option.option_value_list)}
                            {foreach $data_variant_option.option_value_list as $variant_option_value}
                                <div class="variant-option-value-item pt-3">
                                    {include file=get_theme_path('views/modules/products/inc/variant_option_value_form.tpl')
                                    vof_variant_option_row=$vf_variant_option_row
                                    data_variant_option_value=$variant_option_value
                                    }
                                </div>
                            {/foreach}
                        {else}
                            <div class="variant-option-value-item pt-3">
                                {include file=get_theme_path('views/modules/products/inc/variant_option_value_form.tpl')
                                vof_variant_option_row=$vf_variant_option_row
                                data_variant_option_value=[]
                                }
                            </div>
                        {/if}

                    </div>

                    <button type="button" class="btn btn-sm btn-primary btn-variant-option-add mt-3" data-variant-option-row="{$vf_variant_option_row}"><i class="fas fa-plus me-1"></i>{lang('ProductAdmin.text_variant_option_add')}</button>
                </div>
            </div>

        </div>

    </div>

{/strip}
