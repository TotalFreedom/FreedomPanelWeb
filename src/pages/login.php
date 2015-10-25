<?php
require_once('../global/global.php');

// If the user is accessing this page, check if they have a valid cookie, if so, log them in straight away
$users->autoLogin();
?>
<!DOCTYPE html>
<html>
<head>
<!-- All the files that are required -->
  <link rel="stylesheet" href="../dist/css/login.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
  <script src="../dist/js/login.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title><?php echo $config['page_title']; ?> Login</title>
</head>

<body>
<!-- Where all the magic happens -->
<!-- LOGIN FORM -->
<center>
<div class="text-center" style="padding:50px 0">
	<div class="logo"><?php echo $config['server_name']; ?> Login</div>
	<!-- Main Form -->
	<div class="login-form-1">
		<form id="login-form" class="text-left" method='post' action='../global/scripts/useractions.php?action=login'>
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="username" class="sr-only">Username</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="username">
					</div>
					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="password">
					</div>
					<div class="form-group login-group-checkbox">
						<input type="checkbox" id="remember" name="remember">
						<label for="remember">Remember me</label>
					</div>
				</div>
				<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			</div>
			<div class="etc-login-form">
        <?php
        if (isset($_GET['incorrect'])) {
          echo 'Incorrect username or password';
        }
         ?>
			</div>
		</form>
	</div>
	<!-- end:Main Form -->
</div>

</center>
</body>
</html>
