<!doctype html>
<html class="{if !empty($html_class)}{$html_class}{/if}" dir="{lang('General.direction')}" lang="{lang('General.code')}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <base href="{site_url()}">
        <title>{if !empty($page_title)}{$page_title}{/if}</title>

        {$metadata}

        <!-- StyleSheets -->
        {include file=get_theme_path('views/master/common/css.tpl')}
        {if !empty($css_files)}{$css_files}{/if}

        <!--[if lt IE 9]>
        <script type="text/javascript" src="{base_url('common/js/html5shiv-3.7.3.min.js')}"></script>
        <script type="text/javascript" src="{base_url('common/js/respond-1.4.2.min.js')}"></script>
        <![endif]-->

        <script src="{base_url('common/plugin/bootstrap/js/bootstrap.bundle.js')}" type="text/javascript"></script>
        <script src="{base_url('common/plugin/jquery/jquery.min.js')}" type="text/javascript"></script>
        <script src="{base_url('common/js/admin/catcool.js')}?{CACHE_TIME_JS}" type="text/javascript"></script>

        <script>{script_global()}</script>
    </head>
    <body class="{if !empty($body_class)}{$body_class}{/if}">
        <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        {$layout}

        {include file=get_theme_path('views/master/common/js.tpl')}
        {if !empty($js_files)}{$js_files}{/if}

    </body>
</html>
