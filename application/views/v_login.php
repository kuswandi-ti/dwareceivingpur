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

        <title>Garansi Proses</title>

        <?php require_once('_partials/_styles.php'); ?>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

	<body>
	    <?php require_once('_partials/_preloader.php'); ?>

	    <!-- ============================================================== -->
	    <!-- Main wrapper - style you can find in pages.scss -->
	    <!-- ============================================================== -->
	    <section id="wrapper">	    	
	        <div class="login-register" style="background-image:url(<?php echo $this->config->item('PATH_ASSET_TEMPLATE'); ?>assets/images/background/login-register.jpg);">	        	
	            <div class="login-box card">
	                <div class="card-body">
	                	<img src="<?php echo $this->config->item('PATH_ASSET_TEMPLATE'); ?>assets/images/background/guarantee-logo.png" style="display: block; margin-left: auto; margin-right: auto;">
	                    <form class="form-horizontal" id="form_login" action="#">
	                        <h2 class="box-title m-b-20 text-center"><br />Log In</h2>
	                        <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
                                </div>
                            </div>                            
                            <div class="form-group text-center m-t-20">
	                            <div class="col-xs-12">
	                                <button class="btn btn-info btn-md btn-block waves-effect waves-light" id="btn_login" type="submit">Submit</button>
                                    <br><br><br>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	            <p>&nbsp;</p>
	            <p>&nbsp;</p>
	        </div>
	    </section>
    
    	<?php require_once('_partials/_scripts.php'); ?>
        <?php echo $custom_scripts; ?>    
	</body>
</html>