{strip}
    <div class="row slide-right">
        <div class="col-12 col-md-8">

            <div class="post-category-list mt-2 mt-lg-4">

                <div class="heading heading-border heading-bottom-double-border">
                    <h2><i class="fas fa-hashtag me-1"></i>{$tag}</h2>
                </div>
                {if !empty($list)}
                    {foreach $list as $news}
                        {include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news is_show_category=true}
                    {/foreach}
                {/if}

            </div>

            {if !empty($list) && !empty($pager->links('news', 'frontend'))}
                {$pager->links('news', 'frontend')}
            {/if}

        </div>
        <div class="col-12 col-md-4">
            <div data-plugin-sticky data-plugin-options="{literal}{'minWidth': 991, 'containerSelector': '.slide-right', 'padding': {'top': 55}}{/literal}">

                {include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12 col-md-8">

            <div class="post-category-list mt-3">

                <div class="heading heading-border heading-bottom-double-border">
                    <h3>{lang('News.text_new_post')}</h3>
                </div>

                {include file=get_theme_path('views/modules/news/inc/list_new.tpl')}

                {if !empty($counter_list)}
                    <div class="heading heading-border heading-bottom-double-border mt-3 mt-lg-5">
                        <h3>{lang('News.text_popular_post')}</h3>
                    </div>
                    {foreach $counter_list as $news}
                        {include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news is_show_category=true}
                    {/foreach}
                {/if}

            </div>
        </div>
        <div class="col-12 col-md-4">


        </div>
    </div>
{/strip}
