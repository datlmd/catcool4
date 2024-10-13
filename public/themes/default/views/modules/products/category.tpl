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
    <h2>{$category_parent.name}</h2>
    {if $category_parent.thumb || $category_parent.description}
        <div class="d-block">
            {if $category_parent.thumb}
                <div class="d-sm-inline mb-3 me-4 text-center""><img src="{$category_parent.thumb}" alt="{$category_parent.name}" title="{$category_parent.name}" class="img-thumbnail" /></div>
            {/if}
            {if $category_parent.description}
                <div class="d-sm-inline align-top">{$category_parent.description|capitalize}</div>
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


    {if $product_list}
        <div id="display-control" class="row">
            <div class="col-lg-3">
                <div class="mb-3">
                    <a href="{$compare}" id="compare-total" class="btn btn-primary d-block">
                        <i class="fas fa-exchange-alt"></i> 
                        <span class="d-none d-xl-inline ms-2">{lang("ProductCategory.text_compare")}</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-1 d-none d-lg-block">
                <div class="btn-group">
                    <button type="button" id="button-list" class="btn btn-light" data-bs-toggle="tooltip" title="{lang("Genaral.button_list")}">
                        <i class="fas fa-th-list"></i>
                    </button>
                    <button type="button" id="button-grid" class="btn btn-light" data-bs-toggle="tooltip" title="{lang("Genaral.button_grid")}">
                        <i class="fas fa-th"></i>
                    </button>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-1 col-6">
                <div class="input-group mb-3">
                    <label for="input-sort" class="input-group-text">{lang("ProductCategory.text_sort")}</label> <select
                        id="input-sort" class="form-select" onchange="location = this.value;">
                        {foreach $sorts as $sort_data}
                            <option value="{$sort_data.href}" {if $sort_data.value == '{$sort}-{$order}'} selected{/if}>
                                {$sort_data.text}
                            </option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="input-group mb-3">
                    <label for="input-limit" class="input-group-text">{lang("ProductCategory.text_limit")}</label>
                    <select id="input-limit" class="form-select" onchange="location = this.value;">
                        {foreach $limits as $limit_data}
                            <option value="{$limit_data.href}" {if $limit_data.value == $limit} selected{/if}>
                                {$limit_data.text}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        </div>
        <div id="product-list" class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4">
            {foreach $product_list as $product}
                <div class="col mb-3">{$product}</div>
            {/foreach}
        </div>
        <div class="row">
            <div class="col-sm-6 text-start">{$pagination}</div>
            <div class="col-sm-6 text-end">{$results}</div>
        </div>
    {/if}

{/strip}