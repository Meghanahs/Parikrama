<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo base_url();?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo lang('login'); ?> - <?php echo $this->db->get("settings")->row()->system_vendor; ?> </title>

    <!-- Bootstrap core CSS -->
    
    <link href="common/css/bootstrap.min.css" rel="stylesheet">
    <link href="common/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link rel="stylesheet" href="common/css/tab.css">
    <link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="common/css/style.css" rel="stylesheet">
    <link href="common/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

      <!--     
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label> 
      -->
      
<div class="row">
<div class="col-md-4 col-md-offset-4">
<div class="form-body">
    <ul class="nav nav-tabs final-login">
        <li class="active"><a data-toggle="tab" href="#sectionA">Sign In</a></li>
        <li><a data-toggle="tab" href="#sectionB">Sign Up</a></li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active">
        <div class="innter-form">
        <form class="sa-innate-form" method="post" action="auth/login">
        <h2 class="login form-signin-heading">Parikrama</h2>
      <div id="infoMessage"><?php echo $message;?></div>
            <label>Email Address</label>
             <input type="text" class="form-control" name="identity" placeholder="<?php echo lang('useremail'); ?>" autofocus>          
            <label>Password</label>
             <input type="password" class="form-control" name="password" placeholder="<?php echo lang('password'); ?>">
          <center>   <button type="submit" >Sign In</button></center>
            <p style="text-align:center;"><a data-toggle="modal" href="#myModal"> <?php echo lang('forgot_password'); ?></a></p>
        <!--    </button> -->
            </form>
            </div>
           
            <div class="clearfix"></div>
        </div>
        <div id="sectionB" class="tab-pane fade">
			<div class="innter-form">
            <form class="sa-innate-form" method="post">
			  <div id="infoMessage"><?php echo $message;?></div>
            <label>Name</label>
            <input type="text" name="username" autofocus>
            <label>Email Address</label>
            <input type="text" name="username">
			<label>Phone Number</label>
            <input type="text" name="phone_no">
            <label>Password</label>
            <input type="password" name="password">
           <center> <button type="submit">Register</button></center>
            </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    
     <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <form method="post" action="auth/forgot_password">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><?php echo lang('forgot_password'); ?></h4>
                            </div>

                              <div class="modal-body">
                                  <p><?php echo lang('reset_message');?></p>
                                  <input type="text" name="email" placeholder="<?php echo lang('email');?>" autocomplete="off" class="form-control placeholder-no-fix">

                              </div>
                              <div class="modal-footer">
                                  <button data-dismiss="modal" class="btn btn-default" type="button"><?php echo lang('cancel');?></button>
                                  <input class="btn btn-success" type="submit" name="submit" value="submit">
                              </div>
                      </form>
                  </div>
              </div>
          </div>
          

    <!-- js placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="common/js/jquery-1.11.1.min.js"></script>
    <script src="common/js/jquery.js"></script>
    <script src="common/js/bootstrap.min.js"></script>


  </body>
</html>
