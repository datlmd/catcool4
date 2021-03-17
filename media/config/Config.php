<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class CustomConfig extends BaseConfig 
{
	/**
	 * Ngôn ngữ mặc định
	 */
	public $language = "vn";

	/**
	 * Danh sách ngôn ngữ lấy từ db langluages
	 */
	public $listLanguageCache = '{"1":{"id":"1","name":"Vietnames","code":"vn","icon":null,"user_id":"1","published":"1"},"2":{"id":"2","name":"English","code":"english","icon":"flag-icon flag-icon-gb","user_id":"1","published":"1"}}';

	/**
	 * Hiển thị Selectbox ngôn ngữ?
	 */
	public $isShowSelectLanguage = true;

	/**
	 * Set theme frontend default/kenhtraitim
	 */
	public $themeFrontend = "kenhtraitim";

	/**
	 * Set theme cho admin
	 */
	public $themeAdmin = "admin";

	/**
	 * SEO site name mặc định
	 */
	public $siteName = "Cat Cool CMS";

	/**
	 * SEO keywords mặc định
	 */
	public $siteKeywords = "thiet ke web, website, chuyen nghiep";

	/**
	 * SEO description
	 */
	public $siteDescription = "thiết kế website chuyên nghiệp";

	/**
	 * key hash
	 */
	public $catcoolHash = "pass!@#$%";

	/**
	 * tên nhóm admin, để check nhứng user nào có quyền admin
	 */
	public $adminGroup = "admin";

	/**
	 * Thời gian expire cookie của user khi login
	 */
	public $userExpire = 0;

	/**
	 * Tên cookie login cho user
	 */
	public $rememberCookieName = "remember_cookie_catcool";

	/**
	 * Có cần check csrf trong admin hay không?
	 */
	public $isCheckCsrfAdmin = TRUE;

	/**
	 * Set tên input khi sử dụng giá trị cho csrf key
	 */
	public $csrfNameKey = "t_cc_key";

	/**
	 * Set tên input khi sử dụng csrf value
	 */
	public $csrfNameValue = "t_cc_value";

	/**
	 * Thời gian expire của csrf
	 */
	public $csrfCookieExpire = 3600;

	public $siteUrl = "http://192.168.64.2/dev/catcool";

	/**
	 * Bật chế độ resize hình
	 */
	public $enableResizeImage = true;

	/**
	 * Hình logo
	 */
	public $imageLogoUrl = "";

	/**
	 * Hình mặc định nêu hình gốc không tồn tại
	 */
	public $imageNone = "root/logo-hoatuoi24h-21.png";

	/**
	 * Chiều rộng hình tối đa trên pc
	 */
	public $imageWidthPc = 1280;

	/**
	 * Chiều cao tối đa của hình trên pc
	 */
	public $imageHeightPc = 1024;

	/**
	 * Chiều rộng tối đa của hình trên mobile (pixel)
	 */
	public $imageWidthMobile = 800;

	/**
	 * Chiều cao tối đa của hình trên mobile
	 */
	public $imageHeightMobile = 800;

	/**
	 * Hiển thị thanh menu, false sẽ ẩn menu gọn lại
	 */
	public $enableScrollMenuAdmin = true;

	/**
	 * true sử dụng menu bằng icon, false sẽ sử dụng menu kiểu text
	 */
	public $enableIconMenuAdmin = true;

	/**
	 * Avatar mặc định cho nam
	 */
	public $avatarDefaultMale = "images/male.png";

	/**
	 * Avatar mặc định cho nữ
	 */
	public $avatarDefaultFemale = "images/female.png";

	/**
	 * Setting email host
	 */
	public $emailHost = "ssl://smtp.googlemail.com";

	/**
	 * Port email
	 */
	public $emailPort = 465;

	/**
	 * Tài khoảng email smtp
	 */
	public $emailSmtpUser = "lmd.dat@gmail.com";

	/**
	 * email smtp pass
	 */
	public $emailSmtpPass = "tovyyqgibmnruaes";

	/**
	 * Email from
	 */
	public $emailFrom = "lmd.dat@gmail.com";

	/**
	 * Email Subject title
	 */
	public $emailSubjectTitle = "CatCool FW";

	/**
	 * Bật SSL
	 */
	public $enableSsl = TRUE;

	/**
	 * Khai báo html cho breadcrumb open
	 */
	public $breadcrumbOpen = "<ul class='breadcrumb breadcrumb-light d-block text-center appear-animation' data-appear-animation='fadeIn' data-appear-animation-delay='300'>";

	/**
	 * Khai báo html cho breadcrumb close
	 */
	public $breadcrumbClose = "</ul>";

	/**
	 * Khai báo html cho breadcrumb_item_open
	 */
	public $breadcrumbItemOpen = "<li class='active'>";

	/**
	 * Khai báo html đóng cho breadcrumb_item_close
	 */
	public $breadcrumbItemClose = "</li>";

	/**
	 * Khai báo định dạng ngày tháng
	 */
	public $dateFormat = "d/m/Y H:i:s";

	/**
	 * Icon website
	 */
	public $imageIconUrl = "root/cropped-logo_cv6080-32x32.png";

	/**
	 * Chế độ tối
	 */
	public $enableDarkMode = true;

	/**
	 * So luong trang
	 */
	public $paginationLimit = 20;

	/**
	 * so luong trang trong admin
	 */
	public $paginationLimitAdmin = 20;

	/**
	 * Kich thuoc file toi da
	 */
	public $fileMaxSize = 300000;

	public $fileExtAllowed = "zip|txt|png|PNG|jpe|JPE|jpeg|JPEG|jpg|JPG|gif|GIF|bmp|BMP|ico|tiff|tif|svg|svgz|zip|rar|msi|cab|mp3|qt|mov|pdf|psd|ai|eps|ps|doc|mp4";

	public $fileMimeAllowed = 'text/plain|image/png|image/jpeg|image/gif|image/bmp|image/tiff|image/svg+xml|application/zip|"application/zip"|application/x-zip|"application/x-zip"|application/x-zip-compressed|"application/x-zip-compressed"|application/rar|"application/rar"|application/x-rar|"application/x-rar"|application/x-rar-compressed|"application/x-rar-compressed"|application/octet-stream|"application/octet-stream"|audio/mpeg|video/quicktime|application/pdf';

	public $fileMaxWidth = 0;

	public $fileMaxHeight = 0;

	public $fileEncryptName = false;

	/**
	 * RESIZE_IMAGE_DEFAULT_WIDTH
	 */
	public $imageThumbnailLargeWidth = 2048;

	/**
	 * RESIZE_IMAGE_DEFAULT_HEIGHT
	 */
	public $imageThumbnailLargeHeight = 2048;

	/**
	 * RESIZE_IMAGE_THUMB_WIDTH
	 */
	public $imageThumbnailSmallWidth = 800;

	/**
	 * RESIZE_IMAGE_THUMB_HEIGHT
	 */
	public $imageThumbnailSmallHeight = 800;

	public $imageQuality = 60;

	public $imageWatermark = "top_right";

	public $imageWatermarkText = "Cat Cool Lê";

	public $imageWatermarkPath = "";

	public $imageWatermarkHorOffset = -20;

	public $imageWatermarkVrtOffset = 20;

	public $imageWatermarkFontPath = "./system/fonts/Lemonada.ttf";

	public $imageWatermarkFontSize = 46;

	public $imageWatermarkFontColor = "#15b07f";

	public $imageWatermarkShadowColor = "";

	public $imageWatermarkShadowDistance = "";

	public $imageWatermarkOpacity = 50;

	public $languageAdmin = "english";

	public $lengthClass = 1;

	public $weightClass = 1;

	public $timezone = "Asia/Ho_Chi_Minh";

	public $country = 237;

	public $countryProvince = 79;

	public $currency = "VND";

	/**
	 * https://fixer.io/quickstart
	 */
	public $fixerIoAccessKey = "3fabec301ee1683b95fd8240bb5aba97";

	public $emailEngine = "smtp";

	public $emailParameter = "";

	public $emailSmtpTimeout = 6;

	public $encryptionKey = "";

	public $maintenance = "";

	public $seoUrl = "";

	public $robots = "";

	public $compression = "";

	public $gaEnabled = true;

	/**
	 * GA ID
	 */
	public $gaSiteid = "";

	public $fbAppId = "";

	public $fbPages = "";

	/**
	 * google-site-verification
	 */
	public $googleSiteVerification = "";

	/**
	 * alexaVerifyID
	 */
	public $alexaVerifyId = "";

	public $siteImage = "";

}
