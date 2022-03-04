<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/user.php';
?>

<?php
$class = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insert_admin = $class->insert_admin($_POST);
}
if ($adminRole != 0) {
    header('Location: index.php');
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Tạo tài khoản</h2>
        <?php
        if (isset($insert_admin)) {
            echo $insert_admin;
        }
        ?>
        <form autocomplete="new-password" autocomplete="off" autocomplete="false" action="" method="post">
            <div class="form-group">
                <label>Tên nhân viên:</label>
                <input type="text" name="adminName" class="form-control" placeholder="Tên nhân viên" />
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="adminEmail" class="form-control" placeholder="Email" />
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="adminPhone" class="form-control" placeholder="Số điện thoại" />
            </div>
            <div class="form-group">
                <label>Tài khoản:</label>
                <input type="text" name="adminUser" class="form-control" placeholder="Tài khoản" />
            </div>
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="adminPassword" class="form-control" placeholder="Mật khẩu" />
            </div>
            <div class="form-group">
                <label>Nhập lại mật khẩu:</label>
                <input type="password" name="readminPassword" class="form-control" placeholder="Nhập lại mật khẩu" />
            </div>
            <div class="form-group">
                <label>Phân quyền: </label>
                <select name="level" class="form-control" id="exampleFormControlSelect1">
                    <option value="">Phân quyền</option>
                    <option value="0">Quản lý</option>
                    <option value="1">Nhân viên</option>
                </select>
            </div>
            <div class="form-group">
                <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
            </div>
        </form>
    </div>
</div>
<?php include 'inc/footer.php'; ?>