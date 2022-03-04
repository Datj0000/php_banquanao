<?php 
$title = 'Đổi mật khẩu';
include 'inc/header2.php';
$login_check = Session::get('customer_login');
if ($login_check == false) {
    header('Location: dang-nhap.html');
}
$id = Session::get('customer_id');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $UpdateCustomers = $cs->update_pass($_POST, $id);
}
?>
</div>
<?php
include 'inc/sidebar.php';
?>
    <h2 class="title2">Đổi mật khẩu</h2>
    <div class="row">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <?php
                    if (isset($UpdatePass)) {
                        echo '<td colspan="3">' . $UpdatePass . '</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>Mật khẩu cũ</td>
                    <td><input name="oldpass" type="text" class="form-input" value=""></td>
                </tr>
                <tr>
                    <td>Mật khẩu mới</td>
                    <td><input name="newpass" type="text" class="form-input" value=""></td>
                </tr>
                <tr>
                    <td>Nhập lại mật khẩu</td>
                    <td><input name="repass" type="text" class="form-input" value=""></td>
                </tr>
                <tr>
                    <td colspan="2"><button name="save" type="submit">Lưu</button></td>
                </tr>   
            </table>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>
<?php
include 'inc/footer.php';
?>