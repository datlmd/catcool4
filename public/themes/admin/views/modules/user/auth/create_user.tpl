<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{lang('create_user_heading')}</h2>
                <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet
                    vestibulum mi. Morbi lobortis pulvinar quam.</p>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{lang('index_heading')}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{lang('create_user_heading')}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{lang('create_user_subheading')}</h5>
                <div class="card-body">
                    {form_open('user/auth/create_user', 'id="validationform" data-parsley-validate="" novalidate=""')}
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_user_fname_label')}</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            {form_input($first_name, '', 'required="" placeholder="Type something" class="form-control"')}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_user_lname_label')}</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            {form_input($last_name, '', 'required="" placeholder="" class="form-control"')}
                        </div>
                    </div>
                    {if $identity_column !== 'email'}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_user_identity_label')}</label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($identity, '', 'required="" placeholder="Type something" class="form-control"')}
                            </div>
                        </div>
                    {/if}
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_user_company_label')}</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            {form_input($company, '', 'required="" placeholder="Type something" class="form-control"')}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_user_email_label')}</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            {form_input($email, '', 'required="" placeholder="Type something" class="form-control"')}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_user_phone_label')}</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            {form_input($phone, '', 'required="" placeholder="Type something" class="form-control"')}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_user_password_label')}</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            {form_input($password, '', 'required="" placeholder="Password" class="form-control"')}
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            {form_input($password_confirm, '', 'data-parsley-equalto="#pass2" placeholder="Re-Type Password" class="form-control"')}
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">{lang('create_user_submit_btn')}</button>
                            <button type="reset" class="btn btn-space btn-secondary">Cancel</button>
                        </div>
                    </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>