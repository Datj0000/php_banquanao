<?php 
$title = 'Sửa thông tin';
include 'inc/header2.php';
?>
<?php

$login_check = Session::get('customer_login');
if ($login_check == false) {
	header('Location: dang-nhap.html');
}

?>
<?php
$id = Session::get('customer_id');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
	$UpdateCustomers = $cs->update_customers($_POST, $id, $_FILES);
}

?>
</div>
<?php
include 'inc/sidebar.php';
?>
<h2 class="title2">Sửa thông tin cá nhân</h2>
<div class="row">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<?php
				if (isset($UpdateCustomers)) {
					echo '<td colspan="3">' . $UpdateCustomers . '</td>';
				}
				?>
			</tr>
			<?php $get_customers = $cs->show_customers($id);
			if ($get_customers) {
				while ($result = $get_customers->fetch_assoc()) {
			?>
					<tr>
						<td>Họ và tên</td>
						<td><input name="name" type="text" class="form-input" value="<?php echo $result['name'] ?>"></td>
					</tr>
					<tr>
						<td>Số điện thoại</td>
						<td><input name="phone" type="text" class="form-input" value="<?php echo $result['phone'] ?>"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input name="email" type="email" class="form-input" value="<?php echo $result['email'] ?>"></td>
					</tr>
					<tr>
						<td>Địa chỉ</td>
						<td><input name="address" type="text" class="form-input" value="<?php echo $result['address'] ?>"></td>
					</tr>
					<tr>
						<td>Ảnh đại diện</td>
						<td><input style="border: none;" type="file" name="image" /></td>
					</tr>
					<tr>
						<td colspan="2"><button name="save" type="submit">Lưu</button></td>
					</tr>
			<?php
				}
			}
			?>
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