<?php
$title = 'Đăng nhập';
include 'inc/header.php';  ?>
<?php
require 'vendor/autoload.php';
$login_check = Session::get('customer_login');
if ($login_check == true) {
    header('Location:trang-chu.html');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $insertCustomers = $cs->insert_customers($_POST);
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

    $login_Customers = $cs->login_customers($_POST);
}
?>
</div>
<div class="account-page">
    <div class="container">
        <div class="row">
            <?php
            $get_display = $display->show_display();
            if ($get_display) {
                while ($result = $get_display->fetch_assoc()) {
            ?>
                    <div class="col-2">
                        <img src="admin/uploads/<?php echo $result['imgbanner'] ?>">
                    </div>
            <?php
                }
            }
            ?>
            <div class="col-2">
                <div class="form-container">
                    <div class="form-btn">
                        <span onclick="login()">Đăng kí</span>
                        <span onclick="register()">Đăng nhập</span>
                        <hr id="Indicator">
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    if (isset($insertCustomers)) {
                        echo $insertCustomers;
                    }
                    ?>
                    <form id="RegForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input id="email" name="email" type="email" placeholder="Tài khoản">
                        <input id="password" type="password" name="password" placeholder="Mật khẩu">
                        <div style="margin-top: 20px;">
                            <button style="margin: 30px 0" type="submit" name="login">Đăng nhập</button>
                            <a href="quen-mat-khau.html">Quên mật khẩu?</a>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <?php
                    if (isset($login_Customers)) {
                        echo $login_Customers;
                    }
                    ?>
                    <form style="top: 70px;" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="LoginForm" method="post">
                        <input name="email" type="email" placeholder="Email">
                        <input name="password" type="password" placeholder="Mật khẩu">
                        <input name="re_password" type="password" placeholder="Nhập lại mật khẩu">
                        <input name="name" type="text" placeholder="Họ và tên">
                        <input name="address" type="text" placeholder="Địa chỉ">
                        <input name="phone" type="text" placeholder="Số điện thoại">
                        <button type="submit" name="submit">Đăng kí</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ------------footer----------- -->
<?php include 'inc/footer.php'  ?>