<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // var_dump($_FILES);
    // die();
    $updatesocit = $footer->update_footer($_POST, $_FILES);
}

?>
<div class="panel">
    <div class="panel-heading">
        <h2>Cập nhật chân trang</h2>
        <?php
        if (isset($updatesocit)) {
            echo $updatesocit;
        }
        ?>
        <?php
        $get_footer = $footer->getfooter();
        if ($get_footer) {
            while ($result = $get_footer->fetch_assoc()) {
        ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Logo:</label>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img id="previewImage" src="uploads/<?php echo $result['image'] ?>"><br>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="file" name="image" onchange="ShowImagePreview(this, document.getElementById('previewImage'))" />
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề:</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $result['title'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="mail" value="<?php echo $result['mail'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $result['phone'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="<?php echo $result['address'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" class="form-control" name="facebook" value="<?php echo $result['facebook'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Youtube</label>
                        <input type="text" class="form-control" name="youtube" value="<?php echo $result['youtube'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Twitter</label>
                        <input type="text" class="form-control" name="twitter" value="<?php echo $result['twitter'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" class="form-control" name="instagram" value="<?php echo $result['instagram'] ?>" />
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