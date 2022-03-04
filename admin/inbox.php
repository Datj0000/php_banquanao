<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php
include '../vendor/autoload.php';
if (isset($_GET['shiftid'])) {
	$id = $_GET['shiftid'];
	$ordercode = $_GET['ordercode'];
	$mail_sent = $_GET['email'];
	try {
		include '../inc/email.php';
		$mail->addAddress($mail_sent, 'Quý khách');
		$content = "<table style='width: 100%;margin-top:20px'>";
		$content .= "<tbody style='text-align: center;'>";
		$content .= "<tr><th>STT</th> <th>Sản phẩm</th> <th>Hình ảnh</th> <th>Số lượng</th> <th>Size</th> <th>Giá</th></tr>";
		$get_product_cart = $ct->get_detail_order($id);
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
		$mail->Subject = "Cảm ơn quý khách đã đặt hàng tại Shop";
		$mail->Body    = "Shop đã gửi đơn hàng $ordercode cho đơn vị vận chyển quy khách vui lòng đợi 2-3 ngày để nhận hàng. <br>
		$content";
		$mail->send();
	} catch (Exception $e) {
		echo "Lỗi: {$mail->ErrorInfo}";
	}
	$shifted = $ct->shifted($id);
	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
}

if (isset($_GET['delid'])) {
	$id = $_GET['delid'];
	$del_shifted = $ct->del_shifted($id);
	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
}
?>

<div class="panel">
    <div class="panel-heading">
        <h2>Đặt hàng</h2>
        <form action="" method="post">
            <div class="block">
                <?php
				if (isset($shifted)) {
					echo $shifted;
				}
				if (isset($del_shifted)) {
					echo $del_shifted;
				}
				?>
                <table class="table display nowrap" cellspacing="0" width="100%" id="table">
                    <thead>
                        <td>STT</td>
                        <td>Mã Đơn</td>
                        <td>Thời gian đặt</td>
                        <td>Chi tiết đơn</td>
                        <td>Trạng thái</td>
                        <td>Chức năng</td>
                    </thead>
                    <tbody>
                        <?php
						$get_inbox_cart = $ct->get_inbox_cart();
						if ($get_inbox_cart) {
							$i = 0;
							while ($result = $get_inbox_cart->fetch_assoc()) {
								$i++;
								Session::set("qtypro", $i);
						?>
                        <tr>
                            <td data-label="STT"><?php echo $i; ?></td>
                            <td data-label="Mã Đơn"><?php echo $result['ordercode'] ?></td>
                            <input name="ordercode" type="hidden" value="<?php echo $result['ordercode'] ?>">
                            <td data-label="Thời gian đặt"><?php echo $fm->formatDate($result['date_order']) ?></td>
                            <td data-label="Chi tiết đơn"><a style="color: #333;"
                                    href="customer.php?customerid=<?php echo $result['customer_id'] ?>&orderid=<?php echo $result['id'] ?>"><i
                                        class="fa fa-eye" aria-hidden="true"></i></a></td>
                            <?php
									$idc = $result['customer_id'];
									$get_customer = $cs->show_customers($idc);
									if ($get_customer) {
										while ($result_m = $get_customer->fetch_assoc()) {
									?>
                            <input name="email" type="hidden" value="<?php echo $result_m['email'] ?>" />

                            <?php
											$mail_sent = $result_m['email'];
										}
									}
									?>
                            <td data-label="Trạng thái">
                                <?php
										if ($result['type'] == 1) {
										?>
                                <p>Đã thanh toán</p>
                                <?php
										} elseif ($result['type'] == 0) {
										?>
                                <p>Chưa thanh toán</p>
                                <?php
										}
										?>
                            </td>
                            <td data-label="">
                                <?php
										if ($result['status'] == 0) {
										?>
                                <a class="btn btn-success" role="button" aria-pressed="true"
                                    href="?shiftid=<?php echo $result['id'] ?>&email=<?php echo $mail_sent ?>&ordercode=<?php echo $result['ordercode'] ?>">
                                    Giao hàng</a>
                                <?php
										} elseif ($result['status'] == 1) {
										?>
                                <input class="btn btn-warning" type="button" value="Đang giao">
                                <?php
										} elseif ($result['status'] == 2) {
										?>
                                <a style="width: 105px;" class="btn btn-danger" role="button" aria-pressed="true"
                                    href="?delid=<?php echo $result['id'] ?>">
                                    Xoá đơn</a>
                                <?php
										} elseif ($result['status'] == 3) {
										?>
                                <a style="width: 105px;" class="btn btn-success" role="button" aria-pressed="true"
                                    href="?shiftid=<?php echo $result['id'] ?>&email=<?php echo $mail_sent ?>&ordercode=<?php echo $result['ordercode'] ?>">
                                    Đổi hàng</a>
                                <?php
										}
										?>
                            </td>
                        </tr>
                        <?php
							}
						}
						?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<?php include 'inc/footer.php'; ?>