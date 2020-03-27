<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-scroll-to-active="true">
    <div class="scroll-sidebar">
        <div class="user-profile" style="background: url(<?php echo $this->config->item('PATH_ASSET_TEMPLATE'); ?>assets/images/background/user-info.jpg) no-repeat;">
            <div class="profile-img"> <img src="<?php echo $this->config->item('PATH_ASSET_IMAGE'); ?>avatar/user_avatar.png" alt="user" /> </div>
            <div class="profile-text">
                <a href="javascript:void(0)" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo $this->session->userdata('sess_nama_receivingpur'); ?></a>
                <div class="dropdown-menu animated flipInY">
                    <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    <a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                    <a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0)" id="form_logout_side" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="home" aria-expanded="false"><i class="ti-home"></i><span class="hide-menu">Home</span></a>
                </li>
                <li class="nav-devider"></li>
                <li>
                    <a class="waves-effect waves-dark" href="receiving" aria-expanded="false"><i class="ti-package"></i><span class="hide-menu">Receiving BPP & CER</span></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->