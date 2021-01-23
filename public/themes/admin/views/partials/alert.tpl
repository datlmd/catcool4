<div class="alert-catcool alert alert-{if $type}{$type}{else}info{/if} alert-dismissible mb-2 fade show animate__animated animate__fadeIn">
	<div id="alert_message">
		{if $type eq 'danger' || $type eq 'info'}
			<i class="fas fa-exclamation-circle me-1"></i>
		{elseif $type eq 'success'}
			<i class="fas fa-check me-1"></i>
		{/if}
		{$message}
	</div>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
