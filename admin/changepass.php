<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/user.php';
?>

<?php
$id = Session::get('adminId');
$class = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldPass =  md5($_POST['oldpassword']);
    $newPass = md5($_POST['newpassword']);
    $rePass = md5($_POST['repassword']);
    $change_pass = $class->change_pass($oldPass, $newPass, $rePass, $id);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Đổi mật khẩu</h2>
        <?php
        if (isset($change_pass)) {
            echo $change_pass;
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label>Mật khẩu cũ:</label>
                <input type="password" name="oldpassword" class="form-control" placeholder="Mật khẩu cũ" />
            </div>
            <div class="form-group">
                <label>Mật khẩu mới:</label>
                <input type="password" name="newpassword" class="form-control" placeholder="Mật khẩu mới" />
            </div>
            <div class="form-group">
                <label>Xác nhận mật khẩu:</label>
                <input type="password" name="repassword" class="form-control" placeholder="Xác nhận mật khẩu" />
            </div>
            <div class="form-group">
                <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
            </div>
        </form>
    </div>
</div>
<?php include 'inc/footer.php'; ?>