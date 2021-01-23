<div class="row mb-2">{*border-bottom*}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-header">
			<h2 class="pageheader-title float-start me-3 mb-1"><a href="{site_url($manage_url)}" class="text-dark ms-1">{if !empty($heading_title)}{$heading_title}{else}{lang('GeneralManage.heading_title')}{/if}</a></h2>
			<div class="page-breadcrumb float-start ms-1">
				<nav aria-label="breadcrumb">
					{if !empty($breadcrumb)}{$breadcrumb}{/if}
				</nav>
			</div>
			<p class="pageheader-text"></p>
		</div>
	</div>
</div>
