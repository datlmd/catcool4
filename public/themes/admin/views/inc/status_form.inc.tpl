{strip}
	<div class="card bg-light">
		<div class="card-body">
			<div class="my-2">
				{lang('Admin.text_published')}:
				{if isset($edit_data.deleted) && !is_null($edit_data.deleted)}
					<span class="text-danger ms-2">{lang('Admin.text_deleted')}</span>
				{elseif !empty($edit_data.published) || !empty($status)}
					<span class="badge-dot badge-success ms-2 me-1"></span>{lang('Admin.text_enabled')}
				{else}
					<span class="badge-dot border border-dark ms-2 me-1"></span>{lang('Admin.text_disabled')}
				{/if}
			</div>
			<div class="my-2">
				{lang('Admin.text_ctime')}: {if !empty($edit_data.ctime)}{$edit_data.ctime}{/if}
			</div>
			<div class="my-2">
				{lang('Admin.text_mtime')}: {if !empty($edit_data.mtime)}{$edit_data.mtime}{/if}
			</div>
		</div>
	</div>
{/strip}
