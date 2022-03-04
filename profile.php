<?php 
$title = 'Hồ sơ';
include 'inc/header2.php';
$login_check = Session::get('customer_login');
if ($login_check == false) {
	header('Location:dang-nhap.html');
}
?>

</div>
</div>
<?php
include 'inc/sidebar.php';
?>

<h2 class="title2">Thông tin cá nhân</h2>
<div class="row">
	<form onsubmit="return false">
		<table>
			<?php
			$id = Session::get('customer_id');
			$get_customers = $cs->show_customers($id);
			if ($get_customers) {
				while ($result = $get_customers->fetch_assoc()) {
			?>
					<tr>
						<td>Họ và tên</td>
						<td><input type="text" readonly="readonly" class="form-input" value="<?php echo $result['name'] ?>"></td>
					</tr>
					<tr>
						<td>Điện thoại</td>
						<td><input type="number" readonly="readonly" class="form-input" value="<?php echo $result['phone'] ?>"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" readonly="readonly" class="form-input" value="<?php echo $result['email'] ?>"></td>
					</tr>
					<tr>
						<td>Địa chỉ</td>
						<td><input type="text" readonly="readonly" class="form-input" value="<?php echo $result['address'] ?>"></td>
					</tr>
			<?php
				}
			}
			?>
		</table>
		<div class="row">
			<a href="sua-thong-tin.html"><button type="button" style="margin-right: 5px;">Sửa thông tin</button></a>
			<a href="doi-mat-khau.html"><button type="button" style="margin-left: 5px;">Đổi mật khẩu</button></a>
		</div>
	</form>
</div>
</div>
</div>
</div>
</div>



<?php
include 'inc/footer.php';

?>