{strip}
    {if !empty($article_info)}
        {if empty($article_type) || $article_type eq 'top'}
            <article {if !empty($article_class)}class="{$article_class}"{/if}>
                {if empty($is_hide_image)}
                    <a href="{site_url($article_info.detail_url)}" class="mb-2 d-block">
                        <img src="{if !empty($article_info.images.thumb)}{image_thumb_url($article_info.images.thumb, 140, 90)}{else}{image_thumb_url($article_info.images.robot, 140, 90)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($article_info.name)}">
                    </a>
                {/if}
                <h4>
                    <a href="{site_url($article_info.detail_url)}" class="art-title">{$article_info.name}</a>
                </h4>
                {if empty($is_hide_datetime)}
                    {if !empty($is_show_category) && !empty($article_info.category_ids)}
                        <div class="d-inline-block me-2">
                            {foreach $article_info.category_ids as $category_id}
                                <a href="{base_url($category_list[$category_id].slug)}" class="art-category">{$category_list[$category_id].name}</a>
                            {/foreach}
                        </div>
                    {/if}
                    <div class="d-inline-block art-time">
                         {time_ago($article_info.publish_date)}
                    </div>
                {/if}
                {if empty($is_hide_description)}
                    <p class="art-description">{$article_info.description|truncate:160}</p>
                {/if}
            </article>
        {elseif $article_type eq 'left'}
            <article {if !empty($article_class)}class="{$article_class}"{/if}>
                {if empty($is_hide_image)}
                    <a href="{site_url($article_info.detail_url)}" class="art-image">
                        <img src="{if !empty($article_info.images.thumb)}{image_thumb_url($article_info.images.thumb, 140, 90)}{else}{image_thumb_url($article_info.images.robot, 140, 90)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($article_info.name)}">
                    </a>
                {/if}
                <header>
                    <h4>
                        <a href="{site_url($article_info.detail_url)}" class="art-title">{$article_info.name}</a>
                    </h4>
                    {if empty($is_hide_datetime)}
                        {if !empty($is_show_category) && !empty($article_info.category_ids)}
                            <div class="d-inline-block me-2">
                                {foreach $article_info.category_ids as $category_id}
                                    <a href="{base_url($category_list[$category_id].slug)}" class="art-category">{$category_list[$category_id].name}</a>
                                {/foreach}
                            </div>
                        {/if}
                        <div class="d-inline-block art-time">
                            {time_ago($article_info.publish_date)}
                        </div>
                    {/if}
                    {if empty($is_hide_description)}
                        <p class="art-description">{$article_info.description|truncate:160}</p>
                    {/if}
                </header>
            </article>
        {elseif $article_type eq 'right'}
            <article {if !empty($article_class)}class="{$article_class}"{/if}>

                {if empty($is_hide_image)}
                    <a href="{site_url($article_info.detail_url)}" class="art-image art-image-right">
                        <img src="{if !empty($article_info.images.thumb)}{image_thumb_url($article_info.images.thumb, 140, 90)}{else}{image_thumb_url($article_info.images.robot, 140, 90)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($article_info.name)}">
                    </a>
                {/if}

                <header>
                    <h4>
                        <a href="{site_url($article_info.detail_url)}" class="art-title">{$article_info.name}</a>
                    </h4>
                    {if empty($is_hide_datetime)}
                        {if !empty($is_show_category) && !empty($article_info.category_ids)}
                            <div class="d-inline-block me-2">
                                {foreach $article_info.category_ids as $category_id}
                                    <a href="{base_url($category_list[$category_id].slug)}" class="art-category">{$category_list[$category_id].name}</a>
                                {/foreach}
                            </div>
                        {/if}
                        <div class="d-inline-block art-time">
                            {time_ago($article_info.publish_date)}
                        </div>
                    {/if}
                    {if empty($is_hide_description)}
                        <p class="art-description">{$article_info.description|truncate:160}</p>
                    {/if}
                </header>

            </article>
        {elseif $article_type eq 'small'}
            <article {if !empty($article_class)}class="{$article_class}"{/if}>
                {if empty($is_hide_image)}
                    <a href="{site_url($article_info.detail_url)}" class="art-image art-image-small">
                        <img src="{if !empty($article_info.images.thumb)}{image_thumb_url($article_info.images.thumb, 140, 90)}{else}{image_thumb_url($article_info.images.robot, 140, 90)}{/if}" class="img-fluid border-radius-0" width="100%" alt="{htmlentities($article_info.name)}">
                    </a>
                {/if}
                <header>
                    <h4>
                        <a href="{site_url($article_info.detail_url)}" class="art-title">{$article_info.name}</a>
                    </h4>
                    {if empty($is_hide_datetime)}
                        {if !empty($is_show_category) && !empty($article_info.category_ids)}
                            <div class="d-inline-block me-2">
                                {foreach $article_info.category_ids as $category_id}
                                    <a href="{base_url($category_list[$category_id].slug)}" class="art-category">{$category_list[$category_id].name}</a>
                                {/foreach}
                            </div>
                        {/if}
                        <div class="d-inline-block art-time">
                            {time_ago($article_info.publish_date)}
                        </div>
                    {/if}
                    {if empty($is_hide_description)}
                        <p class="art-description">{$article_info.description|truncate:160}</p>
                    {/if}
                </header>
            </article>
        {/if}
    {/if}
{/strip}
