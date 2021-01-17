<div class="row mt-2">
	<div class="col-8 pl-3">
		{if !empty($paging.pagination_links)}
			<p><nav aria-label="Page navigation" class="table-responsive">{$paging.pagination_links}</nav></p>
		{/if}
	</div>
	<div class="col-4 pr-3 text-right {if !empty($paging.pagination_links)}mt-sm-3 mt-2{/if}">
        {$paging.pagination_title}
	</div>
</div>