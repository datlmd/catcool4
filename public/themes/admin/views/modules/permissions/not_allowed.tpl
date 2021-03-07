{strip}
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mt-3">
                <h5 class="card-header"><i class="fas fa-list me-2"></i>{lang('PermissionAdmin.heading_title')}</h5>
                <div class="card-body my-3">
                    <h4>
                        {if !empty($permission_text)}
                            {$permission_text}
                        {else}
                            {lang('PermissionAdmin.not_permission')}
                        {/if}
                    </h4>
                    <span class="text-danger">Action: {$action}</span>
                </div>
            </div>
        </div>
    </div>
</div>
{/strip}
