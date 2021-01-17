<header id="header" data-plugin-options="{literal}{'stickyEnabled': false, 'stickyEnableOnBoxed': false, 'stickyEnableOnMobile': false, 'stickyStartAt': 122, 'stickySetTop': '-122px', 'stickyChangeLogo': false}{/literal}">
    <div class="header-body border-color-primary border-top-0 box-shadow-none">
        <div class="header-container container z-index-2" style="min-height: 70px;">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <h1 class="header-logo">
                            <a href="index.html">
                                <img alt="Porto" width="255" height="48" src="{img_url('assets/img/logo.png')}">
                                <span class="hide-text">Porto - Demo Blog 5</span>
                            </a>
                        </h1>
                    </div>
                </div>
                <div class="header-column justify-content-end">
                    <div class="header-row h-100">
                        <a href="http://themeforest.net/item/porto-responsive-html5-template/4106987" target="_blank" class="py-3 d-block">
{*                            <img alt="Porto" class="img-fluid pl-3" src="{img_url('assets/img/blog/blog-ad-2.jpg')}" />*}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-nav-bar header-nav-bar-top-border header-border-bottom bg-light">
            <div class="header-container container">
                <div class="header-row">
                    <div class="header-column">
                        <div class="header-row justify-content-end justify-content-lg-start">
                            <div class="header-nav p-0">
                                <div class="header-nav header-nav-line header-nav-top-line header-nav-top-line-with-border header-nav-spaced header-nav-first-item-no-padding justify-content-start">
                                    <div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                        <nav class="collapse">
                                            {include file=get_theme_path('views/inc/menu_main.tpl')}
                                        </nav>
                                    </div>
                                    <button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                                <div class="header-nav-features">
                                    <div class="header-nav-features-search-reveal-container">
                                        <div class="header-nav-feature header-nav-features-search header-nav-features-search-reveal d-inline-flex">
                                            <a href="#" class="header-nav-features-search-show-icon d-inline-flex"><i class="fas fa-search header-nav-top-icon"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-nav-features header-nav-features-no-border p-static">
        <div class="header-nav-feature header-nav-features-search header-nav-features-search-reveal header-nav-features-search-reveal-big-search header-nav-features-search-reveal-big-search-full">
            <div class="container">
                <div class="row h-100 d-flex">
                    <div class="col h-100 d-flex">
                        <form role="search" class="d-flex h-100 w-100" action="page-search-results.html" method="get">
                            <div class="big-search-header input-group">
                                <input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Type and hit enter...">
                                <a href="#" class="header-nav-features-search-hide-icon"><i class="fas fa-times header-nav-top-icon"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
