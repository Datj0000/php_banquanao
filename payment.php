<?php 
$title = 'Thanh toán';
include 'inc/header2.php';

?>
<style>
	th {
		text-align: center;
		padding: 5px;
		color: #fff;
		background: #ff523b;
		font-weight: normal;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}
</style>
<?php
$customer_id = Session::get('customer_id');
$login_check = Session::get('customer_login');
if ($login_check == false) {
	header('Location: dang-nhap.html');
}
require 'vendor/autoload.php';
if (isset($_SESSION['coupon'])) {
	$cart1 = $_SESSION['coupon'];
}
$content = "<table style='width: 100%;margin-top:20px'>";
$content .= "<style>
th {
	margin-top: 20px;
	text-align: center;
	padding: 5px;
	color: #fff;
	background: #ff523b;
	font-weight: normal;
}
td {
	padding: 10px 5px;
}
td img {
	width: 80px;
	height: 100px;
	margin-right: 10px;
}
</style>";
$content .= "<tbody style='text-align: center;'>";
$content .= "<tr><th>STT</th> <th>Sản phẩm</th> <th>Hình ảnh</th> <th>Số lượng</th> <th>Size</th> <th>Giá</th></tr>";
$get_product_cart = $ct->get_product_cart($customer_id);
if ($get_product_cart) {
	$subtotal = 0;
	$i = 0;
	while ($result = $get_product_cart->fetch_assoc()) {
		$i++;
		$subtotal = $result['price'] * $result['quantity'];
		$content .= "<tr><td>$i</td> <td>" . $result['productName'] . "</td> <td><img width='80' heigh='100' src='http://localhost/website_mvc/admin/uploads/" . $result['image'] . "'></td> 
				<td>" . $result['quantity'] . "</td> <td>" . $result['size'] . "</td> <td>" . $fm->format_currency($subtotal) . " " . "VNĐ" . "</td></tr>";
	}
	$ship = 20000;
	if (isset($cart1)) {
		$subtotal = $subtotal + $ship - $cart1['coupon_price'];
	} else {
		$subtotal = $subtotal + $ship;
	}
	$content .= "</tbody>";
	$content .= "</table>";
	$content .= "<div style='margin-top:10px; float:right'>Thành tiền: " . $fm->format_currency($subtotal) . " " . "VNĐ" . "</div>";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order'])) {
	$note = $_POST['note'];
	$mail_sent = $_POST['email'];
	$name = $_POST['name'];
	$subtotal = $_POST['subtotal'];
	if (isset($_SESSION['coupon'])) {
		$cart1 = $_SESSION['coupon'];
		$insertOrder = $ct->insertOrder($customer_id, $note, $cart1, $subtotal);
		unset($_SESSION['coupon']);
	} else {
		$insertOrder = $ct->insertOrder2($customer_id, $note, $subtotal);
	}
	$ordercode = Session::get('ordercode');
	try {
		header('Location: dat-hang-thanh-cong.html');
		include 'inc/email.php';
		$mail->addAddress($mail_sent, $name);
		$mail->Subject = "Cảm ơn quý khách $name đã đặt hàng tại Shop";
		$mail->Body    = "Shop rất vui thông báo đơn hàng $ordercode của quý khách đã được tiếp nhận và đang trong quá trình xử lý. 
		Shop sẽ thông báo đến quý khách ngay khi hàng chuẩn bị được giao. <br>
		$content";
		$mail->send();
	} catch (Exception $e) {
		echo "Lỗi: {$mail->ErrorInfo}";
	}
	$delCart = $ct->del_all_data_cart();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paymentonline'])) {
	$note = $_POST['note'];
	$mail_sent = $_POST['email'];
	$name = $_POST['name'];
	$subtotal = $_POST['subtotal'];
	if (isset($_SESSION['coupon'])) {
		$cart1 = $_SESSION['coupon'];
		$insertOrder = $ct->insertOrderOnline($customer_id, $note, $cart1, $subtotal);
		unset($_SESSION['coupon']);
	} else {
		$insertOrder = $ct->insertOrderOnline2($customer_id, $note, $subtotal);
	}
	$ordercode = Session::get('ordercode');
	try {
		include 'inc/email.php';
		$mail->addAddress($mail_sent, $name);
		$mail->Subject = "Cảm ơn quý khách $name đã đặt hàng tại Shop";
		$mail->Body    = "Shop rất vui thông báo đơn hàng $ordercode của quý khách đã được tiếp nhận và đang trong quá trình xử lý. 
		Shop sẽ thông báo đến quý khách ngay khi hàng chuẩn bị được giao. <br>
		$content";
		$mail->send();
	} catch (Exception $e) {
		echo "Lỗi: {$mail->ErrorInfo}";
	}
	$delCart = $ct->del_all_data_cart();
}
?>

