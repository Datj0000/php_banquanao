<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if (isset($_GET['type_slider']) && isset($_GET['type'])) {
	$id = $_GET['type_slider'];
	$type = $_GET['type'];
	$update_type_slider = $slider->update_type_slider($id, $type);
}
if (isset($_GET['slider_del'])) {
	$id = $_GET['slider_del'];
	$del_slider = $slider->del_slider($id);
}

?>
<div class="panel">
	<div class="panel-heading">
		<h2>Danh sách Slider</h2>
		<?php
		if (isset($del_slider)) {
			echo $del_slider;
		}
		?>
		<a style="margin: 10px 0 30px 0; color: #676A6D;" href="slideradd.php" class="btn btn-default" role="button">
			<i style="font-size: 12px;" class="fa fa-plus" aria-hidden="true"></i>Thêm</a>
		<table class="table display nowrap" cellspacing="0" width="100%" id="table">
			<thead>
				<tr>
					<td>STT</td>
					<td>Tiều đề</td>
					<td>Hình ảnh</td>
					<td>Trạng thái</td>
					<td>Chức năng</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$get_slider = $slider->show_slider_list();
				if ($get_slider) {
					$i = 0;
					while ($result_slider = $get_slider->fetch_assoc()) {
						$i++;
				?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $result_slider['sliderName'] ?></td>
							<td><img src="uploads/<?php echo $result_slider['slider_image'] ?>" height="120px" width="500px" /></td>
							<td>
								<?php
								if ($result_slider['type'] == 1) {
								?>
									<a href="?type_slider=<?php echo $result_slider['sliderId'] ?>&type=0"><i class="fa fa-toggle-on green" aria-hidden="true"></i></i></a>
								<?php
								} else {
								?>
									<a href="?type_slider=<?php echo $result_slider['sliderId'] ?>&type=1"><i class="fa fa-toggle-off green" aria-hidden="true"></i></a>
								<?php
								}
								?>
							</td>
							<td>
								<a href="?slider_del=<?php echo $result_slider['sliderId'] ?>" onclick="return confirm('Bạn có muốn xoá không?');"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>
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