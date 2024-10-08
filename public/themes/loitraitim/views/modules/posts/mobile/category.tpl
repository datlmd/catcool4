{strip}

    <div class="bg-white my-0 p-2">

        <div class="category-tree">
            <a class="me-2" href="{site_url()}">
                <i class="fas fa-home"></i>
            </a>
            {include file=get_theme_path('views/inc/category_tree.tpl') categories=$post_category_tree}
        </div>

        <div class="category-name d-block mt-2 mb-4 shadow-sm">
            <span>{$detail.name}</span>
        </div>

        {if !empty($list)}
            <div class="mb-5">
                {foreach $list as $post}
                    {if $post@iteration eq 1}
                        {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_class="mb-3 home-page"}
                    {else}
                        {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-4 pt-4 border-top category"}
                    {/if}
                {/foreach}

                {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                    {$pager->links('default', 'frontend')}
                {/if}
            </div>
        {/if}

        {if !empty($post_latest_list)}
            <div class="category-name d-block mt-4 mb-4">
                <span>{lang('Post.text_latest_post')}</span>
            </div>
            {foreach $post_latest_list as $post}
                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}

        {if !empty($counter_list)}
            <div class="category-name d-block mt-4 mb-4">
                <span>{lang('Post.text_popular_post')}</span>
            </div>
            {foreach $counter_list as $post}
                {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$post article_type='middle_left' article_class="mb-3 pb-3 border-bottom" is_show_category=true}
            {/foreach}
        {/if}
    </div>


    {* {include file=get_theme_path('views/modules/news/inc/counter_view.tpl') counter_list=$counter_list} *}


{/strip}
