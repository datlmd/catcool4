{strip}
    {if !empty($errors)}
        <div class="text-danger">
            {foreach $errors as $err}
                {$err}<br/>
            {/foreach}
        </div>
    {elseif !empty($product['variant'])}
        <div class="row mb-3 border-bottom pb-3">
            <div class="col-4 fw-bolder text-center">
            </div>
            <div class="col-4 fw-bolder text-center">
                {lang("ProductAdmin.text_quantity")}
            </div>
            <div class="col-4 fw-bolder text-center">
                {lang("ProductAdmin.text_price")}
            </div>
        </div>
        {foreach $product.sku_list as $sku}
            <input type="hidden" name="product_sku[{$sku.product_sku_id}][product_id]" value="{$sku.product_id}">
            <input type="hidden" name="product_sku[{$sku.product_sku_id}][product_sku_id]" value="{$sku.product_sku_id}">
            <div class="row mb-3">
                <div class="col-4 col-form-label text-end">
                    {$sku.sku_name}
                </div>
                <div class="col-4">
                    <input type="number" name="product_sku[{$sku.product_sku_id}][quantity]" value="{$sku.quantity}" id="input_product_sku_{$sku.product_sku_id}_quantity" min="0" class="form-control {if $sku.quantity <= 0}is-invalid{/if}">
                    <div id="error_product_sku_{$sku.product_sku_id}_quantity" class="invalid-feedback {if $sku.quantity < 10}d-block{/if}">
                        {if $sku.quantity <= 0}
                            {lang('ProductAdmin.text_sku_out_of_stock')}
                        {else}
                            {lang('ProductAdmin.text_sku_few_product_left')}
                        {/if}
                    </div>
                </div>
                <div class="col-4">
                    <div class="input-group">
                        <span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
                        <input type="text" data-type="currency" name="product_sku[{$sku.product_sku_id}][price]" value="{show_currency_system($sku.price)}" id="input_product_sku_{$sku.product_sku_id}_price" class="form-control">
                    </div>
                    <div id="error_product_sku_{$sku.product_sku_id}_price" class="invalid-feedback"></div>
                </div>
            </div>
        {/foreach}
    {else}
        <div class="row mb-3 border-bottom pb-3">
            <div class="col-6 fw-bolder text-center">
                {lang("ProductAdmin.text_quantity")}
            </div>
            <div class="col-6 fw-bolder text-center">
                {lang("ProductAdmin.text_price")}
            </div>
        </div>
        <input type="hidden" name="product_info[product_id]" value="{$product.product_id}">
        <div class="row mb-3">
            <div class="col-6">
                <input type="number" name="product_info[quantity]" value="{$product.quantity}" id="input_product_info_quantity" min="0" class="form-control">
                <div id="error_product_info_quantity" class="invalid-feedback"></div>
            </div>
            <div class="col-6">
                <div class="input-group">
                    <span class="input-group-text">{if !empty($currency.symbol_left)}{$currency.symbol_left}{elseif !empty($currency.symbol_right)}{$currency.symbol_right}{/if}</span>
                    <input type="text" data-type="currency" name="product_info[price]" value="{show_currency_system((float)$product.price)}" id="input_product_info_price" class="form-control">
                </div>
                <div id="error_product_info_price" class="invalid-feedback"></div>
            </div>
        </div>
    {/if}
{/strip}
