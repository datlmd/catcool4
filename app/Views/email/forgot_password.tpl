<html>
<body>
	<h1>{sprintf(lang('UserAdmin.email_forgot_password_heading'), $username)}</h1>
	<p>{sprintf(lang('UserAdmin.email_forgot_password_subheading'), anchor('users/manage/reset_password/'|cat:$forgotten_password_code, lang('UserAdmin.email_forgot_password_link')))}</p>
</body>
</html>
