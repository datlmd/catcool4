{strip}
	{lang('Email.text_register_signup')}<br/>
	<br/>
	{lang('Email.text_register_firstname')} <b>{$first_name}</b><br/>
	{lang('Email.text_register_lastname')} <b>{$last_name}</b><br/>
	{if $customer_group}
		{lang('Email.text_register_customer_group')} <b>{$customer_group}</b><br/>
	{/if}
	{lang('Email.text_register_email')} <b>{$email}</b><br/>
	{if $phone}
		{lang('Email.text_register_telephone')} <b>{$phone}</b>
	{/if}
	<br/>
	<br/>
	{$store_name}<br/>
	<a href="{$store_url}" target="_blank">{$store_url}</a>
{/strip}
