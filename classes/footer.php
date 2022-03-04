<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * 
 */
class footer
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function getfooter()
	{
		$query = "SELECT * FROM tbl_footer WHERE id= '1' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_footer()
	{
		$query = "SELECT * FROM tbl_footer where id='1'";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_footer($data, $file)
	{
		$mail = mysqli_real_escape_string($this->db->link, $data['mail']);
		$checkphone = preg_replace('/[^0-9]/', '', $data['phone']);
		$phone = mysqli_real_escape_string($this->db->link, $checkphone);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$title = mysqli_real_escape_string($this->db->link, $data['title']);
		$fb = mysqli_real_escape_string($this->db->link, $data['facebook']);
		$yt = mysqli_real_escape_string($this->db->link, $data['youtube']);
		$tw = mysqli_real_escape_string($this->db->link, $data['twitter']);
		$is = mysqli_real_escape_string($this->db->link, $data['instagram']);

		$permited  = array('jpg', 'jpeg', 'png', 'gif');

		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "uploads/" . $unique_image;

		if ($mail == "" || $phone == "" || $address == "" || $title == "" || $fb == "" || $yt == "" || $tw == "" || $is == "") {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Vui lòng điền đủ các trường
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
			if (!empty($file_name)) {
				if ($file_size > 506800) {
					$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Ảnh kích thước quá lớn
					</div>";
					return $alert;
				} elseif (in_array($file_ext, $permited) === false) {
					$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Bạn chỉ có thể tải ảnh: " . implode(', ', $permited) . "
					</div>";
					return $alert;
				}
				move_uploaded_file($file_temp, $uploaded_image);
				$query = "UPDATE `tbl_footer` SET 
					image = '$unique_image',
					`mail`='$mail',
					`phone`='$phone',
					`address`='$address',
					`title`='$title',
					`facebook`='$fb',
					`youtube`='$yt',
					`twitter`='$tw',
					`instagram`='$is'
		 		WHERE id = '1' ";
			} else {
				$query = "UPDATE `tbl_footer` SET 
					`mail`='$mail',
					`phone`='$phone',
					`address`='$address',
					`title`='$title',
					`facebook`='$fb',
					`youtube`='$yt',
					`twitter`='$tw',
					`instagram`='$is'
		 		WHERE id = '1' ";
			}
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
?>