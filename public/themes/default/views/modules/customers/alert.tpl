{strip}
    <h1 class="text-start">
        {$heading_title}
    </h1>
    
    <div class="mt-3 mb-4">
        <div id="activate_alert">{print_flash_alert()}</div>
        {if $success}
            {include file=get_theme_path('views/inc/alert.tpl') message=$success type='success'}
        {elseif $error}
            {include file=get_theme_path('views/inc/alert.tpl') message=$error type='danger'}
        {/if}
    </div>
{/strip}
