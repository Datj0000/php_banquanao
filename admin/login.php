<?php
include '../classes/adminlogin.php';
?>
<?php
$class = new adminlogin();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$adminUser = $_POST['adminUser'];
	$adminPass = md5($_POST['adminPass']);
	$login_check = $class->login_admin($adminUser, $adminPass);
}
?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<link href="assets/css/font.css" rel="stylesheet">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="assets/img/logo-dark.png" alt="Klorofil Logo"></div>
								<p class="lead">Đăng nhập</p>
							</div>
							<form class="form-auth-small" action="" method="post">
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Tài khoản</label>
									<input type="text" class="form-control" id="signin-email" name="adminUser" placeholder="Tài khoản">
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Mật khẩu</label>
									<input type="password" class="form-control" id="signin-password" name="adminPass" placeholder="Mật khẩu">
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-center">
										<?php
										if (isset($login_check)) {
											echo $login_check;
										}
										?>
									</label>
								</div>
								<button type="submit" style="outline: none;" class="btn btn-primary btn-lg btn-block">Đăng nhập</button>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="forgotpass.php">Quên mật khẩu?</a></span>
								</div>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<!-- <h1 class="heading">Free Bootstrap dashboard template</h1>
							<p>by The Develovers</p> -->
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>