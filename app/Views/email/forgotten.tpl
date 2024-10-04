{strip}
	{lang('Email.text_forgotten_greeting', [$store_name])}<br/>
	<br/>
	{lang('Email.text_forgotten_change')}<br/>
	<br/>
	<a href="{$reset}" target="_blank">{$reset}</a><br/>
	<br/>
	{lang('Email.text_forgotten_ip')}<br/>
	<br/>
	{$ip}<br/>
	<br/>
	{$store_name}<br/>
	<a href="{$store_url}" target="_blank">{$store_url}</a>
{/strip}
