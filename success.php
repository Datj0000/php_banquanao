<?php 
$title = 'Đặt hàng thành công';
include 'inc/header2.php';
$login_check = Session::get('customer_login');
if ($login_check == false) {
	header('Location: dang-nhap.html');
}
?>

<style type="text/css">
	h2.success_order {
		text-align: center;
		color: red;
	}

	p.success_note {
		text-align: center;
		padding: 8px;
		font-size: 17px;
	}
</style>
</div>
<div class="small-container" style="height: 100vh;">
	<h2 class="title">Đặt hàng thành công</h2>
	<div style="display:block; margin: 0 auto; text-align: center; align-items:center">
		<img style="width:10%" src="images/checkv.png">
	</div>
	<p class="success_note">Chúng tôi sẽ liên hệ bạn sớm ,xem chi tiết đơn hàng của bạn <a style="font-weight: bold;" href="don-hang.html">tại đây</a></p>
</div>
<?php
include 'inc/footer.php';
?>