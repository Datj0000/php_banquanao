<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/user.php'; ?>
<?php

if (!isset($_GET['customerid']) || $_GET['customerid'] == NULL) {
    echo "<script>window.location ='index.php'</script>";
} else {
    $id = $_GET['customerid'];
    $idorder = $_GET['orderid'];
}
?>
<style>
    div.dataTables_wrapper div.dataTables_info {
        visibility: hidden;
    }

    @media print {
        @page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    @page {
        size: A4;
        margin: 0;
    }

    .panel-heading {
        overflow: hidden;
    }
</style>
<div class="panel">
    <div class="panel-heading" id="printableArea">
        <div style="text-align:center;font-size: 24px;">
            HÓA ĐƠN THANH TOÁN
            <br />
        </div>
        <h3>Khách hàng</h3>
        <?php
        $get_customer = $cs->show_customers($id);
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
        $get_note = $us->show_order($idorder);
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
            <h3>Đơn hàng</h3>
            <table class="table display nowrap" cellspacing="0" width="100%" id="table2">
                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Sản phẩm</td>
                        <td>Hình ảnh</td>
                        <td>Số lượng</td>
                        <td>Size</td>
                        <td>Giá</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $show_order = $ct->get_detail_order($idorder);
                    if ($show_order) {
                        $i = 0;
                        $price = 0;
                        while ($result_oder = $show_order->fetch_assoc()) {
                            $i++;
                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $result_oder['productName'] ?></td>
                                <td><img style="width:100px" src="uploads/<?php echo $result_oder['image'] ?>" /></td>
                                <td><?php echo $result_oder['quantity'] ?></td>
                                <td><?php echo $result_oder['size'] ?></td>
                                <td><?php echo $fm->format_currency($result_oder['price']) . " " . "VNĐ" ?></td>
                            </tr>
                    <?php
                            $price += $result_oder['price'];
                        }
                    }
                    ?>
                </tbody>
            </table>
            <table>
                <tr>
                    <td>Tổng giá</td>
                    <td>: </td>
                    <td> <?php
                            echo $fm->format_currency($price) . " " . "VNĐ"
                            ?>
                    </td>
                </tr>
                <?php
                if (isset($coupon_price)) {
                ?>
                    <tr>
                        <td>Giảm giá</td>
                        <td>: </td>
                        <td>
                            <?php
                            echo $fm->format_currency($coupon_price) . " " . "VNĐ"
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td>Phí ship</td>
                    <td>: </td>
                    <td>
                        <?php
                        $ship = 20000;
                        echo $fm->format_currency($ship) . " " . "VNĐ"
                        ?></td>
                    </td>
                </tr>
                <tr>
                    <td>Thành tiền &nbsp</td>
                    <td>: &nbsp&nbsp&nbsp&nbsp</td>
                    <td>
                        <?php
                        $total = $price + $ship;
                        if (isset($coupon_price)) {
                            echo $fm->format_currency($total - $coupon_price) . " " . "VNĐ";
                        } else {
                            echo $fm->format_currency($total) . " " . "VNĐ";
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <button style="outline: none;margin: 20px 30px 50px 30px;" onclick="printDiv('printableArea')" type="button" class="btn btn-primary">
        <i class="fa fa-print" aria-hidden="true"></i>In</button>
</div>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<?php include 'inc/footer.php'; ?>