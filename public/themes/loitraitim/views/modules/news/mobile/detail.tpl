{strip}
    <article class="post-detail my-0 py-2 px-0">
        <header class="detail padding-x">

            <div class="category-tree">
                <a class="me-2" href="{site_url()}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-angle-right me-2"></i>
                {include file=get_theme_path('views/inc/category_tree.tpl') categories=$news_category_tree}
            </div>

            <h2>{$detail.name}</h2>
            <div class="post-meta padding fs-small py-1">
                <span>{if !empty($detail.author)}{$detail.author}{else}Ryan Lee{/if},</span>
                {if !empty($detail.source)}
                    <span>
                        <a href="{$detail.source}" target="_blank">
                            {lang('News.text_source')}: {str_ireplace('www.', '', parse_url($detail.source, PHP_URL_HOST))}
                        </a>
                    </span>
                {/if}
                <span><i class="far fa-clock"></i> {time_ago($detail.publish_date)}</span>
                <span class="d-none"><i class="fas fa-eye"></i> {$detail.counter_view}</span>
                {if $detail.is_comment eq COMMENT_STATUS_ON}
                    <span class="d-none" id="detail_total_comment">
                        <i class="far fa-comments"></i> <fb:comments-count href="{$detail.detail_url}"></fb:comments-count> {lang('News.text_comment')}
                    </span>
                {/if}
            </div>
        </header>

        <div class="post-description padding-x">
            <strong>{$detail.description}</strong>
        </div>
        {if !empty($related_list)}

            <ul class="post-related padding-x">
                {foreach $related_list as $related}
                    <li class="ms-3"><a href="{site_url($related.detail_url)}">{$related.name}</a></li>
                {/foreach}
            </ul>
        {/if}
        <div class="post-content">

            {str_ireplace('<img ', '<img data-fancybox="gallery" ', $detail.content)}

        </div>

        <div class="padding-x mt-3">
            <div class="fb-like" data-href="{base_url($detail.detail_url)}" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="false"></div>
        </div>

        {if !empty($detail.tags)}
            <div class="mt-2 padding-x">
                {include file=get_theme_path('views/modules/news/inc/list_tags.tpl') tags=explode(',', $detail.tags)}
            </div>
        {/if}

        <div class="row padding-x">

            <div class="col-sm-6 mt-2">
                <a target="_blank" class="fb-share" href="https://www.facebook.com/sharer/sharer.php?u={base_url($detail.detail_url)}">Chia sẻ Facebook</a>
            </div>
            <div class="col-sm-6 mt-2 zalo-share">
                <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                <div class="zalo-share-button share-button-zalo" data-href="{base_url($detail.detail_url)}" data-oaid="579745863508352884" data-layout="3" data-color="blue" data-customize="true">
                    <a href="javascript:void(0);">Chia sẻ Zalo</a>
                </div>
            </div>
        </div>

        {if $detail.is_comment eq COMMENT_STATUS_ON}
            <div class="padding-x">
                {include file=get_theme_path('views/inc/facebook_comment.tpl') fb_url=base_url($detail.detail_url)}
            </div>
        {/if}


    </article>

    <section class="bg-white padding-x pb-3">

        {if !empty($news_the_same_list)}
            <div class="category-name d-block pt-3 mt-2 mb-4">
                <span>{lang('News.text_same_category')}</span>
            </div>
            {foreach $news_the_same_list as $news}
                {if $news.news_id eq $detail.news_id}
                    {continue}
                {/if}
                {include file=get_theme_path('views/modules/news/inc/article_info_mobile.tpl') article_info=$news article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}

        {include file=get_theme_path('views/inc/shopee_ads.tpl')}

        {include file=get_theme_path('views/modules/news/inc/list_new.tpl')}

    </section>


    {include file=get_theme_path('views/modules/news/inc/counter_view.tpl')}

    {literal}
        <style>
            .LayoutAlbumWrapper:last-child, .eventNewsTimeline-wrapper:last-child {
                display: none;
            }
            article.post-detail .post-content .post-content-end div, article.post-detail .post-content div div {
                width: 100%;
                text-align: center;
            }
        </style>
    {/literal}
{/strip}
