{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-12">
            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('heading_title')}</h5>
				<div class="card-body px-0 pb-0 pt-3 bg-light">
                    {if !empty(validation_errors())}
						<ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                    {/if}
					<div class="tab-regular">
						<ul class="nav nav-tabs border-bottom ps-3" id="config_tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link p-2 ps-3 pe-3 {if $tab_type eq 'tab_page'}active{/if}" id="tab_page" data-toggle="tab" href="#tab_content_page" role="tab" aria-controls="tab_page" aria-selected="{if $tab_type eq 'tab_page'}true{else}false{/if}">{lang('tab_general')}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link p-2 ps-3 pe-3 {if $tab_type eq 'tab_image'}active{/if}" id="tab_image" data-toggle="tab" href="#tab_content_image" role="tab" aria-controls="tab_image" aria-selected="{if $tab_type eq 'tab_image'}true{else}false{/if}">{lang('tab_image')}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link p-2 ps-3 pe-3 {if $tab_type eq 'tab_local'}active{/if}" id="tab_local" data-toggle="tab" href="#tab_content_local" role="tab" aria-controls="tab_local" aria-selected="{if $tab_type eq 'tab_local'}true{else}false{/if}">{lang('tab_local')}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link p-2 ps-3 pe-3 {if $tab_type eq 'tab_option'}active{/if}" id="tab_option" data-toggle="tab" href="#tab_content_option" role="tab" aria-controls="tab_option" aria-selected="{if $tab_type eq 'tab_option'}true{else}false{/if}">{lang('tab_option')}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link p-2 ps-3 pe-3 {if $tab_type eq 'tab_mail'}active{/if}" id="tab_mail" data-toggle="tab" href="#tab_content_mail" role="tab" aria-controls="tab_mail" aria-selected="{if $tab_type eq 'tab_mail'}true{else}false{/if}">{lang('tab_mail')}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link p-2 ps-3 pe-3 {if $tab_type eq 'tab_server'}active{/if}" id="tab_server" data-toggle="tab" href="#tab_content_server" role="tab" aria-controls="tab_server" aria-selected="{if $tab_type eq 'tab_server'}true{else}false{/if}">{lang('tab_server')}</a>
							</li>
						</ul>
						<div class="tab-content border-0 p-3" id="tab_content">
							<div class="tab-pane fade {if $tab_type eq 'tab_page'}show active{/if}" role="tabpanel" id="tab_content_page"  aria-labelledby="tab_page">
								{include file=get_theme_path('views/_modules/configs/inc/tab_page.tpl')}
							</div>
							<div class="tab-pane fade {if $tab_type eq 'tab_image'}show active{/if}" role="tabpanel" id="tab_content_image"  aria-labelledby="tab_image">
								{include file=get_theme_path('views/_modules/configs/inc/tab_image.tpl')}
							</div>
							<div class="tab-pane fade {if $tab_type eq 'tab_local'}show active{/if}" role="tabpanel" id="tab_content_local"  aria-labelledby="tab_local">
								{include file=get_theme_path('views/_modules/configs/inc/tab_local.tpl')}
							</div>
							<div class="tab-pane fade {if $tab_type eq 'tab_option'}show active{/if}" role="tabpanel" id="tab_content_option"  aria-labelledby="tab_option">
								{include file=get_theme_path('views/_modules/configs/inc/tab_option.tpl')}
							</div>
							<div class="tab-pane fade {if $tab_type eq 'tab_mail'}show active{/if}" role="tabpanel" id="tab_content_mail"  aria-labelledby="tab_mail">
								{include file=get_theme_path('views/_modules/configs/inc/tab_mail.tpl')}
							</div>
							<div class="tab-pane fade {if $tab_type eq 'tab_server'}show active{/if}" role="tabpanel" id="tab_content_server"  aria-labelledby="tab_server">
								{include file=get_theme_path('views/_modules/configs/inc/tab_server.tpl')}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
