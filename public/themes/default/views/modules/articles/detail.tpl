{strip}
    <article class="article">
        <header>
            <h2>{$article_info.name}</h2>

            <div class="article-meta">

                {if !empty($article_info.author)}
                    <span class="text-capitalize">{$article_info.author},</span>
                {/if}
                <span class="meta-datetime"><i class="far fa-calendar-alt me-1"></i>
                    {time_ago($article_info.publish_date)}</span>
                {if !empty($article_info.category_ids)}
                    <span>
                        <i class="far fa-folder ms-2 me-1"></i>
                        {foreach $article_info.category_ids as $category_id}
                            {if !empty($article_category_list[$category_id])}
                                <a href="{$article_category_list[$category_id].href}">{$article_category_list[$category_id].name}</a>
                                {if !$category_id@last}, {/if}
                            {/if}
                        {/foreach}
                    </span>
                {/if}
                {if !empty($article_info.counter_view)}
                    <span><i class="fas fa-eye"></i> {$article_info.counter_view}</span>
                {/if}
                {if !empty($article_info.source)}
                    <span>
                        {lang('Article.text_source')}: {str_ireplace('www.', '', parse_url($article_info.source, PHP_URL_HOST))}
                    </span>
                {/if}
            </div>

        </header>

        <div class="article-main">
        
            <div class="article-description">{$article_info.description}</div>

            {if !empty($article_info.table_of_contents)}
                <div class="catcool-table-of-contents">{$article_info.table_of_contents}</div>
            {/if}

            <div id="article_content_detail" class="article-content">
                {str_ireplace('<img ', '<img data-fancybox="gallery" ', $article_info.content)}
            </div>

        </div>

    </article>
{/strip}