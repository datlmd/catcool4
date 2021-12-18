{strip}

    <div class="container-xxl bg-white my-0 mt-lg-0 mt-xl-3 py-3 px-5">
        <div class="row">
            <div class="col">
                <div class="category-name d-block mt-4 mb-4">
                    <span><i class="fas fa-hashtag"></i>{$tag}</span>
                </div>

                {if !empty($list)}

                    {foreach $list as $news}
                        {include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='left' article_class="mb-4 pb-4 border-bottom category" is_show_category=true}
                    {/foreach}

                    {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                        {$pager->links('default', 'frontend')}
                    {/if}
                {/if}
            </div>
            <aside class="col-md-4 col-12 d-none d-lg-block pt-3 ps-4">

                {if !empty(slide_list)}
                    {foreach $new_list as $news}
                        {include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='left' article_class="mb-3" is_show_category=true is_hide_description=true}
                    {/foreach}
                {/if}

            </aside>
        </div>
    </div>

    <section class="container-xxl bg-white px-5 pb-3">
        <div class="row">
            <div class="col">

                {include file=get_theme_path('views/modules/news/inc/list_new.tpl')}

            </div>
            <div class="col-md-4 col-12">

            </div>
        </div>
    </section>


    {include file=get_theme_path('views/modules/news/inc/counter_view.tpl')}


{/strip}
