<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PinCamera</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="../gambar/favicon.ico" />
        <!--======== All Stylesheet =========-->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fontes -->
        <link href="../css/buttons.css" rel="stylesheet">
        <!-- adminbag main css -->
        <link href="../css/main.css" rel="stylesheet">
        <!-- light theme css -->
        <link href="../css/light.css" rel="stylesheet">
        <!-- media css for responsive  -->
        <link href="../css/main.media.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
  </head>
  <style type="text/css">
    body
    {
      background-color: #CBCBCB1A;
    }
  </style>
<body class="page-header-fixed">
<?php
 $fungsi=new fungsi_php();
 ?>
  <div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
      <div class="page-logo">
        <a href="index.php?page=home&status=ok" style="text-align: center; text-decoration: none; color: #337ab7;">
          <img class="logo-default hide-sm" alt="logo" src="../gambar/logoo.png" style="width: 175%;">
        </a>
      </div>
      <div class="page-logo img-responsive">
         <button class="btn btn-outline btn-round btn-sm btn-info img-responsive" style="padding-left: 5%; margin-top: 5%; text-align: center; margin-left: 230%;" data-toggle="modal" data-target=".bs-example-modal-sm-upload"><i class="glyphicon glyphicon-plus"></i> Upload Inspirasimu
          </button>
      </div>
        <!-- BEGIN TOP NAVIGATION MENU -->
      <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
          <!-- START USER LOGIN DROPDOWN -->
          <li class="dropdown dropdown-user">
             <?php
              $fungsi->cekfoto();
            ?>
            <ul class="dropdown-menu dropdown-menu-default">
              <li> 
                <a href="index.php?page=profil"> <i class="glyphicon glyphicon-user"></i> Profil</a>
              </li>
              <li>
                <a href="index.php?page=setting"> <i class="glyphicon glyphicon-cog"></i> Setting</a>
              </li>
              <li class="divider">
              </li>
              <li> 
                <a href="logout.php?maukeluar=iya'"> <i class="glyphicon glyphicon-off"></i> Log Out </a>
              </li>
            </ul>
          </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
      </div>
      <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
  </div>
  <div class="modal fade bs-example-modal-sm-upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" style="color: #3598DC;" >Upload Inspirasi</h4>
                      </div>
                      <div class="modal-body">
                        <form enctype ="multipart/form-data" action="aksi.php" method="POST">
                          <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Judul inspirasimu" required>
                          </div>
                          <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select name="kategori" class="form-control" required>
                                   <?php
                                    $fungsi->kategorimodal();
                                  ?>
                            </select>
                            <label for="tambah_kategori" style="padding: 4%;margin-bottom: -4%;"><a href="index.php?page=tambah_kategori"><i class="glyphicon glyphicon-plus"></i> Tambah Kategori</a></label>
                          </div>
                          <div class="form-group">
                            <label>Caption</label>
                            <textarea class="form-control" placeholder="Caption Inspirasimu" name="caption" required></textarea>
                          </div>
                          <div class="form-group">
                            <label>Tag</label>
                            <textarea class="form-control" placeholder="Tag" name="tag" required></textarea>
                          </div>
                          <div class="form-group">
                            <label>Pilih Gambar</label>
                            <input type="file" name="file" required />
                            <p class="help-block">Max 2MB</p>
                            <button type="submit" name="upload" class="btn btn-round btn-outline btn-success btn-sm"><i class="glyphicon glyphicon-send"></i> Upload</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
  <div class="container">
  <!-- Start page content wrapper -->
    <div class="page-content-wrapper">
      <div class="row dashboard-header">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div id="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
              <div class="social-feed-box btn-round">
                <div class="social-avatar" style="text-align: center;">
                  <div class="social-body" style="margin-left: 5%;">
                    <?php
                        $fungsi=new fungsi_php();
                        $fungsi->fotoprofil();
                        $fungsi->profil();
                    ?>
                  </div>
              </div>
              </div>
        </div>
      </div>
      <div id="row">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <?php
                $fungsi->koleksi();
            ?>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery.min.js"></script>
<!-- bootstrap js -->
<script src="../js/bootstrap.min.js"></script>
</html>