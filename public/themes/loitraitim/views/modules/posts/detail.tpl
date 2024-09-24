{strip}
    <article class="container-xxl post-detail my-0 mt-lg-0 mt-xl-3 py-3 px-5">
        <header class="detail">

            <div class="category-tree">
                <a class="me-2" href="{site_url()}">
                    <i class="fas fa-home"></i>
                </a>
                {include file=get_theme_path('views/inc/category_tree.tpl') categories=$post_category_tree}
            </div>

            <h2>{$detail.name}</h2>
            <div class="post-meta padding fs-small py-1 {if !in_array($detail.source_type, [1, 2])}d-none{/if}">
                <span>{if !empty($detail.author)}{$detail.author}{else}Ryan Lee{/if},</span>
                {if !empty($detail.source)}
                    <span>
                        {lang('Post.text_source')}: {str_ireplace('www.', '', parse_url($detail.source, PHP_URL_HOST))}
                    </span>
                {/if}
                <span><i class="far fa-clock"></i> {time_ago($detail.publish_date)}</span>
                <span class="d-none"><i class="fas fa-eye"></i> {$detail.counter_view}</span>
                {if $detail.is_comment eq COMMENT_STATUS_ON}
                    <span class="d-none" id="detail_total_comment">
                        <i class="far fa-comments"></i> <fb:comments-count href="{$detail.detail_url}"></fb:comments-count> {lang('Post.text_comment')}
                    </span>
                {/if}
            </div>
        </header>
        <div class="row">
            <div class="col">
                {if !empty($related_list)}

                    <ul class="post-related">
                        {foreach $related_list as $related}
                            <li><a href="{site_url($related.detail_url)}">{$related.name}</a></li>
                        {/foreach}
                    </ul>

                {/if}
                <div class="post-content">
                    <div class="post-content-start position-sticky">
                        <ul>
                            <li>
                                <a href="{site_url()}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            {if $detail.is_comment eq COMMENT_STATUS_ON}
                                <li>
                                    <a href="{base_url($detail.detail_url)}#comments">
                                        <i class="far fa-comments"></i>
                                    </a>
                                </li>
                            {/if}
                            <li>
                                <a title="Share Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={base_url($detail.detail_url)}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                                <div class="zalo-share-button share-button-zalo" data-href="{base_url($detail.detail_url)}" data-oaid="579745863508352884" data-layout="3" data-color="blue" data-customize="true">
                                    <a title="Share Zalo" href="javascript:void(0);"><i>Zalo</i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="post-content-end">
                        
                        <div class="post-description text-start">
                            <strong>{$detail.description}</strong>
                        </div>

                        {if !empty($detail.table_of_contents)}
                            <div class="catcool-table-of-contents">{$detail.table_of_contents}</div>
                        {/if}

                        <div id="article_content_detail" class="article-content-detail mt-3">
                            {str_ireplace('<img ', '<img data-fancybox="gallery" ', $detail.content)}
                        </div>

                    </div>

                </div>

                <div class="fb-like" data-href="{base_url($detail.detail_url)}" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="false"></div>

                {if !empty($detail.tags)}
                    <div class="mt-2">
                        {include file=get_theme_path('views/modules/posts/inc/list_tags.tpl') tags=explode(',', $detail.tags)}
                    </div>
                {/if}

                {if $detail.is_comment eq COMMENT_STATUS_ON}
                    {include file=get_theme_path('views/inc/facebook_comment.tpl') fb_url=base_url($detail.detail_url)}
                {/if}

            </div>
            <aside class="col-md-4 col-12 d-none d-lg-block">
                <div class="position-sticky">
                    {if !empty($post_counter_list)}
                        {foreach $post_counter_list as $post}
                            {if $post.post_id eq $detail.post_id}
                                {continue}
                            {/if}
                            {include file=get_theme_path('views/modules/posts/inc/article_info.tpl') article_info=$post article_type='left' article_class="mb-3" is_show_category=true is_hide_description=true}
                        {/foreach}
                    {/if}
                </div>
            </aside>
        </div>
    </article>

    <section class="container-xxl bg-white px-5 pb-3">
        <div class="row">
            <div class="col">
                {if !empty($related_list)}
                    <div class="category-name d-block mt-2 mb-4">
                        <span>{lang('Post.text_related')}</span>
                    </div>
                    {foreach $related_list as $post}
                        {if $post.post_id eq $detail.post_id}
                            {continue}
                        {/if}

                        {include file=get_theme_path('views/modules/posts/inc/article_info.tpl') article_info=$post article_type='small' article_class="mb-3 pb-3 border-bottom" is_show_category=true is_hide_description=true}
                    {/foreach}
                {/if}

                {if !empty($post_same_category_list)}
                    <div class="category-name d-block mt-2 mb-4">
                        <span>{lang('Post.text_same_category')}</span>
                    </div>
                    {foreach $post_same_category_list as $post}
                        {if $post.post_id eq $detail.post_id}
                            {continue}
                        {/if}
                        {include file=get_theme_path('views/modules/posts/inc/article_info.tpl') article_info=$post article_type='left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
                    {/foreach}
                {/if}

                {if !empty($post_latest_list)}
                    <div class="category-name d-block mt-2 mb-4">
                        <span>{lang('Post.text_new_post')}</span>
                    </div>
                    {foreach $post_latest_list as $post}
                        {if $post.post_id eq $detail.post_id}
                            {continue}
                        {/if}
                        {include file=get_theme_path('views/modules/posts/inc/article_info.tpl') article_info=$post article_type='left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
                    {/foreach}
                {/if}

            </div>
            <div class="col-md-4 col-12">

            </div>
        </div>
    </section>

    {include file=get_theme_path('views/modules/news/inc/counter_view.tpl') counter_list=$post_hot_list text_title=lang('Post.text_hot_post')}

    {literal}
        <style>
            article.post-detail .post-content img {
                max-width: 600px !important;
            }
        </style>
    {/literal}
{/strip}
