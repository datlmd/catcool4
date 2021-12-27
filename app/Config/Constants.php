<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//datlm custom

//cache browser js css loader
defined('CACHE_TIME_CSS') OR define('CACHE_TIME_CSS', '20211227');
defined('CACHE_TIME_JS') OR define('CACHE_TIME_JS', '20211226');

// CAT COOL
defined('ALERT_POPUP')   OR define('ALERT_POPUP', 'alert_popup'); // view alert popup
defined('ALERT_SUCCESS') OR define('ALERT_SUCCESS', 'success'); // alert type
defined('ALERT_WARNING') OR define('ALERT_WARNING', 'warning'); // alert type
defined('ALERT_DANGER')  OR define('ALERT_DANGER', 'danger'); // alert type
defined('ALERT_ERROR')   OR define('ALERT_ERROR', 'danger'); // alert type

//pagination
defined('PAGINATION_DEFAULF_LIMIT')        OR define('PAGINATION_DEFAULF_LIMIT', 20);
defined('PAGINATION_MANAGE_DEFAULF_LIMIT') OR define('PAGINATION_MANAGE_DEFAULF_LIMIT', 20);

//logo text
defined('LOGO_TEXT')     OR define('LOGO_TEXT', 'Cat Cool');
defined('LOGO_TEXT_SUB') OR define('LOGO_TEXT_SUB', 'Web Solutions');

defined('CATCOOL_DASHBOARD') OR define('CATCOOL_DASHBOARD', 'manage/dashboard');

//publish status
defined('STATUS_ON')  OR define('STATUS_ON', 1);
defined('STATUS_OFF') OR define('STATUS_OFF', 0);

//comment status
defined('COMMENT_STATUS_OFF')  OR define('COMMENT_STATUS_OFF', 0); // tat binh luan
defined('COMMENT_STATUS_ON') OR define('COMMENT_STATUS_ON', 1); // tu dong duyet
defined('COMMENT_STATUS_CONFIRM') OR define('COMMENT_STATUS_CONFIRM', 2); // cho duyet

//gender
defined('GENDER_MALE')   OR define('GENDER_MALE', 1);
defined('GENDER_FEMALE') OR define('GENDER_FEMALE', 2);
defined('GENDER_OTHER')  OR define('GENDER_OTHER', 3);

// su dung cho url
defined('URL_LAST_SESS_NAME') OR define('URL_LAST_SESS_NAME', 'last_url');
defined('URL_LAST_FLAG')      OR define('URL_LAST_FLAG', 1);

//display list
defined('DISPLAY_LIST') OR define('DISPLAY_LIST', 'list');
defined('DISPLAY_GRID') OR define('DISPLAY_GRID', 'grid');

defined('UPLOAD_FILE_DIR')             OR define('UPLOAD_FILE_DIR', 'public/uploads/');
defined('UPLOAD_FILE_CACHE_DIR')       OR define('UPLOAD_FILE_CACHE_DIR', 'cache/');
defined('UPLOAD_IMAGE_DEFAULT')        OR define('UPLOAD_IMAGE_DEFAULT', 'images/img_default.jpg');
defined('RESIZE_IMAGE_DEFAULT_WIDTH')  OR define('RESIZE_IMAGE_DEFAULT_WIDTH', 2048);
defined('RESIZE_IMAGE_DEFAULT_HEIGHT') OR define('RESIZE_IMAGE_DEFAULT_HEIGHT', 2048);
defined('RESIZE_IMAGE_THUMB_WIDTH')    OR define('RESIZE_IMAGE_THUMB_WIDTH', 800);
defined('RESIZE_IMAGE_THUMB_HEIGHT')   OR define('RESIZE_IMAGE_THUMB_HEIGHT', 600);

//menu position
defined('MENU_POSITION_MAIN')   OR define('MENU_POSITION_MAIN', 'main');
defined('MENU_POSITION_FOOTER') OR define('MENU_POSITION_FOOTER', 'footer');
defined('MENU_POSITION_TOP')    OR define('MENU_POSITION_TOP', 'top');
defined('MENU_POSITION_BOTTOM') OR define('MENU_POSITION_BOTTOM', 'bottom');
defined('MENU_POSITION_OTHER')  OR define('MENU_POSITION_OTHER', 'other');

//cache name
defined('SET_CACHE_NAME_MENU') OR define('SET_CACHE_NAME_MENU', 'menu_position');

//social
defined('LOGIN_SOCIAL_TYPE_FACEBOOK')  OR define('LOGIN_SOCIAL_TYPE_FACEBOOK', 'fb');
defined('LOGIN_SOCIAL_TYPE_GOOGLE')    OR define('LOGIN_SOCIAL_TYPE_GOOGLE', 'gg');
defined('LOGIN_SOCIAL_TYPE_ZALO')      OR define('LOGIN_SOCIAL_TYPE_ZALO', 'zalo');
defined('LOGIN_SOCIAL_TYPE_TWITTER')   OR define('LOGIN_SOCIAL_TYPE_TWITTER', 'tw');
defined('LOGIN_SOCIAL_TYPE_INSTAGRAM') OR define('LOGIN_SOCIAL_TYPE_INSTAGRAM', 'ins');

defined('SEO_EXTENSION') OR define('SEO_EXTENSION', 'html');
