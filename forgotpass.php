<?php 
$title = 'Quên mật khẩu';
include 'inc/header.php';  ?>

<?php
include 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $forgotpass = $cs->forgotpass($_POST);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])) {
    $email = $_GET['email'];
    $changepass = $cs->changepass($_POST, $email);
}

?>
</div>
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
            <?php
            if (!isset($_GET['email']) || $_GET['email'] == NULL) {
            ?>
                <div class="form-container">
                    <div class="form-btn">
                        <span style="text-align: center;">Lấy lại mật khẩu</span>
                        <hr id="Indicator2">
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    if (isset($forgotpass)) {
                        echo $forgotpass;
                    }
                    ?>
                    <form method="post" action="">
                        <input id="email" name="email" type="email" placeholder="Tài khoản">
                        <button style="margin-top: 20px;" type="submit" name="submit">Gửi</button>
                    </form>
                </div>
            <?php
            } else {
                $email = $_GET['email'];
                $token =  $_GET['token'];
            ?>
                <div class="form-container">
                    <span class="title">Lấy lại mật khẩu</span>
                    <div class="clearfix"></div>
                    <?php
                    if (isset($changepass)) {
                        echo $changepass;
                    }
                    ?>
                    <form method="post" action="">
                        <input name="password" type="password" placeholder="Mật khẩu">
                        <input name="re_password" type="password" placeholder="Nhập lại mật khẩu">
                        <button style="margin-top: 20px;" type="submit" name="change">Đổi mật khẩu</button>
                    </form>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>
<!-- ------------footer----------- -->
<?php include 'inc/footer.php'  ?>