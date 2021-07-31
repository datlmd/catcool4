{strip}
    <div class="row slide-right">
        <div class="col-12 col-md-8 {if empty($is_mobile)}ps-5{/if}">

            <div class="post-category-list mt-2 mt-lg-2">

                <div class="heading heading-border heading-bottom-double-border">
                    <h2 class="{if !empty($is_mobile)}px-4{/if}"><i class="fas fa-hashtag me-1"></i>{$tag}</h2>
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
        <div class="col-12 col-md-4 {if !empty($is_mobile)}px-4 mt-4{else}ps-5{/if}">
            <div data-plugin-sticky data-plugin-options="{literal}{'minWidth': 991, 'containerSelector': '.slide-right', 'padding': {'top': 55}}{/literal}">

                <div class="heading heading-border heading-bottom-double-border {if empty($is_mobile)}d-none{/if}">
                    <h3>{lang('News.text_hot')}</h3>
                </div>
                {include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12 col-md-8 {if !empty($is_mobile)}px-4{else}ps-5{/if}">

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
