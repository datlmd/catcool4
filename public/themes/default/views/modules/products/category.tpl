{function name=menu_category level=1}
    <ul class="level-{$level}">
        {foreach $data as $value}
            {if !empty($value.subs)}
                <li class="py-1">
                    <a href="{$value.href}" class="my-1">{$value.name}</a>
                    {call name=menu_category data=$value.subs level=$level+1}
                </li>
            {else}
                <li class="py-1"><a href="{$value.href}">{$value.name}</a></li>
            {/if}
        {/foreach}
    </ul>
{/function}

{strip}
    <h2>{$category.name}</h2>
    {if $category.thumb || $category.description}
        <div class="d-block">
            {if $category.thumb}
                <div class="d-sm-inline mb-3 me-4 text-center""><img src="{$category.thumb}" alt="{$category.name}" title="{$category.name}" class="img-thumbnail" /></div>
            {/if}
            {if $category.description}
                <div class="d-sm-inline align-top">{$category.description|capitalize}</div>
            {/if}
        </div>
        <hr />
    {/if}



    {if !empty($category_list[$category_id]['subs'])}
        <h3>{lang("ProductCategory.text_refine")}</h3>
        {if $category_list[$category_id].count <= 5}
            <div class="row">
                <div class="col-sm-3">
                    <ul>
                        {foreach $category_list[$category_id]['subs'] as $value}
                            <li class="py-1">
                                <a href="{$value.href}" >{$value.name}</a>
                                {if !empty($value.subs)}
                                    {call name=menu_category data=$value.subs}
                                {/if}
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        {else}
            <div class="row">
                {foreach $category_list[$category_id]['subs'] as $value}
                    <div class="col-sm-3">
                        <ul>
                            <li>
                                <a href="{$value.href}">{$value.name}</a>
                                {if !empty($value.subs)}
                                    {call name=menu_category data=$value.subs}
                                {/if}
                            </li>
                        </ul>
                    </div>
                {/foreach}
            </div>

        {/if}
    {/if}

{/strip}