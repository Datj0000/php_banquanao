<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if (isset($_GET['type_brand']) && isset($_GET['type'])) {
	$id = $_GET['type_brand'];
	$type = $_GET['type'];
	$update_type_brand = $slider->update_type_brand($id, $type);
}
if (isset($_GET['brand_del'])) {
	$id = $_GET['brand_del'];
	$del_brand = $slider->del_brand($id);
}

?>
<div class="panel">
	<div class="panel-heading">
		<h2>Danh sách nhà tài trợ</h2>
		<?php
		if (isset($del_brand)) {
			echo $del_brand;
		}
		?>
		<a style="margin: 10px 0 30px 0; color: #676A6D;" href="brandadd.php" class="btn btn-default" role="button">
			<i style="font-size: 12px;" class="fa fa-plus" aria-hidden="true"></i>Thêm</a>
		<table class="table display nowrap" cellspacing="0" width="100%" id="table">
			<thead>
				<tr>
					<td>STT</td>
					<td>Tên nhà tài trợ</td>
					<td>Logo</td>
					<td>Trạng thái</td>
					<td>Chức năng</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$get_brand = $slider->show_brand_list();
				if ($get_brand) {
					$i = 0;
					while ($result_brand = $get_brand->fetch_assoc()) {
						$i++;
				?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $result_brand['title'] ?></td>
							<td><img src="uploads/<?php echo $result_brand['image'] ?>" width="90px" /></td>
							<td>
								<?php
								if ($result_brand['type'] == 1) {
								?>
									<a href="?type_brand=<?php echo $result_brand['id'] ?>&type=0"><i class="fa fa-toggle-on green" aria-hidden="true"></i></i></a>
								<?php
								} else {
								?>
									<a href="?type_brand=<?php echo $result_brand['id'] ?>&type=1"><i class="fa fa-toggle-off green" aria-hidden="true"></i></a>
								<?php
								}
								?>
							</td>
							<td>
								<a href="?brand_del=<?php echo $result_brand['id'] ?>" onclick="return confirm('Bạn có muốn xoá không?');"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>
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