<div class="blog-posts single-post mt-4 ">
    <article class="post post-large blog-single-post border-0 m-0 p-0">
        <div class="post-content ml-0">
            <h2 class="font-weight-bold">{$detail.name|unescape:"html"}</h2>
            <div class="post-meta">
                <span><i class="far fa-user"></i> RSS: <a href="{$detail.source}" target="_blank" title="{$detail.source}">{$detail.source|truncate:70:"...":true}</a> </span>
{*                {if !empty($detail.tags)}*}
{*                    <span>*}
{*                        <i class="far fa-folder"></i>*}
{*                        {foreach explode(',', $detail.tags) as $tag}*}
{*                            <a href="{base_url()}tags/{$tag}">{$tag}</a>*}
{*                        {/foreach}*}
{*                    </span>*}
{*                {/if}*}
                <span><i class="far fa-clock"></i> {format_date($detail.publish_date, "H:i d/m/Y")}</span>

{*                    <span><i class="far fa-comments"></i> <a href="#">12 Comments</a></span>*}
            </div>
            <div>
                {$detail.content|unescape:"html"}
            </div>



            {include file=get_theme_path('views/_modules/news/inc/list_tags.tpl') tags=explode(',', $detail.tags)}

            <div class="post-block mt-5 post-share">
                <h4 class="mb-3">Share this Post</h4>

                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style ">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a class="addthis_button_tweet"></a>
                    <a class="addthis_button_pinterest_pinit"></a>
                    <a class="addthis_counter addthis_pill_style"></a>
                </div>
                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50faf75173aadc53"></script>
                <!-- AddThis Button END -->

            </div>

            {assign var="fb_url" value="`$news.slug`.`$news.news_id`"}
            {include file=get_theme_path('views/inc/facebook_comment.tpl') fb_url=site_url($fb_url)}


        </div>
    </article>
</div>

{include file=get_theme_path('views/_modules/news/inc/list_news_top.tpl') news_list=$news_category_list news_id_not=$detail.news_id}