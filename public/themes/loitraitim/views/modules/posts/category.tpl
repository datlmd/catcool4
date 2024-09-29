{strip}

    <div class="container-xxl bg-white my-0 mt-lg-0 mt-xl-3 py-3 px-5">
        <div class="row">
            <div class="col pe-4">

                <div class="category-tree">
                    <a class="me-2" href="{site_url()}">
                        <i class="fas fa-home"></i>
                    </a>
                    {include file=get_theme_path('views/inc/category_tree.tpl') categories=$post_category_tree}
                </div>

                <div class="category-name d-block mt-3 mb-4">
                    <span>{$detail.name}</span>
                </div>
                {if !empty($list)}
                 
                    {foreach $list as $post}
                        {if $post@iteration < 2}
                            {assign var="image_type" value="left"}
                        {else}
                            {assign var="image_type" value="small"}
                        {/if}
                        {include file=get_theme_path('views/modules/posts/inc/article_info.tpl') 
                            article_info=$post 
                            article_type=$image_type 
                            article_class="mb-4 pt-4 border-top category"
                            is_show_tag=true
                        }
                    {/foreach}

                    {if !empty($list) && !empty($pager->links('default', 'frontend'))}
                        {$pager->links('default', 'frontend')}
                    {/if}
                {/if}
            </div>
            <aside class="col-md-4 col-12 d-none d-lg-block pt-3 ps-4">
                
                {if !empty($counter_list)}
                    <div class="category-name d-block mt-2 mb-4">
                        <span>{lang('Post.text_popular_post')}</span>
                    </div>

                    {foreach $counter_list as $post}
                        {include file=get_theme_path('views/modules/posts/inc/article_info.tpl')
                            article_info=$post article_type='small'
                            article_class="mb-3"
                            is_show_category=true
                            is_hide_description=true
                        }
                    {/foreach}
                {/if}

            </aside>
        </div>
    </div>

    <section class="container-xxl bg-white px-5 py-3">
        <div class="row">
            <div class="col">

                {if !empty($post_latest_list)}
                    <div class="category-name d-block mt-2 mb-4">
                        <span>{lang('Post.text_latest_post')}</span>
                    </div>
                    {foreach $post_latest_list as $post}
                        {include file=get_theme_path('views/modules/posts/inc/article_info.tpl') 
                        article_info=$post 
                        article_type='small' 
                        article_class="mb-3 pb-3 border-bottom" 
                        is_show_category=true}
                    {/foreach}
                {/if}

            </div>
            <div class="col-md-4 col-12">
                

            </div>
        </div>
    </section>


    {* {include file=get_theme_path('views/modules/posts/inc/counter_view.tpl') counter_list=$counter_list} *}

{/strip}
