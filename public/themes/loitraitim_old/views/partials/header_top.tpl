{strip}
    {literal}
    <div class="sticky-wrapper sticky-wrapper-transparent sticky-wrapper-effect-1 sticky-wrapper-border-bottom d-lg-block d-xl-none" data-plugin-sticky data-plugin-options="{'minWidth': 0, 'stickyStartEffectAt': 100, 'padding': {'top': 0}}">
    {/literal}
        <div class="sticky-body bg-white">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-9">
                        <div class="py-2">
                            <a href="{site_url()}">
                                <img class="ml-2" alt="{config_item('site_name')}" width="auto" data-change-src="{img_url('logo.png')}" src="{img_url('logo.png')}">
                            </a>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <button class="hamburguer-btn m-1" data-set-active="false">
                            <span class="hamburguer">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header id="header" class="side-header d-flex">
        <div class="header-body">
            <div class="header-container px-3 d-flex h-100">
                <div class="header-column flex-row flex-lg-column justify-content-center h-100">
                    <div class="header-row flex-row justify-content-start justify-content-lg-center py-lg-4 py-md-1">
                        <h1 class="header-logo my-0 my-lg-2">
                            <a href="{site_url()}">
                                <img alt="{config_item('site_name')}" width="100%" src="{img_url('logo.png')}">
                                <span class="hide-text">{config_item('site_name')}</span>
                            </a>
                        </h1>
                    </div>
                    <div class="header-row header-row-side-header flex-row h-100 pb-lg-5">
                        <div class="header-nav header-nav-links header-nav-links-side-header header-nav-links-vertical header-nav-links-vertical-columns align-self-center">
                            <div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders">
                                <nav class="collapse" id="menu_main_collapse">
                                    {include file=get_theme_path('views/inc/menu_main.tpl')}
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="header-row justify-content-end pb-lg-3">
                        <p class="text-2 mt-0 pt-lg-3">{get_today()}</p>
                        <p class="d-none text-1">{lang('News.text_copyright')}</p>
                        <button class="btn header-btn-collapse-nav m-0 ms-2" data-bs-toggle="collapse" href="#menu_main_collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

{/strip}
