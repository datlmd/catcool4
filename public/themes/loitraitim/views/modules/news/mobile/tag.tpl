{strip}

    <div class="bg-white my-0 p-2">

        <div class="category-name d-block mt-2 mb-4 shadow-sm">
            <span><i class="fas fa-hashtag"></i>{$tag}</span>
        </div>

        {if !empty($list)}

            {foreach $list as $news}
                {include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='middle_left' article_class="mb-4 pb-4 border-bottom category" is_show_category=true}
            {/foreach}

            {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                {$pager->links('default', 'frontend')}
            {/if}
        {/if}

        {include file=get_theme_path('views/modules/news/inc/list_new.tpl')}
    </div>


    {include file=get_theme_path('views/modules/news/inc/counter_view.tpl')}


{/strip}
