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
    echo "<meta content='0;URL=?id=live'>";
}
if (!isset($_GET['id'])) {
    echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
}
if (isset($_GET['delid'])) {
    $id = $_GET['delid'];
    $del_shifted = $ct->del_shifted($id);
    echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
}
$get_product = $product->show_product();
if ($get_product) {
    $i = 0;
    while ($result = $get_product->fetch_assoc()) {
        $i++;
        $qtyproduct = $i;
    }
}
$get_user = $cs->show_user();
if ($get_user) {
    $i = 0;
    while ($result = $get_user->fetch_assoc()) {
        $i++;
        $qtyuser = $i;
    }
}
$get_pro_soldout = $product->getproduct_soldout();
if ($get_pro_soldout) {
    $qtyorder = 0;
    while ($result = $get_pro_soldout->fetch_assoc()) {
        $price = $result['product_soldout'];
        $qtyorder += $price;
    }
}

$get_inbox_cart = $ct->get_inbox_cart();
if ($get_inbox_cart) {
    $i = 0;
    while ($result = $get_inbox_cart->fetch_assoc()) {
        $i++;
        Session::set("qtypro", $i);
    }
}
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <h2>Thống kê</h2>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span>
                    <p>
                        <span class="number">
                            <?php
                            if (!empty($qtyproduct)) {
                                echo $qtyproduct;
                            } else {
                                echo '0';
                            }
                            ?>
                        </span>
                        <span class="title">Sản phẩm</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                    <p>
                        <span class="number">
                            <?php
                            if (!empty($qtyorder)) {
                                echo $qtyorder;
                            } else {
                                echo '0';
                            }
                            ?>
                        </span>
                        <span class="title">Đã bán</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
                    <p>
                        <span class="number">
                            <?php
                            $CountFile = "../coutview.log";
                            $CF = fopen($CountFile, "r");
                            $Views = fread($CF, filesize($CountFile));
                            fclose($CF);
                            echo ($Views);
                            ?>
                        </span>
                        <span class="title">Truy cập</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <p>
                        <span class="number">
                            <?php
                            if (!empty($qtyuser)) {
                                echo $qtyuser;
                            } else {
                                echo '0';
                            }
                            ?>
                        </span>
                        </span>
                        <span class="title">Khách hàng</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div id="headline-chart" class="ct-chart"></div>
            </div>
            <?php
            $get_order = $ct->order_confirm();
            if ($get_order) {
                $total = 0;
                while ($result = $get_order->fetch_assoc()) {
                    $price = $result['price'];
                    $total += $price;
                }
            }
            $date = getdate();
            $mon = $date['mon'];
            $get_mon = $ct->order_confirm_mon($mon);
            $amount_mon = 0;
            if ($get_mon) {
                while ($result_mon = $get_mon->fetch_assoc()) {
                    $price_mon = $result_mon['price'];
                    $amount_mon += $price_mon;
                }
            }
            $last_mon = $date['mon'] - 1;
            $get_last_mon = $ct->order_confirm_mon($last_mon);
            $amount_last_mon = 0;
            if ($get_last_mon) {
                while ($result_last_mon = $get_last_mon->fetch_assoc()) {
                    $price_last_mon = $result_last_mon['price'];
                    $amount_last_mon += $price_last_mon;
                }
            }
            $year = $date['year'];
            $get_year = $ct->order_confirm_year($year);
            $amount_year = 0;
            if ($get_year) {
                while ($result_year = $get_year->fetch_assoc()) {
                    $price_year = $result_year['price'];
                    $amount_year += $price_year;
                }
            }
            $last_year = $date['year'] - 1;
            $get_last_year = $ct->order_confirm_year($last_year);
            $amount_last_year = 0;
            if ($get_last_year) {
                while ($result_last_year = $get_last_year->fetch_assoc()) {
                    $price_last_year = $result_last_year['price'];
                    $amount_last_year += $price_last_year;
                }
            }
            ?>
            <div class="col-md-4">
                <div class="weekly-summary text-right">
                    <span class="number">
                        <?php
                        if (!empty($amount_year)) {
                            echo $fm->format_currency($amount_year) . " " . "VNĐ";
                            $percent_year = round($amount_year / ($amount_year + $amount_last_year) * 100, 0);
                        } else {
                            echo '0';
                        }
                        ?>
                    </span> <span class="percentage">
                        <?php

                        if ($amount_year - $amount_last_year > 0) {
                        ?>
                            <i class="fa fa-caret-up text-success"></i>
                        <?php
                        } else {
                        ?>
                            <i class="fa fa-caret-down text-danger"></i>
                            <?php
                        }
                        if (!empty($percent_year)) {
                            echo $percent_year;
                        }
                            ?>%</span>
                    <span class="info-label">Thu nhập năm <?php echo $year ?></span>
                </div>
                <div class="weekly-summary text-right">
                    <span class="number">
                        <?php
                        if (!empty($amount_mon)) {
                            echo $fm->format_currency($amount_mon) . " " . "VNĐ";
                            $percent_mon = round($amount_mon / ($amount_mon + $amount_last_mon) * 100, 0);
                        } else {
                            echo '0';
                        }
                        ?>
                    </span>
                    <span class="percentage">
                        <?php
                        if ($amount_mon - $amount_last_mon > 0) {
                        ?>
                            <i class="fa fa-caret-up text-success"></i>
                        <?php
                        } else {
                        ?>
                            <i class="fa fa-caret-down text-danger"></i>
                            <?php
                        }
                        if (!empty($percent_mon)) {
                            echo $percent_mon;
                        }
                            ?>%</span>
                    <span class="info-label">Thu nhập tháng <?php echo $mon ?></span>
                </div>
                <div class="weekly-summary text-right">
                    <span class="number">
                        <?php
                        if (!empty($total)) {
                            echo $fm->format_currency($total) . " " . "VNĐ";
                            $percent_total = round($amount_mon / ($amount_mon + $total / 12) * 100, 0);
                        } else {
                            echo '0';
                        }
                        ?>
                    </span>
                    <span class="percentage">
                        <?php
                        if (!empty($total)) {
                            if ($amount_mon - $total / 12 > 0) {
                        ?>
                                <i class="fa fa-caret-up text-success"></i>
                            <?php
                            } else {
                            ?>
                                <i class="fa fa-caret-down text-danger"></i>
                                <?php
                            }
                        }
                        if (!empty($percent_total)) {
                            echo $percent_total;
                        }
                                ?>%</span>
                    <span class="info-label">Tổng doanh số</span>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END RECENT PURCHASES -->

