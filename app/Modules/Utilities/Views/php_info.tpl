{strip}
	{form_hidden('manage_url', $manage_url)}
	<div class="container-fluid  dashboard-content">
		{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UtilityAdmin.heading_title')}
		<div class="row">
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
				{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=php_info}
			</div>
			<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
				<div class="card">
					<div class="card-body">
						{if !empty($info_list)}
							{foreach $info_list as $key => $item}
								<h3 class="text-center">{$key}</h3>
								{foreach $item as $name => $value}
									<div class="form-group row">
										<label class="col-12 col-sm-4 col-form-label text-sm-right"><strong>{$name}</strong></label>
										<div class="col-12 col-sm-8 col-lg-6 pt-1">
											{if is_array($value) && count($value) == 2 && $value[0] == $value[1]}
												{$value[0]}
											{elseif is_array($value)}
												{foreach $value as $val}
													{$val}
												{/foreach}
											{else}
												{$value}
											{/if}
										</div>
									</div>
								{/foreach}
							{/foreach}
						{else}
							{lang('Admin.text_no_results')}
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
