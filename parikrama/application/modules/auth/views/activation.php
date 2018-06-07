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
      
<div class="row">
    <div class="style="2px solid black;">
     <h3 style="text-align:center;color:teal;padding-top: 75px;">Registration Successfull, Check your mail for Activation Link</h3>
      <center><a href=""><button type="button" class="btn">Go Back</a></button></center>
</div>

</div>
  </body>
</html>
