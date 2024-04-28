{strip}
    {assign var="menu_main" value=get_menu_by_position()}
    <ul class="nav">
        {if !empty($menu_main)}
            {foreach $menu_main as $key => $item}
                <li class="nav-item dropdown">
                    <a class="dropdown-item" href="{$item.slug}" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <span>{$item.name}</span>
                    </a>
                    {if !empty($item.subs)}
                        <div class="dropdown-menu">
                            <ul class="list-unstyled">
                                {foreach $item.subs as $sub}
                                    <li>
                                        <a class="nav-item" href="{$sub.slug}">
                                            <span>{$sub.name}</span>
                                        </a>
                                    </li>
                                {/foreach}
                                {foreach $item.subs as $sub}
                                    <li>
                                        <a class="nav-item" href="{$sub.slug}">
                                            <span>{$sub.name}</span>
                                        </a>
                                    </li>
                                {/foreach}
                                {foreach $item.subs as $sub}
                                    <li>
                                        <a class="nav-item" href="{$sub.slug}">
                                            <span>{$sub.name}</span>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>

                    {/if}
                </li>
            {/foreach}
        {/if}
    </ul>
{/strip}

