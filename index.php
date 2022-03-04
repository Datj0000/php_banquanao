<?php
$title = 'Trang chủ';
include 'inc/header.php';
?>
<div class="row">
    <?php
    $get_display = $display->show_display();
    if ($get_display) {
        while ($result = $get_display->fetch_assoc()) {
    ?>
            <div class="col-2">
                <h1><?php echo $result['titlebanner'] ?></h1>
                <p><?php echo $result['descbanner'] ?></p>
                <a href="san-pham.html"><button style="margin-top: 20px;">Xem thêm &#8594;</button></a>
            </div>
            <div class="col-2">
                <img src="admin/uploads/<?php echo $result['imgbanner'] ?>">
            </div>
    <?php
        }
    }
    ?>
</div>
</div>
</div>
<!-- ------------- featured categorries ---------------- -->
<div class="categories">
    <div class="small-container">
        <div class="row slider">
            <?php
            $get_slider = $slider->show_slider();
            if ($get_slider) {
                while ($result_slider = $get_slider->fetch_assoc()) {
            ?>
                    <div class="col-3 slider-img">
                        <img src="admin/uploads/<?php echo $result_slider['slider_image'] ?>" alt="<?php echo $result_slider['sliderName'] ?>" />
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

</div>
<!-- ------------- featured products ---------------- -->
<div class="small-container">
    <h2 class="title">Sản phẩm nổi bật</h2>
    <div class="row" style="display: flex">
        <?php
        $product_feathered = $product->getproduct_feathered();
        if ($product_feathered) {
            while ($result = $product_feathered->fetch_assoc()) {
        ?>
                <div class="col-4">
                    <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                        <img src="admin/uploads/<?php echo $result['image'] ?>" alt="" />
                    </a>
                    <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                        <h4 class="productName"><?php echo $result['productName'] ?></h4>
                    </a>
                    <ul>
                                <?php
                                $proid = $result['productId'];
                                $sql = $con->query("SELECT id FROM stars WHERE product_id = '$proid'");
                                $numR = $sql->num_rows;
                                $sql = $con->query("SELECT SUM(rateIndex) AS total FROM stars WHERE product_id = '$proid'");
                                $rData = $sql->fetch_array();
                                $total = $rData['total'];
                                if ($numR > 0 && isset($total)) {
                                    $avg3 = round($total / $numR, 0);
                                    for ($count = 1; $count <= 5; $count++) {
                                        if ($count <= $avg3) {
                                            $color = '#fa543c';
                                        } else {
                                            $color = '#ccc';
                                        } ?>
                                        <i class="fa fa-star" style="display: inline;color: <?= $color ?>;"></i>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div style="color: #ccc;">
                                        <input id="proid" type="hidden" value="<?php echo $result['productId'] ?>">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                <?php
                                }
                                ?>
                            </ul>
                    <p><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></p>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="clearfix"></div>
    <h2 class="title">Sản phẩm bán chạy</h2>
    <div class="row" style="display: flex">
        <?php
        $product_feathered = $product->getproduct_top2();
        if ($product_feathered) {
            while ($result = $product_feathered->fetch_assoc()) {
        ?>
                <div class="col-4">
                    <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                        <img src="admin/uploads/<?php echo $result['image'] ?>" alt="" />
                    </a>
                    <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                        <h4 class="productName"><?php echo $result['productName'] ?></h4>
                    </a>
                    <ul>
                                <?php
                                $proid = $result['productId'];
                                $sql = $con->query("SELECT id FROM stars WHERE product_id = '$proid'");
                                $numR = $sql->num_rows;
                                $sql = $con->query("SELECT SUM(rateIndex) AS total FROM stars WHERE product_id = '$proid'");
                                $rData = $sql->fetch_array();
                                $total = $rData['total'];
                                if ($numR > 0 && isset($total)) {
                                    $avg3 = round($total / $numR, 0);
                                    for ($count = 1; $count <= 5; $count++) {
                                        if ($count <= $avg3) {
                                            $color = '#fa543c';
                                        } else {
                                            $color = '#ccc';
                                        } ?>
                                        <i class="fa fa-star" style="display: inline;color: <?= $color ?>;"></i>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div style="color: #ccc;">
                                        <input id="proid" type="hidden" value="<?php echo $result['productId'] ?>">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                <?php
                                }
                                ?>
                            </ul>
                    <p><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></p>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="clearfix"></div>
    <h2 class="title">Sản phẩm mới</h2>
    <div class="row" style="display: flex">
        <?php
        $product_new = $product->getproduct_new();
        if ($product_new) {
            while ($result = $product_new->fetch_assoc()) {
        ?>
                <div class="col-4">
                    <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                        <img src="admin/uploads/<?php echo $result['image'] ?>" alt="" />
                    </a>
                    <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                        <h4 class="productName"><?php echo $result['productName'] ?></h4>
                    </a>
                    <ul>
                                <?php
                                $proid = $result['productId'];
                                $sql = $con->query("SELECT id FROM stars WHERE product_id = '$proid'");
                                $numR = $sql->num_rows;
                                $sql = $con->query("SELECT SUM(rateIndex) AS total FROM stars WHERE product_id = '$proid'");
                                $rData = $sql->fetch_array();
                                $total = $rData['total'];
                                if ($numR > 0 && isset($total)) {
                                    $avg3 = round($total / $numR, 0);
                                    for ($count = 1; $count <= 5; $count++) {
                                        if ($count <= $avg3) {
                                            $color = '#fa543c';
                                        } else {
                                            $color = '#ccc';
                                        } ?>
                                        <i class="fa fa-star" style="display: inline;color: <?= $color ?>;"></i>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div style="color: #ccc;">
                                        <input id="proid" type="hidden" value="<?php echo $result['productId'] ?>">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                <?php
                                }
                                ?>
                            </ul>
                    <p><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></p>
                </div>
        <?php
            }
        }
        ?>

    </div>
    <div class="row">
        <a href="san-pham.html"><button style="align-items: center;">Xem thêm&#8594;</button></a>
    </div>
</div>
<!-- ------------ offer -------------- -->
<div class="offer">
    <div class="small-container">
        <div class="row">
            <?php
            $get_display = $display->show_display();
            if ($get_display) {
                while ($result = $get_display->fetch_assoc()) {
            ?>
                    <div class="col-2">
                        <img src="admin/uploads/<?php echo $result['image'] ?>" class="offer-img">
                    </div>
                    <div class="col-2">
                        <p>Độc quyền tại cửa hàng</p>
                        <h1><?php echo $result['productName'] ?></h1>
                        <?php echo $fm->textShorten($result['product_desc'], 300) ?></small>
                        <br>
                        <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                            <button type="submit">Mua ngay &#8594;</button></a>
                    </div>
            <?php
                }
            }
            ?>

        </div>
    </div>
</div>
<!-- ------------ testimonial -------------- -->
<div class="testimonial">
    <div class="small-container">
        <div class="row">
            <div class="col-3">
                <i class="fa fa-qoute-lef"></i>
                <p>Abilities or he perfectly pretended so strangers be exquisite. Oh to another chamber pleased
                    imagine do in. Went me rank at last loud shot an draw. Excellent so to no sincerity smallness.
                    Removal request delight if on he we</p>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <img src="images/user-1.png">
                <h3>Đat Nguyen</h3>
            </div>
            <div class="col-3">
                <i class="fa fa-qoute-lef"></i>
                <p>Abilities or he perfectly pretended so strangers be exquisite. Oh to another chamber pleased
                    imagine do in. Went me rank at last loud shot an draw. Excellent so to no sincerity smallness.
                    Removal request delight if on he we</p>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <img src="images/user-2.png">
                <h3>dăq quyễn</h3>
            </div>
            <div class="col-3">
                <i class="fa fa-qoute-lef"></i>
                <p>Abilities or he perfectly pretended so strangers be exquisite. Oh to another chamber pleased
                    imagine do in. Went me rank at last loud shot an draw. Excellent so to no sincerity smallness.
                    Removal request delight if on he we</p>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <img src="images/user-3.png">
                <h3>Quang Hoang</h3>
            </div>
        </div>
    </div>
</div>
<!-- ------------------- brands --------------------- -->
<div class="brands">
    <div class="small-container">
        <div class="row">
            <?php
            $get_brand = $slider->show_brand();
            if ($get_brand) {
                while ($result = $get_brand->fetch_assoc()) {
            ?>
                    <div class="col-5">
                        <img src="admin/uploads/<?php echo $result['image'] ?>">
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- ------------footer----------- -->

<?php include 'inc/footer.php'  ?>