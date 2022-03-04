<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $insertbrand = $slider->insert_brand($_POST, $_FILES);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Thêm nhà tài trợ</h2>
        <div class="block">
            <?php
            if (isset($insertbrand)) {
                echo $insertbrand;
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tên nhà tài trợ:</label>
                    <input type="text" name="brandname" class="form-control" placeholder="Tên nhà tài trợ" />
                </div>
                <div class="form-group">
                    <label>Logo:</label>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img id="previewImage" src="uploads/add.jpg" ><br>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <input type="file" name="image" onchange="ShowImagePreview(this, document.getElementById('previewImage'))" />
                </div>
                <div class="form-group">
                    <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>