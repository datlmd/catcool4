{strip}
	<div class="row">
		<div class="col-md-8 col-lg-7">
			{include file=get_theme_path('views/modules/news/inc/list_slide_home.tpl')}
		</div>
		<div class="col-md-4 col-lg-5">
			{include file=get_theme_path('views/modules/news/inc/list_new.tpl')}
		</div>
	</div>

	<div class="row pb-1 pt-2">

		<div class="col-lg-6">

			{include file=get_theme_path('views/modules/news/inc/list_category_home.tpl')}

		</div>

		<div class="col-lg-6">

			<div class="row p-2 p-lg-0 p-md-3">
				<div class="col-lg-12 d-none d-lg-block">

					{include file=get_theme_path('views/modules/news/inc/list_hot.tpl')}

				</div>
				<div class="col-lg-12">
					<div class="row">
						<div class="col-md-6">

							{include file=get_theme_path('views/modules/news/inc/list_counter.tpl')}

							{include file=get_theme_path('views/inc/facebook_box.tpl')}

						</div>
						<div class="col-md-6">

						</div>
					</div>

				</div>

			</div>

		</div>

	</div>
{/strip}
