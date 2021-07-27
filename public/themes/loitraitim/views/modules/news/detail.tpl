{strip}
    <div class="row slide-right">
        <div class="col-12 col-lg-8">

            <div class="blog-posts single-post mt-2 mt-lg-0 mt-xl-3">

                <article class="post post-detail">

                    {if !empty($is_mobile)}
                        {if !empty($detail.images.thumb) || !empty($detail.images.robot)}
                            <img src="{if !empty($detail.images.thumb)}{image_thumb_url($detail.images.thumb, 440, 300)}{else}{image_thumb_url($detail.images.robot, 440, 300)}{/if}" class="img-fluid border-radius-0 mb-2" width="100%" alt="{htmlentities($detail.name)}">
                        {/if}
                    {/if}

                    {if !empty($detail.category_ids)}
                        {foreach $detail.category_ids as $category_id}
                            <a href="{base_url($category_list[$category_id].slug)}" class="padding me-1">{$category_list[$category_id].name}</a>
                        {/foreach}
                    {/if}

                    <h2 class="font-weight-bold text-primary padding py-0 mb-0">{$detail.name}</h2>
                    <div class="post-content ml-0">
                        <div class="post-meta padding py-1">
                            {if !empty($detail.source)}
                                <span>
                                    {lang('News.text_source')}: {str_ireplace('www.', '', parse_url($detail.source, PHP_URL_HOST))}
                                </span>
                            {/if}
                            <span><i class="far fa-user"></i> {if !empty($detail.author)}{$detail.author}{else}Ryan Lee{/if}</span>
                            <span><i class="far fa-clock"></i> {time_ago($detail.publish_date)}</span>
                            <span><i class="fas fa-eye"></i> {$detail.counter_view}</span>
                            {if $detail.is_comment eq COMMENT_STATUS_ON}
                                <span id="detail_total_comment">
                                    <i class="far fa-comments"></i> <fb:comments-count href="{$detail.detail_url}"></fb:comments-count> {lang('News.text_comment')}
                                </span>
                            {/if}
                        </div>

                        <div class="w-100 padding py-1">
                            <blockquote class="blockquote-tertiary">
                                <p class="mb-0">{$detail.description}</p>
                            </blockquote>
                        </div>

                        <div class="detail-content">
                            {$detail.content}
                        </div>

                        <div class="padding pb-0">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="fb-like" data-href="{base_url($detail.detail_url)}" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="false"></div>
                                </div>
                            </div>

                            <h4>{lang('News.text_tag')}</h4>
                            {include file=get_theme_path('views/modules/news/inc/list_tags.tpl') tags=explode(',', $detail.tags)}

                            <div class="row">

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
                                {include file=get_theme_path('views/inc/facebook_comment.tpl') fb_url=base_url($detail.detail_url)}
                            {/if}
                        </div>

                    </div>

                </article>

            </div>

        </div>

        {if empty($is_mobile)}
            <div class="col-12 col-lg-4 d-none d-lg-block">
                <div data-plugin-sticky data-plugin-options="{literal}{'minWidth': 991, 'containerSelector': '.slide-right', 'padding': {'top': 55}}{/literal}">

                    {include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

                </div>
            </div>
        {/if}

    </div>

    <div class="row">
        <div class="col-12 col-lg-8 {if !empty($is_mobile)}px-4{/if} px-lg-4 px-xl-0">
            <div class="post-category-list">

                {include file=get_theme_path('views/modules/news/inc/detail_same_category.tpl') news_list=$news_category_list news_id_not=$detail.news_id}

                <div class="heading heading-border heading-bottom-double-border mt-4 mt-lg-5">
                    <h3>{lang('News.text_new_post')}</h3>
                </div>
                {include file=get_theme_path('views/modules/news/inc/list_new.tpl')}


                {if !empty($counter_list)}
                    <div class="heading heading-border heading-bottom-double-border mt-3 mt-lg-4">
                        <h3>{lang('News.text_popular_post')}</h3>
                    </div>
                    {foreach $counter_list as $news}
                        {include file=get_theme_path('views/modules/news/inc/item_news.tpl') news=$news}
                    {/foreach}
                {/if}

            </div>

        </div>
        <div class="col-12 col-lg-4">


        </div>
    </div>
{/strip}
