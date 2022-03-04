<?php 
$title = 'Giới thiệu';
include 'inc/header2.php';
?>
</div>
<div class="small-container">
    <h2 class="title">Giới thiệu</h2>
    <div class="row" style="text-align: justify;">
        <?php
        $get_about = $display->get_about();
        if ($get_about) {
            while ($result = $get_about->fetch_assoc()) {
        ?>
                <?php echo $result['desc_about'] ?>
        <?php
            }
        }
        ?>
    </div>
</div>
<?php
include 'inc/footer.php'
?>