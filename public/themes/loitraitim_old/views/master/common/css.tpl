<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/fonts/fontawesome/css/fontawesome-all.css')}">
<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/animate/animate.min.css')}">

{*<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/simple-line-icons/css/simple-line-icons.min.css')}">*}
<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/owl.carousel/assets/owl.carousel.css')}">
<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/owl.carousel/assets/owl.theme.default.css')}">
{*<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/magnific-popup/magnific-popup.css')}">*}

{if ENVIRONMENT === 'production'}
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/theme.min.css')}?{CACHE_TIME_CSS}">
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/theme-elements.min.css')}?{CACHE_TIME_CSS}">
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/theme-blog.min.css')}?{CACHE_TIME_CSS}">
    
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/skins/default.min.css')}?{CACHE_TIME_CSS}">
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/custom.min.css')}?{CACHE_TIME_CSS}">
{else}
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/theme.css')}?{CACHE_TIME_CSS}">
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/theme-elements.css')}?{CACHE_TIME_CSS}">
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/theme-blog.css')}?{CACHE_TIME_CSS}">

    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/skins/default.css')}?{CACHE_TIME_CSS}">
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/custom.css')}?{CACHE_TIME_CSS}">
{/if}
