{strip}

    <div class="container-xxl bg-white my-0 mt-lg-0 mt-xl-3 py-3 px-5">
        <div class="row">
            <div class="col">
                <div class="category-tree">
                    <a class="me-2" href="{site_url()}">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-angle-right me-2"></i>
                    {include file=get_theme_path('views/inc/category_tree.tpl') categories=$news_category_tree}
                </div>
                <div class="category-name d-block mt-3 mb-4 shadow-sm">
                    <span>{$detail.name}</span>
                </div>
                {if !empty($list)}
                    <div class="row">
                        {foreach $list as $news}
                            {if $news@iteration > 2}
                                {break}
                            {/if}
                            <div class="col-sm-6 col-12">
                                {include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_class="mb-3 home-page"}
                            </div>
                        {/foreach}
                    </div>

                    {foreach $list as $news}
                        {if $news@iteration <= 2}
                            {continue}
                        {/if}
                        {include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='left' article_class="mb-4 pt-4 border-top category"}
                    {/foreach}

                    {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                        {$pager->links('default', 'frontend')}
                    {/if}
                {/if}
            </div>
            <aside class="col-md-4 col-12 d-none d-lg-block pt-3 ps-4">

                {if !empty(slide_list)}
                    {foreach $slide_list as $news}
                        {include file=get_theme_path('views/modules/news/inc/article_info.tpl') article_info=$news article_type='left' article_class="mb-3" is_show_category=true is_hide_description=true}
                    {/foreach}
                {/if}

                {include file=get_theme_path('views/inc/shopee_ads.tpl')}

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
