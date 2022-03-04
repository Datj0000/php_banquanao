<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php
if (isset($_GET['delid'])) {
	$id = $_GET['delid'];
	$delcoupon = $cp->del_coupon($id);
}
if (isset($_GET['active'])) {
	$id = $_GET['id'];
	$active = $_GET['active'];
	$update_active = $cp->update_active($id, $active);
}
?>
<div class="panel">
	<div class="panel-heading">
		<h2>Danh sách mã giảm giá</h2>
		<?php
		if (isset($delcoupon)) {
			echo $delcoupon;
		}
		if (isset($updateCat)) {
			echo $updateCat;
		}
		?>
		<a style="margin: 10px 0 30px 0; color: #676A6D;" href="couponadd.php" class="btn btn-default" role="button">
			<i style="font-size: 12px;" class="fa fa-plus" aria-hidden="true"></i>Thêm</a>
		<table class="table display nowrap" cellspacing="0" width="100%" id="table">
			<thead>
				<tr>
					<td>STT</td>
					<td>Tên mã</td>
					<td>Mã giảm giá</td>
					<td>Số lượng</td>
					<td>Tiền giảm</td>
					<td>Thời gian hết hạn</td>
					<td>Trạng thái</td>
					<td>Chức năng</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$show_coupone = $cp->show_coupon();
				if ($show_coupone) {
					$i = 0;
					while ($result = $show_coupone->fetch_assoc()) {
						$i++;

				?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result['name'] ?></td>
							<td><?php echo $result['coupon'] ?></td>
							<td><?php echo $result['quantity'] ?></td>
							<td><?php echo $fm->format_currency($result['coupon_price']) . " " . "VNĐ" ?></td>
							<td><?php echo $result['time_expired'] ?></td>
							<td>
								<?php
								if ($result['active'] == 1) {
								?>
									<a href="?id=<?php echo $result['id'] ?>&active=0"><i class="fa fa-toggle-off green" aria-hidden="true"></i></a>
								<?php
								} else {
								?>
									<a href="?id=<?php echo $result['id'] ?>&active=1"><i class="fa fa-toggle-on green" aria-hidden="true"></i></a>
								<?php
								}
								?>
							</td>
							<td>
								<a href="couponedit.php?id=<?php echo $result['id'] ?>"><i class="fa fa-pencil-square-o green" aria-hidden="true"></i></a>
								<a onclick="return confirm('Bạn chắc chắn muốn xoá?')" href="?delid=<?php echo $result['id'] ?>"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>
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