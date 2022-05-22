{strip}
	{form_hidden('manage_url', $manage_url)}
	<div class="container-fluid  dashboard-content">

		<div class="row">
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
				{include file=get_theme_path('views/inc/menu_utilities.inc.tpl') active="email"}
			</div>

			<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">

				{include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('UtilityAdmin.heading_title')}

				<div class="card">
					<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang("Email.text_template")}</h5>
					<div class="card-body">
						{form_open(uri_string())}
							<div class="form-group row">
								<label class="col-12 col-sm-3 col-form-label text-sm-end">
									{lang("Email.text_template")}
								</label>
								<div class="col-12 col-sm-8 col-lg-7">
									<select name="template" id="template" class="form-control">
										{foreach $email_templates as $value}
											<option value="{$value}" {if $value eq $template}selected{/if}>{$value}</option>
										{/foreach}
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
								<div class="col-12 col-sm-8 col-lg-7">
									<button type="submit" class="btn btn-primary btn-lg mt-2">{lang('Admin.button_check')}</button>
								</div>
							</div>
						{form_close()}
					</div>
				</div>
				{if !empty($content)}
					<div class="card">
						<h5 class="card-header"><i class="fas fa-info me-2"></i>Email {if !empty($template)}{$template}{/if}</h5>
						<div class="card-body">
							{if !empty(print_flash_alert())}
								{print_flash_alert()}
							{/if}
							{if !empty($errors)}
								{include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
							{/if}

							{form_open(uri_string())}
								<h2>Subject: [{config_item('email_subject_title')}] {$subject}</h2>
								From: {config_item('email_from')}
								<div class="border rounded p-4 mb-4 mt-3">{$content}</div>
								<div class="form-group row">
									<label class="col-12 col-sm-3 col-form-label text-sm-end">
										{lang('Email.text_email')}
									</label>
									<div class="col-12 col-sm-8 col-lg-7">
										<input type="text" name="email" id="email" value="{old('email')}" class="form-control">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-12 col-sm-3 col-form-label text-sm-end"></div>
									<div class="col-12 col-sm-8 col-lg-7">
										<input type="hidden" name="template" value="{$template}" class="form-control">
										<button type="submit" class="btn btn-primary btn-lg mt-2">{lang("Email.button_send")}</button>
									</div>
								</div>
							{form_close()}
						</div>
					</div>
				{/if}
			</div>

		</div>
	</div>
{/strip}
