{strip}
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
{/strip}
