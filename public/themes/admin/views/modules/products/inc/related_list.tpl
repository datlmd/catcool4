{strip}
    {if !empty($related_list)}
        {foreach $related_list as $item}
            <div class="form-check m-2">
                <input class="form-check-input" type="checkbox" name="related_ids[]" value="{$item.product_id}" {if !empty($is_checked)}checked="checked"{/if} id="related_id_{$item.product_id}">
                <div class="row">
                    <label class="form-check-label col-10" for="related_id_{$item.product_id}">
                        {$item.name}
                    </label>
                    <a href="{$manage_url}/edit/{$item.product_id}" target="_blank" class="text-primary col-2 text-end">{lang('Admin.button_link')}</a>
                </div>
            </div>
        {/foreach}
    {else}
        {lang('Admin.text_no_results')}
    {/if}
{/strip}
