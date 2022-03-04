<?php 
$title = 'Đơn hàng';
include 'inc/header2.php';
?>

<?php
$login_check = Session::get('customer_login');
if ($login_check == false) {
	header('Location: dang-nhap.html');
}
?>
<?php
if (isset($_GET['confirmid'])) {
	$id = $_GET['confirmid'];
	$shifted_confirm = $ct->shifted_confirm($id);
}
if (isset($_GET['exchangeid'])) {
	$id = $_GET['exchangeid'];
	$shifted_confirm = $ct->exchange($id);
}
if (isset($_GET['delid'])) {
	$id = $_GET['delid'];
	$del_shifted = $ct->del_shifted($id);
}
?>
</div>
<?php
include 'inc/sidebar.php';
?>
<h2 class="title2">Đơn hàng đã đặt</h2>
<table class="table">
	<thead>
		<th>STT</th>
		<th>Mã đơn</th>
		<th>Ngày đặt</th>
		<th>Chi tiêt đơn</th>
		<th>Trạng thái</th>
		<th style="min-width: 25%;"></th>
	</thead>
	<?php
	$customer_id = Session::get('customer_id');
	$get_cart_ordered = $ct->get_cart_ordered($customer_id);
	if ($get_cart_ordered) {
		$i = 0;
		while ($result = $get_cart_ordered->fetch_assoc()) {
			$i++;
	?>
			<tr>
				<td data-label="STT"><?php echo $i; ?></td>
				<td data-label="Mã đơn"><?php echo $result['ordercode'] ?></td>
				<td data-label="Ngày đặt"><?php echo $result['date_order'] ?></td>
				<td data-label="Chi tiêt đơn">
					<a style="color: #333;" href="<?php echo 'chi-tiet-don-hang-'. $result['id'] .'.html' ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
				</td>
				<td data-label="Trạng thái">
					<?php
					if ($result['status'] == '0') {
						echo '<p>Đang xử lý</p>';
					} elseif ($result['status'] == 1) {
						echo '<p>Đang giao</p>';
					} elseif ($result['status'] == 2) {
						echo '<p>Đã nhận</p>';
					} elseif ($result['status'] == 3) {
						echo '<p>Đang xử lý</p>';
					}
					?>
				</td>
				<?php
				if ($result['status'] == '0') {
				?>
					<td data-label="">
						<a onclick="return confirm('Bạn chắc chắn muốn huỷ đơn không?')" href="don-hang.html?delid=<?php echo $result['id'] ?>">Huỷ đơn</a>
					</td>
				<?php
				} elseif ($result['status'] == '1') {
				?>
					<td data-label="">
						<a href="don-hang.html?confirmid=<?php echo $result['id'] ?>">Đã nhận</a><span> || </span>
						<a href="don-hang.html?exchangeid=<?php echo $result['id'] ?>">Đổi trả</a>
					</td>
				<?php
				} elseif ($result['status'] == '3') {
				?>
					<td data-label=""><?php echo '<p>N/A</p>'; ?></td>
				<?php
				} else {
				?>
					<td data-label=""><?php echo '<p>N/A</p>'; ?></td>
				<?php
				}
				?>
			</tr>
	<?php
		}
	}
	?>
</table>
</div>
</div>
</div>
</div>
<?php
include 'inc/footer.php';
?>