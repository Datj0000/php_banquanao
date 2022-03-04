<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $updateDisplay = $display->update_display($_POST, $_FILES);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Sửa giao diện</h2>
        <?php
        if (isset($updateDisplay)) {
            echo $updateDisplay;
        }
        ?>
        <?php
        $get_display = $display->get_display();
        if ($get_display) {
            while ($result_display = $get_display->fetch_assoc()) {
        ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Logo:</label>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img id="previewImage" src="uploads/<?php echo $result_display['logo'] ?>"><br>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="file" name="logo" onchange="ShowImagePreview(this, document.getElementById('previewImage'))" />
                    </div>
                    <div class="form-group">
                        <label>Banner:</label>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img id="previewImage2" src="uploads/<?php echo $result_display['imgbanner'] ?>"><br>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="file" name="image" onchange="ShowImagePreview2(this, document.getElementById('previewImage2'))" />
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề:</label>
                        <input type="text" name="titlebanner" class="form-control" value="<?php echo $result_display['titlebanner'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Chi tiết:</label>
                        <textarea name="descbanner" class="form-control"><?php echo $result_display['descbanner'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Sản phẩm nổi bật</label>
                        <select id="select" name="producttop" class="form-control">
                            <option value="">--------Chọn sản phẩm--------</option>
                            <?php
                            $pro = new product();
                            $prolist = $pro->show_product_list();
                            if ($prolist) {
                                while ($result = $prolist->fetch_assoc()) {
                            ?>
                                    <option <?php
                                            if ($result['productId'] == $result_display['productId']) {
                                                echo 'selected';
                                            }
                                            ?> value="<?php echo $result['productId'] ?>"><?php echo $result['productName'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
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

<?php include 'inc/footer.php'; ?>