{strip}
	<div class="footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 text-center">
					Copyright © {date('Y')} CatCool. All rights reserved. Dashboard by Dat Le.
					{if ENVIRONMENT !== 'production'}
						<br/>Page rendered in: <strong>___theme_time___</strong> seconds.
					{/if}
				</div>
			</div>
		</div>
	</div>
{/strip}
