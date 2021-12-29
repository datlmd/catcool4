{strip}

    <div class="bg-white my-0 p-2">

        <div class="category-tree">
            <a class="me-2" href="{site_url()}">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-angle-right me-2"></i>
            {include file=get_theme_path('views/inc/category_tree.tpl') categories=$post_category_tree}
        </div>

        <div class="category-name d-block mt-2 mb-4 shadow-sm">
            <span>{$detail.name}</span>
        </div>

        {if !empty($list)}

            {foreach $list as $news}
                {if $news@iteration eq 1}
                    {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$news article_class="mb-3 home-page"}
                {else}
                    {include file=get_theme_path('views/modules/posts/inc/article_info_mobile.tpl') article_info=$news article_type='middle_left' article_class="mb-4 pt-4 border-top category"}
                {/if}
            {/foreach}

            {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                {$pager->links('default', 'frontend')}
            {/if}
        {/if}

        {include file=get_theme_path('views/modules/news/inc/list_new.tpl')}
    </div>


    {include file=get_theme_path('views/modules/news/inc/counter_view.tpl')}


{/strip}
