{strip}
    {if !empty($news)}
        <article class="post post-medium ms-2 ms-lg-0">
            <div class="row mb-4">
                <div class="col-4">
                    <div class="post-image">
                        <a href="{site_url($news.detail_url)}">
                            <img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid img-thumbnail border-0 w-100" alt="{$news.name}" />
                        </a>
                    </div>
                </div>
                <div class="col-8 ps-0">
                    <div class="post-content">
                        <h4 class="font-weight-bold pt-0 text-4 line-height-4 mb-0"><a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a></h4>
                        {if !empty($is_show_category) && !empty($news.category_ids)}
                            <span>
                                {foreach $news.category_ids as $category_id}
                                    <a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none text-dark fw-bold me-2">{$category_list[$category_id].name}</a>
                                {/foreach}
                            </span>
                        {/if}
                        <span class="d-inline-block text-default text-1">
                            {time_ago($news.publish_date)}
                        </span>
                        <p class="mb-0 d-none d-md-block">
                            {$news.description}
                        </p>
                    </div>
                </div>
            </div>
        </article>
    {/if}
{/strip}
