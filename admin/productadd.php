<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $insertProduct = $product->insert_product($_POST, $_FILES);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Thêm sản phẩm</h2>
        <div class="block">
            <?php
            if (isset($insertProduct)) {
                echo $insertProduct;
            }
            ?>
            <form action="productadd.php" method="post" enctype="multipart/form-data">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="productName" class="form-control" placeholder="Tên sản phẩm" />
                    </div>
                    <div class="form-group">
                        <label>Danh mục:</label>
                        <select class="form-control" id="select" name="category">
                            <option value="">Chọn danh mục</option>
                            <?php
                            $catlist = $cat->show_category();
                            if ($catlist) {
                                while ($result = $catlist->fetch_assoc()) {
                            ?>
                                    <option value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><label>Số lượng</label>:</label>
                        <input type="number" name="productQuantity" class="form-control" placeholder="Số lượng" />
                    </div>
                    <div class="form-group">
                        <label>Mô tả sản phẩm:</label>
                        <textarea id="dess" name="product_desc" class="tinymce"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Giá tiền:</label>
                        <input type="number" name="price" class="form-control" placeholder="Giá tiền" />
                    </div>
                    <div class="form-group">
                        <label>Ảnh sản phẩm: </label>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img id="previewImage" src="uploads/add.jpg"><br>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="file" name="image" onchange="ShowImagePreview(this, document.getElementById('previewImage'))" />
                    </div>
                    <div class="form-group">
                        <label>Ảnh mô tả: </label>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img id="previewImage2" src="uploads/add.jpg"><br>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="file" name="images[]" id="multiple" multiple="multiple" onchange="ShowImagePreview2(this, document.getElementById('previewImage2'))" />
                    </div>
                    <div class="form-group">
                        <label>Loại sản phẩm: </label>
                        <select class="form-control" id="select" name="type">
                            <option value="">Chọn loại</option>
                            <option value="0">Nổi bật</option>
                            <option value="1">Không nổi bật</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
                    </div>
                </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>