{strip}
	<html>
	<body>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
			<tbody>
			<tr>
				<td height="20" style="line-height:20px" colspan="3">&nbsp;</td>
			</tr>
			{include file=get_view_path('email/inc/logo.tpl')}
			<tr>
				<td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
				<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
						<tbody>
						<tr>
							<td height="4" style="line-height:4px">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">
									<span style="font-size:15px">
										<p></p>
										<div style="margin-top:16px;margin-bottom:20px">{lang('Email.text_dear', [ucwords($full_name)])}</div>
										<div>{lang("Email.forgot_password_content_1")}</div>
										<p></p>
										{lang("Email.forgot_password_content_2", [anchor('users_admin/manage/reset_password/'|cat:$forgotten_password_code, lang('Email.forgot_password_link'), 'style="color:#3b7b98"')])}
										<p></p>
										{lang("Email.forgot_password_content_3")}
										<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
											<tbody>
											<tr>
												<td height="20" style="line-height:20px">&nbsp;</td>
											</tr>
											<tr>
												<td align="middle">
													<a href="{site_url('users/manage/reset_password/'|cat:$forgotten_password_code)}?redirect_from=button" style="color:#3b5998;text-decoration:none" target="_blank">
														<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
															<tbody>
															<tr>
																<td style="border-collapse:collapse;border-radius:6px;text-align:center;display:block;border:none;background:#3b7b98;padding:6px 20px 10px 20px">
																	<a href="{site_url('users_admin/manage/reset_password/'|cat:$forgotten_password_code)}?redirect_from=button" style="color:#3b5998;text-decoration:none;display:block" target="_blank">
																		<center>
																			<font size="3">
																				<span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#ffffff;font-weight:500;font-family:Roboto-Medium,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:17px">
																					{lang("Email.button_change_password")}
																				</span>
																			</font>
																		</center>
																	</a>
																</td>
															</tr>
															</tbody>
														</table>
													</a>
												</td>
											</tr>
											<tr>
												<td height="20" style="line-height:20px">&nbsp;</td>
											</tr>
											</tbody>
										</table>
										<br>
										<div>
											<span style="color:#333333;font-weight:bold">{lang("Email.forgot_password_content_4")}</span>
										</div>
										{lang("Email.forgot_password_content_5")}<br/><br/>
										<p style="padding-top: 10px; color: #76808f;">{lang("Email.text_signature", [ucwords(config_item('site_name'))])}</p>
									</span>
								</span>
							</td>
						</tr>
						<tr>
							<td height="50" style="line-height:50px">&nbsp;</td>
						</tr>
						</tbody>
					</table>
				</td>
				<td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
			</tr>
			{include file=get_view_path('email/inc/footer.tpl')}
			<tr>
				<td height="20" style="line-height:20px" colspan="3">&nbsp;</td>
			</tr>
			</tbody>
		</table>
	</body>
	</html>
{/strip}
