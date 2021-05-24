<div class="body {if !empty($div_body_class)}{$div_body_class}{/if}">
    {print_flash_alert()}
    {if !empty($header_top)}{$header_top}{/if}
    {if !empty($header_bottom)}{$header_bottom}{/if}
    <div role="main" class="main">
        {if !empty($breadcumb)}{$breadcumb}{/if}
        <div class="container">
            <div class="row">
                {if !empty($content_left)}
                    <aside id="content-left" class="col-3 d-none d-md-block">
                        {$content_left}
                    </aside>
                {/if}

                <div id="content" class="col">
                    {if !empty($content_top)}{$content_top}{/if}
                    {if !empty($content)}{$content}{/if}
                    {if !empty($content_bottom)}{$content_bottom}{/if}
                </div>

                {if !empty($content_right)}
                    <aside id="content-right" class="col-3 d-none d-md-block">
                        {$content_right}
                    </aside>
                {/if}
            </div>
        </div>
    </div>
    {if !empty($footer_top)}{$footer_top}{/if}
    {if !empty($footer_bottom)}{$footer_bottom}{/if}
</div>