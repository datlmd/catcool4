<div class="alert alert-{if $type}{$type}{else}info{/if} alert-dismissible fade show animate__animated animate__fadeIn">
	{if is_array($message)}
		{foreach $message as $mess}
			{if $type eq 'danger' || $type eq 'info'}
				<i class="fas fa-exclamation-circle me-1"></i>
			{elseif $type eq 'success'}
				<i class="fas fa-check me-1"></i>
			{/if}
			{$mess}<br />
		{/foreach}
	{else}
		{if $type eq 'danger' || $type eq 'info'}
			<i class="fas fa-exclamation-circle me-1"></i>
		{elseif $type eq 'success'}
			<i class="fas fa-check me-1"></i>
		{/if}
		{$message}
	{/if}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

