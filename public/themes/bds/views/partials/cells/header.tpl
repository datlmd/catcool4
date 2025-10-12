{strip}
    <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <a href="{site_url()}" class="navbar-brand">
            <img alt="{config_item('site_name')}" width="60" data-change-src="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}" data-change-src-root="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}" class="image-change" src="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}">
            <span class="d-none">{config_item('site_name')}</span>
        </a>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{base_url()}" class="active">Vinhomes Cần Giờ</a></li>
          <li><a href="#tongquan">TỔNG QUAN</a></li>
          <li><a href="#vitri">VỊ TRÍ</a></li>
          <li><a href="#tienich">TIỆN ÍCH</a></li>
          <li><a href="#matbang">MẶT BẰNG</a></li>
          <li><a href="#tiendo">TIẾN ĐỘ</a></li>
          <li><a href="#phaply">PHÁP LÝ</a></li>
          <li><a href="#lienhe">LIÊN HỆ</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

    {* <header id="header" class="header shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light container-xxl p-0">
            <div class="container-fluid px-1">
                <a href="{site_url()}" class="navbar-brand">
                    <img alt="{config_item('site_name')}" width="auto" data-change-src="{img_url('logo_small.png')}" data-change-src-root="{img_url('logo.png')}" class="image-change" src="{img_url('logo.png')}">
                    <span class="d-none">{config_item('site_name')}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" id="btn_menu_show_offcanvas" data-bs-target="#navbar_menu_header_mobile" aria-controls="navbar_menu_header_mobile">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse d-none d-lg-block justify-content-end" id="navbar_menu_header">
                    {include file=get_theme_path('views/inc/menu_main.tpl')}
                    <form class="d-flex d-none">
                        <div><i class="fas fa-search"></i></div>
                    </form>
                </div>

                <div class="offcanvas offcanvas-start d-flex d-block d-lg-none" id="navbar_menu_header_mobile" aria-labelledby="offcanvasLeftLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasLeftLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <a href="{site_url()}" class="text-center d-flex-row mb-3 justify-content-center">
                        <img class="ml-2" alt="{config_item('site_name')}" width="auto" src="{img_url('logo.png')}">
                        <span class="d-none">{config_item('site_name')}</span>
                    </a>

                    {include file=get_theme_path('views/inc/menu_main.tpl') menu_type='mobile'}
                    <p class="text-center d-flex-row justify-content-center text-secondary fs-small py-3">{get_today()}</p>
                </div>
            </div>
        </nav>
    </header> *}
{/strip}
