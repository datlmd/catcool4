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
                                          <li class="breadcrumb-item active" aria-current="page">{lang('create_group_heading')}</li>
                                    </ol>
                              </nav>
                        </div>
                  </div>
            </div>
      </div>
      <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="card">
                        <h5 class="card-header">{lang('create_group_subheading')}</h5>
                        <div class="card-body">
                            {form_open('user/auth/create_group', 'id="validationform" data-parsley-validate="" novalidate=""')}
                              <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_group_name_label')}</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        {form_input($group_name, '', 'required="" placeholder="Type something" class="form-control"')}
                                    </div>
                              </div>
                              <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('create_group_desc_label')}</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        {form_input($description, '', 'required="" placeholder="" class="form-control"')}
                                    </div>
                              </div>
                              <div class="form-group row text-center">
                                    <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                          <button type="submit" class="btn btn-space btn-primary">{lang('create_group_submit_btn')}</button>
                                        {*<button class="btn btn-space btn-secondary">Cancel</button>*}
                                    </div>
                              </div>
                            {form_close()}
                        </div>
                  </div>
            </div>
      </div>
</div>