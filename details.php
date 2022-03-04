<?php
$title = 'Chi tiết';
include 'inc/header2.php';  ?>
<?php

if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
    echo "<script>window.location ='404.html'</script>";
} else {
    $id = $_GET['proid'];
    $idcat =  $_GET['catid'];
}
$customer_id = Session::get('customer_id');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist'])) {
    $catid = $_POST['catid'];
    $productid = $_POST['productid'];
    $insertWishlist = $product->insertWishlist($catid, $productid, $customer_id);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $insertCart = $ct->add_to_cart($size, $quantity, $id);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitadd'])) {
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $insertCart = $ct->add_to_cart2($size, $quantity, $id);
}
// if (isset($_POST['binhluan_submit'])) {
//     $binhluan_insert = $cs->insert_binhluan();
// }
?>
<form method="post" action="">
    <div class="small-container single-product">
        <div class="row">
            <?php
            $get_product_details = $product->get_details($id);
            if ($get_product_details) {
                while ($result_details = $get_product_details->fetch_assoc()) {
            ?>
                    <div class="col-2">
                        <img src="admin/uploads/<?php echo $result_details['image'] ?>" width="100%" id="productImg">

                        <div class="small-img-row">
                            <?php
                            $get_images = $product->get_images($id);
                            if ($get_images) {
                                while ($result_images = $get_images->fetch_assoc()) {
                            ?>
                                    <div class="small-img-rol">
                                        <img src="admin/uploads/<?php echo $result_images['image'] ?>" width="100%" class="small-img">
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>

                    </div>
                    <div class="col-2">
                        <h5>
                            <p style="font-size: 18px;">Trang chủ / <?php echo $result_details['catName'] ?></p>
                        </h5>
                        <h1><?php echo $result_details['productName'] ?></h1>
                        <h4>Giá: <?php echo $fm->format_currency($result_details['price']) . " " . "VNĐ" ?></h4>
                        <br>
                        <input type="hidden" name="catid" value="<?php echo $result_details['catId'] ?>">
                        <input type="hidden" name="productid" value="<?php echo $result_details['productId'] ?>">
                        <p></p>
                        <p><span style="margin-right: 38px">Size: </span> <input type="number" name="size" value="35" min="35" max="42"></p>
                        <p><span>Số lượng:</span> <input type="number" name="quantity" value="1" min="1"></p>
                        <?php
                        if (isset($insertCart)) {
                            echo $insertCart;
                        }
                        if (isset($insertWishlist)) {
                            echo $insertWishlist;
                        }
                        ?>
                        <div style="margin-top:20px">
                            <?php
                            $login_check = Session::get('customer_login');
                            if ($login_check) {
                            ?>
                                <button type="submit" class="buysubmit" name="wishlist">Yêu thích</button>
                                <div class="clearfix"></div>
                            <?php
                            } else {
                                echo '';
                            }
                            $check_product = $product->check_active_product($id);
                            if ($check_product) {
                            ?>
                                <button type="submit" name="submit">Thêm vào giỏ</button>
                                <div class="clearfix"></div>
                                <button type="submit" name="submitadd">Mua ngay</button>
                            <?php
                            } else {
                                echo '<span class="error">Sản phẩm tạm thời hết hàng</span>';
                            }
                            ?>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</form>

<div class="clearfix"></div>
<div class="small-container desc-product">
    <h2>Mô tả sản phẩm
        <i class="fa fa-indent"></i>
    </h2>
    <br>
    <?php
    $get_product_details = $product->get_details($id);
    if ($get_product_details) {
        while ($result_details = $get_product_details->fetch_assoc()) {
    ?>
            <p><?php echo $result_details['product_desc'] ?></p>
    <?php
        }
    }
    ?>
</div>
</div>

<!-- ---------------Products----------------- -->
<div class="small-container">
    <div class="row">
        <div class="col-2" style="margin-bottom: auto;">
            <h2 style="margin-bottom: 30px;">Bình luận sản phẩm</h2>
            <?php
            $sql = $con->query("SELECT id FROM stars WHERE product_id = '$id'");
            $numR = $sql->num_rows;
            $sql = $con->query("SELECT SUM(rateIndex) AS total FROM stars WHERE product_id = '$id'");
            $rData = $sql->fetch_array();
            $total = $rData['total'];
            if ($numR > 0) {
                $avg2 = round($total / $numR, 0) - 1;
                if ($avg2 < 0) {
                    $avg = 0;
                } else {
                    $avg = $avg2;
                }
            ?>
                <input type="hidden" value="<?= $avg ?>" id="avg">
            <?php
            }
            ?>
            <div>
                <input id="proid" type="hidden" value="<?php echo $id ?>">
                <i class="fa fa-star voterating" data-index="0"></i>
                <i class="fa fa-star voterating" data-index="1"></i>
                <i class="fa fa-star voterating" data-index="2"></i>
                <i class="fa fa-star voterating" data-index="3"></i>
                <i class="fa fa-star voterating" data-index="4"></i>
            </div>
            <script>
                var ratedIndex = -1,
                    proid = $('#proid').val(),
                    avg = $('#avg').val(),
                    uID = 0;

                $(document).ready(function() {
                    resetStarColors();
                    setStars(parseInt(avg));
                    if (localStorage.getItem('ratedIndex') != null) {
                        setStars(parseInt(localStorage.getItem('ratedIndex')));
                        uID = localStorage.getItem('uID');
                    }

                    $('.voterating').on('click', function() {
                        ratedIndex = parseInt($(this).data('index'));
                        localStorage.setItem('ratedIndex', ratedIndex);
                        saveToTheDB();
                    });

                    $('.voterating').mouseover(function() {
                        resetStarColors();
                        var currentIndex = parseInt($(this).data('index'));
                        setStars(currentIndex);
                    });

                    $('.voterating').mouseleave(function() {
                        resetStarColors();

                        if (ratedIndex != -1)
                            setStars(ratedIndex);
                    });
                });

                function saveToTheDB() {
                    $.ajax({
                        url: "ajax/details.php",
                        method: "POST",
                        dataType: 'json',
                        data: {
                            save: 1,
                            uID: uID,
                            proid: proid,
                            ratedIndex: ratedIndex
                        },
                        success: function(r) {
                            uID = r.id;
                            localStorage.setItem('uID', uID);
                        }
                    });
                }

                function setStars(max) {
                    for (var i = 0; i <= max; i++)
                        $('.voterating:eq(' + i + ')').css('color', '#fd513b');
                }

                function resetStarColors() {
                    $('.voterating').css('color', '#ccc');
                }
            </script>
            <form action="" method="POST">
                <input type="hidden" value="<?php echo $id ?>" id="proid">
                <input type="text" placeholder="Điền tên" class="form-input" id="name">
                <textarea rows="5" class="form-area" placeholder="Nội dung bình luận" id="comment"></textarea>
                <button type="button" id="binhluan_submit">Gửi bình luận</button>
            </form>
<script>
    $('#binhluan_submit').on('click', function() {
        var proid = $('#proid').val();
        var name = $('#name').val();
        var comment = $('#comment').val();
            $.ajax({
                url: "ajax/details.php",
                method: "POST",
                data: {
                    proid: proid,
                    name: name,
                    comment: comment
                }
                // success: function(data) {
                //     if ($data == 1) {
                //         alert("Tạo tài khoản thành công");
                //     } else {
                //         alert("Tạo tài khoản thất bại");
                //     }
                // }
            })
    });
</script>
            <div>
                <?php
                $cmlist = $cs->show_comment_user($id);
                if ($cmlist) {
                    while ($result = $cmlist->fetch_assoc()) {
                ?>
                        <p style="font-weight: bold; margin-bottom:5px"><?php echo $result['tenbinhluan'] ?>:</p>
                        <p style="font-size: 13px;"><?php echo $result['binhluan'] ?></p>
                        <hr style="margin: 5px 0 10px 0">
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-2">
            <h2>Sản phẩm liên quan</h2>
            <div class="row">
                <?php
                $relate_to_product = $product->get_relate_to_product($id, $idcat);
                if ($relate_to_product) {
                    while ($result = $relate_to_product->fetch_assoc()) {
                ?>
                        <div class="col-4">
                            <a href="<?php echo 'san-pham/' . $result['productId'] . '-' . $result['catId'] . '-' . $fm->makeUrl($result['productName']) . '.html' ?>">
                                <img style="padding: 20px 0;" src="admin/uploads/<?php echo $result['image'] ?>" alt="" />
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
                } else {
                    echo '<span>Không tìm được sản phẩm liên quan</span>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- ------------footer----------- -->
<script>
    var ProductImg = document.getElementById("productImg");
    var SmallImg = document.getElementsByClassName("small-img");

    SmallImg[0].onclick = function() {
        ProductImg.src = SmallImg[0].src;
    }
    SmallImg[1].onclick = function() {
        ProductImg.src = SmallImg[1].src;
    }
    SmallImg[2].onclick = function() {
        ProductImg.src = SmallImg[2].src;
    }
    SmallImg[3].onclick = function() {
        ProductImg.src = SmallImg[3].src;
    }
</script>
<?php
include 'inc/footer.php'
?>