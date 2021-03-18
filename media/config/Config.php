<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class CustomConfig extends BaseConfig 
{
	public $supportedLocales = ['vi','en'];

	/**
	 * tên nhóm admin, để check nhứng user nào có quyền admin
	 */
	public $adminGroup = "admin";

	/**
	 * alexaVerifyID
	 */
	public $alexaVerifyId = "";

	public $appTimezone = "Asia/Ho_Chi_Minh";

	/**
	 * Avatar mặc định cho nữ
	 */
	public $avatarDefaultFemale = "images/female.png";

	/**
	 * Avatar mặc định cho nam
	 */
	public $avatarDefaultMale = "images/male.png";

	/**
	 * Khai báo html cho breadcrumb close
	 */
	public $breadcrumbClose = "</ul>";

	/**
	 * Khai báo html đóng cho breadcrumb_item_close
	 */
	public $breadcrumbItemClose = "</li>";

	/**
	 * Khai báo html cho breadcrumb_item_open
	 */
	public $breadcrumbItemOpen = "<li class='active'>";

	/**
	 * Khai báo html cho breadcrumb open
	 */
	public $breadcrumbOpen = "<ul class='breadcrumb breadcrumb-light d-block text-center appear-animation' data-appear-animation='fadeIn' data-appear-animation-delay='300'>";

	/**
	 * key hash
	 */
	public $catcoolHash = "pass!@#$%";

	public $compression = "";

	public $country = 237;

	public $countryProvince = 79;

	public $currency = "VND";

	/**
	 * Khai báo định dạng ngày tháng
	 */
	public $dateFormat = "d/m/Y H:i:s";

	/**
	 * Ngôn ngữ mặc định
	 */
	public $defaultLocale = "vi";

	public $defaultLocaleAdmin = "en";

	public $emailEngine = "smtp";

	/**
	 * Email from
	 */
	public $emailFrom = "lmd.dat@gmail.com";

	/**
	 * Setting email host
	 */
	public $emailHost = "ssl://smtp.googlemail.com";

	public $emailParameter = "";

	/**
	 * Port email
	 */
	public $emailPort = 465;

	/**
	 * email smtp pass
	 */
	public $emailSmtpPass = "tovyyqgibmnruaes";

	public $emailSmtpTimeout = 6;

	/**
	 * Tài khoảng email smtp
	 */
	public $emailSmtpUser = "lmd.dat@gmail.com";

	/**
	 * Email Subject title
	 */
	public $emailSubjectTitle = "CatCool FW";

	/**
	 * Chế độ tối
	 */
	public $enableDarkMode = true;

	/**
	 * true sử dụng menu bằng icon, false sẽ sử dụng menu kiểu text
	 */
	public $enableIconMenuAdmin = true;

	/**
	 * Bật chế độ resize hình
	 */
	public $enableResizeImage = true;

	/**
	 * Hiển thị thanh menu, false sẽ ẩn menu gọn lại
	 */
	public $enableScrollMenuAdmin = true;

	public $encryptionKey = "";

	public $fbAppId = "";

	public $fbPages = "";

	public $fileEncryptName = false;

	public $fileExtAllowed = "zip|txt|png|PNG|jpe|JPE|jpeg|JPEG|jpg|JPG|gif|GIF|bmp|BMP|ico|tiff|tif|svg|svgz|zip|rar|msi|cab|mp3|qt|mov|pdf|psd|ai|eps|ps|doc|mp4";

	public $fileMaxHeight = 0;

	/**
	 * Kich thuoc file toi da
	 */
	public $fileMaxSize = 300000;

	public $fileMaxWidth = 0;

	public $fileMimeAllowed = 'text/plain|image/png|image/jpeg|image/gif|image/bmp|image/tiff|image/svg+xml|application/zip|"application/zip"|application/x-zip|"application/x-zip"|application/x-zip-compressed|"application/x-zip-compressed"|application/rar|"application/rar"|application/x-rar|"application/x-rar"|application/x-rar-compressed|"application/x-rar-compressed"|application/octet-stream|"application/octet-stream"|audio/mpeg|video/quicktime|application/pdf';

	/**
	 * https://fixer.io/quickstart
	 */
	public $fixerIoAccessKey = "3fabec301ee1683b95fd8240bb5aba97";

	/**
	 * Bật SSL
	 */
	public $forceGlobalSecureRequests = true;

	public $gaEnabled = true;

	/**
	 * GA ID
	 */
	public $gaSiteid = "";

	/**
	 * google-site-verification
	 */
	public $googleSiteVerification = "";

	/**
	 * Chiều cao tối đa của hình trên mobile
	 */
	public $imageHeightMobile = 800;

	/**
	 * Chiều cao tối đa của hình trên pc
	 */
	public $imageHeightPc = 1024;

	/**
	 * Icon website
	 */
	public $imageIconUrl = "root/cropped-logo_cv6080-32x32.png";

	/**
	 * Hình logo
	 */
	public $imageLogoUrl = "";

	/**
	 * Hình mặc định nêu hình gốc không tồn tại
	 */
	public $imageNone = "root/logo-hoatuoi24h-21.png";

	public $imageQuality = 60;

	/**
	 * RESIZE_IMAGE_DEFAULT_HEIGHT
	 */
	public $imageThumbnailLargeHeight = 2048;

	/**
	 * RESIZE_IMAGE_DEFAULT_WIDTH
	 */
	public $imageThumbnailLargeWidth = 2048;

	/**
	 * RESIZE_IMAGE_THUMB_HEIGHT
	 */
	public $imageThumbnailSmallHeight = 800;

	/**
	 * RESIZE_IMAGE_THUMB_WIDTH
	 */
	public $imageThumbnailSmallWidth = 800;

	public $imageWatermark = "top_right";

	public $imageWatermarkFontColor = "#15b07f";

	public $imageWatermarkFontPath = "./system/fonts/Lemonada.ttf";

	public $imageWatermarkFontSize = 46;

	public $imageWatermarkHorOffset = -20;

	public $imageWatermarkOpacity = 50;

	public $imageWatermarkPath = "";

	public $imageWatermarkShadowColor = "";

	public $imageWatermarkShadowDistance = "";

	public $imageWatermarkText = "Cat Cool Lê";

	public $imageWatermarkVrtOffset = 20;

	/**
	 * Chiều rộng tối đa của hình trên mobile (pixel)
	 */
	public $imageWidthMobile = 800;

	/**
	 * Chiều rộng hình tối đa trên pc
	 */
	public $imageWidthPc = 1280;

	/**
	 * $indexPage = index.php
	 */
	public $indexPage = "";

	/**
	 * Hiển thị Selectbox ngôn ngữ?
	 */
	public $isShowSelectLanguage = true;

	public $lengthClass = 1;

	/**
	 * Danh sách ngôn ngữ lấy từ db langluages
	 */
	public $listLanguageCache = '{"1":{"id":"1","name":"Vietnames","code":"vi","icon":"","user_id":"1","published":"1"},"2":{"id":"2","name":"English","code":"en","icon":"flag-icon flag-icon-gb","user_id":"1","published":"1"}}';

	public $maintenance = "";

	/**
	 * If true, the current Request object will automatically determine the
language to use based on the value of the Accept-Language header.

If false, no automatic detection will be performed.
	 */
	public $negotiateLocale = false;

	/**
	 * So luong trang
	 */
	public $paginationLimit = 20;

	/**
	 * so luong trang trong admin
	 */
	public $paginationLimitAdmin = 20;

	/**
	 * Tên cookie login cho user
	 */
	public $rememberCookieName = "remember_cookie_catcool";

	public $robots = "";

	public $seoUrl = "";

	/**
	 * SEO description
	 */
	public $siteDescription = "thiết kế website chuyên nghiệp";

	public $siteImage = "";

	/**
	 * SEO keywords mặc định
	 */
	public $siteKeywords = "thiet ke web, website, chuyen nghiep";

	/**
	 * SEO site name mặc định
	 */
	public $siteName = "Cat Cool CMS";

	public $siteUrl = "http://192.168.64.2/dev/catcool";

	public $baseURL = "http://192.168.64.2/dev/catcool";

	/**
	 * Set theme cho admin
	 */
	public $themeAdmin = "admin";

	/**
	 * Set theme frontend default/kenhtraitim
	 */
	public $themeFrontend = "kenhtraitim";

	/**
	 * Thời gian expire cookie của user khi login
	 */
	public $userExpire = 0;

	public $weightClass = 1;

}
