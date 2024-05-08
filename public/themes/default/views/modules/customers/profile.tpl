{strip}
    <div class="row">
        <div class="col-sm-3">
            <div class="text-center">
                <img src="{image_url($customer_avatar, 250, 250)}" alt="{$customer_name}" class="rounded-circle w-100" >
            </div>
            <h3 class="text-uppercase text-center my-3">{$customer_name}</h3>
        </div>

        <div class="col-sm-9">
            <h2 class="mb-2">{lang('Customer.text_my_account')}</h2>
            <ul class="list-unstyled">
                <li class="pb-2"><a href="{$edit}">{lang('Customer.text_profile_edit')}</a></li>
                <li class="pb-2"><a href="{$password}">{lang('Customer.text_profile_password')}</a></li>
                <li class="pb-2"><a href="{$address}">{lang('Customer.text_profile_address')}</a></li>
                <li class="pb-2"><a href="{$wishlist}">{lang('Customer.text_profile_wishlist')}</a></li>
            </ul>
            <h2 class="mt-3 mb-2">
                {lang('Customer.text_my_orders')}
            </h2>
            <ul class="list-unstyled">
                <li class="pb-2"><a href="{$order}">{lang('Customer.text_profile_order')}</a></li>
                <li class="pb-2"><a href="{$subscription}">{lang('Customer.text_profile_subscription')}</a></li>
                <li class="pb-2"><a href="{$download}">{lang('Customer.text_profile_download')}</a></li>
                {if $reward}
                    <li class="pb-2"><a href="{$reward}">{lang('Customer.text_profile_reward')}</a></li>
                {/if}
                <li class="pb-2"><a href="{$return}">{lang('Customer.text_profile_return')}</a></li>
                <li class="pb-2"><a href="{$transaction}">{lang('Customer.text_profile_transaction')}</a></li>
            </ul>
            
            <h2 class="mt-3 mb-2">
                {lang('Customer.text_newsletter')}
            </h2>
            <ul class="list-unstyled">
                <li class="pb-2"><a href="{$newsletter}">{lang('Customer.text_profile_newsletter')}</a></li>
            </ul>

        </div>
        
    </div>
    
{/strip}
