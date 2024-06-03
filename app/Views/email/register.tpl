{strip}
	{lang('Email.text_register_welcome', [$store_name])}<br/>
	<br/>
	{if !$approval}
		{lang('Email.text_register_login')}<br/>
		<br/>
		{$login}<br/>
		<br/>
		{lang('Email.text_register_service')}<br/>
		<br/>
		{lang('Email.text_register_thanks')}<br/>
		{$store_name}<br/>
		{$store_url}
	{else}
		{lang('Email.text_register_approval')}<br/>
		<br/>
		{$login}<br/>
		<br/>
		{lang('Email.text_register_thanks')}<br/>
		{$store_name}<br/>
		{$store_url}
	{/if}
{/strip}
