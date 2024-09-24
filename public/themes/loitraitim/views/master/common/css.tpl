<link rel="stylesheet" type="text/css" href="{base_url('common/css/catcool.css')}">

<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/fonts/fontawesome/css/fontawesome-all.css')}">
<link rel="stylesheet" type="text/css" href="{base_url('common/plugin/animate/animate.min.css')}">

{if ENVIRONMENT === 'production'}
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/custom.min.css')}?{CACHE_TIME_CSS}">
{else}
    <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/custom.css')}?{CACHE_TIME_CSS}">
{/if}
{if !empty($is_mobile)}
    {if ENVIRONMENT === 'production'}
        <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/mobile.min.css')}?{CACHE_TIME_CSS}">
    {else}
        <link rel="stylesheet" type="text/css" href="{theme_url('assets/css/mobile.css')}?{CACHE_TIME_CSS}">
    {/if}
{/if}
