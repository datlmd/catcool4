{strip}

    {if empty($vof_variant_option_row)}
        {assign var="vof_variant_option_row" value="product_variant_option_row_value"}
    {/if}

    {if !empty($data_variant_option_value)}
        {assign var="vof_variant_option_value_row" value=sprintf($variant_option_row_name, $data_variant_option_value.option_value_id)}
    {else}
        {assign var="vof_variant_option_value_row" value="product_variant_option_value_row_value"}
    {/if}

    {if !empty($data_variant_option_value.option_id)}
        <input type="hidden" name="product_variant_option[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][option_id]" value="{$data_variant_option_value.option_id}"/>
    {/if}

    {if !empty($data_variant_option_value.option_value_id)}
        <input type="hidden" name="product_variant_option[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][option_value_id]" value="{$data_variant_option_value.option_value_id}"/>
    {/if}

    <div class="d-flex flex-row">
        {if isset($variant_option_index) && $variant_option_index eq 0}
            <div class="pe-2 variant-option-value-item-image">
{*            <div class="flex-grow-1 pe-2 variant-option-value-item-image">*}

                <input type="hidden" name="product_variant_option[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][image]" value="{$data_variant_option_value.image|default:""}" id="input_product_variant_option_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_image" />

                <div class="drop-drap-file" data-module="products" data-image-id="product_variant_option_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_image" data-input-name="product_variant_option[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][image]" data-image-class="img-thumbnail">
                    <div id="product_variant_option_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_image" class="text-center drop-drap-image-content" {if empty($data_variant_option_value.image)}style="display: none;"{/if}>
                        <div class="drop-drap-image">
                            <a href="{image_url($data_variant_option_value.image|default:"")}" data-lightbox="products">
                                <img src="{image_thumb_url($data_variant_option_value.image|default:"")}"
                                     class="img-thumbnail"
                                >
                            </a>
                        </div>
                        <div class="btn-group my-1" role="group">
                            <button type="button"
                                    class="btn btn-xs btn-light button-image-crop"
                                    onclick="Catcool.cropImage('{$data_variant_option_value.image|default:""}', 1, this);">
                                <i class="fas fa-crop"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-light button-image-delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                    <input type="file" name="product_variant_option_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_file" class="file-input d-none" size="20" />

                    <div class="upload-area dropzone dz-clickable" {if !empty($data_variant_option_value.image)}style="display: none;"{/if}>
                        <h5 class="dz-message text-nowrap py-4">
                            <i class="fas fa-plus me-1 text-primary"></i>
                            <i class="fas fa-image text-primary"></i>
                        </h5>
                    </div>
                </div>
            </div>
        {/if}
        <div class="flex-grow-1">
{*        <div {if !isset($variant_option_index) || $variant_option_index > 0}class="flex-grow-1"{/if}>*}
            {foreach $language_list as $language}
                <div class="input-group {if !$language@last}mb-1{/if}">
                    {if $language_list|count > 1}<span class="input-group-text">{$language.icon}</span>{/if}
                    <input type="text" name="product_variant_option[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][lang][{$language.id}][name]"
                           id="input_product_variant_option_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_lang_{$language.id}_name"
                           class="form-control variant-option-name {if $language@first}default{/if}"
                           value="{old("product_variant_option[{$vof_variant_option_row}][option_values][{$vof_variant_option_value_row}][lang][{$language.id}][name]", $data_variant_option_value.lang.{$language.id}.name)|default:""}"
                           data-varian-option-row="{$vof_variant_option_row}" data-variant-option-value-row="{$vof_variant_option_value_row}"
                           maxlength="{PRODUCT_VARIANT_LENGTH}"
                    >
                    <span class="input-group-text"><span class="variant-option-name-length">{$data_variant_option_value.lang.{$language.id}.name|count_characters:true|default:0}</span>/{PRODUCT_VARIANT_LENGTH}</span>
                </div>
                <div id="error_product_variant_option_{$vof_variant_option_row}_option_values_{$vof_variant_option_value_row}_lang_{$language.id}_name" class="invalid-feedback"></div>
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
