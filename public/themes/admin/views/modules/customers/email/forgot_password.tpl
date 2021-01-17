<html>
<body>
	<h1>{sprintf(lang('email_forgot_password_heading'), $username)}</h1>
	<p>{sprintf(lang('email_forgot_password_subheading'), anchor('users/manage/reset_password/'|cat:$forgotten_password_code, lang('email_forgot_password_link')))}</p>
</body>
</html>