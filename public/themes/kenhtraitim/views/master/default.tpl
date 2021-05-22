<!DOCTYPE html>
<html class="{if !empty($html_class)}{$html_class}{/if}" dir="{lang('General.direction')}" lang="{lang('General.code')}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<base href="{site_url()}">

	<!-- Favicon -->
	<link rel="shortcut icon" href="{img_url('assets/img/favicon.ico')}" type="image/x-icon" />
	<link rel="apple-touch-icon" href="{img_url('assets/img/apple-touch-icon.png')}">

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="content-language" content="{if $lang_abbr}{$lang_abbr}{else}vi{/if}">
	<title>{if !empty($page_title)}{$page_title}{/if}</title>
	{$metadata}
	<meta name="author" content="CatCoolCMS">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- StyleSheets -->
    <link rel="stylesheet" href="{base_url('common/plugin/bootstrap/css/bootstrap.min')}" type="text/css">
    <link rel="stylesheet" href="{base_url('common/css/catcool')}" type="text/css">
	{if !empty($css_files)}{$css_files}{/if}

	<!-- Head Libs -->
	<script src="{base_url('common/plugin/modernizr/modernizr.min')}"></script>

    <script>{script_global()}</script>
</head>
<body class="{if !empty($body_class)}{$body_class}{/if}">

	{$layout}

	<script src="{base_url('common/vendor/jquery/jquery-3.4.1.min', 'common')}" type="text/javascript"></script>
	<script src="{base_url('common/vendor/bootstrap/js/popper.min', 'common')}" type="text/javascript"></script>
	<script src="{base_url('common/vendor/bootstrap/js/bootstrap.min', 'common')}" type="text/javascript"></script>
	<!-- JavaScripts -->
	{$js_files}

	{if (config_item('ga_enabled') && (! empty(config_item('ga_siteid')) && config_item('ga_siteid') != 'UA-XXXXX-Y'))}
		{literal}
		<!-- Google Analytics-->
		<script>
			window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
			ga('create','{{config_item('ga_siteid')}}','auto');ga('send','pageview')
		</script>
		<script src="https://www.google-analytics.com/analytics.js" async defer></script>
		{/literal}
	{/if}

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
