<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PinCamera</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="gambar/favicon.ico" />
        <!--======== All Stylesheet =========-->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fontes -->
        <link href="css/buttons.css" rel="stylesheet">
        <!-- adminbag main css -->
        <link href="css/main.css" rel="stylesheet">
        <!-- light theme css -->
        <link href="css/light.css" rel="stylesheet">
        <!-- media css for responsive  -->
        <link href="css/main.media.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
  </head>
  <style type="text/css">
    body
    {
      background-color: #CBCBCB1A;
    }
  </style>
<body class="page-header-fixed">
  <div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
      <div class="page-logo">
        <a href="home.php" style="text-decoration: none; color: #337ab7;">
          <img src="gambar/logoo.png" class="logo-default hide-sm" alt="logo" style="width: 175%;">
        </a>
      </div>
        <!-- BEGIN TOP NAVIGATION MENU -->
      <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
          <!-- START USER LOGIN DROPDOWN -->
          <li>
            <a  href="index.html">
                <span class="username username-hide-on-mobile"><i class="glyphicon glyphicon-log-in"></i> LOGIN</span>
            </a>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
      </div>
      <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
  </div>
  <div class="container">
  <!-- Start page content wrapper -->
    <div class="page-content-wrapper">
      <div class="row dashboard-header">
        <div class="col-lg-12">
          <div id="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
              <div class="social-feed-box btn-round"\>
                <div class="social-avatar" style="text-align: center;">
                  <div class="media-body">   <div class="caption" data-toggle="modal" data-target=".bs-example-modal-sm1">
                        <h4>
                          Kategori <i class="glyphicon glyphicon-list-alt"></i></h4></div></div>
                    <hr style="margin-bottom: -2%;">
                  </div>
                  <div class="social-body" style="margin-left: 5%;">
                    <?php
                      include 'fungsi_php.php';
                      $fungsi=new fungsi_php();
                      $fungsi->tampil_kategori();
                    ?>
                  </div>
              </div>
            </div>
          </div>
          <div id="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <?php
                if (isset($_GET['kategori']))
                {
                    $fungsi->galerikategori();
                }
                else
                {
                    $fungsi->galeri();  
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- bootstrap js -->
<script src="js/bootstrap.min.js"></script>
</html>