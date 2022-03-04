<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php

if (!isset($_GET['productid']) || $_GET['productid'] == NULL) {
    echo "<script>window.location ='productlist.php'</script>";
} else {
    $id = $_GET['productid'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $updateProduct = $product->update_product($_POST, $_FILES, $id);
}
$images = mysqli_query($con, "SELECT image FROM tbl_imagesproduct WHERE productId ='$id' ")
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Sửa sản phẩm</h2>
        <div class="block">
            <?php
            if (isset($updateProduct)) {
                echo $updateProduct;
            }
            ?>
            <?php
            $get_product_by_id = $product->getproductbyId($id);
            if ($get_product_by_id) {
                while ($result_product = $get_product_by_id->fetch_assoc()) {
            ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" name="productName" class="form-control" value="<?php echo  $result_product['productName'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Danh mục:</label>
                            <select class="form-control" id="select" name="category">
                                <?php
                                $catlist = $cat->show_category();
                                if ($catlist) {
                                    while ($result = $catlist->fetch_assoc()) {
                                ?>
                                        <option <?php
                                                if ($result['catId'] == $result_product['catId']) {
                                                    echo 'selected';
                                                }
                                                ?> value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><label>Số lượng</label>:</label>
                            <input type="number" name="productQuantity" class="form-control" value="<?php echo $result_product['productQuantity'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Mô tả sản phẩm:</label>
                            <textarea id="dess" name="product_desc" class="tinymce"><?php echo $result_product['product_desc'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Giá tiền:</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $result_product['price'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Ảnh sản phẩm: </label>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <img id="previewImage" src="uploads/<?php echo $result_product['image'] ?>"><br>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <input type="file" name="image" onchange="ShowImagePreview(this, document.getElementById('previewImage'))" />
                        </div>
                        <div class="form-group">
                            <label>Ảnh mô tả: </label>
                            <div class="clearfix"></div>
                            <?php
                            foreach ($images as $key => $value) {
                            ?>
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <img id="previewImage2" src="uploads/<?php echo $value['image'] ?>">
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                            <input type="file" name="images[]" id="multiple" multiple="multiple" onchange="ShowImagePreview2(this, document.getElementById('previewImage2'))" />
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