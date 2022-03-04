<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * 
 */
class user
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function show_order($idorder)
	{
		$query = "SELECT * FROM tbl_order WHERE id='$idorder' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_staff()
	{
		$query = "SELECT * FROM tbl_admin order by adminId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_staff($id)
	{
		$query = "SELECT * FROM tbl_admin where adminId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function del_staff($id)
	{
		$query = "DELETE FROM tbl_admin where adminId = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "
			<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<i class='fa fa-check-circle'></i> Xoá thành công
			</div>";
			return $alert;
		} else {
			$alert = "
			<div class='alert alert-danger alert-dismissiblee' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<i class='fa fa-times-circle'></i> Xoá không thành công
			</div>";
			return $alert;
		}
	}
	public function change_pass($oldPass, $newPass, $rePass, $id)
	{
		$oldPass = mysqli_real_escape_string($this->db->link, md5($oldPass));
		$newPass = mysqli_real_escape_string($this->db->link, md5($newPass));
		$rePass = mysqli_real_escape_string($this->db->link, md5($rePass));
		if (empty($oldPass) || empty($newPass) || empty($rePass)) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Vui lòng điền đầy đủ các trường còn trống
				</div>";
			return $alert;
		} else if ($newPass == $oldPass) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Mật khẩu mới và mật khẩu cũ giống nhau
				</div>";
			return $alert;
		} else if ($newPass != $rePass) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Mật khẩu mới và mật khẩu nhập lại không trùng nhau
				</div>";
			return $alert;
		} else {
			$query = "UPDATE tbl_admin SET adminPass = '$newPass' WHERE adminId = '$id'";
			$result = $this->db->update($query);
			if ($result) {
				$alert = "
				<div class='alert alert-success alert-dismissible' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-check-circle'></i> Xoá thành công
				</div>";
				return $alert;
			} else {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Xoá không thành công
				</div>";
				return $alert;
			}
		}
	}
	public function insert_admin($data)
	{
		$adminName = mysqli_real_escape_string($this->db->link, $data['adminName']);
		$adminUser = mysqli_real_escape_string($this->db->link, $data['adminUser']);
		$adminPassword = mysqli_real_escape_string($this->db->link, md5($data['adminPassword']));
		$readminPassword = mysqli_real_escape_string($this->db->link, md5($data['readminPassword']));
		$adminEmail = mysqli_real_escape_string($this->db->link, $data['adminEmail']);
		$level = mysqli_real_escape_string($this->db->link, $data['level']);
		$adminPhone = preg_replace('/[^0-9]/', '', $data['adminPhone']);
		$phone = mysqli_real_escape_string($this->db->link, $adminPhone);
		if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $data['adminPassword']))) {
			if (strlen($data['adminPassword']) > 20) {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Mật khẩu quá dài!
				</div>";
				return $alert;
			}
			if (strlen($data['adminPassword']) < 8) {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Mật khẩu quá ngắn!
				</div>";
				return $alert;
			}
			if (!preg_match("#[0-9]+#", $data['adminPassword'])) {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Mật khẩu cần ít nhất 1 số!
				</div>";
				return $alert;
			}
			if (!preg_match("#[a-z]+#", $data['adminPassword'])) {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Mật khẩu cần ít nhất 1 chữ!
				</div>";
				return $alert;
			}
			if (!preg_match("#[A-Z]+#", $data['adminPassword'])) {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Mật khẩu cần ít nhất 1 chữ cái viết hoa!
				</div>";
				return $alert;
			}
		} else if ($adminPassword != $readminPassword) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Nhập lại mật khẩu không trùng khớp
				</div>";
			return $alert;
		} else if (strlen($phone) != 10) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Số điện thoại không hợp lệ
				</div>";
			return $alert;
		} else if (!preg_match("/^[0-9]*$/", $phone)) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Số điện thoại không hợp lệ
				</div>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_admin WHERE adminEmail = '$adminEmail' LIMIT 1";
			$result_check = $this->db->select($check_email);
			$check_user = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' LIMIT 1";
			$result_check2 = $this->db->select($check_user);
			if ($result_check && $result_check2) {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Tài khoản hoặc email đã tồn tại
				</div>";
				return $alert;
			} else {
				$query = "INSERT INTO tbl_admin(adminName,adminEmail,adminPhone,adminPass,adminUser, level) 
				VALUES('$adminName','$adminEmail','$adminPhone','$adminPassword','$adminUser', '$level')";
				$result = $this->db->insert($query);
				if ($result) {
					$alert = "
					<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-check-circle'></i> Đăng kí thành công
					</div>";
					return $alert;
				} else {
					$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Đăng kí không thành công
					</div>";
					return $alert;
				}
			}
		}
	}
	public function edit_profile($data, $id)
	{
		$adminName = mysqli_real_escape_string($this->db->link, $data['adminName']);
		$adminEmail = mysqli_real_escape_string($this->db->link, $data['adminEmail']);
		$adminPhone = preg_replace('/[^0-9]/', '', $data['adminPhone']);
		$phone = mysqli_real_escape_string($this->db->link, $adminPhone);
		if (strlen($phone) != 10) {
			$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Số điện thoại không hợp lệ
					</div>";
			return $alert;
		} else if (!preg_match("/^[0-9]*$/", $phone)) {
			$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Số điện thoại không hợp lệ
					</div>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_admin WHERE adminEmail = '$adminEmail' AND adminId != '$id' LIMIT 1";
			$result_check = $this->db->select($check_email);
			if ($result_check) {
				$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Email đã tồn tại
					</div>";
				return $alert;
			} else if (empty($adminName) || empty($adminEmail)) {
				$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Không được để trống thông tin
					</div>";
				return $alert;
			} else {
				$query = "UPDATE tbl_admin SET
				adminName = '$adminName',
				adminEmail = '$adminEmail',
				adminPhone = '$adminPhone' 
				WHERE adminId = '$id'";
				$result = $this->db->update($query);
				if ($result) {
					$alert = "
					<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-check-circle'></i> Cập nhật thành công
					</div>";
					return $alert;
				} else {
					$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Cập nhật không thành công
					</div>";
					return $alert;
				}
			}
		}
	}
	public function update_admin($data, $id)
	{
		$adminName = mysqli_real_escape_string($this->db->link, $data['adminName']);
		$adminEmail = mysqli_real_escape_string($this->db->link, $data['adminEmail']);
		$level = mysqli_real_escape_string($this->db->link, $data['level']);
		$adminPhone = preg_replace('/[^0-9]/', '', $data['adminPhone']);
		$phone = mysqli_real_escape_string($this->db->link, $adminPhone);
		if (strlen($phone) != 10) {
			$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Số điện thoại không hợp lệ
					</div>";
			return $alert;
		} else if (!preg_match("/^[0-9]*$/", $phone)) {
			$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Số điện thoại không hợp lệ
					</div>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_admin WHERE adminEmail = '$adminEmail' AND adminId != '$id' LIMIT 1";
			$result_check = $this->db->select($check_email);
			if ($result_check) {
				$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Email đã tồn tại
					</div>";
				return $alert;
			} else {
				$query = "UPDATE tbl_admin SET
				adminName = '$adminName',
				adminEmail = '$adminEmail',
				adminPhone = '$adminPhone', 
				level = '$level'
				WHERE adminId = '$id'";
				$result = $this->db->update($query);
				if ($result) {
					$alert = "
					<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-check-circle'></i> Cập nhật thành công
					</div>";
					return $alert;
				} else {
					$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Cập nhật không thành công
					</div>";
					return $alert;
				}
			}
		}
	}
	public function forgotpass($data)
	{
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		if ($email == '') {
			$alert = "<p class='error'>Email không được rỗng</p>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_admin WHERE adminEmail='$email' LIMIT 1";
			$result_check = $this->db->select($check_email);
			if ($result_check) {
				$token = substr(md5(rand(0, 10000)), 0, 16);
				$query = "UPDATE tbl_admin SET token='$token' WHERE adminEmail='$email'";
				$result = $this->db->update($query);
				$mail_sent = $email;
				try {
					include '../inc/email.php';
					$mail->addAddress($mail_sent, 'Shop');
					$mail->Subject = "Lấy lại mật khẩu";
					$mail->Body    = "Đây là đỉa chỉ URL để đổi mật khẩu <br>
					Nếu bạn muốn đổi mật khẩu hãy tích <a target='_blank' href ='http://localhost/website_mvc/admin/forgotpass.php?email=" . $email . "&token=" . $token . "'>vào đây</a> 
					";
					$mail->send();
					$alert = "<span class='success'>Vui lòng ra kiểm tra email của bạn</span>";
					return $alert;
				} catch (Exception $e) {
					$alert = "<span class='error'>Lỗi: {$mail->ErrorInfo}</span>";
					return $alert;
				}
			} else {
				$alert = "<p class='error'>Email chưa dùng cho tài khoản nào cả</p>";
				return $alert;
			}
		}
	}
	public function changepass($data, $email)
	{
		$email = mysqli_real_escape_string($this->db->link, $email);
		$newPass = mysqli_real_escape_string($this->db->link, md5($data['password']));
		$rePass = mysqli_real_escape_string($this->db->link, md5($data['re_password']));
		if (empty($newPass) || empty($rePass)) {
			$alert = "Vui lòng điền đầy đủ các trường còn trống";
			return $alert;
		} else if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $data['password']))) {
			if (strlen($data['password']) > 16) {
				return "<span class='error'>Mật khẩu quá dài!</span>";
			}
			if (strlen($data['password']) < 8) {
				return "<span class='error'>Mật khẩu quá ngắn!</span>";
			}
			if (!preg_match("#[0-9]+#", $data['password'])) {
				return "<span class='error'>Mật khẩu cần ít nhất 1 số!</span>";
			}
			if (!preg_match("#[a-z]+#", $data['password'])) {
				return "<span class='error'>Mật khẩu cần ít nhất 1 chữ!</span>";
			}
			if (!preg_match("#[A-Z]+#", $data['password'])) {
				return "<span class='error'>Mật khẩu cần ít nhất 1 chữ cái viết hoa!</span>";
			}
		} else if ($newPass != $rePass) {
			$alert = "Mật khẩu mới và mật khẩu nhập lại không trùng nhau";
			return $alert;
		} else {
			$query = "UPDATE tbl_admin SET adminPass = '$newPass' WHERE adminEmail ='$email' ";
			$result = $this->db->update($query);
			if ($result) {
				header('Location: login.php');
			} else {
				$msg = "<span class='error'>Đổi mật khẩu thất bại</span>";
				return $msg;
			}
		}
	}
}
?>