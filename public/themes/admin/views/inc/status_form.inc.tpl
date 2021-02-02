{strip}
<div class="card bg-light">
	<div class="card-body">
		<div class="form-group row">
			<p class="col-4 m-0">Status</p>
			<p class="col-8 m-0">
                {if !empty($edit_data.published) || !empty($status)}
					<span class="badge-dot badge-success me-1"></span>Active
				{else}
					<span class="badge-dot border border-dark me-1"></span>Disabled
                {/if}
			</p>
		</div>
		<div class="form-group row">
			<p class="col-4 m-0">Created at</p>
			<p class="col-8 m-0">
                {if !empty($edit_data.ctime)}{$edit_data.ctime}{/if}
			</p>
		</div>
		<div class="form-group row">
			<p class="col-4 m-0">Updated at</p>
			<p class="col-8 m-0">
				{if !empty($edit_data.mtime)}{$edit_data.mtime}{/if}
			</p>
		</div>
	</div>
</div>
{/strip}
