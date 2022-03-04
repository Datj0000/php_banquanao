<?php
$filepath = realpath(dirname(__FILE__));
include($filepath . '/../lib/session.php');
Session::checkLogin();
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class adminlogin
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function login_admin($adminUser, $adminPass)
	{
		$adminUser = $this->fm->validation($adminUser);
		$adminPass = $this->fm->validation($adminPass);

		$adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
		//1 bien trieu hieu va 1 bien ket noi csdl
		$adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

		if (empty($adminUser) || empty($adminPass)) {
			$alert = "Không được để trống";
			return $alert;
		} else {
			$query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass'";
			$result = $this->db->select($query);

			if ($result != false) {

				$value = $result->fetch_assoc(); //lấy kết quả

				Session::set('adminlogin', true);

				Session::set('adminId', $value['adminId']);
				Session::set('adminUser', $value['adminUser']);
				Session::set('adminName', $value['adminName']);
				Session::set('adminRole', $value['level']);

				header('Location:index.php');
			} else {
				$alert = "Tài khoản hoặc mật khẩu sai";
				return $alert;
			}
		}
	}
	
}
?>