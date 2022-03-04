<?php
$title = 'Sản phẩm';
include 'inc/header2.php';  ?>
<?php
$param = "";
$sortParam = "";
$orderConditon = "";
$link = "san-pham.html?";
//Tìm kiếm
$search = isset($_GET['productName']) ? $_GET['productName'] : "";
if ($search) {
    $where = "WHERE `productName` LIKE '%" . $search . "%'";
    $param .= "productName=" . $search . "&";
    $sortParam =  "productName=" . $search . "&";
}

//Sắp xếp
$orderField = isset($_GET['field']) ? $_GET['field'] : "";
$orderSort = isset($_GET['sort']) ? $_GET['sort'] : "";
if (
    !empty($orderField)
    && !empty($orderSort)
) {
    $orderConditon = "ORDER BY `tbl_product`.`" . $orderField . "` " . $orderSort;
    $param .= "field=" . $orderField . "&sort=" . $orderSort . "&";
}

$item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 12;
$current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $item_per_page;
if ($search) {
    $products = mysqli_query($con, "SELECT * FROM `tbl_product` WHERE `productName` LIKE '%" . $search . "%' " . $orderConditon . "  LIMIT " . $item_per_page . " OFFSET " . $offset);
    $totalRecords = mysqli_query($con, "SELECT * FROM `tbl_product` WHERE `productName` LIKE '%" . $search . "%'");
} else {
    $products = mysqli_query($con, "SELECT * FROM `tbl_product` " . $orderConditon . " LIMIT " . $item_per_page . " OFFSET " . $offset);
    $totalRecords = mysqli_query($con, "SELECT * FROM `tbl_product`");
}
$totalRecords = $totalRecords->num_rows;
$totalPages = ceil($totalRecords / $item_per_page);
?>
</div>
</div>

<div class="small-container">
    <h2 class="title">Danh sách sản phẩm</h2>
    <div class="row row-2">
        <form action="" method="GET">
            <input style="float: left; height: 30px" class="form-input2" type="text" placeholder="Từ khoá tìm kiếm" value="<?= isset($_GET['productName']) ? $_GET['productName'] : "" ?>" name="productName" />
            <button style="margin: 5px 0 0 5px; width: 100px; height:30px;" type="submit">Tìm</button>
        </form>
        <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option <?php if (isset($_GET['sort']) && $_GET['sort'] == "desc" && $_GET['field'] == "productId") { ?> selected <?php  } ?> value="<?= $link . $sortParam ?>field=productId&sort=desc">Theo sản phẩm mới</option>
            <option <?php if (isset($_GET['sort']) && $_GET['sort'] == "asc" && $_GET['field'] == "productId") { ?> selected <?php } ?> value="<?= $link . $sortParam ?>field=productId&sort=asc">Theo sản phẩm cũ</option>
            <option <?php if (isset($_GET['sort']) && $_GET['sort'] == "desc" && $_GET['field'] == "price") { ?> selected <?php } ?> value="<?= $link . $sortParam ?>field=price&sort=desc">Theo giá cao</option>
            <option <?php if (isset($_GET['sort']) && $_GET['sort'] == "asc" && $_GET['field'] == "price") { ?> selected <?php } ?> value="<?= $link . $sortParam ?>field=price&sort=asc">Theo giá thấp</option>
        </select>
    </div>
    <div class="row">
        <?php
        while ($result = mysqli_fetch_array($products)) {
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
        ?>
    </div>
    <?php
    include 'inc/pagination.php';
    ?>
</div>
<!-- ------------footer----------- -->

<?php include 'inc/footer.php'  ?>