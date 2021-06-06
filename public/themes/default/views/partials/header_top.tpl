{strip}
    {literal}
    <header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 135, 'stickySetTop': '-135px', 'stickyChangeLogo': true}">
        <div class="header-body border-color-primary border-bottom-0 box-shadow-none" data-sticky-header-style="{'minResolution': 0}" data-sticky-header-style-active="{'background-color': '#f7f7f7'}" data-sticky-header-style-deactive="{'background-color': '#FFF'}">
    {/literal}
            <div class="header-top header-top-borders">
                <div class="container h-100">
                    <div class="header-row h-100">
                        <div class="header-column justify-content-start">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item nav-item-borders py-2">
                                            <span class="ps-0"><i class="far fa-dot-circle text-4 text-color-primary" style="top: 1px;"></i> 1234 Street Name, City Name</span>
                                        </li>
                                        <li class="nav-item nav-item-borders py-2 d-none d-lg-inline-flex">
                                            <a href="tel:123-456-7890"><i class="fab fa-whatsapp text-4 text-color-primary" style="top: 0;"></i> 123-456-7890</a>
                                        </li>
                                        <li class="nav-item nav-item-borders py-2 d-none d-sm-inline-flex">
                                            <a href="mailto:mail@domain.com"><i class="far fa-envelope text-4 text-color-primary" style="top: 1px;"></i> mail@domain.com</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    {assign var="menu_top" value=get_menu_by_position(MENU_POSITION_TOP)}
                                    <ul class="nav nav-pills">
                                        {if !empty($menu_top)}
                                            {foreach $menu_top as $key => $item}
                                                <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                                    <a class="nav-link ps-0" href="{site_url({$item.slug})}"><i class="fas fa-angle-right"></i> {$item.name}</a>
                                                </li>
                                            {/foreach}
                                        {/if}
                                        <li class="nav-item dropdown nav-item-left-border d-none d-sm-block">
                                            <a class="nav-link" href="#" role="button" id="dropdownLanguage" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img src="{img_url('blank.gif')}" class="flag flag-us" alt="English" /> English
                                                <i class="fas fa-angle-down"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownLanguage">
                                                <a class="dropdown-item" href="#"><img src="{img_url('blank.gif')}" class="flag flag-us" alt="English" /> English</a>
                                                <a class="dropdown-item" href="#"><img src="{img_url('blank.gif')}" class="flag flag-es" alt="English" /> Español</a>
                                                <a class="dropdown-item" href="#"><img src="{img_url('blank.gif')}" class="flag flag-fr" alt="English" /> Française</a>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-container container">
                <div class="header-row py-2">
                    <div class="header-column">
                        <div class="header-row">
                            <div class="header-logo">
                                <a href="index.html">
                                    <img alt="Porto" width="100" height="48" data-sticky-width="82" data-sticky-height="40" data-sticky-top="84" src="{img_url('logo.png')}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-column justify-content-end">
                        <div class="header-row">
                            <ul class="header-extra-info d-flex align-items-center me-3">
                                <li class="d-none d-sm-inline-flex">
                                    <div class="header-extra-info-text">
                                        <label>SEND US AN EMAIL</label>
                                        <strong><a href="mailto:mail@example.com">MAIL@EXAMPLE.COM</a></strong>
                                    </div>
                                </li>
                                <li>
                                    <div class="header-extra-info-text">
                                        <label>CALL US NOW</label>
                                        <strong><a href="tel:8001234567">800-123-4567</a></strong>
                                    </div>
                                </li>
                            </ul>
                            <div class="header-nav-features">
                                <div class="header-nav-feature header-nav-features-cart header-nav-features-cart-big d-inline-flex ms-2" {literal}data-sticky-header-style="{'minResolution': 991}" data-sticky-header-style-active="{'top': '78px'}" data-sticky-header-style-deactive="{'top': '0'}"{/literal}>
                                    <a href="#" class="header-nav-features-toggle">
                                        <img src="{img_url('icons/icon-cart-big.svg')}" height="34" alt="" class="header-nav-top-icon-img">
                                                    <span class="cart-info">
                                                        <span class="cart-qty">1</span>
                                                    </span>
                                    </a>
                                    <div class="header-nav-features-dropdown" id="headerTopCartDropdown">
                                        <ol class="mini-products-list">
                                            <li class="item">
                                                <a href="#" title="Camera X1000" class="product-image"><img src="{img_url('products/product-1.jpg')}" alt="Camera X1000"></a>
                                                <div class="product-details">
                                                    <p class="product-name">
                                                        <a href="#">Camera X1000 </a>
                                                    </p>
                                                    <p class="qty-price">
                                                        1X <span class="price">$890</span>
                                                    </p>
                                                    <a href="#" title="Remove This Item" class="btn-remove"><i class="fas fa-times"></i></a>
                                                </div>
                                            </li>
                                        </ol>
                                        <div class="totals">
                                            <span class="label">Total:</span>
                                            <span class="price-total"><span class="price">$890</span></span>
                                        </div>
                                        <div class="actions">
                                            <a class="btn btn-dark" href="#">View Cart</a>
                                            <a class="btn btn-primary" href="#">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="header-nav-bar bg-color-light-scale-1 mb-3 px-3 px-lg-0">
                    <div class="header-row">
                        <div class="header-column">
                            <div class="header-row justify-content-end">
                                <div class="header-nav header-nav-links justify-content-start" {literal}data-sticky-header-style="{'minResolution': 991}" data-sticky-header-style-active="{'margin-left': '150px'}" data-sticky-header-style-deactive="{'margin-left': '0'}"{/literal}>
                                    <div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                        <nav class="collapse">
                                            {assign var="menu_main" value=get_menu_by_position()}
                                            <ul class="nav nav-pills" id="mainNav">
                                                {if !empty($menu_main)}
                                                    {foreach $menu_main as $key => $item}
                                                        <li class="dropdown">
                                                            <a class="dropdown-item dropdown-toggle" href="{site_url({$item.slug})}">
                                                                {$item.name}
                                                            </a>
                                                            {if !empty($item.subs)}
                                                                <ul class="dropdown-menu">
                                                                    {foreach $item.subs as $sub}
                                                                        <li>
                                                                            <a class="dropdown-item" href="{site_url({$sub.slug})}">
                                                                                {$sub.name}
                                                                            </a>
                                                                        </li>
                                                                    {/foreach}
                                                                </ul>
                                                            {/if}
                                                        </li>
                                                    {/foreach}
                                                {/if}
                                            </ul>
                                        </nav>
                                    </div>
                                    <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-target=".header-nav-main nav">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                                <div class="header-nav-features header-nav-features-no-border d-none d-md-inline-flex" style="margin-right: 10px;" {literal}data-sticky-header-style="{'minResolution': 991}" data-sticky-header-style-active="{'margin-right': '50px'}" data-sticky-header-style-deactive="{'margin-right': '10px'}"{/literal}>
                                    <form role="search" action="page-search-results.html" method="get">
                                        <div class="simple-search input-group w-auto">
                                            <input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Search...">
                                        <span class="input-group-append bg-white">
                                            <button class="btn" type="submit">
                                                <i class="fa fa-search header-nav-top-icon"></i>
                                            </button>
                                        </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
{/strip}
