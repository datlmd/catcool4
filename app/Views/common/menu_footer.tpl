{strip}
    {assign var="menu_footer" value=get_menu_by_position(MENU_POSITION_FOOTER)}
    {if !empty($menu_footer)}
        <div class="row accordion" id="accordion_menu_footer">
            {foreach $menu_footer as $key => $item}
                <div class="col-12 col-md-6 col-lg-3 accordion-item">
                    <h5 class="d-none d-md-block"><span>{$item.name}</span></h5>
                    <h5 class="accordion-header d-block d-md-none" id="accordion_menu_footer_heading_{$key}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menu_footer_flush_collapse_{$key}" aria-expanded="false" aria-controls="menu_footer_flush_collapse_{$key}">
                            <span>{$item.name}</span>
                        </button>
                    </h5>
                    {if !empty($item.subs)}
                        <ul id="menu_footer_flush_collapse_{$key}" class="list-unstyled accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion_menu_footer">
                            {foreach $item.subs as $sub}
                                <li>
                                    <a href="{$sub.slug}" class="">
                                        <span>{$sub.name}</span>
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </div>
            {/foreach}
        </div>
    {/if}
{/strip}

