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
	<link rel="shortcut icon" href="{img_url('favicon/favicon.ico')}" type="image/x-icon" />
	<link rel="apple-touch-icon" sizes="180x180" href="{img_url('favicon/apple-touch-icon.png')}">
	<link rel="icon" type="image/png" sizes="32x32" href="{img_url('favicon/favicon-32x32.png')}">

	<title>{if !empty($page_title)}{$page_title}{/if}</title>
	{$metadata}

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

	<!-- Web Fonts  -->
	{*<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">*}

	<!-- StyleSheets -->
	<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/bootstrap/css/bootstrap.min.css')}">
	<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/bootstrap/css/bootstrap-utilities.min.css')}">
    <link rel="stylesheet" href="{base_url('common/css/catcool.css')}" type="text/css">
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

	{if !empty(config_item('google_adsend_enabled')) && !empty(config_item('google_adsend_client'))}
		<!--- google adsend -->
		<script data-ad-client="{config_item('google_adsend_client')}" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!--- end google adsend -->
	{/if}
</head>
<body class="{if !empty($body_class)}{$body_class}{/if}">
	{$layout}
	<!-- JavaScripts -->
	{include file=get_theme_path('views/master/common/js.tpl')}
	{if !empty($js_files)}{$js_files}{/if}

	{if !empty(config_item('google_optimize'))}
		<script src="https://www.googleoptimize.com/optimize.js?id={config_item('google_optimize')}"></script>
	{/if}

	{if !empty(config_item('ga_enabled')) && !empty(config_item('ga_siteid'))}
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
