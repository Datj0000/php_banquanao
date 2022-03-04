<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if (isset($_GET['productid'])) {
	$id = $_GET['productid'];
	$delpro = $product->del_product($id);
}
if (isset($_GET['type_product']) && isset($_GET['type'])) {
	$id = $_GET['type_product'];
	$type = $_GET['type'];
	$update_type_product = $product->update_type_product($id, $type);
}
if (isset($_GET['active_product']) && isset($_GET['active'])) {
	$id = $_GET['active_product'];
	$active = $_GET['active'];
	$update_active_product = $product->update_active_product($id, $active);
}
?>
<div class="panel">
	<div class="panel-heading">
		<h2>Danh sách sản phẩm</h2>
		<?php
		if (isset($delpro)) {
			echo $delpro;
		}
		if (isset($updateProduct)) {
			echo $updateProduct;
		}
		?>
		<div class="panel-body no-padding">
			<a style="margin: 10px 0 30px 0; color: #676A6D;" href="productadd.php" class="btn btn-detault" role="button">
				<i style="font-size: 12px;" class="fa fa-plus" aria-hidden="true"></i>Thêm</a>
			<table class="table display nowrap" cellspacing="0" width="100%" id="table">
				<thead>
					<tr>
						<td>STT</td>
						<td>Sản phẩm</td>
						<td>Giá</td>
						<td>Tồn kho</td>
						<td>Đã bán</td>
						<td>Ảnh</td>
						<td>Danh mục</td>
						<td>Nổi bật</td>
						<td>Trạng thái</td>
						<td>Chức năng</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$pdlist = $product->show_product();
					if ($pdlist) {
						$i = 0;
						while ($result = $pdlist->fetch_assoc()) {
							$i++;
					?>
							<tr class="odd gradeX">
								<td><?php echo $i ?></td>
								<td><?php echo $result['productName'] ?></td>
								<td><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></td>
								<td><?php echo $result['productQuantity'] ?></td>
								<td><?php echo $result['product_soldout'] ?></td>
								<td><img style="width: 60px; height: 70px;" src="uploads/<?php echo $result['image'] ?>"></td>
								<td><?php echo $result['catName'] ?></td>
								<td>
									<?php
									if ($result['type'] == 1) {
									?>
										<a href="?type_product=<?php echo $result['productId'] ?>&type=0"><i class="fa fa-arrow-up green" aria-hidden="true"></i></a>
									<?php
									} else {
									?>
										<a href="?type_product=<?php echo $result['productId'] ?>&type=1"><i class="fa fa-arrow-down red" aria-hidden="true"></i></a>
									<?php
									}
									?>
								</td>
								<td>
									<?php
									if ($result['active'] == 1) {
									?>
										<a href="?active_product=<?php echo $result['productId'] ?>&active=0"><i class="fa fa-toggle-off green" aria-hidden="true"></i></a>
									<?php
									} else {
									?>
										<a href="?active_product=<?php echo $result['productId'] ?>&active=1"><i class="fa fa-toggle-on green" aria-hidden="true"></i></a>
									<?php
									}
									?>
								</td>
								<td>
									<a href="productedit.php?productid=<?php echo $result['productId'] ?>"><i class="fa fa-pencil-square-o green" aria-hidden="true"></i></a>
									<a href="?productid=<?php echo $result['productId'] ?>" onclick="return confirm('Bạn có muốn xoá không?');"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>
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
</div>

<?php include 'inc/footer.php'; ?>