{strip}

    {if empty($product_variant_option_row)}
        {assign var="product_variant_option_row" value="product_variant_option_row_value"}
    {/if}

    {if empty($product_variant_option_value_row)}
        {assign var="product_variant_option_value_row" value="product_variant_option_value_row_value"}
    {/if}

    {if !empty($product_variant_option_value.option_value_id)}
        <input type="hidden" name="product_variant[{$product_variant_option_row}][option_values][{$product_variant_option_value_row}][option_value_id]" value="{$product_variant_option_value.option_value_id}"/>
    {/if}

    {if !empty($product_variant_option_value.product_option_value_id)}
        <input type="hidden" name="product_variant[{$product_variant_option_row}][option_values][{$product_variant_option_value_row}][product_option_value_id]" value="{$product_variant_option_value.product_option_value_id}"/>
    {/if}

    <div id="product_variant_option_row_{$product_variant_option_row}" data-row="{$product_variant_option_row}" class="product-variant-option rounded bg-light p-3">
        <div class="text-end product-variant-close">
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>

        <input type="hidden" name="product_option[{$product_variant_option_row}][product_option_id]" value=""/>

        <div class="row">
            <label class="col-sm-3 col-form-label text-end">{lang('ProductAdmin.text_variant_name')}</label>
            <div class="col-sm-9">
                <select name="product_variant[{$product_variant_option_row}][option_id]" id="input_product_variant_{$product_variant_option_row}_option_id" class="form-select cc-form-select-single">
                    <option value="">{lang('Admin.text_select')}</option>
                    {foreach $option_list as $option}
                        <option value="{$option.option_id}">{$option.name}</option>
                    {/foreach}
                </select>

            </div>
        </div>

        <div class="product-variant-option-list">
            <div class="row product-variant-option-item">
                <label class="col-sm-3 col-form-label text-end">{lang('ProductAdmin.text_variant_option')}</label>
                <div class="col-sm-9">
                    <ul class="list-group my-2">
                        <li class="list-group-item">
                            {include file=get_theme_path('views/modules/products/inc/variant_option_form.tpl')
                            product_variant_option_row=$product_variant_option_row
                            product_variant_option_value_row=$product_variant_option_value_row
                            product_variant_option_value=[]
                            }
                        </li>
                    </ul>
                    <button type="button" class="btn btn-sm btn-primary btn-variant-option-add"><i class="fas fa-plus me-1"></i>{lang('ProductAdmin.text_variant_option_add')}</button>
                </div>
            </div>

        </div>

    </div>

{/strip}
