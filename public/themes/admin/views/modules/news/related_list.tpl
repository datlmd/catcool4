{strip}
    <h4 class="text-primary">{$related}</h4>
    {if !empty($related_list)}
        {foreach $related_list as $related}
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="related_ids[]" value="{$related.news_id}" id="related_id_{$related.news_id}">
                <div class="row">
                    <label class="form-check-label col-10" for="related_id_{$related.news_id}">
                        {$related.name}
                    </label>
                    <a href="{$manage_url}/edit/{$related.news_id}" target="_blank" class="text-primary col-2 text-center">{lang('Admin.button_link')}</a>
                </div>
            </div>
        {/foreach}
    {else}
        {lang('Admin.text_no_results')}
    {/if}
{/strip}
