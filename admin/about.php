<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $updateAbout = $display->update_about($_POST);
}
?>
<div class="panel">
    <div class="panel-heading">
        <h2>Sửa giới thiệu</h2>
        <?php
        if (isset($updateAbout)) {
            echo $updateAbout;
        }
        ?>
        <?php
        $get_about = $display->get_about();
        if ($get_about) {
            while ($result_display = $get_about->fetch_assoc()) {
        ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Giới thiệu:</label>
                        <textarea id="dess" name="desc_about" class="tinymce"><?php echo $result_display['desc_about'] ?></textarea>
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