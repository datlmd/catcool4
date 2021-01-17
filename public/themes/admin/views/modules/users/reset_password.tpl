
<style>
	body {
		background: url({img_url('assets/images/auth-bg.jpg')}) no-repeat center center;
	}
</style>
<div class="splash-container">
	<div class="card">
		<div class="card-header">
			{include file=get_theme_path('views/inc/logo.tpl') lodo_sub_class="text-dark"}
		</div>
		<div class="card-body pt-4">
			<div class="splash-description mb-1">{lang('text_reset_password_heading')}</div>
			{if !empty($errors)}
				{include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
			{/if}
			{form_open(uri_string())}
				<div class="form-group mb-3">
					{lang('text_reset_password')}
					<input type="password" name="new_password" value='{set_value("new_password")}' id="password" class="form-control">
				</div>
				<div class="form-group mb-3">
					{lang('text_reset_password_confirm')}
					<input type="password" name="new_password_confirm" value='{set_value("new_password_confirm")}' id="new_password_confirm" class="form-control">
				</div>
				{form_hidden('id', $user.id)}
				{form_hidden($csrf)}
				<button type="submit" class="btn btn-primary btn-lg btn-block mt-4">{lang('button_reset_password')}</button>
			{form_close()}
		</div>
		<div class="card-footer bg-white text-center p-0">
			<div class="row m-0 p-0">
				<div class="card-footer-item card-footer-item-bordered col-6">
					{anchor("users/manage/forgot_password", lang('text_login'), 'class="footer-link"')}
				</div>
				<div class="card-footer-item card-footer-item-bordered col-6">
					{anchor("users/manage/forgot_password", lang('text_forgot_password'), 'class="footer-link"')}
				</div>
			</div>
		</div>
	</div>
</div>