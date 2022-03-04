<?php
include '../inc/header3.php';
?>
<?php
require_once("./config.php");
if(isset($_GET['vnp_SecureHash'])){
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
}
else{
    header('Location: ../trang-chu.html');
}
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
unset($inputData['vnp_SecureHashType']);
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . '&' . $key . "=" . $value;
    } else {
        $hashData = $hashData . $key . "=" . $value;
        $i = 1;
    }
}

//$secureHash = md5($vnp_HashSecret . $hashData);
$secureHash = hash('sha256', $vnp_HashSecret . $hashData);
?>
<!--Begin display -->
</div>
<style>
    .form-group {
        margin: 10px 0;
    }
</style>
<div class="small-container" style="height: 100vh;">
    <h2 class="title">Thông tin đơn hàng</h2>
    <div style="text-align: left; width: 40%" class="small-container">
        <div class="form-group">
            <label>Mã đơn hàng:</label>
            <label>
                <?php
                $order_id = $_GET['vnp_TxnRef'];
                $sql = "SELECT * FROM tbl_order WHERE id = '$order_id'";
                $get_ordercode = mysqli_query($conn,  $sql);
                while ($result = mysqli_fetch_array($get_ordercode)) {
                    $ordercode = $result['ordercode'];
                }
                echo $ordercode
                ?></label>
        </div>
        <div class="form-group">
            <label>Số tiền:</label>
            <label><?= number_format($_GET['vnp_Amount'] / 100) ?> VNĐ</label>
        </div>
        <div class="form-group">
            <label>Nội dung thanh toán:</label>
            <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
        </div>
        <div class="form-group">
            <label>Mã phản hồi (vnp_ResponseCode):</label>
            <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
        </div>
        <div class="form-group">
            <label>Mã GD Tại VNPAY:</label>
            <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
        </div>
        <div class="form-group">
            <label>Mã Ngân hàng:</label>
            <label><?php echo $_GET['vnp_BankCode'] ?></label>
        </div>
        <div class="form-group">
            <label>Thời gian thanh toán:</label>
            <label><?php echo $_GET['vnp_PayDate'] ?></label>
        </div>
        <div class="form-group">
            <label>Kết quả:</label>
            <label>
                <?php
                if ($secureHash == $vnp_SecureHash) {
                    if ($_GET['vnp_ResponseCode'] == '00') {
                        $order_id = $_GET['vnp_TxnRef'];
                        $money = $_GET['vnp_Amount'] / 100;
                        $note = $_GET['vnp_OrderInfo'];
                        $vnp_response_code = $_GET['vnp_ResponseCode'];
                        $code_vnpay = $_GET['vnp_TransactionNo'];
                        $code_bank = $_GET['vnp_BankCode'];
                        $time = $_GET['vnp_PayDate'];
                        $date_time = substr($time, 0, 4) . '-' . substr($time, 4, 2) . '-' . substr($time, 6, 2) . ' ' . substr($time, 8, 2) . ' ' . substr($time, 10, 2) . ' ' . substr($time, 12, 2);
                        require_once('../lib/database.php');
                        $conn = mysqli_connect("localhost", "root", "", "website_mvc");
                        $sql = "SELECT * FROM tbl_order WHERE id = '$order_id'";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_num_rows($query);

                        if ($row > 0) {
                            $sql = "UPDATE tbl_order SET type ='1', id = '$order_id', vnp_response_code = '$vnp_response_code', code_vnpay = '$code_vnpay', code_bank = '$code_bank' WHERE id = '$order_id'";
                            mysqli_query($conn, $sql);
                        } else {
                            $sql = "INSERT INTO tbl_order (id, vnp_response_code, code_vnpay, code_bank, type) VALUES ('$order_id','$vnp_response_code', '$code_vnpay', '$code_bank'. '1')";
                            mysqli_query($conn, $sql);
                        }

                        echo "GD Thanh cong";
                    } else {
                        echo "GD Khong thanh cong";
                    }
                } else {
                    echo "Chu ky khong hop le";
                }
                ?>
            </label>
            <br>
            <center>
                <a href="../website_mvc/don-hang.html">
                    <button>Quay lại</button>
                </a>
            </center>
        </div>
    </div>

</div>
<?php
include '../inc/footer.php'
?>