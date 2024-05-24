<button id="btn_group_drop_setting" type="button" class="btn btn-sm btn-light btn-space me-0" data-bs-toggle="dropdown" aria-expanded="false">
	<i class="fas fa-cog"></i>
</button>
<ul class="dropdown-menu" aria-labelledby="btn_group_drop_setting">
	{if !empty($translate_frontend)}<li><a class="dropdown-item" href="{site_url('manage/translations')}?module_id={$translate_frontend}">{lang("Admin.text_translate")}</a></li>{/if}
	{if !empty($translate_admin)}<li><a class="dropdown-item" href="{site_url('manage/translations')}?module_id={$translate_admin}">{lang("Admin.text_translate_admin")}</a></li>{/if}
</ul>
