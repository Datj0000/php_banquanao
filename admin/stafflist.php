<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/user.php';
?>

<?php
$class = new user();
if (isset($_GET['delid'])) {
    $id = $_GET['delid'];
    $delstaff = $class->del_staff($id);
}
if ($adminRole != 0) {
    header('Location: index.php');
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Danh sách nhân viên</h2>
        <?php
        if (isset($delstaff)) {
            echo $delstaff;
        }
        ?>
		<table class="table display nowrap" cellspacing="0" width="100%" id="table">
            <thead>
                <tr>
                    <td>STT</td>
                    <td>Tên nhân viên</td>
                    <td>Email</td>
                    <td>Số điện thoại</td>
                    <td>Tài khoản</td>
                    <td>Quyền</td>
                    <td>Chức năng</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $show_staff = $class->show_staff();
                if ($show_staff) {
                    $i = 0;
                    while ($result = $show_staff->fetch_assoc()) {
                        $i++;
                ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $result['adminName'] ?></td>
                            <td><?php echo $result['adminEmail'] ?></td>
                            <td><?php echo $result['adminPhone'] ?></td>
                            <td><?php echo $result['adminUser'] ?></td>
                            <td>
                                <?php
                                if ($result['level'] == 1) {
                                    echo 'Nhân viên';
                                } else {
                                    echo 'Quản lý';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="staffedit.php?id=<?php echo $result['adminId'] ?>"><i class="fa fa-pencil-square-o green" aria-hidden="true"></i></a>
                                <a onclick="return confirm('Bạn chắc chắn muốn xoá?')" href="?delid=<?php echo $result['adminId'] ?>"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'inc/footer.php'; ?>