{strip}
	<html>
	<body>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
			<tbody>
			<tr>
				<td height="20" style="line-height:20px" colspan="3">&nbsp;</td>
			</tr>
			{if !empty(config_item('image_logo_url'))}
				<tr>
					<td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
					<td>
						<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
							<tbody>
								<tr>
									<td height="15" style="line-height:15px">&nbsp;</td>
								</tr>
								<tr>
									<td width="32" align="left" valign="middle" style="height:32px;line-height:0px">
										<img src="{image_url(config_item('image_logo_url'))}" width="100%" alt="{config_item('site_name')}" style="border:0;font-size:19px;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;color:#1877f2">
									</td>
								</tr>
								<tr style="border-bottom:solid 1px #e5e5e5">
									<td height="15" style="line-height:15px">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
				</tr>
			{/if}
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
										{lang("Email.forgot_password_content_2")}
										<p></p>
										<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:max-content;margin-top:20px;margin-bottom:20px">
											<tbody>
											<tr>
												<td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:14px 32px 14px 32px;background-color:#f2f2f2;border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:1px solid #ccc;border-bottom:1px solid #ccc;text-align:center;border-radius:7px;display:block;border:1px solid #1877f2;background:#e7f3ff">
													<span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">
														<span style="font-size:17px;font-family:Roboto;font-weight:700;margin-left:0px;margin-right:0px">{$new_password}</span>
													</span>
												</td>
											</tr>
											</tbody>
										</table>
										{lang("Email.forgot_password_content_3")}
										<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
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
																<td style="border-collapse:collapse;border-radius:6px;text-align:center;display:block;border:none;background:#1877f2;padding:6px 20px 10px 20px">
																	<a href="{site_url('users/manage/reset_password/'|cat:$forgotten_password_code)}?redirect_from=button" style="color:#3b5998;text-decoration:none;display:block" target="_blank">
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
												<td height="8" style="line-height:8px">&nbsp;</td>
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
			<tr>
				<td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
				<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse">
						<tbody>
						<tr style="border-top:solid 1px #e5e5e5">
							<td height="19" style="line-height:19px">&nbsp;</td>
						</tr>
						<tr>
							<td style="font-family:Roboto-Regular,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:12px;color:#8a8d91;line-height:16px;font-weight:400">
								{lang("Email.text_automate")}
							</td>
						</tr>
						</tbody>
					</table>
				</td>
				<td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td height="20" style="line-height:20px" colspan="3">&nbsp;</td>
			</tr>
			</tbody>
		</table>
	</body>
	</html>
{/strip}
