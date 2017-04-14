<?php $self->document->setTitle("Home"); echo $self->load->controller('common/header_home'); ?>
     <main class="app-layout-content">

                    <!-- Page header -->
                    <div class="page-header bg-app bg-inverse">
                        <div class="container">
                            <div class="p-y-lg text-center">
                                <h1 class="display-2">Contact us</h1>
                                <p class="text-muted">Get in touch with us</p>
                            </div>
                        </div>
                    </div>
                    <!-- End page header -->

                    <div class="page-content bg-white">
                        <div class="container">
                            <!-- Section Content -->
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <form class="form-horizontal" action="" method="post">
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <label for="frontend-contact-firstname">First name</label>
                                                <input class="form-control" type="text" id="frontend-contact-firstname" name="frontend-contact-firstname" />
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="frontend-contact-lastname">Last name</label>
                                                <input class="form-control" type="text" id="frontend-contact-lastname" name="frontend-contact-lastname" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="frontend-contact-email">Email</label>
                                                <input class="form-control" type="email" id="frontend-contact-email" name="frontend-contact-email" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="frontend-contact-subject">Where?</label>
                                                <select class="form-control" id="frontend-contact-subject" name="frontend-contact-subject" size="1">
                <option value="1">Support</option>
                <option value="2">Billing</option>
                <option value="3">Management</option>
                <option value="4">Feature Request</option>
              </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="frontend-contact-msg">Message</label>
                                                <textarea class="form-control" id="frontend-contact-msg" name="frontend-contact-msg" rows="7"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <button class="btn btn-app btn-block" type="submit">Send Message</button>
                                            </div>
                                        </div>
                                        <span class="help-block">This form is a placeholder. Requests won't be proccessed.</span>
                                    </form>
                                </div>
                            </div>
                            <!-- .row -->
                            <!-- End Section Content -->
                        </div>
                        <!-- .container -->
                    </div>
                    <!-- .section -->

                    <!-- Google Maps, initialized in js/pages/frontend_contact.js, for more examples please check https://hpneo.github.io/gmaps/ -->
                    <div class="bg-white" id="js-map-contact" style="height: 350px;"></div>

                </main>

                <footer class="app-layout-footer">
                    <div class="container p-y-md">
                        <div class="pull-right hidden-sm hidden-xs">
                            <a href="https://shapebootstrap.net/item/1525731-BitflyerBank-admin-frontend-template/?ref=rustheme" target="_blank" rel="nofollow">Purchase a license</a>
                        </div>
                        <div class="pull-left text-center text-md-left">
                            BitflyerBank &copy; <span class="js-year-copy"></span>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- .app-layout-container -->
        </div>
        <!-- .app-layout-canvas -->

        <!-- Apps Modal -->
        <!-- Opens from the button in the header -->
        <div id="apps-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-sm modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <!-- Apps card -->
                    <div class="card m-b-0">
                        <div class="card-header bg-app bg-inverse">
                            <h4>Apps</h4>
                            <ul class="card-actions">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="ion-close"></i></button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-block">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <a class="card card-block m-b-0 bg-app-secondary bg-inverse" href="home.html">
                                        <i class="ion-speedometer fa-4x"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                    <a class="card card-block m-b-0 bg-app-tertiary bg-inverse" href="index.html">
                                        <i class="ion-laptop fa-4x"></i>
                                        <p>Home</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- .card-block -->
                    </div>
                    <!-- End Apps card -->
                </div>
            </div>
        </div>
        <!-- End Apps Modal -->

          </div>
    <script src="catalog/view/theme/default/assets/jquery.min.js"></script>
    <script src="catalog/view/theme/default/assets/bootstrap.min.js"></script>
    <script src="catalog/view/theme/default/assets/jquery.slimscroll.min.js"></script>
    <script src="catalog/view/theme/default/assets/jquery.scrollLock.min.js"></script>
    <script src="catalog/view/theme/default/assets/jquery.placeholder.min.js"></script>
    <script src="catalog/view/theme/default/assets/app.js"></script>
    <script src="catalog/view/theme/default/assets/app-custom.js"></script>

        <!-- Page JS Plugins -->
        <script src="http://maps.google.com/maps/api/js"></script>
        <script src="catalog/view/theme/default/assets/gmaps.min.js"></script>

        <!-- Page JS Code -->
        <script src="catalog/view/theme/default/assets/frontend_contact.js"></script>

    </body>


</html>