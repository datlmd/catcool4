<?php
	$page_meta = $page['props']['meta'] ?? "";
	
	if (isset($page['props']['meta'])) {
		unset($page['props']['meta']);
	}
?>

<!DOCTYPE html>
<html dir="<?= lang('General.direction') ?>" lang="<?= str_replace('_', '-', lang('General.code')) ?>">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="content-language" content="<?= lang('General.code') ?>">

		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<base href="<?= site_url() ?>">

		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php base_url(config_item('favicon')) ?>" type="image/x-icon" />
		<? if (!empty(config_item('favicon_apple_touche'))): ?>
			<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(config_item('favicon_apple_touche')) ?>">
		<? endif; ?>
		<? if (!empty(config_item('favicon_32_32'))): ?>
			<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(config_item('favicon_32_32')) ?>">
		<? endif; ?>

        <title inertia><?= $page_meta['page_title'] ?? "" ?></title>
		<?= $page_meta['metadata'] ?? "" ?>
        <!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<link
			rel="stylesheet"
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
			integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
			crossorigin="anonymous"
		/>

		<?= $page_meta['css_files'] ?? "" ?>

		<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php base_url('common/js/html5shiv-3.7.3.min.js') ?>"></script>
		<script type="text/javascript" src="<?php base_url('common/js/respond-1.4.2.min.js') ?>"></script>
		<![endif]-->

		<!-- <?php include(get_theme_path('views/master/common/css.tpl')) ?> -->

		<link rel="stylesheet" href="<?= base_url('common/css/catcool.css') ?>" type="text/css">

		<!-- Head Libs -->
		<script src="<?= base_url('common/plugin/modernizr/modernizr.min.js') ?>"></script>

		<script src="<?= base_url('common/plugin/bootstrap/js/bootstrap.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('common/plugin/jquery/jquery.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('common/plugin/bootstrap/js/popper.min.js') ?>" type="text/javascript"></script>

		<?= reactjs_css()?>

		<script><?= script_global() ?></script>
		
        <!-- Scripts -->
        <!-- @routes -->
        <!-- @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/Pages/{$page['component']}.tsx"]) -->
        <!-- @inertiaHead -->
    </head>
    <body class="<?= $page_meta['body_class'] ?? "" ?>">
        <!-- @inertia -->
		<div id="app" data-page='<?= htmlentities(json_encode($page)) ?>'></div>

		<? if (ENVIRONMENT === 'production'): ?>
			<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
			<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
		<? else: ?>
			<script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
			<script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
		<? endif; ?>

		<?= $page_meta['js_files'] ?? "" ?>

		<?= reactjs_script() ?>
    </body>
</html>
