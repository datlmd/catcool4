{strip}
    {if !empty($news)}
        {if !empty($is_mobile)}

            <article class="row p-3 mb-3 border-top border-bottom bg-white px-4">
                <h4 class="pb-2 line-height-4 font-weight-bold text-5 text-dark mb-0 ps-0 pe-1">
                    <a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a>
                </h4>
                <div class="col-4 p-1">
                    <a href="{site_url($news.detail_url)}">
                        <img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 110, 70)}{else}{image_thumb_url($news.images.robot, 110, 70)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($news.name)}">
                    </a>
                </div>
                <div class="col-8 ps-2 pe-0">
                    <p class="text-3">{$news.description|truncate:160}</p>
                    {if !empty($is_show_category) && !empty($news.category_ids)}
                        <span>
                            {foreach $news.category_ids as $category_id}
                                <a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none fw-light me-2">{$category_list[$category_id].name}</a>
                            {/foreach}
                        </span>
                    {/if}
                    <span class="d-inline-block text-default font-weight-normal text-1">
                         {time_ago($news.publish_date)}
                    </span>
                </div>

            </article>

        {else}

            <article class="post post-medium ms-2 ms-lg-0 border-bottom mb-4">
                <div class="row mb-4">
                    <div class="col-4 pe-0">
                        <div class="post-image">
                            <a href="{site_url($news.detail_url)}">
                                <img src="{if !empty($news.images.thumb)}{image_thumb_url($news.images.thumb, 220, 160)}{else}{image_thumb_url($news.images.robot, 220, 160)}{/if}" class="w-100" width="100%" alt="{htmlentities($news.name)}" />
                            </a>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="post-content">
                            <h4 class="font-weight-bold pt-0 text-5 line-height-4 mb-0"><a href="{site_url($news.detail_url)}" class="text-decoration-none text-color-dark">{$news.name}</a></h4>
                            {if !empty($is_show_category) && !empty($news.category_ids)}
                                <span>
                                    {foreach $news.category_ids as $category_id}
                                        <a href="{base_url($category_list[$category_id].slug)}" class="text-decoration-none fw-light me-2">{$category_list[$category_id].name}</a>
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
    {/if}
{/strip}