</div>
<div class="small-container">
	<h2 class="title">Thanh toán</h2>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div class="row">
			<div class="col-3-5" style="margin-bottom: auto;">
				<?php
				$check_cart_login = $ct->check_cart_login($customer_id);
				if ($check_cart_login) {
				?>
					<table>
						<tr>
							<th>Sản phẩm</th>
							<th>Số lượng</th>
							<th>Size</th>
							<th>Giá</th>
						</tr>
						<?php
						$get_product_cart = $ct->get_product_cart($customer_id);
						if ($get_product_cart) {
							$subtotal = 0;
							$qty = 0;
							while ($result = $get_product_cart->fetch_assoc()) {
						?>
								<tr>
									<td>
										<div class="cart-info">
											<img src="admin/uploads/<?php echo $result['image'] ?>">
											<div>
												<p style="max-width: 225px;" class="productName"><?php echo $result['productName'] ?></p>
												<small class="productPrice"><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></small>
											</div>
										</div>
									</td>
									<td class="centertd">
										<?php echo $result['quantity'] ?>
									</td>
									<td class="centertd">
										<?php echo $result['size'] ?>
									</td>
									<td>
										<p class="centertd">
											<?php
											$total = $result['quantity'] * $result['price'];
											echo $fm->format_currency($total) . " " . "VNĐ";
											?>
										</p>
									</td>
								</tr>
						<?php
								$subtotal += $total;
								$qty = $qty + $result['quantity'];
							}
						}
						?>
					</table>
					<?php
					$ship = 20000;
					if (isset($cart1)) {
						$subtotal = $subtotal + $ship - $cart1['coupon_price'];
					} else {
						$subtotal = $subtotal + $ship;
					}
					?>
					<input type="hidden" name="subtotal" value="<?php echo $subtotal ?>">
				<?php
				}
				?>
			</div>
			<div class="col-3">
				<h3 style="padding: 5px;">Địa chỉ giao hàng</h3>
				<table style="font-size: 13px;">
					<?php
					$id = Session::get('customer_id');
					$get_customers = $cs->show_customers($id);
					if ($get_customers) {
						while ($result = $get_customers->fetch_assoc()) {
					?>
							<tr>
								<td>Họ và tên</td>
								<td><input name="name" type="text" class="form-input" value="<?php echo $result['name'] ?>"></td>
							</tr>
							<tr>
								<td>Số điện thoại</td>
								<td><input type="text" readonly="readonly" class="form-input" value="<?php echo $result['phone'] ?>"></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><input name="email" type="text" class="form-input" value="<?php echo $result['email'] ?>"></td>
							</tr>
							<tr>
								<td>Địa chỉ</td>
								<td><input type="text" readonly="readonly" class="form-input" value="<?php echo $result['address'] ?>"></td>
							</tr>
							<tr>
								<td>Yêu cầu</td>
								<td><input name="note" type="text" class="form-input" value=""></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<a href="editprofile.php">Sửa thông tin</a>
								</td>
							</tr>
					<?php
						}
					}
					?>
				</table>

			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<button type="submit" name="order">Ship COD</button>
			<button type="submit" name="paymentonline">Thanh toán</button>
		</div>
	</form>
</div>
<?php
include 'inc/footer.php';
?>