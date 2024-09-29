{strip}
    <article class="post-detail my-0 p-2">
        <header class="detail padding-x">

            <div class="category-tree">
                <a class="me-2" href="{site_url()}">
                    <i class="fas fa-home"></i>
                </a>
                {include file=get_theme_path('views/inc/category_tree.tpl') categories=$post_category_tree}
            </div>

            <h2>{$detail.name}</h2>
            
            <div class="post-meta padding fs-small py-1">
                {if !empty($detail.source) && in_array($detail.source_type, [1, 2])}
                    <span>{if !empty($detail.author)}{$detail.author}{else}Ryan Lee{/if},</span>
                    <span>
                        {lang('Post.text_source')}: {str_ireplace('www.', '', parse_url($detail.source, PHP_URL_HOST))}
                    </span>
                {/if}

                <span><i class="far fa-clock"></i> {time_ago($detail.publish_date)}</span>
                <span class="mx-2"><i class="fas fa-eye"></i> {$detail.counter_view}</span>
                {if $detail.is_comment eq COMMENT_STATUS_ON}
                    <span class="d-none" id="detail_total_comment">
                        <i class="far fa-comments"></i> <fb:comments-count href="{$detail.detail_url}"></fb:comments-count> {lang('Post.text_comment')}
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

            {if !empty($detail.table_of_contents)}
                <div class="catcool-table-of-contents">{$detail.table_of_contents}</div>
            {/if}

            <div id="article_content_detail" class="article-content-detail">
                {str_ireplace('<img ', '<img data-fancybox="gallery" ', $detail.content)}
            </div>

            {* Lay danh sach bai hoc *}
            {if !empty($lesson_categories)}
                {include file=get_theme_path('views/modules/posts/inc/lesson_categories.tpl') post_id=$detail.post_id}
            {/if}

        </div>

        <div class="padding-x mt-3">
            <div class="fb-like" data-href="{base_url($detail.detail_url)}" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="false"></div>
        </div>

        {if !empty($detail.tags)}
            <div class="mt-2 padding-x">
                {include file=get_theme_path('views/modules/posts/inc/list_tags.tpl') tags=explode(',', $detail.tags)}
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

    <section class="bg-white padding-x p-2 pb-3">

        {if !empty($related_list)}
            <div class="category-name d-block pt-3 mb-4">
                <span>{lang('Post.text_related')}</span>
            </div>
            {foreach $related_list as $post}
                {if $post.post_id eq $detail.post_id}
                    {continue}
                {/if}

                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='small' article_class="mb-3 pb-3 border-bottom" is_show_category=true is_hide_description=true}
            {/foreach}
        {/if}

        {if !empty($post_same_category_list) && empty($lesson_categories)}
            <div class="category-name d-block my-4">
                <span>{lang('Post.text_same_category')}</span>
            </div>
            {foreach $post_same_category_list as $post}
                {if $post.post_id eq $detail.post_id}
                    {continue}
                {/if}
                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}

        {if !empty($counter_list)}
            <div class="category-name d-block my-4">
                <span>{lang('Post.text_popular_post')}</span>
            </div>
            {foreach $counter_list as $post}
                {if $post.post_id eq $detail.post_id}
                    {continue}
                {/if}
                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}

        {if !empty($post_latest_list)}
            <div class="category-name d-block my-4">
                <span>{lang('Post.text_latest_post')}</span>
            </div>
            {foreach $post_latest_list as $post}
                {if $post.post_id eq $detail.post_id}
                    {continue}
                {/if}
                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}

    </section>

{/strip}
