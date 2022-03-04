<?php
$title = 'Chi tiết đơn';
include 'inc/header2.php'; ?>
<?php

if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    echo "<script>window.location ='order.php'</script>";
} else {
    $idcus = Session::get('customer_id');
    $id = $_GET['id'];
}
?>
</div>
<?php
include 'inc/sidebar.php';
?>
<h2 class="title2">Chi tiết đơn hàng</h2>
<h3 style="margin-bottom: 15px;">Thông tin</h3>
<?php
$get_customer = $cs->show_customers($idcus);
if ($get_customer) {
    while ($result = $get_customer->fetch_assoc()) {
?>
        <p>Họ và tên: <?php echo $result['name'] ?></p>
        <p>Điện thoại: <?php echo $result['phone'] ?></p>
        <p>Email: <?php echo $result['email'] ?></p>
        <p>Địa chỉ: <?php echo $result['address'] ?></p>
<?php
    }
}
?>
<?php
$us = new user();
$get_note = $us->show_order($id);
if ($get_note) {
    while ($result_note = $get_note->fetch_assoc()) {
?>
        <p>Mã đơn hàng: <?php echo $result_note['ordercode'] ?></p>
        <?php
        if (!empty($result_note['coupon'])) {
            $coupon = $result_note['coupon'];
            $get_cp = $cp->check_coupon_2($coupon);
            if ($get_cp) {
                while ($resultcp = $get_cp->fetch_assoc()) {
                    $coupon_price = $resultcp['coupon_price'];
                }
            }
        }
        if (!empty($result_note['note'])) {
        ?>
            <p>Yêu cầu: <?php echo $result_note['note'] ?></p>
        <?php
        }
        ?>
<?php
    }
}
?>
<div>
    <h3 style="margin: 10px 0 15px;">Đơn hàng</h3>
    <table class="table">
        <thead>
            <th>STT</th>
            <th>Sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Số lượng</th>
            <th>Size</th>
            <th>Giá</th>
        </thead>
        <tbody>
            <?php
            $show_order = $ct->get_detail_order($id);
            if ($show_order) {
                $i = 0;
                $price = 0;
                while ($result_oder = $show_order->fetch_assoc()) {
                    $i++;
            ?>
                    <tr>
                        <td data-label="STT"><?php echo $i; ?></td>
                        <td data-label="Sản phẩm"><?php echo $result_oder['productName'] ?></td>
                        <td data-label="Hình ảnh"><img src="admin/uploads/<?php echo $result_oder['image'] ?>" height="120px" width="500px" /></td>
                        <td data-label="Số lượng"><?php echo $result_oder['quantity'] ?></td>
                        <td data-label="Size"><?php echo $result_oder['size'] ?></td>
                        <td data-label="Giá"><?php echo $fm->format_currency($result_oder['price']) . " " . "VNĐ" ?></td>
                    </tr>
            <?php
                    $price += $result_oder['price'];
                }
            }
            ?>
        </tbody>
    </table>
</div>
<div style="font-size: 14px;">
    <p>Tổng giá: <?php echo $fm->format_currency($price) . " " . "VNĐ" ?> </p>
    <?php
    if (isset($coupon_price)) {
    ?>
        <p>Giảm giá: <?php echo $fm->format_currency($coupon_price) . " " . "VNĐ" ?> </p>
    <?php
    }
    ?>
    <p>Phí ship:
        <?php
        $ship = 20000;
        echo $fm->format_currency($ship) . " " . "VNĐ"
        ?></p>
    <p>Thành tiền:
        <?php
        $total = $price + $ship;
        if (isset($coupon_price)) {
            echo $fm->format_currency($total - $coupon_price) . " " . "VNĐ";
        } else {
            echo $fm->format_currency($total) . " " . "VNĐ";
        }
        ?>
    </p>
</div>
</div>
</div>
</div>
</div>
<?php include 'inc/footer.php'; ?>