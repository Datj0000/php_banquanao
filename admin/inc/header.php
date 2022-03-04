<?php
include '../lib/session.php';
Session::checkSession();
include '../lib/database.php';
include '../helpers/format.php';
$adminId = Session::get('adminId');
$adminRole = Session::get('adminRole');
spl_autoload_register(function ($class) {
	include_once "../classes/" . $class . ".php";
});


$db = new Database();
$fm = new Format();
$ct = new cart();
$cat = new category();
$cs = new customer();
$product = new product();
$slider = new slider();
$address = new address();
$display = new display();
$footer = new footer();
$cp = new coupon();
?>

<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: max-age=2592000");
?>
<!doctype html>
<html lang="en">

<head>
	<title>Admin</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<link rel="stylesheet" href="assets/css/myStyle.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.24/af-2.3.6/r-2.2.7/datatables.min.css" />
	<link href="assets/css/font.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
</style>
<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="index.php"><img src="assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="inbox.php" class="dropdown-toggle icon-menu">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">
									<?php
									$qty = Session::get("qtypro");
									if(isset($qty)){
										echo $qty;
									}
									else{
										echo '0';
									}
									?>
								</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar"><span> Xin chào <?php echo Session::get('adminName') ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="editprofile.php"><i class="lnr lnr-user"></i> <span>Đổi thông tin</span></a></li>
								<li><a href="changepass.php"><i class="lnr lnr-cog"></i> <span>Đổi mật khẩu</span></a></li>
								<li><a href="?action=logout"><i class="lnr lnr-exit"></i> <span>Đăng xuất</span></a></li>
								<?php
								if (isset($_GET['action']) && $_GET['action'] == 'logout') {
									session::destroy();
								}
								?>
							</ul>
						</li>

					</ul>
				</div>
			</div>
		</nav>