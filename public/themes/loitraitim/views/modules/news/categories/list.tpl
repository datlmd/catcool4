{strip}
    <div class="row slide-right">
        <div class="col-12 col-md-8 {if empty($is_mobile)}ps-5{/if}">

            <div class="post-category-list mt-2 mt-lg-2">

                <div class="heading heading-border heading-bottom-double-border">
                    <h2 class="{if !empty($is_mobile)}px-4{/if}">{$detail.name}</h2>
                </div>
                {if !empty($list)}

                    {if empty($is_mobile)}
                        <div class="row mb-5">
                            {foreach $list as $news}
                                {if $news@iteration <= 2}
                                    <div class="col-12 col-md-6">
                                        <article class="post post-medium ms-2 ms-lg-0 mb-4">
                                            <a href="{site_url($news.detail_url)}">
                                                <img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="w-100" width="100%" alt="{htmlentities($news.name)}" />
                                            </a>
                                            <div class="post-content">
                                                <h4 class="font-weight-bold pt-0 text-5 line-height-4 mb-0"><a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a></h4>

                                                <span class="d-inline-block text-default text-1">
                                                    {time_ago($news.publish_date)}
                                                </span>
                                                <p class="mb-0 d-none d-md-block">
                                                    {$news.description}
                                                </p>
                                            </div>
                                        </article>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                    {else}
                        {foreach $list as $news}
                            {if $news@iteration <= 2}
                                {include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news}
                            {/if}
                        {/foreach}
                    {/if}

                    {foreach $list as $news}
                        {if $news@iteration > 2}
                            {include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news}
                        {/if}
                    {/foreach}
                {/if}

            </div>

            {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                {$pager->links('default', 'frontend')}
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
