<div class="card bg-light">
	<div class="card-body">
		<div class="form-group row">
			<p class="col-4 m-0">Status</p>
			<p class="col-8 m-0">
                {if $edit_data.published eq true || $status}
					<span class="badge-dot badge-success mr-1"></span>Active
				{else}
					<span class="badge-dot border border-dark mr-1"></span>Disabled
                {/if}
			</p>
		</div>
		<div class="form-group row">
			<p class="col-4 m-0">Created at</p>
			<p class="col-8 m-0">
                {$edit_data.ctime}
			</p>
		</div>
		<div class="form-group row">
			<p class="col-4 m-0">Updated at</p>
			<p class="col-8 m-0">
                {$edit_data.mtime}
			</p>
		</div>
	</div>
</div>
