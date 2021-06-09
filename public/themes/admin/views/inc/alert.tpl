{strip}
	<div class="alert alert-{if $type}{$type}{else}info{/if} alert-dismissible fade show animate__animated animate__fadeIn">
		{if is_array($message)}
			{foreach $message as $mess}
				{if $type eq 'danger' || $type eq 'info'}
					<i class="fas fa-exclamation-circle me-2"></i>
				{elseif $type eq 'success'}
					<i class="fas fa-check-circle me-2"></i>
				{/if}
				{$mess}<br />
			{/foreach}
		{else}
			{if $type eq 'danger' || $type eq 'info'}
				<i class="fas fa-exclamation-circle me-2"></i>
			{elseif $type eq 'success'}
				<i class="fas fa-check-circle me-2"></i>
			{/if}
			{$message}
		{/if}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
{/strip}
