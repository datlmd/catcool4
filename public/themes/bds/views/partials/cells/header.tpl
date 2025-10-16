{strip}
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="{site_url()}" class="logo d-flex align-items-center me-auto me-xl-0">
                <img alt="{config_item('site_name')}" width="60"
                    data-change-src="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}"
                    data-change-src-root="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}" class="image-change"
                    src="{img_url('cangio/Vinhomes-Green-Paradise-Logo-2.png')}">
                <span class="d-none">{config_item('site_name')}</span>
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
{/strip}