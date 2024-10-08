{strip}
<!DOCTYPE html>
<html class="{if !empty($html_class)}{$html_class} {/if}side-header" dir="{lang('General.direction')}" lang="{lang('General.code')}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="content-language" content="{lang('General.code')}">

	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<base href="{site_url()}">

	<!-- Favicon -->
	<link rel="shortcut icon" href="{base_url()}{config_item('favicon')}" type="image/x-icon" />
	{if !empty(config_item('favicon_apple_touche'))}
		<link rel="apple-touch-icon" sizes="180x180" href="{base_url()}{config_item('favicon_apple_touche')}">
	{/if}
	{if !empty(config_item('favicon_32_32'))}
		<link rel="icon" type="image/png" sizes="32x32" href="{base_url()}{config_item('favicon_32_32')}">
	{/if}

	<title>{if !empty($page_title)}{$page_title}{/if}</title>
	{$metadata}

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

	<!-- Web Fonts  -->
	{*<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">*}

	<!-- StyleSheets -->
	<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/bootstrap/css/bootstrap.min.css')}">
	<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/bootstrap/css/bootstrap-utilities.min.css')}">
    
	{include file=get_theme_path('views/master/common/css.tpl')}

	{if !empty($css_files)}{$css_files}{/if}

	<!-- Head Libs -->
	<script src="{base_url('common/plugin/modernizr/modernizr.min.js')}"></script>

	<script src="{base_url('common/plugin/bootstrap/js/bootstrap.bundle.js')}" type="text/javascript"></script>
	<script src="{base_url('common/plugin/jquery/jquery.min.js')}" type="text/javascript"></script>
	<script src="{base_url('common/plugin/bootstrap/js/popper.min.js')}" type="text/javascript"></script>

    <script>{script_global()}</script>
	<!-- GOOGLE SEARCH STRUCTURED DATA FOR ARTICLE -->
	{if !empty($script_google_search)}{$script_google_search}{/if}

	{if ENVIRONMENT === 'production' && !empty(config_item('google_adsend_enabled')) && !empty(config_item('google_adsend_client'))}
		<!--- google adsend -->
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={config_item('google_adsend_client')}"
				crossorigin="anonymous"></script>
		<!--- end google adsend -->
	{/if}

	<meta property="fb:pages" content="494134137267796" />
	
</head>
<body class="{if !empty($body_class)}{$body_class}{/if}">

	{$layout}
	<button id="btn_scroll_to_top" onclick="scrollToTop()"><i class="fas fa-angle-up"></i></button>

	<!-- JavaScripts -->
	{include file=get_theme_path('views/master/common/js.tpl')}

	{if !empty($js_files)}{$js_files}{/if}

	{if ENVIRONMENT === 'production' && !empty(config_item('google_optimize'))}
		<script src="https://www.googleoptimize.com/optimize.js?id={config_item('google_optimize')}"></script>
	{/if}

	{if ENVIRONMENT === 'production' && !empty(config_item('ga_enabled')) && !empty(config_item('ga_siteid'))}
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id={config_item('ga_siteid')}"></script>
		{literal}
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());

				gtag('config', '{/literal}{config_item('ga_siteid')}{literal}');
			</script>
		{/literal}
	{/if}

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.1';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
{/strip}
