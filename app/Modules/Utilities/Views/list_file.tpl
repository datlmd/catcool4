{strip}
	<div class="container-fluid  dashboard-content">
		{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UtilityAdmin.heading_title')}
		<div class="row">

			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
				{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=file_browser}
			</div>

			<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-folder-open me-2"></i>File Browser</h5>
					<div class="card-body">
						<div class="mb-3">
							<a href="{base_url($manage_url|cat:"/list_file?dir=public/themes")}" class="btn btn-sm  {if $dir eq 'public/themes'}btn-primary active{else}btn-light{/if}">Themes</a>
							<a href="{base_url($manage_url|cat:"/list_file?dir=public/uploads")}" class="btn btn-sm mx-2 {if $dir eq 'public/uploads'}btn-primary active{else}btn-light{/if}">Uploads</a>
							<a href="{base_url($manage_url|cat:"/list_file?dir=app/Language")}" class="btn btn-sm {if $dir eq 'app/Language'}btn-primary active{else}btn-light{/if}">Language</a>
						</div>
						<!-- HTML -->
						<div id="fba" data-host="{site_url()}" data-api="{$api}" data-route="{$route}"></div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
{/strip}
