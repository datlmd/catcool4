<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class CustomConfig extends BaseConfig
{
    public $language = "vn";
    public $list_language_cache = '{"1":{"id":"1","name":"Vietnames","code":"vn","icon":null,"user_id":"1","published":"1"},"2":{"id":"2","name":"English","code":"english","icon":"flag-icon flag-icon-gb","user_id":"1","published":"1"}}';
    public $is_show_select_language = true;
    public $theme_frontend = "kenhtraitim";
    public $theme_admin = "admin";
    public $site_name = "Cat Cool CMS";
    public $site_keywords = "Cthiet ke web, website, chuyen nghiep";
    public $site_description = "thiết kế website chuyên nghiệp";
    public $catcool_hash = "pass!@#$%";

    public $admin_group = "admin";

    //Thời gian expire cookie của user khi login
    public $user_expire = 0;

    //Tên cookie login cho user
    public $remember_cookie_name = "remember_cookie_catcool";

    //Có cần check csrf trong admin hay không?
    public $is_check_csrf_admin = TRUE;

    //Set tên input khi sử dụng giá trị cho csrf key
    public $csrf_name_key = "t_cc_key";

    //Set tên input khi sử dụng csrf value
    public $csrf_name_value = "t_cc_value";

    //Thời gian expire của csrf
    public $csrf_cookie_expire = 3600;

    //Hiển thị develbar tool hay không? 1
    public $enable_develbar = FALSE;

    public $site_url = "http://192.168.64.2/dev/catcool";

    //Bật chế độ resize hình
    public $enable_resize_image = true;

    //Hình logo
    public $image_logo_url = "";

    //Hình mặc định nêu hình gốc không tồn tại
    public $image_none = "root/logo-hoatuoi24h-21.png";

    //Chiều rộng hình tối đa trên pc
    public $image_width_pc = 1280;

    //Chiều cao tối đa của hình trên pc
    public $image_height_pc = 1024;

    //Chiều rộng tối đa của hình trên mobile (pixel)
    public $image_width_mobile = 800;

    //Chiều cao tối đa của hình trên mobile
    public $image_height_mobile = 800;

    //Hiển thị thanh menu, false sẽ ẩn menu gọn lại
    public $enable_scroll_menu_admin = true;

    //true sử dụng menu bằng icon, false sẽ sử dụng menu kiểu text
    public $enable_icon_menu_admin = true;

    //Avatar mặc định cho nam
    public $avatar_default_male = "images/male.png";

    //Avatar mặc định cho nữ
    public $avatar_default_female = "images/female.png";

    //Setting email host
    public $email_host = "ssl://smtp.googlemail.com";

    //Port email
    public $email_port = 465;

    //Tài khoảng email smtp
    public $email_smtp_user = "lmd.dat@gmail.com";

    //email smtp pass
    public $email_smtp_pass = "tovyyqgibmnruaes";

    //Email from
    public $email_from = "lmd.dat@gmail.com";

    //Email Subject title
    public $email_subject_title = "CatCool FW";

    //Bật SSL
    public $enable_ssl = TRUE;

    //Khai báo html cho breadcrumb open
    public $breadcrumb_open = "<ul class='breadcrumb breadcrumb-light d-block text-center appear-animation' data-appear-animation='fadeIn' data-appear-animation-delay='300'>";

    //Khai báo html cho breadcrumb close
    public $breadcrumb_close = "</ul>";

    //Khai báo html cho breadcrumb_item_open
    public $breadcrumb_item_open = "<li class='active'>";

    //Khai báo html đóng cho breadcrumb_item_close
    public $breadcrumb_item_close = "</li>";

    //Khai báo định dạng ngày tháng
    public $date_format = "d/m/Y H:i:s";

    //Icon website
    public $image_icon_url = "root/cropped-logo_cv6080-32x32.png";

    //Chế độ tối
    public $enable_dark_mode = true;

    //So luong trang
    public $pagination_limit = 20;

    //so luong trang trong admin
    public $pagination_limit_admin = 20;

    //Kich thuoc file toi da
    public $file_max_size = 300000;

    public $file_ext_allowed = "zip|txt|png|PNG|jpe|JPE|jpeg|JPEG|jpg|JPG|gif|GIF|bmp|BMP|ico|tiff|tif|svg|svgz|zip|rar|msi|cab|mp3|qt|mov|pdf|psd|ai|eps|ps|doc|mp4";

    public $file_mime_allowed = 'text/plain|image/png|image/jpeg|image/gif|image/bmp|image/tiff|image/svg+xml|application/zip|"application/zip"|application/x-zip|"application/x-zip"|application/x-zip-compressed|"application/x-zip-compressed"|application/rar|"application/rar"|application/x-rar|"application/x-rar"|application/x-rar-compressed|"application/x-rar-compressed"|application/octet-stream|"application/octet-stream"|audio/mpeg|video/quicktime|application/pdf';

    public $file_max_width = 0;

    public $file_max_height = 0;

    public $file_encrypt_name = false;

    //RESIZE_IMAGE_DEFAULT_WIDTH
    public $image_thumbnail_large_width = 2048;

    //RESIZE_IMAGE_DEFAULT_HEIGHT
    public $image_thumbnail_large_height = 2048;

    //RESIZE_IMAGE_THUMB_WIDTH
    public $image_thumbnail_small_width = 800;

    //RESIZE_IMAGE_THUMB_HEIGHT
    public $image_thumbnail_small_height = 800;

    public $image_quality = 60;

    public $image_watermark = "top_right";

    public $image_watermark_text = "Cat Cool Lê";

    public $image_watermark_path = "";

    public $image_watermark_hor_offset = -20;

    public $image_watermark_vrt_offset = 20;

    public $image_watermark_font_path = "./system/fonts/Lemonada.ttf";

    public $image_watermark_font_size = 46;

    public $image_watermark_font_color = "#15b07f";

    public $image_watermark_shadow_color = "";

    public $image_watermark_shadow_distance = "";

    public $image_watermark_opacity = 50;

    public $language_admin = "english";

    public $length_class = 1;

    public $weight_class = 1;

    public $timezone = "Asia/Ho_Chi_Minh";

    public $country = 237;

    public $country_province = 79;

    public $currency = "VND";

    //https://fixer.io/quickstart
    public $fixer_io_access_key = "3fabec301ee1683b95fd8240bb5aba97";

    public $email_engine = "smtp";

    public $email_parameter = "";

    public $email_smtp_timeout = 6;

    public $encryption_key = "";

    public $maintenance = "";

    public $seo_url = "";

    public $robots = "";

    public $compression = "";
}



