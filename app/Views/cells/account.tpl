{strip}
	<div class="list-group mb-3">
	
		{if empty($logged)}
			<a href="{$login}" class="list-group-item">{lang('Customer.text_login')}</a>
			<a href="{$register}" class="list-group-item">{lang('Customer.text_register')}</a>
			<a href="{$forgotten}" class="list-group-item">{lang('Customer.text_forgotten')}</a>
		{/if}
		
		<a href="{$profile}" class="list-group-item">{lang('Customer.text_profile')}</a>
		{if !empty($logged)}
			<a href="{$edit}" class="list-group-item">{lang('Customer.text_account_edit')}</a>
			<a href="{$password}" class="list-group-item">{lang('Customer.text_password')}</a>
		{/if}
		
		<a href="{$address}" class="list-group-item">{lang('Customer.text_address')}</a>
		<a href="{$wishlist}" class="list-group-item">{lang('Customer.text_wishlist')}</a>
		<a href="{$order}" class="list-group-item">{lang('Customer.text_order')}</a>
		<a href="{$download}" class="list-group-item">{lang('Customer.text_download')}</a>

		<a href="{$reward}" class="list-group-item">{lang('Customer.text_reward')}</a>
		<a href="{$return}" class="list-group-item">{lang('Customer.text_return')}</a>
		<a href="{$transaction}" class="list-group-item">{lang('Customer.text_transaction')}</a>
		<a href="{$newsletter}" class="list-group-item">{lang('Customer.text_newsletter')}</a>
		<a href="{$subscription}" class="list-group-item">{lang('Customer.text_subscription')}</a>

		{if !empty($logged)}
			<a href="{$logout}" class="list-group-item">{lang('Customer.text_logout')}</a>
		{/if}
		
	</div>
{/strip}
