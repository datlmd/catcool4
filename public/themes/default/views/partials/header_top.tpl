{strip}
    <header>
        {* phan header tren cung *}
        <div class="container-fluid header-top">
            <div class="container-xxl d-flex justify-content-between">

                <div class="header-top-contact animate__animated animate__fadeInDown">

                    <ul class="nav nav-pills">
                        {if !empty(lang('Frontend.text_address_value'))}
                            <li class="nav-item d-none d-md-inline">
                                <a class="nav-link disabled">
                                    <i class="far fa-dot-circle me-1"></i>
                                    <span data-type="lang" data-key="Frontend.text_address_value">{lang('Frontend.text_address_value')}</span>
                                </a>
                            </li>
                        {/if}
                        {if !empty(lang('Frontend.text_phone_value'))}
                            <li class="nav-item contact-phone">
                                <a href="tel:{lang('Frontend.text_phone_value')}" class="nav-link">
                                    <i class="fas fa-phone me-1"></i>
                                    <span class="d-none d-md-inline" data-type="lang" data-key="Frontend.text_phone_value">{lang('Frontend.text_phone_value')}</span>
                                </a>
                            </li>
                        {/if}
                        {if !empty(lang('Frontend.text_email_value'))}
                            <li class="nav-item">
                                <a href="mailto:{lang('Frontend.text_email_value')}" class="nav-link">
                                    <i class="far fa-envelope me-1"></i>
                                    <span class="d-none d-md-inline" data-type="lang" data-key="Frontend.text_email_value">{lang('Frontend.text_email_value')}</span>
                                </a>
                            </li>
                        {/if}
                    </ul>

                </div>

                <div class="header-top-account animate__animated animate__fadeIn">

                    <ul class="nav">

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
                            {view_cell('Common::currency')}
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                                <span class="d-none d-md-inline ms-1">{lang('Frontend.text_my_account')}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Tên</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <i class="far fa-heart"></i>
                                <span class="d-none d-md-inline ms-1">{lang('Frontend.text_wishlist')}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="d-none d-md-inline ms-1">{lang('Frontend.text_shopping_cart')}</span>
                            </a>
                        </li>

                        {if is_multi_lang() == true}
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
                        <img alt="{config_item('site_name')}" class="" src="{image_thumb_url(config_item('image_logo_url'), 100, 80)}">
                    </a>
                </div>

                <div class="header-search">
                    <form role="search" action="{site_url("search")}" method="get">
                        <div class="input-group">
                            <input type="text" name="t" class="form-control" placeholder="{lang('General.text_search')}" aria-label="{lang('General.text_search')}" aria-describedby="btn_search_product">
                            <button  type="submit" class="input-group-text" id="btn_search_product"><i class="fa fa-search header-nav-top-icon"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {* phan header menu chinh *}
        <div class="container-fluid header-bottom">
            <div class="container-xxl header-menu">

                <div class="header-menu-content">

                    {view_cell('Common::menuMain')}

                </div>

            </div>
        </div>
    </header>
{/strip}
