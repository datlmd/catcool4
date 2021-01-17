<div class="body {Events::trigger('div_body_class', '', 'string')}">
    {print_flash_alert()}
    {$header_top}
    {$header_bottom}
    <div role="main" class="main">
        {$breadcumb}
        <div class="container">
            <div class="row">
                {if !empty($content_left)}
                    <aside id="content-left" class="col-3 d-none d-md-block">
                        {$content_left}
                    </aside>
                {/if}

                <div id="content" class="col">
                    {$content_top}
                    {$content}
                    {$content_bottom}
                </div>

                {if !empty($content_right)}
                    <aside id="content-right" class="col-3 d-none d-md-block">
                        {$content_right}
                    </aside>
                {/if}
            </div>
        </div>
    </div>
    {$footer_top}
    {$footer_bottom}
</div>
