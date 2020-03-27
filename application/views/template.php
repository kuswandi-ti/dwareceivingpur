<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicon icon -->
        <?php require_once('_partials/_favicon.php'); ?>

        <title>Receiving BPP & CER Purchasing | <?php echo $title; ?></title>

        <base href="<?php echo base_url(); ?>" />

        <?php require_once('_partials/_styles.php'); ?>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="fix-header fix-sidebar card-no-border logo-center">
        <?php require_once('_partials/_preloader.php'); ?>

        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <?php require_once('_partials/_topbar.php'); ?>
            <?php require_once('_partials/_sidebar.php'); ?>

            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles">
                        <div class="col-md-5 col-8 align-self-center">
                            <h3 class="text-themecolor"><?php echo $page_title; ?></h3>
                            <ol class="breadcrumb">
                                <?php echo $breadcrumb; ?>
                            </ol>
                        </div>
                    </div>

                    <?php echo $_content; ?>

                </div>
            </div>

            <?php require_once('_partials/_footer.php'); ?>
        </div>
        
        <?php require_once('_partials/_scripts.php'); ?>
        <?php echo $custom_scripts; ?>

        <script type="text/javascript">
            $(document).ready(function() {
                
                $(".select2").select2();

                $("body").on("click", "#form_logout_top, #form_logout_side", function() {
                    swal({
                        title               : 'Logout ?',
                        text                : "Yakin akan logout dari aplikasi ?",
                        type                : 'question',
                        showCancelButton    : true,
                        confirmButtonText   : 'Yes',
                        cancelButtonText    : "No",
                        confirmButtonClass  : "btn-warning",
                        showLoaderOnConfirm : true,
                        preConfirm          : function() {
                            return new Promise(function(resolve) {
                                $.ajax({
                                    url     : 'login/logout',
                                    type    : 'POST',
                                })
                                .done(function(response){
                                    swal.close(); // https://stackoverflow.com/questions/44973038/how-to-close-sweet-alert-on-ajax-request-completion
                                    window.location.href = 'login';
                                })
                                .fail(function(xhr, status, error) {
                                    var errorMessage = xhr.status + ': ' + xhr.statusText
                                    Swal.fire({
                                        type        : 'error',
                                        title       : '<strong>Error</strong>',
                                        text        : errorMessage,
                                    });
                                });
                            });
                        },
                        allowOutsideClick: false     
                    });
                });
            });            
        </script>
    </body>
</html>
