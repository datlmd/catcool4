{strip}
    <section class="page-header page-header-modern overlay overlay-color-quaternary overlay-show overlay-op-2 mb-0" style="background-image: url('{img_url('breadcrumb.jpg')}');">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col">
                    <div class="row">
                        <div class="col-md-12 align-self-center p-static order-2 text-center">
                            <div class="overflow-hidden pb-2">
                                <h1 class="font-weight-bold text-9 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="100">
                                    {if !empty($breadcrumb_title)}{$breadcrumb_title}{/if}
                                </h1>
                            </div>
                        </div>
                        <div class="col-md-12 align-self-center order-1">
                            {if !empty($breadcrumb)}{$breadcrumb}{/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/strip}
