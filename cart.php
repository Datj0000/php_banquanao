    <?php
    $title = 'Giỏ hàng';
    include 'inc/header2.php';  ?>

    <?php
    $customer_id = Session::get('customer_id');
    if (!isset($_GET['id'])) {
        echo "<meta http-equiv='refresh' content='0;URL=gio-hang.html?id=live'>";
    }
    if (isset($_GET['cartid'])) {
        $cartid = $_GET['cartid'];
        $delcart = $ct->del_product_cart($cartid);
        echo "<meta http-equiv='refresh' content='0;URL=gio-hang.html?id=live'>";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
        $id = $_POST['cartId'];
        $quantity = $_POST['quantity'];
        $update_quantity_cart = $ct->update_quantity_Cart($quantity, $id);
        echo "<meta http-equiv='refresh' content='0;URL=gio-hang.html'>";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['size'])) {
        $id = $_POST['cartId'];
        $size = $_POST['size'];
        $update_size_cart = $ct->update_size_Cart($size, $id);
        echo "<meta http-equiv='refresh' content='0;URL=gio-hang.html'>";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check'])) {
        $coupon = $_POST['coupon'];
        $check_coupon = $cp->check_coupon($coupon);
        if (isset($_SESSION['coupon'])) {
            $cart1 = $_SESSION['coupon'];
        }
    }

    ?>
    <style>
        th {
            text-align: center;
            padding: 7px;
            color: #fff;
            background: #ff523b;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
    </div>
    </div>
    <!-- -----------------cart item details------------------- -->
    <div class="small-container cart-page">
        <?php
        if ($check_cart) {
        ?>
            <table>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Size</th>
                    <th>Giá</th>
                </tr>
                <?php
                $get_product_cart = $ct->get_product_cart();
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
                                        <p><?php echo $result['productName'] ?></p>
                                        <small><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></small>
                                        <br>
                                        <a href="gio-hang.html?cartid=<?php echo $result['cartId'] ?>">Xoá</a>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 20%;">
                                <form action="" method="post">
                                    <input id="input_cart" type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>" />
                                    <input style="text-align: center;" onchange="this.form.submit()" id="input_cart" type="number" name="quantity" value="<?php echo $result['quantity'] ?>" min="1">
                                </form>
                            </td>
                            <td style="width: 20%;">
                                <form action="" method="post">
                                    <input id="input_cart" type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>" />
                                    <input style="text-align: center;" onchange="this.form.submit()" id="input_cart" type="number" name="size" value="<?php echo $result['size'] ?>" min="35" max="42">
                                </form>
                            </td>
                            <td>
                                <p>
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
        }
        ?>
        <?php
        if (isset($update_quantity_cart)) {
            echo $update_quantity_cart;
        }
        if (isset($update_size_cart)) {
            echo $update_size_cart;
        }
        if (isset($delcart)) {
            echo $delcart;
        }
        if (isset($check_coupon)) {
            echo $check_coupon;
        }
        ?>
        <div class="total-price">
            <?php
            $check_cart = $ct->check_cart_login();
            if (!$check_cart) {
                echo
                '<div style="display:block; margin: 0 auto; text-align: center; align-items:center">
                    <img style="width:70%" src="images/mascot@2x.png">
                    <p style="margin: 10px 0">Giỏ hàng của bạn trống</p>
                    <a href="san-pham.html"><button type="submit">Tiếp tục mua</button></a>
                </div>';
            } else {
            ?>
            <table>
                <tr>
                    <td>Tổng</td>
                    <td>
                        <?php
                        echo $fm->format_currency($subtotal) . " " . "VNĐ";
                        Session::set('sum', $subtotal);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Mã giảm</td>
                    <td>
                        <?php
                        if (isset($cart1)) {
                            echo $fm->format_currency($cart1['coupon_price']) . " " . "VNĐ";
                        } else {
                            echo '0' . " " . "VNĐ";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Ship</td>
                    <td>
                        <?php
                        $ship = 20000;
                        echo $fm->format_currency($ship) . " " . "VNĐ";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Thành tiền</td>
                    <td>
                        <?php
                        if (isset($cart1)) {
                            $gtotal = $subtotal + $ship - $cart1['coupon_price'];
                            echo $fm->format_currency($gtotal) . " " . "VNĐ";
                        } else {
                            $gtotal = $subtotal + $ship;
                            echo $fm->format_currency($gtotal) . " " . "VNĐ";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <form action="" method="post">
                        <td>
                            <input style="width:150px" name="coupon" class="form-input" type="text">
                        </td>
                        <td>
                            <button name="check" type="submit">Nhập mã</button>
                        </td>
                    </form>
                </tr>
                <tr>
                    <td>
                        <a href="san-pham.html"><button type="submit">Tiếp tục mua</button></a>
                    </td>
                    <td>
                        <a href="thanh-toan.html"><button type="submit">Thanh toán</button></a>
                    </td>
                </tr>
            </table>
        <?php
            }
        ?>
        </div>
    </div>


    <!-- ------------footer----------- -->

    <?php include 'inc/footer.php'  ?>