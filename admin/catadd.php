<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catName = $_POST['catName'];

    $insertCat = $cat->insert_category($catName);
}
?>

<div class="panel">
    <div class="panel-heading">
        <h2>Thêm danh mục</h2>
        <div class="block copyblock">
            <?php
            if (isset($insertCat)) {
                echo $insertCat;
            }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label>Tên danh mục:</label>
                    <input type="text" name="catName" class="form-control" placeholder="Tên danh mục" />
                </div>
                <div class="form-group">
                    <input class="btn btn-success" type="submit" name="submit" value="Lưu" />
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>