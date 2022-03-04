<?php
// include '../classes/adminlogin.php';
include '../classes/user.php';
?>
<?php
// $class = new adminlogin();
$user = new user();
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
<?php
include '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['forgot'])) {
    $forgotpass = $user->forgotpass($_POST);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])) {
    $email = $_GET['email'];
    $changepass = $user->changepass($_POST, $email);
}

?>

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
                                <p class="lead">Quên mật khẩu</p>
                            </div>
                            <form class="form-auth-small" action="" method="post">

                                <?php
                                if (!isset($_GET['email']) || $_GET['email'] == NULL) {
                                ?>
                                    <div class="form-group">
                                        <label for="signin-email" class="control-label sr-only">Tài khoản</label>
                                        <input type="text" class="form-control" id="signin-email" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="fancy-checkbox element-center">
                                            <?php
                                            if (isset($forgotpass)) {
                                                echo $forgotpass;
                                            }
                                            ?>
                                        </label>
                                    </div>
                                    <button name="forgot" type="submit" style="outline: none;" class="btn btn-primary btn-lg btn-block">Gửi</button>
                                <?php
                                } else {
                                    $email = $_GET['email'];
                                    $token =  $_GET['token'];
                                ?>
                                    <div class="form-container">
                                        <div class="form-group">
                                            <label for="signin-password" class="control-label sr-only">Mật khẩu</label>
                                            <input type="password" class="form-control" id="signin-password" name="password" placeholder="Mật khẩu">
                                        </div>
                                        <div class="form-group">
                                            <label for="signin-password" class="control-label sr-only">Nhập lại mật khẩu</label>
                                            <input type="password" class="form-control" id="signin-password" name="re_password" placeholder="Nhập lại mật khẩu">
                                        </div>
                                        <div class="form-group clearfix">
                                            <label class="fancy-checkbox element-center">
                                                <?php
                                                if (isset($changepass)) {
                                                    echo $changepass;
                                                }
                                                ?>
                                            </label>
                                        </div>
                                        <button name="change" type="submit" style="outline: none;" class="btn btn-primary btn-lg btn-block">Đổi mật khẩu</button>
                                    </div>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="overlay"></div>
                        <div class="content text">
                            <h1 class="heading">Free Bootstrap dashboard template</h1>
                            <p>by The Develovers</p>
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