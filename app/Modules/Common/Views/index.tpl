{strip}
	{form_hidden('manage_url', $manage_url)}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-folder me-2"></i>{lang('FileManager.heading_title')}</h5>
					<div class="card-body vh-100">
						<button class="btn btn-sm btn-primary" onclick="Catcool.showMenuFileManager();">Open</button>
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
{literal}
	<script>
		$(function () {
			Catcool.showMenuFileManager();
		});
	</script>
{/literal}
