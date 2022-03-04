<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if (isset($_GET['delid'])) {
	$id = $_GET['delid'];
	$delcat = $cat->del_category($id);
}
?>
<div class="panel">
	<div class="panel-heading">
		<h2>Danh mục sản phẩm</h2>
		<div>
			<?php
			if (isset($delcat)) {
				echo $delcat;
			}
			if (isset($updateCat)) {
				echo $updateCat;
			}
			?>
		</div>
		<a style="margin: 10px 0 30px 0; color: #676A6D;" href="catadd.php" class="btn btn-default" role="button">
			<i style="font-size: 12px;" class="fa fa-plus" aria-hidden="true"></i>Thêm</a>
		<table class="table display nowrap" cellspacing="0" width="100%" id="table">
			<thead>
				<tr>
					<td>STT</td>
					<td>Tên danh mục</td>
					<td>Chức năng</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$show_cate = $cat->show_category();
				if ($show_cate) {
					$i = 0;
					while ($result = $show_cate->fetch_assoc()) {
						$i++;
				?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result['catName'] ?></td>
							<td><a href="catedit.php?catid=<?php echo $result['catId'] ?>"><i class="fa fa-pencil-square-o green" aria-hidden="true"></i></a>
								<a onclick="return confirm('Bạn có muốn xoá không?')" href="?delid=<?php echo $result['catId'] ?>"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>
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