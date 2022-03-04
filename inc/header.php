<?php
include 'lib/session.php';
Session::init();
?>
<?php

include 'lib/database.php';
include 'helpers/format.php';

spl_autoload_register(function ($class) {
    include_once "classes/" . $class . ".php";
});


$db = new Database();
$fm = new Format();
$ct = new cart();
$cat = new category();
$cs = new customer();
$product = new product();
$slider = new slider();
$address = new address();
$display = new display();
$footer = new footer();
$cp = new coupon();

$CountFile = "coutview.log";
$CF = fopen($CountFile, "r");
$Views = fread($CF, filesize($CountFile));
fclose($CF);
$Views++;
$CF = fopen($CountFile, "w");
fwrite($CF, $Views);
fclose($CF);

?>
<?php
date_default_timezone_set('Asia/Bangkok');
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: max-age=2592000");
$check_cart = $ct->check_cart_login();
if ($check_cart) {
    $get_product_cart = $ct->get_product_cart();
    if ($get_product_cart) {
        $subtotal = 0;
        $qty = 0;
        while ($result = $get_product_cart->fetch_assoc()) {
            $total = $result['quantity'] * $result['price'];
            $subtotal += $total;
            $qty = $qty + $result['quantity'];
        }
        Session::set('qty', $qty);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="http://localhost/website_mvc/" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/myStyle.css">
    <script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <?php
    $get_display = $display->show_display();
    if ($get_display) {
        while ($result = $get_display->fetch_assoc()) {
    ?>
            <link rel="shortcut icon" type="image/png" href="admin/uploads/<?php echo $result['logo'] ?>" />
    <?php
        }
    }
    ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <?php
                    $get_display = $display->show_display();
                    if ($get_display) {
                        while ($result = $get_display->fetch_assoc()) {
                    ?>
                            <a href="trang-chu.html"><img src="admin/uploads/<?php echo $result['logo'] ?>" width="80px" height="40px"></a>
                    <?php
                        }
                    }
                    ?>
                </div>
                <nav>
                    <ul id="MenuItems">
                        <li><a href="trang-chu.html">Trang chủ</a></li>
                        <li><a href="san-pham.html">Sản phẩm</a></li>
                        <li>
                            <div class="dropdown">
                                <p>Danh mục</p>
                                <div class="dropdown-content">
                                    <?php
                                    $cate = $cat->show_category();
                                    if ($cate) {
                                        while ($result_new = $cate->fetch_assoc()) {
                                    ?>
                                            <p style="margin-bottom: 2px;">
                                                <a href="danh-muc.html?catid=<?php echo $result_new['catId'] ?>"><?php echo $result_new['catName'] ?></a>
                                            </p>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <?php
                        if (isset($_GET['customer_id'])) {
                            $delCart = $ct->del_all_data_cart();
                            Session::destroy();
                        }
                        ?>
                        <li><a href="gioi-thieu.html">Giới thiệu</a></li>
                        <li><?php
                            $login_check = Session::get('customer_login');
                            if ($login_check == false) {
                                echo '<a href="dang-nhap.html">Đăng nhập</a></li>';
                            } else {
                                echo '<p><a href="ho-so.html">' . Session::get('customer_name') . '</a></p></li>';
                            }
                            ?>
                    </ul>
                </nav>
                <a style="position: relative;" href="gio-hang.html">
                    <img src="images/cart.png" width="20px" height="20px">
                    <span class="badge">
                        <?php
                        $check_cart = $ct->check_cart();
                        if ($check_cart) {
                            $qtycart = Session::get("qty");
                            echo $qtycart;
                        } else {
                            echo '0';
                        }
                        ?>
                    </span></a>
                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>