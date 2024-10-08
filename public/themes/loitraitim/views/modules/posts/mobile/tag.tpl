{strip}

    <div class="bg-white my-0 p-2">

        <div class="category-name d-block mt-2 mb-4 shadow-sm">
            <span><i class="fas fa-hashtag"></i>{$tag}</span>
        </div>

        {if !empty($list)}
            <div class="mb-5">
                {foreach $list as $post}
                    {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-4 pb-4 border-bottom category" is_show_category=true}
                {/foreach}

                {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                    {$pager->links('default', 'frontend')}
                {/if}
            </div>
        {/if}

        {if !empty($post_counter_list)}
            <div class="category-name d-block mt-2 mb-4">
                <span>{lang('Post.text_popular_post')}</span>
            </div>
            {foreach $post_counter_list as $post}
                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}

        {if !empty($post_latest_list)}
            <div class="category-name d-block mt-2 mb-4">
                <span>{lang('Post.text_latest_post')}</span>
            </div>
            {foreach $post_latest_list as $post}
                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}
    </div>


    {* {include file=get_theme_path('views/modules/news/inc/counter_view.tpl') counter_list=$post_hot_list text_title=lang('Post.text_hot_post')} *}


{/strip}
