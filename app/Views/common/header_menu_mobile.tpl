{strip}
{*    phan khai bao chieu cao khi scroll*}
    <div class="header-mobile-scroll" style="display: none;"></div>

    <div class="header-mobile-content container-fluid border-bottom">
        <div class="d-flex justify-content-between">

            <div class="header-logo">
                <a href="{site_url()}">
                    <img alt="{config_item('site_name')}" class="" src="{image_thumb_url(config_item('image_logo_url'), 100, 80)}">
                </a>
            </div>

            <div class="header-mobile-menu-icon">

                <ul class="nav">

                    <li class="nav-item">
                        <a class="nav-link header-menu-icon-search" data-bs-toggle="offcanvas" href="#mobile_search_form_offcanvas" aria-controls="mobile_search_form_offcanvas">
                            <i class="fas fa-search"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{$wishlist}" title="{lang('General.text_wishlist')}">
                            <i class="far fa-heart"></i>
                            <span class="position-absolute top-1 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="{$shopping_cart}" title="{lang('General.text_shopping_cart')}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="position-absolute top-1 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" title="{lang('General.text_my_account')}" data-bs-toggle="dropdown" aria-expanded="false">
                            {if !$logged}
                                <i class="fas fa-user"></i>
                            {else}
                                <img src="{$customer_avatar}" alt="{$customer_name}" class="rounded-circle customer-avatar" >
                            {/if}
                            
                        </a>
                        <ul class="dropdown-menu">
                            {if !$logged}
                                <li><a class="dropdown-item" href="{$login}">{lang('General.text_login')}</a></li>
                                <li><a class="dropdown-item" href="{$register}">{lang('General.text_register')}</a></li>
                            {else}
                                <li><a class="dropdown-item text-uppercase text-primary" href="{$account}">
                                {* {lang('General.text_account')} *}
                                    {$customer_name}
                                </a></li>
                                <li><a class="dropdown-item" href="{$order}">{lang('General.text_order')}</a></li>
                                <li><a class="dropdown-item" href="{$transaction}">{lang('General.text_transaction')}</a></li>
                                <li><a class="dropdown-item" href="{$logout}">{lang('General.text_logout')}</a></li>
                            {/if}
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link header-menu-icon-offcanvas" data-bs-toggle="offcanvas" href="#header_mobile_offcanvas_menu" aria-controls="header_mobile_offcanvas_menu">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                </ul>


            </div>
        </div>
    </div>

    {* ---Khu vuc tim kiem mobile--- *}
    <div class="offcanvas offcanvas-top" tabindex="-1" id="mobile_search_form_offcanvas" aria-labelledby="mobile_search_form_offcanvas_label">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobile_search_form_offcanvas_label">{lang('Frontend.text_search_title')}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="header-search-form offcanvas-body">
            {include file=get_view_path('common/search.tpl')}
        </div>
    </div>

    {* ---Khu vuc hien thi menu mobile--- *}
    <div class="offcanvas offcanvas-start header-mobile-offcanvas" tabindex="-1" id="header_mobile_offcanvas_menu" aria-labelledby="header_mobile_offcanvas_menu_label">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="header_mobile_offcanvas_menu_label">{lang('Frontend.text_menu')}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex align-items-start flex-column h-100">
                <div class="mb-auto overflow-auto">

                    {assign var="menu_main" value=get_menu_by_position()}
                    <ul class="nav header-mobile-menu-main">
                        {if !empty($menu_main)}
                            {foreach $menu_main as $key => $item}
                                <li class="nav-item">
                                    {if empty($item.subs)}
                                        <a class="nav-item" href="{$item.slug}">
                                            {$item.name}
                                        </a>
                                    {else}
                                        <a class="nav-item icon-collapse collapsed" data-bs-toggle="collapse" href="#mobile_menu_main_{$key}" role="button" aria-expanded="false" aria-controls="mobile_menu_main_{$key}">
                                            {$item.name}
                                            <span></span>
                                        </a>

                                        <div id="mobile_menu_main_{$key}" class="collapse multi-collapse">
                                            <ul  class="list-unstyled">
                                                {foreach $item.subs as $sub}
                                                    <li>
                                                        <a class="nav-item" href="{$sub.slug}">
                                                            <span>{$sub.name}</span>
                                                        </a>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        </div>
                                    {/if}
                                </li>
                            {/foreach}

                        {/if}
                    </ul>

                </div>

                <div class="header-mobile-menu-bottom">

                    <ul class="nav header-mobile-menu-main">
                        {if is_multi_language() == true}
                            <li class="nav-item">
                                {view_cell('Common::language', 'type=collapse')}
                            </li>
                        {/if}

                        <li class="nav-item">
                            {view_cell('Common::currency', 'type=collapse')}
                        </li>
                    </ul>

                </div>

            </div>

        </div>
    </div>
{/strip}

