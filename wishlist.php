<?php 
$title = 'Yêu thích';
include 'inc/header2.php';
$login_check = Session::get('customer_login');
if ($login_check == false) {
	header('Location: dang-nhap.html');
}
if (isset($_GET['proid'])) {
	$customer_id = Session::get('customer_id');
	$proid = $_GET['proid'];
	$delwlist = $product->del_wlist($proid, $customer_id);
}
?>
</div>
<?php
include 'inc/sidebar.php';
?>
<h2 class="title2">Yêu thích</h2>
<table class="table">
	<thead>
		<th>STT</th>
		<th>Sản phẩm</th>
		<th>Hình ảnh</th>
		<th>Giá</th>
		<th></th>
	</thead>
	<?php
	$get_wishlist = $product->get_wishlist($idcus);
	if ($get_wishlist) {
		$i = 0;
		while ($result = $get_wishlist->fetch_assoc()) {
			$i++;
	?>
			<tr>
				<td data-label="STT"><?php echo $i; ?></td>
				<td data-label="Sản phẩm"><?php echo $result['productName'] ?></td>
				<td data-label="Hình ảnh"><img src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></td>
				<td data-label="Giá"><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></td>
				<td data-label="">
					<p>
						<a href="yeu-thich.html?proid=<?php echo $result['productId'] ?>">Xoá</a> ||
						<a href="<?php echo 'san-pham/' . $result['productId'] .'-'. $result['catId'] .'-'. $fm->makeUrl($result['productName']) . '.html' ?>">Mua</a>
					</p>
				</td>
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