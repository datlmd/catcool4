{form_hidden('alert_type', $type)}
{form_hidden('alert_msg', $message)}
{*<div class="alert-catcool alert alert-{if $type}{$type}{else}info{/if} alert-dismissible fade show">
	<div id="alert_message">{$message}</div>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>*}