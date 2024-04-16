{strip}

    {if !empty($data_variant)}
        {assign var="vf_variant_row" value=$data_variant.variant_row}
    {else}
        {assign var="vf_variant_row" value="product_variant_row_value"}
    {/if}

    <div id="product_variant_row_{$vf_variant_row}" data-row="{$vf_variant_row}" {if isset($variant_index) && $variant_index === 0}data-is-image="1"{else}data-is-image="0"{/if} class="product-variant {if isset($variant_index) && $variant_index === 0}has-image{/if} rounded bg-light p-3 mb-3">
        <div class="d-flex mb-2">
            <div class="flex-grow-1 fs-6 text-primary">
{*                {lang('ProductAdmin.text_variant_group')} {$vf_variant_row}*}
                {lang('ProductAdmin.text_variant_name')}

            </div>
            <div class="text-end product-variant-close">
                <button type="button" class="btn-close" {if isset($variant_index) && $variant_index === 0 && !empty($edit_data.product_variant_list) && $edit_data.product_variant_list|count > 1}disabled{/if} aria-label="Close"></button>
            </div>
        </div>

        <div class="row">
{*            <label class="col-12 col-form-label">{lang('ProductAdmin.text_variant_name')}</label>*}
            <div class="col-12">
                <select name="product_variant[{$vf_variant_row}][variant_id]" id="input_product_variant_{$vf_variant_row}_variant_id" class="form-select">
                    <option value="">{lang('Admin.text_select')}</option>
                    {foreach $variant_list as $variant}
                        <option value="{$variant.variant_id}"{if $data_variant.variant_id eq $variant.variant_id}selected="selected"{/if}>{$variant.name}</option>
                    {/foreach}
                </select>
                <div id="error_product_variant_{$vf_variant_row}_variant_id" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="product-variant-list">
            <div class="row product-variant-item mt-2">
                <label class="col-12 col-form-label">{lang('ProductAdmin.text_variant_value')}</label>
                <div class="col-12">
                    <div class="d-flex flex-wrap">
                        {if !empty($data_variant.value_list)}
                            {foreach $data_variant.value_list as $variant_value}
                                <div class="variant-value-item pb-3">
                                    {include file=get_theme_path('views/modules/products/inc/variant_value_form.tpl')
                                        vof_variant_row=$vf_variant_row
                                        data_variant_value=$variant_value
                                        variant_index = $variant_index
                                    }
                                </div>
                            {/foreach}
{*                        {else}*}
{*                            <div class="variant-value-item pt-3">*}
{*                                {include file=get_theme_path('views/modules/products/inc/variant_value_form.tpl')*}
{*                                vof_variant_row=$vf_variant_row*}
{*                                data_variant_value=[]*}
{*                                }*}
{*                            </div>*}
                        {/if}

                    </div>

                    <button type="button" class="btn btn-xs btn-primary btn-variant-value-add mt-1" data-variant-row="{$vf_variant_row}"><i class="fas fa-plus me-1"></i>{lang('ProductAdmin.text_variant_value_add')}</button>
                </div>
            </div>

        </div>

    </div>

{/strip}
