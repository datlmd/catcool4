{strip}
    <header id="header_main_pc" class="d-none d-lg-inline">
        {* phan header tren cung *}
        <div class="container-fluid header-top">
            <div class="container-xxl d-flex justify-content-between">

                {* <div class="header-top-contact animate__animated animate__fadeInDown"> *}
                <div class="header-top-contact">

                    <ul class="nav nav-pills">
                        {if !empty(config_item('store_address'))}
                            <li class="nav-item d-none d-md-inline">
                                <a class="nav-link disabled">
                                    <i class="far fa-dot-circle me-1"></i>
                                    {config_item('store_address')}
{*                                    <span data-type="lang" data-key="Frontend.text_address_value">{lang('Frontend.text_address_value')}</span>*}
                                </a>
                            </li>
                        {/if}
                        {if !empty(config_item('store_phone'))}
                            <li class="nav-item contact-phone">
                                <a href="tel:{config_item('store_phone')}" class="nav-link">
                                    <i class="fas fa-phone me-1"></i>
                                   {config_item('store_phone')}
                                </a>
                            </li>
                        {/if}
                        {if !empty(config_item('store_email'))}
                            <li class="nav-item">
                                <a href="mailto:{config_item('store_email')}" class="nav-link">
                                    <i class="far fa-envelope me-1"></i>
                                    {config_item('store_email')}
                                </a>
                            </li>
                        {/if}
                    </ul>

                </div>

                {* animate__animated animate__fadeIn *}
                <div class="header-top-account">

                    <ul class="nav">

                        <li class="nav-item">
                            {view_cell('Common::currency')}
                        </li>

                        {assign var="menu_top" value=get_menu_by_position(MENU_POSITION_TOP)}

                        {if !empty($menu_top)}
                            {foreach $menu_top as $key => $item}
                                <li class="nav-item d-none d-md-inline">
                                    <a class="nav-link" href="{$item.slug}">
                                        {if !empty($item.icon)}
                                            <i class="{$item.icon} me-1"></i>
                                        {/if}
                                        {$item.name}
                                    </a>
                                </li>
                            {/foreach}
                        {/if}

                        <li class="nav-item">
                            <a class="nav-link" href="{$wishlist}">
                                <i class="far fa-heart"></i>
                                <span class="d-none d-md-inline ms-1">{lang('General.text_wishlist')}</span>
                                <span class="ms-1">
                                    (0)
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{$shopping_cart}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="d-none d-md-inline ms-1">{lang('General.text_shopping_cart')}</span>
                                <span class="ms-1">
                                    (0)
                                </span>
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                {if !$logged}
                                    <i class="fas fa-user"></i>
                                    <span class="d-none d-md-inline ms-1">{lang('General.text_my_account')}</span>
                                {else}
                                    <img src="{image_url($customer_avatar, 45, 45)}" alt="{$customer_name}" class="rounded-circle customer-avatar" >
                                    <span class="d-none d-md-inline ms-1">{$customer_name}</span>
                                {/if}
                            </a>
                            <ul class="dropdown-menu">
                                {if !$logged}
                                    <li><a class="dropdown-item" href="{$login}">{lang('General.text_login')}</a></li>
                                    <li><a class="dropdown-item" href="{$register}">{lang('General.text_register')}</a></li>
                                {else}
                                    <li><a class="dropdown-item" href="{$account}">{lang('General.text_account')}</a></li>
                                    <li><a class="dropdown-item" href="{$order}">{lang('General.text_order')}</a></li>
                                    <li><a class="dropdown-item" href="{$transaction}">{lang('General.text_transaction')}</a></li>
                                    <li><a class="dropdown-item" href="{$logout}">{lang('General.text_logout')}</a></li>
                                {/if}
                            </ul>
                        </li>

                        {if is_multi_language() == true}
                            <li class="nav-item">
                                {view_cell('Common::language')}
                            </li>
                        {/if}

                    </ul>

                </div>

            </div>

        </div>

        {* phan header logo và tim kiem *}
        <div class="container-fluid header-center">
            <div class="container-xxl d-flex justify-content-between">
                <div class="header-logo">
                    <a href="{site_url()}">
                        <img alt="{config_item('site_name')}" class="" src="{image_url(config_item('image_logo_url'), 100, 80)}">
                    </a>
                </div>

                <div class="header-search-form" style="width: 40%">
                    {include file=get_view_path('common/search.tpl')}
                </div>
            </div>
        </div>

        {* phan header menu chinh *}
        <div class="header-bottom-scroll" style="display: none;"></div>

        <div class="container-fluid header-bottom">
            <div class="container-xxl header-menu">

                <div class="header-menu-content">

                    {view_cell('Common::menuMain')}

                </div>

            </div>
        </div>
    </header>

    <header id="header_main_mobile" class="d-block d-lg-none">
        {include file=get_view_path('common/header_menu_mobile.tpl')}
    </header>
{/strip}
