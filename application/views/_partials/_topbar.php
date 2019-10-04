<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="home">
                <b>
                    <img src="<?php echo $this->config->item('PATH_ASSET_TEMPLATE'); ?>assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                    <img src="<?php echo $this->config->item('PATH_ASSET_TEMPLATE'); ?>assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                </b>
                <span>
                    <img src="<?php echo $this->config->item('PATH_ASSET_TEMPLATE'); ?>assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                    <img src="<?php echo $this->config->item('PATH_ASSET_TEMPLATE'); ?>assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                </span>
            </a>
        </div>

        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $this->config->item('PATH_ASSET_IMAGE'); ?>avatar/user_avatar.png" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?php echo $this->config->item('PATH_ASSET_IMAGE'); ?>avatar/user_avatar.png" alt="user"></div>
                                    <div class="u-text">
                                        <h4><?php echo $this->session->userdata('sess_nama'); ?></h4>
                                        <p class="text-muted">NIK : <?php echo $this->session->userdata('sess_nik'); ?></p><a href="" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);" id="form_logout_top"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->