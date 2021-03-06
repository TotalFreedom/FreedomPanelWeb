<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><[PAGE_TITLE]></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/skin-<[COLOUR_SCHEME]>.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>

    <script src='plugins/chartjs/Chart.js'></script>
    <script src='dist/js/communication.js'></script>
    <script src='dist/js/panel.js'></script>
    <script async src='dist/js/panel_async.js'></script>
    <script src='dist/js/admincontrol.js'></script>
  </head>
  <body class="sidebar-mini skin-<[COLOUR_SCHEME]>">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="?page=dashboard" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><[PAGE_SMALL_TITLE]></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><[PAGE_LARGE_TITLE]></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
            <li id='loadingSpinner' style='display: none;' class='dropdown'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <i class='fa fa-spinner fa-spin'></i>

              </a>

            </li>
              <li class="dropdown user user-menu">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <img src="<[SKIN_HEAD_URL]>" class="user-image" alt="User Image" />

                  <span class="hidden-xs" id=''><[USERNAME]></span>
                </a>
                <ul class="dropdown-menu">

                  <li class="user-header">
                    <img src="<[SKIN_HEAD_URL]>" class="img-circle" alt="User Image" />
                    <p>
                      <[USERNAME]> - <[RANK]>
                      <small></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="?page=account" class="btn btn-default btn-flat">Account</a>
                    </div>
                    <div>
                    <div class="pull-right">
                      <a href="global/scripts/useractions.php?action=logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<[SKIN_HEAD_URL]>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><[USERNAME]></p>
              <!-- Status -->
              <a href="#" id="connected" style='display: none;'><i class="fa fa-circle text-success"></i> Connected</a>
              <a href="#" id="disconnected" style='display: inline;'><i class="fa fa-circle text-danger"></i> Disconnected (connecting...)</a>
            </div>
          </div>


          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">NAVIGATION</li>
            <!-- Optionally, you can add icons to the links -->
            <[NAVBAR]>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           <[PAGE_HEADER]>
            <small><[PAGE_DESCRIPTION]></small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <[PAGE_CONTENT]>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          <[SUBTEXT]>
        </div>
        <!-- Default to the left -->
        <strong><[COPYRIGHT_TEXT]>
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3>Content to go here</h3>

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Colour Scheme
                  <select class="form-control" onchange='document.cookie="colour_scheme=" + this.options[this.selectedIndex].value + ";expires=Wed, 18 Dec 2023 12:00:00 GMT"; location.reload();'>
                    <option value='black'>-</option>
                    <option value='black'>Black</option>
                    <option value='blue'>Blue</option>
                    <option value='yellow'>Yellow</option>
                    <option value='purple'>Purple</option>
                    <option value='red'>Red</option>
                    <option value='green'>Green</option>
                  </select>
                </label>
                <p>
                  Choose a colour theme for the panel
                </p>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
<script>
pollBackend();
</script>

  </body>
</html>
