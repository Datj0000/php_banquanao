<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * 
 */
class display
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function get_about()
	{
		$query = "SELECT * FROM tbl_about where id = '1'";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_about($data)
	{
		$desc_about = mysqli_real_escape_string($this->db->link, $data['desc_about']);
		$query = "UPDATE tbl_about
		SET desc_about = '$desc_about'
		where id = '1'";
		$result = $this->db->update($query);
		if ($result) {
			$alert = "<span class='success'>Cập nhật thành công</span>";
			return $alert;
		} else {
			$alert = "<span class='error'>Cập nhật thất bại</span>";
			return $alert;
		}
	}
	public function get_display()
	{
		$query = "SELECT * FROM tbl_display where id = '1'";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_display()
	{
		$query = "SELECT tbl_product.*, tbl_display.*
			FROM tbl_display INNER JOIN tbl_product ON tbl_product.productId = tbl_display.productId ";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_display($data, $files)
	{
		$title = mysqli_real_escape_string($this->db->link, $data['titlebanner']);
		$desc = mysqli_real_escape_string($this->db->link, $data['descbanner']);
		$product = mysqli_real_escape_string($this->db->link, $data['producttop']);

		$permited  = array('jpg', 'jpeg', 'png', 'gif');

		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "uploads/" . $unique_image;

		$file_name2 = $_FILES['logo']['name'];
		$file_size2 = $_FILES['logo']['size'];
		$file_temp2 = $_FILES['logo']['tmp_name'];

		$div2 = explode('.', $file_name2);
		$file_ext2 = strtolower(end($div2));
		$unique_image2 = substr(md5(time()), 0, 10) . '.' . $file_ext2;
		$uploaded_image2 = "uploads/" . $unique_image2;

		if ($title == "" || $desc == "" || $product == "") {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Không được để trống
				</div>";
			return $alert;
		} else {
			if (!empty($file_name)) {
				//Nếu người dùng chọn ảnh
				if (in_array($file_ext, $permited) === false) {
					$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Bạn chỉ có thể tải ảnh: " . implode(', ', $permited) . "
					</div>";
					return $alert;
				}
				move_uploaded_file($file_temp, $uploaded_image);
				$query = "UPDATE tbl_display SET
					titlebanner = '$title',
					descbanner = '$desc',
					imgbanner = '$unique_image',
					productId = '$product'
					WHERE id = '1'";
			} elseif (!empty($file_name2)) {
				if (in_array($file_ext2, $permited) === false) {
					$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Bạn chỉ có thể tải ảnh: " . implode(', ', $permited) . "
					</div>";
					return $alert;
				}
				move_uploaded_file($file_temp2, $uploaded_image2);
				$query = "UPDATE tbl_display SET
					titlebanner = '$title',
					descbanner = '$desc',
					logo = '$unique_image2',
					productId = '$product'
					WHERE id = '1'";
			} else {
				//Nếu người dùng không chọn ảnh
				$query = "UPDATE tbl_display SET
					titlebanner = '$title',
					descbanner = '$desc', 
					productId = '$product'
					WHERE id = '1'";
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