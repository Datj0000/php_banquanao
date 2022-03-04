<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php

if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    echo "<script>window.location ='couponlist.php'</script>";
} else {
    $id = $_GET['id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updatecp = $cp->update_coupon($_POST, $id);
}

?>

<div class="panel">
    <div class="panel-heading">
        <h2>Sửa mã giảm giá</h2>
        <div class="block copyblock">
            <?php
            if (isset($updatecp)) {
                echo $updatecp;
            }
            ?>
            <?php
            $get_coupon = $cp->get_coupon($id);
            if ($get_coupon) {
                while ($result = $get_coupon->fetch_assoc()) {
            ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Tên mã:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $result['name'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Mã giảm giá:</label>
                            <input type="text" name="coupon" class="form-control" value="<?php echo $result['coupon'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Số lượng:</label>
                            <input type="number" name="quantity" class="form-control" value="<?php echo $result['quantity'] ?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="coupon_price">Số tiền giảm:</label>
                            <input type="number" name="coupon_price" class="form-control" value="<?php echo $result['coupon_price'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Ngày hết hạn:</label>
                            <input type="date" name="time_expired" class="form-control" value="<?php echo $result['time_expired'] ?>" />
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
                        </div>
                    </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>