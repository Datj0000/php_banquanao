<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/user.php';
?>

<?php
$id = Session::get('adminId');
$class = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $edit_profil = $class->edit_profile($_POST, $id);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Thay đổi thông tin</h2>
        <?php
        if (isset($edit_profil)) {
            echo $edit_profil;
        }
        ?>
        <?php
        $show_staff = $class->get_staff($id);
        if ($show_staff) {
            while ($result = $show_staff->fetch_assoc()) {
        ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Họ và tên:</label>
                        <input type="text" name="adminName" class="form-control" value="<?php echo $result['adminName'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="adminEmail" class="form-control" value="<?php echo $result['adminEmail'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại:</label>
                        <input type="text" name="adminPhone" class="form-control" value="<?php echo $result['adminPhone'] ?>" />
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
                    </div>
                </form>
        <?php
            }
        }
        ?>
    </div>
</div>
<?php include 'inc/footer.php'; ?>