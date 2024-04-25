<section class="page-header page-header-classic" style="background-image: url('{img_url('breadcrumb.jpg')}');">
    <div class="container">
        <div class="row">
            <div class="col">
                {if !empty($breadcrumb)}{$breadcrumb}{/if}
            </div>
        </div>
        <div class="row">
            <div class="col p-static">
                <h1 data-title-border>{if !empty($breadcrumb_title)}{$breadcrumb_title}{/if}</h1>
            </div>
        </div>
    </div>
</section>