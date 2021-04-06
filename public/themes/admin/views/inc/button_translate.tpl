<button id="btn_group_drop_setting" type="button" class="btn btn-sm btn-light btn-space me-0" data-bs-toggle="dropdown" aria-expanded="false">
	<i class="fas fa-cog"></i>
</button>
<ul class="dropdown-menu" aria-labelledby="btn_group_drop_setting">
	<li><a class="dropdown-item" href="{site_url('translations/manage')}?module_id={$translate_frontend}">{lang("Admin.text_translate")}</a></li>
	<li><a class="dropdown-item" href="{site_url('translations/manage')}?module_id={$translate_admin}">{lang("Admin.text_translate_admin")}</a></li>
</ul>
