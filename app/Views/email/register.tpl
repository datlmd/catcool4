{strip}
	{lang('Email.text_register_welcome', [$store_name])}<br/>
	<br/>
	{if !$approval}
		{lang('Email.text_register_login')}<br/>
		<br/>
		<a href="{$login}" target="_blank">{$login}</a><br/>
		<br/>
		{lang('Email.text_register_service')}<br/>
		<br/>
		{lang('Email.text_register_thanks')}<br/>
		{$store_name}<br/>
		<a href="{$store_url}" target="_blank">{$store_url}</a>
	{else}
		{lang('Email.text_register_approval')}<br/>
		<br/>
		<a href="{$login}" target="_blank">{$login}</a><br/>
		<br/>
		{lang('Email.text_register_thanks')}<br/>
		{$store_name}<br/>
		<a href="{$store_url}" target="_blank">{$store_url}</a>
	{/if}
{/strip}
