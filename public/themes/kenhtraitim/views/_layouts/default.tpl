<div class="body {Events::trigger('div_body_class', '', 'string')}">
    {print_flash_alert()}
    {$header_top}
    {$header_bottom}
    <div role="main" class="main">
        {$breadcumb}
        <div class="container">
            <div class="row">
                {if !empty($content_left)}
                    <aside id="content-left" class="col-lg-3">
                        {$content_left}
                    </aside>
                {/if}

                <div id="content" class="{if !empty($content_right) && !empty($content_left)}col-lg-6{elseif !empty($content_right)}col-lg-9 order-lg-1{elseif !empty($content_left)}col-lg-9{else}col-lg-12{/if}">
                    {$content_top}
                    {$content}
                    {$content_bottom}
                </div>

                {if !empty($content_right)}
                    <aside id="content-right" class="col-lg-3 order-lg-2">
                        {$content_right}
                    </aside>
                {/if}
            </div>
        </div>
    </div>
    {$footer_top}
    {$footer_bottom}
</div>
