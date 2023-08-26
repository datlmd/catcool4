{strip}

    {if empty($vof_variant_option_row)}
        {assign var="vof_variant_option_row" value="product_variant_option_row_value"}
    {/if}

    {if empty($vof_variant_option_value_row)}
        {assign var="vof_variant_option_value_row" value="product_variant_option_value_row_value"}
    {/if}

    {if !empty($data_variant_option_value.option_value_id)}
        <input type="hidden" name="product_variant[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][option_value_id]" value="{$data_variant_option_value.option_value_id}"/>
    {/if}

    {if !empty($data_variant_option_value.product_option_value_id)}
        <input type="hidden" name="product_variant[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][product_option_value_id]" value="{$data_variant_option_value.product_option_value_id}"/>
    {/if}

    <div class="d-flex flex-row">
        <div class="flex-grow-1">
            {foreach $language_list as $language}
                <div class="input-group {if !$language@last}mb-2{/if}">
                    <span class="input-group-text">{$language.icon}</span>
                    <input type="text" name="product_variant[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][lang][{$language.id}][name]"
                           id="input_product_variant_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_lang_{$language.id}_name"
                           class="form-control variant-option-name {if $language@first}default{/if}"
                           value="{old("product_variant[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][lang][{$language.id}][name]", $data_variant_option_value.lang.{$language.id}.name)|default:""}"
                           data-varian-option-row="{$vof_variant_option_row}" data-variant-option-value-row="{$vof_variant_option_value_row}"
                           maxlength="{PRODUCT_VARIANT_LENGTH}"
                    >
                    <span class="input-group-text"><span class="variant-option-name-length"></span>/{PRODUCT_VARIANT_LENGTH}</span>
                </div>
                <div id="error_product_variant_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_lang_{$language.id}_name" class="invalid-feedback"></div>
            {/foreach}
        </div>

        <div class="py-2 px-3 variant-move">
            <i class="fas fa-arrows-alt"></i>
        </div>

        <div class="py-2 variant-delete">
            <i class="fas fa-trash-alt"></i>
        </div>
    </div>

{/strip}
