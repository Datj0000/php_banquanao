<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/user.php';
?>

<?php
if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    echo "<script>window.location ='couponlist.php'</script>";
} else {
    $idstaff = $_GET['id'];
}
if ($adminRole != 0) {
    header('Location: index.php');
}
$class = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_admin = $class->update_admin($_POST, $idstaff);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Sửa thông tin nhân viên</h2>
        <?php
        if (isset($update_admin)) {
            echo $update_admin;
        }
        ?>
        <?php
        $get_staff = $class->get_staff($idstaff);
        if ($get_staff) {
            while ($result = $get_staff->fetch_assoc()) {
        ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Tên nhân viên:</label>
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
                        <label>Phân quyền: </label>
                        <select class="form-control" id="select" name="level">
                            <option value="">Phân quyền</option>
                            <?php
                            if ($result_product['level'] == 0) {
                            ?>
                                <option selected value="0">Quản lý</option>
                                <option value="1">Nhân viên</option>
                            <?php
                            } else {
                            ?>
                                <option value="0">Quản lý</option>
                                <option selected value="1">Nhân viên</option>
                            <?php
                            }
                            ?>
                        </select>
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