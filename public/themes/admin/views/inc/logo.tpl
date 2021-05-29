{strip}
    {if empty(config_item('image_logo_url'))}
        {if !empty($is_disable_link)}
            <p class="navbar-brand logo-text">
                <span class="logo-main">{LOGO_TEXT}</span>
                <span class="logo-sub {if !empty($lodo_sub_class)}{$lodo_sub_class}{/if}">{LOGO_TEXT_SUB}</span>
            </p>
        {else}
            <a class="navbar-brand logo-text" href="{site_url(CATCOOL_DASHBOARD)}">
                <span class="logo-main">{LOGO_TEXT}</span>
                <span class="logo-sub {if !empty($lodo_sub_class)}{$lodo_sub_class}{/if}">{LOGO_TEXT_SUB}</span>
            </a>
        {/if}
    {else}
        {if !empty($is_disable_link)}
            <p class="navbar-brand logo-img">
                <img src="{image_url(config_item('image_logo_url'))}" alt="logo">
            </p>
        {else}
            <a class="navbar-brand logo-img" href="{site_url(CATCOOL_DASHBOARD)}">
                <img src="{image_url(config_item('image_logo_url'))}" alt="logo">
            </a>
        {/if}
    {/if}
{/strip}
