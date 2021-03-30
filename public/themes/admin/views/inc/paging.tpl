<div class="row">
	<div class="col-sm-4 col-12 my-auto">
		{pager_string($pager->getTotal($pager_name), $pager->getPerPage($pager_name), $pager->getCurrentPage($pager_name))}
	</div>
	<div class="col-sm-8 col-12">
		{$pager->links($pager_name, 'admin')}
	</div>
</div>
