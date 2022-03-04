<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $insertSlider = $slider->insert_slider($_POST, $_FILES);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Thêm Slider</h2>
        <div class="block">
            <?php
            if (isset($insertSlider)) {
                echo $insertSlider;
            }
            ?>
            <form action="slideradd.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tiêu đề:</label>
                    <input type="text" name="sliderName" class="form-control" placeholder="Tiêu đề" />
                </div>
                <div class="form-group">
                    <label>Hình ảnh:</label>
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
                    <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>