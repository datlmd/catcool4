{strip}
    {if !empty($related_list)}
        {foreach $related_list as $item}
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="related_ids[]" value="{$item.news_id}" {if !empty($is_checked)}checked="checked"{/if} id="related_id_{$item.news_id}">
                <div class="row">
                    <label class="form-check-label col-10" for="related_id_{$item.news_id}">
                        {$item.name}
                    </label>
                    <a href="{$manage_url}/edit/{$item.news_id}" target="_blank" class="text-primary col-2 text-center">{lang('Admin.button_link')}</a>
                </div>
            </div>
        {/foreach}
    {else}
        {lang('Admin.text_no_results')}
    {/if}
{/strip}
