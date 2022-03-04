<?php
$con = mysqli_connect("localhost", "root", "", "website_mvc");
if (isset($_POST['save'])) {
    $uID = $con->real_escape_string($_POST['uID']);
    $proid = $con->real_escape_string($_POST['proid']);
    $ratedIndex = $con->real_escape_string($_POST['ratedIndex']);
    $ratedIndex++;

    if (!$uID) {
        $con->query("INSERT INTO stars (product_id, rateIndex) VALUES ('$proid','$ratedIndex')");
        $sql = $con->query("SELECT id FROM stars WHERE product_id = '$proid' ORDER BY id DESC");
        $uData = $sql->fetch_assoc();
        $uID = $uData['id'];
    } else
        $con->query("UPDATE stars SET rateIndex='$ratedIndex' WHERE id='$uID'");

    exit(json_encode(array('id' => $uID)));
}
if (isset($_POST['comment'])) {
    $name = $con->real_escape_string($_POST['name']);
    $proid = $con->real_escape_string($_POST['proid']);
    $comment = $con->real_escape_string($_POST['comment']);
    $con->query("INSERT INTO tbl_binhluan(tenbinhluan,product_id,binhluan) VALUES('$name','$proid','$comment')");
}