<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insertCp = $cp->insert_coupon($_POST);
}
?>
<?php  ?>
<div class="panel">
    <div class="panel-heading">
        <h2>Thêm mã giảm giá</h2>
        <div class="block copyblock">
            <?php
            if (isset($insertCp)) {
                echo $insertCp;
            }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label>Tên mã:</label>
                    <input type="text" name="name" class="form-control" placeholder="Tên mã" />
                </div>
                <div class="form-group">
                    <label>Mã giảm giá:</label>
                    <input type="text" name="coupon" class="form-control" placeholder="Mã giảm giá" />
                </div>
                <div class="form-group">
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" class="form-control" placeholder="Số lượng" />
                </div>
                <div class="form-group">
                    <label>Số tiền giảm:</label>
                    <input type="number" name="coupon_price" class="form-control" placeholder="Số tiền giảm" />
                </div>
                <div class="form-group">
                    <label>Ngày hết hạn:</label>
                    <input type="date" name="time_expired" class="form-control" placeholder="Ngày hết hạn" />
                </div>
                <div class="form-group">
                    <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>