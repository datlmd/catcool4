{strip}
<!DOCTYPE html>
<html class="{if !empty($html_class)}{$html_class}{/if}" dir="{lang('General.direction')}" lang="{str_replace('_', '-', lang('General.code'))}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="content-language" content="{lang('General.code')}">

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

	<title inertia>{$page_title}</title>

	<meta name="csrf-header" content="{csrf_token()}">
	<meta name="csrf-value" content="{csrf_hash()}">

	{$metadata}

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

	<link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
		crossorigin="anonymous"
	/>

	{if !empty($css_files)}{$css_files}{/if}

	<!--[if lt IE 9]>
	<script type="text/javascript" src="{base_url('common/js/html5shiv-3.7.3.min.js')}"></script>
	<script type="text/javascript" src="{base_url('common/js/respond-1.4.2.min.js')}"></script>
	<![endif]-->

	{include file=get_theme_path('views/master/common/css.tpl')}

	<link rel="stylesheet" href="{base_url('common/css/catcool.css')}" type="text/css">

	{include file=get_theme_path('views/master/common/css_theme.tpl')}

	<!-- Head Libs -->
	<script src="{base_url('common/plugin/modernizr/modernizr.min.js')}"></script>

	<script src="{base_url('common/plugin/bootstrap/js/bootstrap.bundle.js')}" type="text/javascript"></script>
	<script src="{base_url('common/plugin/jquery/jquery.min.js')}" type="text/javascript"></script>
	<script src="{base_url('common/plugin/bootstrap/js/popper.min.js')}" type="text/javascript"></script>

    <script>{script_global()}</script>

	{reactjs_css()}
</head>
<body class="{if !empty($body_class)}{$body_class}{/if}">
	<noscript>You need to enable JavaScript to run this app.</noscript>

	{$layout}

	<div id="app" data-page='{{json_encode($page)}}'></div>

	{if ENVIRONMENT === 'production'}
		<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
		<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
	{else}
		<script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
		<script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
	{/if}
	
	{reactjs_script()}

	<script>
		var page_data = '{{$data}}';
		var csrf_name = '{{csrf_token()}}';
		var csrf_value = '{{csrf_hash()}}';
	</script>

	
	<!-- JavaScripts -->
	{if !empty($js_files)}{$js_files}{/if}

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

	{if ENVIRONMENT === 'production'}
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.1';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	{/if}
</body>
</html>
{/strip}
