{strip}
    {if !empty($news)}
        <article class="post post-medium ms-2 ms-lg-0">
            <div class="row mb-4">
                <div class="col-4">
                    <div class="post-image">
                        <a href="{site_url($news.detail_url)}">
                            <img src="{if !empty($news.images.root)}{image_thumb_url($news.images.root)}{else}{image_thumb_url($news.images.robot)}{/if}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded w-100" alt="{$news.name}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" />
                        </a>
                    </div>
                </div>
                <div class="col-8 ps-0">
                    <div class="post-content">
                        <h4 class="font-weight-bold pt-0 text-4 line-height-4 mb-2"><a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a></h4>
                        <p class="mb-0 d-none d-md-block">
                            {$news.description}
                            <span class="d-inline-block text-default text-1 ps-2">
                                {time_ago($news.publish_date)}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </article>
    {/if}
{/strip}
