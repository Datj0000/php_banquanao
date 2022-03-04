<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class customer
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function insert_binhluan()
	{
		$product_id = $_POST['product_id_binhluan'];
		$tenbinhluan = $_POST['tennguoibinhluan'];
		$binhluan = $_POST['binhluan'];
		if ($tenbinhluan == '' || $binhluan == '') {
			$alert = "<p class='error'>Không để trống các trường</p>";
			return $alert;
		} else {
			$query = "INSERT INTO tbl_binhluan(tenbinhluan,binhluan,product_id) VALUES('$tenbinhluan','$binhluan','$product_id')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<p class='success'>Bình luận đã gửi</p>";
				return $alert;
			} else {
				$alert = "<p class='error'>Bình luận không thành công</p>";
				return $alert;
			}
		}
	}
	public function del_comment($id)
	{
		$query = "DELETE FROM tbl_binhluan where id = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "<p class='success'>Xóa bình luận thành công</p>";
			return $alert;
		} else {
			$alert = "<p class='error'>Xóa bình luận không thành công</p>";
			return $alert;
		}
	}
	public function active_comment($id, $active)
	{
		$active = mysqli_real_escape_string($this->db->link, $active);
		$query = "UPDATE tbl_binhluan
		SET active ='$active'
		where id = '$id'";
		$result = $this->db->update($query);
		if ($result) {
			$alert = "<p class='success'>Phê duyệt thành công</p>";
			return $alert;
		} else {
			$alert = "<p class='error'>Phê duyệt không thành công</p>";
			return $alert;
		}
	}
	public function show_comment_admin()
	{
		$query = "SELECT tbl_binhluan.*, tbl_product.productName 
			FROM tbl_binhluan INNER JOIN tbl_product ON tbl_binhluan.product_id = tbl_product.productId
			order by id desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_comment_user($id)
	{
		$query = "SELECT * FROM tbl_binhluan WHERE product_id = '$id' AND active = '1' order by product_id desc LIMIT 2";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_user()
	{
		$query = "SELECT * FROM tbl_customer";
		$result = $this->db->select($query);
		return $result;
	}
	public function insert_customers($data)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));
		$repassword = mysqli_real_escape_string($this->db->link, md5($data['re_password']));
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$phoneNumber = preg_replace('/[^0-9]/', '', $data['phone']);
		$phone = mysqli_real_escape_string($this->db->link, $phoneNumber);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $data['password']))) {
			if (strlen($data['password']) > 20) {
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
		} else if ($password != $repassword) {
			$alert = "<p class='error'>Nhập lại mật khẩu không trùng khớp</p>";
			return $alert;
		} else if (strlen($phone) != 10) {
			$alert = "<p class='error'>Số điện thoại không hợp lệ</p>";
			return $alert;
		} else if (!preg_match("/^[0-9]*$/", $phone)) {
			$alert = "<p class='error'>Số điện thoại không hợp lệ</p>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
			$result_check = $this->db->select($check_email);
			if ($result_check) {
				$alert = "<p class='error'>Email đã dùng cho 1 tài khoản khác</p>";
				return $alert;
			} else {
				$query = "INSERT INTO tbl_customer(name,email,phone,password,address) VALUES('$name','$email','$phone','$password', '$address')";
				$result = $this->db->insert($query);
				if ($result) {
					$name = Session::get('customer_name');
					include 'inc/email.php';
					$mail->addAddress($email, $name);
					$mail->Subject = "Chào mừng quý khách đã đến với cửa hàng - Quà thành viên mới";
					$mail->Body    = "Bạn đã trở thành thành viên mới của cửa hàng. Cửa hàng tặng bạn 1 mã giảm giá giảm 20.000VNĐ cho một đơn hàng của bạn. <br>
					Hãy sử dụng tài khoản để mua hàng để tích lũy nhận thêm nhiều ưu đãi !!!!
					<p style='text-align: center; font-size:20px; font-weight:bold'>NEWMEMBER</p>
					";
					$mail->send();
					$alert = "<p class='success'>Đăng kí thành công</p>";
					return $alert;
				} else {
					$alert = "<p class='error'>Đăng kí thất bại</p>";
					return $alert;
				}
			}
		}
	}
	public function login_customers($data)
	{
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));
		if ($email == '' || $password == '') {
			$alert = "<p class='error'>Email hoặc mật khẩu không được rỗng</p>";
			return $alert;
		} else {
			$check_login = "SELECT * FROM tbl_customer WHERE email='$email' AND password='$password'";
			$result_check = $this->db->select($check_login);
			if ($result_check) {
				$value = $result_check->fetch_assoc();
				Session::set('customer_login', true);
				Session::set('customer_id', $value['id']);
				Session::set('customer_name', $value['name']);
				header('location: trang-chu.html');
			} else {
				$alert = "<p class='error'>Email hoặc mật khẩu sai</p>";
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
			$query = "UPDATE tbl_customer SET password = '$newPass' WHERE email ='$email' ";
			$result = $this->db->update($query);

			if ($result) {
				$msg = "<span class='success'>Đổi mật khẩu thành công</span>";
				return $msg;
			} else {
				$msg = "<span class='error'>Đổi mật khẩu thất bại</span>";
				return $msg;
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
			$check_email = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
			$result_check = $this->db->select($check_email);
			if ($result_check) {
				$token = substr(md5(rand(0, 10000)), 0, 16);
				$query = "UPDATE tbl_customer SET token='$token' WHERE email='$email'";
				$result = $this->db->update($query);

				$mail_sent = $email;
				try {
					include './inc/email.php';
					$mail->addAddress($mail_sent, 'Shop');
					$mail->Subject = "Lấy lại mật khẩu";
					$mail->Body    = "Đây là đia chỉ URL để đổi mật khẩu <br>
					Nếu bạn muốn đổi mật khẩu hãy tích <a target='_blank' href ='http://localhost/website_mvc/quen-mat-khau.html?email=" . $email . "&token=" . $token . "'>vào đây</a> 
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
	public function show_customers($id)
	{
		$query = "SELECT * FROM tbl_customer WHERE id='$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_customers($data, $id, $files)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$phoneNumber = preg_replace('/[^0-9]/', '', $data['phone']);
		$phone = mysqli_real_escape_string($this->db->link, $phoneNumber);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$permited  = array('jpg', 'jpeg', 'png', 'gif');

		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "admin/uploads/" . $unique_image;

		if ($name == "" || $email == "" || $phone == "" || $address == "") {
			$alert = "<p class='error'>Vui lòng điền đầy đủ thông tin</p>";
			return $alert;
		} else if (strlen($phone) != 10) {
			$alert = "<p class='error'>Số điện thoại không hợp lệ</p>";
			return $alert;
		} else if (!preg_match("/^[0-9]*$/", $phone)) {
			$alert = "<p class='error'>Số điện thoại không hợp lệ</p>";
			return $alert;
		} else {
			if (!empty($file_name)) {
				if ($file_size > 506800) {
					$alert = "<span class='success'>Image Size should be less then 50MB!</span>";
					return $alert;
				} elseif (in_array($file_ext, $permited) === false) {
					$alert = "<span class='success'>You can upload only:-" . implode(', ', $permited) . "</span>";
					return $alert;
				}
				move_uploaded_file($file_temp, $uploaded_image);
				$query = "UPDATE tbl_customer
				 	SET name='$name',
				 	email='$email',
				 	phone='$phone',
					address ='$address',
					image = '$unique_image'
				 	WHERE id ='$id'";;
			} else {
				$query = "UPDATE tbl_customer
					SET name='$name',
					email='$email',
					phone='$phone',
					address ='$address' 
					WHERE id ='$id'";;
			}
			$result = $this->db->update($query);
			if ($result) {
				header('Location: ho-so.html');
			} else {
				$alert = "<p class='error'>Cập nhật hồ sơ thất bại</p>";
				return $alert;
			}
		}
	}
	public function update_pass($data, $id)
	{
		$oldPass = mysqli_real_escape_string($this->db->link, md5($data['oldpass']));
		$newPass = mysqli_real_escape_string($this->db->link, md5($data['newpass']));
		$rePass = mysqli_real_escape_string($this->db->link, md5($data['repass']));
		if (empty($oldPass) || empty($newPass) || empty($rePass)) {
			$alert = "Vui lòng điền đầy đủ các trường còn trống";
			return $alert;
		} else if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $data['newpass']))) {
			if (strlen($data['newpass']) > 16) {
				return "<span class='error'>Mật khẩu quá dài!</span>";
			}
			if (strlen($data['newpass']) < 8) {
				return "<span class='error'>Mật khẩu quá ngắn!</span>";
			}
			if (!preg_match("#[0-9]+#", $data['newpass'])) {
				return "<span class='error'>Mật khẩu cần ít nhất 1 số!</span>";
			}
			if (!preg_match("#[a-z]+#", $data['newpass'])) {
				return "<span class='error'>Mật khẩu cần ít nhất 1 chữ!</span>";
			}
			if (!preg_match("#[A-Z]+#", $data['newpass'])) {
				return "<span class='error'>Mật khẩu cần ít nhất 1 chữ cái viết hoa!</span>";
			}
		} else if ($newPass == $oldPass) {
			$alert = "Mật khẩu mới và mật khẩu cũ giống nhau";
			return $alert;
		} else if ($newPass != $rePass) {
			$alert = "Mật khẩu mới và mật khẩu nhập lại không trùng nhau";
			return $alert;
		} else {
			$query = "UPDATE tbl_customer SET password = '$newPass' WHERE id = '$id";
			$result = $this->db->update($query);

			if ($result) {
				header('Location: dang-nhap.html');
			} else {
				$msg = "<span class='error'>Đổi mật khẩu thất bại</span>";
				return $msg;
			}
		}
	}
}
?>