<div class="row">
    <div class="col-md-8">
        <!-- TODO LIST -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Đặt hàng</h3>
                <div class="right">
                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                    <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                </div>
            </div>
            <div class="panel-body no-padding">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Mã Đơn</td>
                            <!-- <td>Thời gian đặt</td> -->
                            <td>Chi tiết</td>
                            <td>Trạng thái</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $get_inbox_cart = $ct->get_inbox_cart_limit();
                        if ($get_inbox_cart) {
                            while ($result = $get_inbox_cart->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $result['ordercode'] ?></td>
                                    <!-- <td><?php echo $fm->formatDate($result['date_order']) ?></td> -->
                                    <td><a style="color: #333;" href="customer.php?customerid=<?php echo $result['customer_id'] ?>&orderid=<?php echo $result['id'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
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
                                    <td>
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
                                    <td>
                                        <?php
                                        if ($result['status'] == 0) {
                                        ?>
                                            <a class="label label-success" role="button" aria-pressed="true" href="?shiftid=<?php echo $result['id'] ?>&email=<?php echo $mail_sent ?>&ordercode=<?php echo $result['ordercode'] ?>">
                                                Giao hàng</a>
                                        <?php
                                        } elseif ($result['status'] == 1) {
                                        ?>
                                            <label style="width: 105px;" class="label label-warning" role="button" aria-pressed="true">
                                            Đang giao</label>
                                        <?php
                                        } elseif ($result['status'] == 2) {
                                        ?>
                                            <a style="width: 105px;" class="label label-danger" role="button" aria-pressed="true" href="?delid=<?php echo $result['id'] ?>">
                                                Xoá đơn</a>
                                        <?php
                                        } elseif ($result['status'] == 3) {
                                        ?>
                                            <a style="width: 105px;" class="label label-success" role="button" aria-pressed="true" href="?shiftid=<?php echo $result['id'] ?>&email=<?php echo $mail_sent ?>&ordercode=<?php echo $result['ordercode'] ?>">
                                                Đổi hàng</a>
                                        <?php
                                        }
                                        ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6"><span class="panel-note"></span></div>
                    <div class="col-md-6 text-right"><a href="inbox.php" class="btn btn-primary">Xem tất cả &#8594;</a></div>
                </div>
            </div>
        </div>
        <!-- END TODO LIST -->
    </div>
    <div class="col-md-4">
        <!-- TIMELINE -->
        <div class="panel panel-scrolling">
            <div class="panel-heading">
                <h3 class="panel-title">Sản phẩm bán chạy</h3>
                <div class="right">
                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                    <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                </div>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled activity-list">
                    <?php
                    $get_product_top = $product->getproduct_top();
                    if ($get_product_top) {
                        $i = 0;
                        while ($result_product_top = $get_product_top->fetch_assoc()) {
                            $i++;
                    ?>
                            <li>
                                <img src="uploads/<?php echo $result_product_top['image'] ?>" alt="Avatar" class="img-circle pull-left avatar">
                                <p><?php echo $result_product_top['productName'] ?>
                                    <span class="timestamp">Bán được: <?php echo $result_product_top['product_soldout'] ?></span>
                                </p>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- END TIMELINE -->
    </div>
</div>
<!-- <div class="row">
    <div class="col-md-5">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Hệ thống</h3>
                <div class="right">
                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                    <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                </div>
            </div>
            <div class="panel-body">
                <div id="system-load" class="easy-pie-chart" data-percent="70">
                    <span class="percent">70</span>
                </div>
                <h4>CPU</h4>
                <ul class="list-unstyled list-justify">
                    <li>Cao: <span>95%</span></li>
                    <li>Trung bình: <span>87%</span></li>
                    <li>Thấp: <span>20%</span></li>
                    <li>Chủ đề: <span>996</span></li>
                    <li>Quy trình: <span>259</span></li>
                </ul>
            </div>
        </div>
    </div>
</div> -->
<?php include 'inc/footer.php'; ?>
<script>
    $(function() {
        var data, options;

        // headline charts
        data = {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            series: [
                [6, 12, 17, 56, 145, 81, ]
            ]
        };

        options = {
            height: 300,
            axisX: {
                showGrid: false
            },
        };

        new Chartist.Line('#headline-chart', data, options);

        // real-time pie chart
        var sysLoad = $('#system-load').easyPieChart({
            size: 130,
            barColor: function(percent) {
                return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
            },
            trackColor: 'rgba(245, 245, 245, 0.8)',
            scaleColor: false,
            lineWidth: 5,
            lineCap: "square",
            animate: 800
        });

        var updateInterval = 3000; // in milliseconds

        setInterval(function() {
            var randomVal;
            randomVal = getRandomInt(0, 100);

            sysLoad.data('easyPieChart').update(randomVal);
            sysLoad.find('.percent').text(randomVal);
        }, updateInterval);

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

    });
</script>