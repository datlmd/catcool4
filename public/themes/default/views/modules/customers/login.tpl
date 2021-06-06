<div class="container">

    <div class="row">
        <div class="col">

            <div class="featured-boxes">
                <div class="row">
                    <div class="col-md-8">
                        <div class="featured-box featured-box-primary text-start mt-5">
                            <div class="box-content">
                                {include file=get_module_path("Users/Views/form_register.tpl") register_title_class='font-weight-semibold'}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="featured-box featured-box-primary text-start mt-5">
                            <div class="box-content">
                                <h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">I'm a Returning Customer</h4>
                                <form action="/" id="frmSignIn" method="post" class="needs-validation">
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label class="font-weight-bold text-dark text-2">Username or E-mail Address</label>
                                            <input type="text" value="" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <a class="float-end" href="#">(Lost Password?)</a>
                                            <label class="font-weight-bold text-dark text-2">Password</label>
                                            <input type="password" value="" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember">
                                                <label class="custom-control-label text-2" for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="submit" value="Login" class="btn btn-primary btn-modern float-end" data-loading-text="Loading...">
                                        </div>
                                    </div>
                                </form>
                                <div class="text-center-line mt-4">Hoặc</div>
                                {include file=get_theme_path('views/inc/login_social.tpl')}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

