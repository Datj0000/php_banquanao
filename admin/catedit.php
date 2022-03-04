<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php

if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
    echo "<script>window.location ='catlist.php'</script>";
} else {
    $id = $_GET['catid'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catName = $_POST['catName'];
    $updateCat = $cat->update_category($catName, $id);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Sửa danh mục</h2>
        <?php
        if (isset($updateCat)) {
            echo $updateCat;
        }
        ?>
        <?php
        $get_cate_name = $cat->getcatbyId($id);
        if ($get_cate_name) {
            while ($result = $get_cate_name->fetch_assoc()) {
        ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Tên danh mục:</label>
                        <input type="text" name="catName" class="form-control" value="<?php echo $result['catName'] ?>" />
                    </div>
                    <div class=" form-group">
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