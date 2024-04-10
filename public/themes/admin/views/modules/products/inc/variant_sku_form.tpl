{strip}

    {if empty($product_variant_combination_attr_id)}
        {assign var="product_variant_combination_attr_id" value="id"}
    {/if}

    {if empty($product_variant_combination_row_id)}
        {assign var="product_variant_combination_row_id" value="__variant_info_row_id__"}
    {/if}

    <input type="hidden" name="product_variant_combination[{$product_variant_combination_row_id}][product_sku_id]" value="{$product_variant_combination.product_sku_id|default:""}" {$product_variant_combination_attr_id}="{$product_variant_combination_row_id}_product_sku_id" >

    <td {$product_variant_combination_attr_id}="{$product_variant_combination_row_id}_price" class="variant-combination-price">
        <div class="input-group">
            <span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
            <input type="number" step="0.01" min="0" name="product_variant_combination[{$product_variant_combination_row_id}][price]" value="{old("product_variant_combination[{$product_variant_combination_row_id}][price]", $product_variant_combination.price|default:0)}" {$product_variant_combination_attr_id}="input_product_variant_combination_{$product_variant_combination_row_id}_price" class="form-control">
        </div>
        <div {$product_variant_combination_attr_id}="error_product_variant_combination_{$product_variant_combination_row_id}_price" class="invalid-feedback"></div>
    </td>

    <td {$product_variant_combination_attr_id}="{$product_variant_combination_row_id}_quantity" class="variant-combination-quantity">
        <input type="number" min="0" name="product_variant_combination[{$product_variant_combination_row_id}][quantity]" value="{old("product_variant_combination[{$product_variant_combination_row_id}][quantity]", $product_variant_combination.quantity|default:0)}" {$product_variant_combination_attr_id}="input_product_variant_combination_{$product_variant_combination_row_id}_quantity" class="form-control">
        <div {$product_variant_combination_attr_id}="error_product_variant_combination_{$product_variant_combination_row_id}_quantity" class="invalid-feedback"></div>
    </td>

    <td {$product_variant_combination_attr_id}="{$product_variant_combination_row_id}_sku" class="variant-combination-sku">
        <input type="text" name="product_variant_combination[{$product_variant_combination_row_id}][sku]" value="{old("product_variant_combination[{$product_variant_combination_row_id}][sku]", $product_variant_combination.sku|default:"")}" {$product_variant_combination_attr_id}="input_product_variant_combination_{$product_variant_combination_row_id}_sku" class="form-control">
        <div {$product_variant_combination_attr_id}="error_product_variant_combination_{$product_variant_combination_row_id}_sku" class="invalid-feedback"></div>
    </td>

    <td {$product_variant_combination_attr_id}="{$product_variant_combination_row_id}_published">
        <div class="switch-button switch-button-xs catcool-center">
            {form_checkbox("product_variant_combination[{$product_variant_combination_row_id}][published]", true, $product_variant_combination.published|default:true, ['id' => "input_product_variant_combination_{$product_variant_combination_row_id}_published"])}
            <span><label for="input_product_variant_combination_{$product_variant_combination_row_id}_published"></label></span>
        </div>
    </td>

{/strip}
