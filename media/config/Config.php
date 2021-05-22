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

	public $backgroundImageAdminPath = "bg-01.jpg";

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

	public $compression = 0;

	public $country = 237;

	public $countryProvince = 79;

	public $currency = "VND";

	public $currencyAuto = 1;

	/**
	 * Khai báo định dạng ngày tháng
	 */
	public $dateFormat = "d/m/Y H:i:s";

	/**
	 * Ngôn ngữ mặc định
	 */
	public $defaultLocale = "vi";

	public $defaultLocaleAdmin = "vi";

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
	public $enableDarkMode = 1;

	/**
	 * true sử dụng menu bằng icon, false sẽ sử dụng menu kiểu text
	 */
	public $enableIconMenuAdmin = 0;

	/**
	 * Bật chế độ resize hình
	 */
	public $enableResizeImage = 1;

	/**
	 * Hiển thị thanh menu, false sẽ ẩn menu gọn lại
	 */
	public $enableScrollMenuAdmin = 1;

	public $encryptionKey = "";

	public $fbAppId = "";

	public $fbPages = "";

	public $fileEncryptName = 0;

	public $fileExtAllowed = "jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP|webp|WEBP|tiff|TIFF|svg|SVG|svgz|SVGZ|psd|PSD|raw|RAW|heif|HEIF|indd|INDD|ai|AI|webm|WEBM|mpg|MPG|mp2|MP2|mpeg|MPEG|mpe|MPE|mpv|MPV|ogg|OGG|mp4|MP4|m4p|M4P|m4v|M4V|avi|AVI|wmv|WMV|mov|MOV|qt|QT|flv|FLV|swf|SWF|avchd|AVCHD|zip|ZIP|txt|TXT|rar|RAR|pdf|PDF|doc|DOC|eps|cab";

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
	public $forceGlobalSecureRequests = 1;

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
	public $imageNone = "";

	public $imageQuality = 90;

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

	public $imageWatermark = "center";

	public $imageWatermarkFontColor = "#ffffff";

	public $imageWatermarkFontPath = "public/common/fonts/TAHOMA.TTF";

	public $imageWatermarkFontSize = 40;

	public $imageWatermarkHorOffset = 0;

	/**
	 * Watermark text: withShadow Boolean value whether to display a shadow or not.
	 */
	public $imageWatermarkIsShadow = 1;

	public $imageWatermarkOpacity = 50;

	public $imageWatermarkPath = "";

	public $imageWatermarkShadowColor = "#707a00";

	public $imageWatermarkShadowDistance = 4;

	public $imageWatermarkText = "Cat Cool";

	public $imageWatermarkType = "text";

	public $imageWatermarkVrtOffset = 0;

	public $imageWatermarEnable = 0;

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

	public $lengthClass = 0;

	/**
	 * Danh sách ngôn ngữ lấy từ db langluages
	 */
	public $listLanguageCache = '{"1":{"id":"1","name":"Vietnames","code":"vi","icon":"flag-icon flag-icon-vn","user_id":"1","published":"1"},"2":{"id":"2","name":"English","code":"en","icon":"flag-icon flag-icon-gb","user_id":"1","published":"1"}}';

	public $maintenance = 0;

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

	public $robots = "abot|dbot|ebot|hbot|kbot|lbot|mbot|nbot|obot|pbot|rbot|sbot|tbot|vbot|ybot|zbot|bot.|bot/|_bot|.bot|/bot|-bot|:bot|(bot|crawl|slurp|spider|seek|accoona|acoon|adressendeutschland|ah-ha.com|ahoy|altavista|ananzi|anthill|appie|arachnophilia|arale|araneo|aranha|architext|aretha|arks|asterias|atlocal|atn|atomz|augurfind|backrub|bannana_bot|baypup|bdfetch|big|brother|biglotron|bjaaland|blackwidow|blaiz|blog|blo.|bloodhound|boitho|booch|bradley|butterfly|calif|cassandra|ccubee|cfetch|charlotte|churl|cienciaficcion|cmc|collective|comagent|combine|computingsite|csci|curl|cusco|daumoa|deepindex|delorie|depspid|deweb|die|blinde|kuh|digger|ditto|dmoz|docomo|download|express|dtaagent|dwcp|ebiness|ebingbong|e-collector|ejupiter|emacs-w3|search|engine|esther|evliya|celebi|ezresult|falcon|felix|ide|ferret|fetchrover|fido|findlinks|fireball|fish|search|fouineur|funnelweb|gazz|gcreep|genieknows|getterroboplus|geturl|glx|goforit|golem|grabber|grapnel|gralon|griffon|gromit|grub|gulliver|hamahakki|harvest|havindex|helix|heritrix|hku|www|octopus|homerweb|htdig|html|index|html_analyzer|htmlgobble|hubater|hyper-decontextualizer|ia_archiver|ibm_planetwide|ichiro|iconsurf|iltrovatore|image.kapsi.net|imagelock|incywincy|indexer|infobee|informant|ingrid|inktomisearch.com|inspector|web|intelliagent|internet|shinchakubin|ip3000|iron33|israeli-search|ivia|jack|jakarta|javabee|jetbot|jumpstation|katipo|kdd-explorer|kilroy|knowledge|kototoi|kretrieve|labelgrabber|lachesis|larbin|legs|libwww|linkalarm|link|validator|linkscan|lockon|lwp|lycos|magpie|mantraagent|mapoftheinternet|marvin/|mattie|mediafox|mediapartners|mercator|merzscope|microsoft|url|control|minirank|miva|mj12|mnogosearch|moget|monster|moose|motor|multitext|muncher|muscatferret|mwd.search|myweb|najdi|nameprotect|nationaldirectory|nazilla|ncsa|beta|nec-meshexplorer|nederland.zoek|netcarta|webmap|engine|netmechanic|netresearchserver|netscoop|newscan-online|nhse|nokia6682/|nomad|noyona|nutch|nzexplorer|objectssearch|occam|omni|open|text|openfind|openintelligencedata|orb|search|osis-project|pack|rat|pageboy|pagebull|page_verifier|panscient|parasite|partnersite|patric|pear.|pegasus|peregrinator|pgp|key|agent|phantom|phpdig|picosearch|piltdownman|pimptrain|pinpoint|pioneer|piranha|plumtreewebaccessor|pogodak|poirot|pompos|poppelsdorf|poppi|popular|iconoclast|psycheclone|publisher|python|rambler|raven|search|roach|road|runner|roadhouse|robbie|robofox|robozilla|rules|salty|sbider|scooter|scoutjet|scrubby|search.|searchprocess|semanticdiscovery|senrigan|sg-scout|shai'hulud|shark|shopwiki|sidewinder|sift|silk|simmany|site|searcher|site|valet|sitetech-rover|skymob.com|sleek|smartwit|sna-|snappy|snooper|sohu|speedfind|sphere|sphider|spinner|spyder|steeler/|suke|suntek|supersnooper|surfnomore|sven|sygol|szukacz|tach|black|widow|tarantula|templeton|/teoma|t-h-u-n-d-e-r-s-t-o-n-e|theophrastus|titan|titin|tkwww|toutatis|t-rex|tutorgig|twiceler|twisted|ucsd|udmsearch|url|check|updated|vagabondo|valkyrie|verticrawl|victoria|vision-search|volcano|voyager/|voyager-hc|w3c_validator|w3m2|w3mir|walker|wallpaper|wanderer|wauuu|wavefire|web|core|web|hopper|web|wombat|webbandit|webcatcher|webcopy|webfoot|weblayers|weblinker|weblog|monitor|webmirror|webmonkey|webquest|webreaper|websitepulse|websnarf|webstolperer|webvac|webwalk|webwatch|webwombat|webzinger|whizbang|whowhere|wild|ferret|worldlight|wwwc|wwwster|xenu|xget|xift|xirq|yandex|yanga|yeti|yodao|zao|zippp|zyborg";

	public $seoUrl = 0;

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

	/**
	 * Set theme cho admin
	 */
	public $themeAdmin = "admin";

	/**
	 * Set theme frontend default/kenhtraitim
	 */
	public $themeFrontend = "default";

	/**
	 * Thời gian expire cookie của user khi login
	 */
	public $userExpire = 0;

	public $weightClass = 0;

}
