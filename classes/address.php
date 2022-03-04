<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php

class address
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function show_address_ttp()
    {
        $query = "SELECT * FROM tbl_tinhthanhpho order by matp ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_address_qh($matp)
    {
        $query = "SELECT * FROM tbl_quanhuyen WHERE matp = '$matp' order by maqh ASC";
        $result = $this->db->select($query);
        return $result;
    }
}
