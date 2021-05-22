<!DOCTYPE html>
<html class="{if !empty($html_class)}{$html_class}{/if}" dir="{lang('General.direction')}" lang="{lang('General.code')}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<base href="{site_url()}">

	<!-- Favicon -->
	<link rel="shortcut icon" href="{img_url('assets/img/favicon.ico')}" type="image/x-icon" />
	<link rel="apple-touch-icon" href="{img_url('assets/img/apple-touch-icon.png')}">

	<title>{if !empty($page_title)}{$page_title}{/if}</title>
	{$metadata}

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- StyleSheets -->
    <link rel="stylesheet" href="{base_url('common/plugin/bootstrap/css/bootstrap.min.css')}" type="text/css">
    <link rel="stylesheet" href="{base_url('common/css/catcool.css')}" type="text/css">
	{include file=get_theme_path('views/master/common/css.tpl')}
	{if !empty($css_files)}{$css_files}{/if}

	<!-- Head Libs -->
	<script src="{base_url('common/plugin/modernizr/modernizr.min.js')}"></script>

	<script src="{base_url('common/plugin/jquery/jquery.min.js')}" type="text/javascript"></script>
	<script src="{base_url('common/plugin/bootstrap/js/popper.min.js')}" type="text/javascript"></script>
	<script src="{base_url('common/plugin/bootstrap/js/bootstrap.min.js')}" type="text/javascript"></script>

    <script>{script_global()}</script>
</head>
<body class="{if !empty($body_class)}{$body_class}{/if}">

	{$layout}

	<!-- JavaScripts -->
	{include file=get_theme_path('views/master/common/js.tpl')}
	{if !empty($js_files)}{$js_files}{/if}

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

</body>
</html>
