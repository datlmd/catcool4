<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">{lang('index_heading')}</h2>
				<p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">{lang('index_heading')}</a></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('index_subheading')}</h5>
				<div class="card-body">
					<p>{anchor('user/auth/create_user', lang('index_create_user_link'))} | {anchor('user/auth/create_group', lang('index_create_group_link'))}</p>
					<div class="table-responsive">
						<table class="table table-striped table-bordered first">
							<thead>
								<tr>
									<th>{lang('index_fname_th')}</th>
									<th><{lang('index_lname_th')}</th>
									<th>{lang('index_email_th')}</th>
									<th>{lang('index_groups_th')}</th>
									<th>{lang('index_status_th')}</th>
									<th>{lang('index_action_th')}</th>
								</tr>
							</thead>
							<tbody>
                            {foreach $users as $user}
								<tr>
									<td>{htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8')}</td>
									<td>{htmlspecialchars($user->last_name,ENT_QUOTES, 'UTF-8')}</td>
									<td>{htmlspecialchars($user->email,ENT_QUOTES,'UTF-8')}</td>
									<td>
                                        {foreach $user->groups as $group}
                                            {anchor("user/auth/edit_group/`$group->id`", htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'))}<br />
                                        {/foreach}
									</td>
									<td>
                                        {if $user->active}
                                            {anchor("user/auth/deactivate/`$user->id`", lang('index_active_link'))}
                                        {else}
                                            {anchor("user/auth/activate/`$user->id`", lang('index_inactive_link'))}
                                        {/if}
									</td>
									<td>{anchor("user/auth/edit_user/`$user->id`", 'Edit')}</td>
								</tr>
                            {/foreach}
							</tbody>
							<tfoot>
							<tr>
								<th>{lang('index_fname_th')}</th>
								<th><{lang('index_lname_th')}</th>
								<th>{lang('index_email_th')}</th>
								<th>{lang('index_groups_th')}</th>
								<th>{lang('index_status_th')}</th>
								<th>{lang('index_action_th')}</th>
							</tr>
							</tfoot>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

