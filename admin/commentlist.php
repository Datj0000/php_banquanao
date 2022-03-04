<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php
if (isset($_GET['binhluanid'])) {
	$id = $_GET['binhluanid'];
	$delcomment = $cs->del_comment($id);
}
if (isset($_GET['activeid'])) {
	$id = $_GET['activeid'];
	$active = $_GET['active'];
	$delcomment = $cs->active_comment($id, $active);
}
?>
<div class="panel">
	<div class="panel-heading">
		<h2>Bình luận</h2>
		<div class="block">
			<?php
			if (isset($delcomment)) {
				echo $delcomment;
			}
			?>
			<table class="table display nowrap" cellspacing="0" width="100%" id="table">
				<thead>
					<tr>
						<td>STT</td>
						<td>Sản phẩm</td>
						<td>Người bình luận</td>
						<td>Bình luận</td>
						<td>Phê duyệt</td>
						<td>Chức năng</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$cmlist = $cs->show_comment_admin();
					if ($cmlist) {
						$i = 0;
						while ($result = $cmlist->fetch_assoc()) {
							$i++;
					?>
							<tr class="odd gradeX">
								<td><?php echo $i ?></td>
								<td><?php echo $result['productName'] ?></td>
								<td><?php echo $result['tenbinhluan'] ?></td>
								<td><?php echo $result['binhluan'] ?></td>
								<td>
									<?php
									if ($result['active'] == 1) {
									?>
										<a href="?activeid=<?php echo $result['id'] ?>&active=0"><i class="fa fa-toggle-on green" aria-hidden="true"></i></a>
									<?php
									} else {
									?>
										<a href="?activeid=<?php echo $result['id'] ?>&active=1"><i class="fa fa-toggle-off green" aria-hidden="true"></i></a>
									<?php
									}
									?>
								</td>
								<td><a onclick="return confirm('Bạn chắc chắn muốn xoá?')" href="?binhluanid=<?php echo $result['id'] ?>"><i class="fa fa-trash-o red" aria-hidden="true"></i></a></td>
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