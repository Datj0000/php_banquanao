<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class coupon
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function insert_coupon($data)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$coupon = mysqli_real_escape_string($this->db->link, $data['coupon']);
		$quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);
		$coupon_price = mysqli_real_escape_string($this->db->link, $data['coupon_price']);
		$time_expired = mysqli_real_escape_string($this->db->link, $data['time_expired']);

		if (empty($name) || empty($coupon) || empty($quantity) || empty($coupon_price) || empty($time_expired)) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Không được để trống
				</div>";
			return $alert;
		} else {
			$query = "INSERT INTO tbl_coupon(name, coupon, quantity, coupon_price, time_expired) 
				VALUES('$name', '$coupon','$quantity','$coupon_price', '$time_expired')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "
				<div class='alert alert-success alert-dismissible' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-check-circle'></i> Thêm thành công
				</div>";
				return $alert;
			} else {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Thêm không thành công
				</div>";
				return $alert;
			}
		}
	}
	public function get_coupon($id)
	{
		$query = "SELECT * FROM tbl_coupon where id = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_coupon()
	{
		$query = "SELECT * FROM tbl_coupon order by id desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_coupon($data, $id)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$coupon = mysqli_real_escape_string($this->db->link, $data['coupon']);
		$quantily = mysqli_real_escape_string($this->db->link, $data['quantily']);
		$coupon_price = mysqli_real_escape_string($this->db->link, $data['coupon_price']);
		$time_expired = mysqli_real_escape_string($this->db->link, $data['time_expired']);
		$id = mysqli_real_escape_string($this->db->link, $id);

		if (empty($name) || empty($coupon) || empty($quantily) || empty($coupon_price) || empty($time_expired)) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Không được để trống
				</div>";
			return $alert;
		} else {
			$query = "UPDATE tbl_coupon 
				SET `name`='$name',
				`coupon`='$coupon',
				`quantily`='$quantily',
				`coupon_price`='$coupon_price' ,
				`time_expired` = '$time_expired'
				WHERE id = '$id'";
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
	public function del_coupon($id)
	{
		$query = "DELETE FROM tbl_coupon where id = '$id'";
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
	public function update_active($id, $active)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$active = mysqli_real_escape_string($this->db->link, $active);
		$query = "UPDATE tbl_coupon SET active = '$active' WHERE id = '$id'";
		$result = $this->db->update($query);
		return $result;
	}

	public function check_coupon_2($coupon)
	{
		$coupon = mysqli_real_escape_string($this->db->link, $coupon);
		$check_coupon = "SELECT * FROM tbl_coupon WHERE coupon= '$coupon' ";
		$result = $this->db->select($check_coupon);
		return $result;
	}
	public function check_coupon($coupon)
	{
		$customer_id = Session::get('customer_id');
		$coupon = mysqli_real_escape_string($this->db->link, $coupon);
		$check_coupon = "SELECT * FROM tbl_coupon WHERE coupon= '$coupon' AND active ='0'";
		$result = $this->db->select($check_coupon);
		if ($result) {
			$value = $result->fetch_assoc();
			$time_expired = $value['time_expired'];
			$quantity = $value['quantity'];
			$id = $value['id'];
			$today = date("Y-m-d");
			if ($quantity > 0) {
				if (strtotime($today) < strtotime($time_expired)) {
					$check_coupon_used = "SELECT * FROM tbl_coupon WHERE id ='$id' AND coupon_used LIKE '%" . $customer_id . "%'";
					$result_cp = $this->db->select($check_coupon_used);
					if ($result_cp == false) {
						$_SESSION['coupon'] = array();
						$_SESSION['coupon']['coupon_used'] = $value['coupon_used'];
						$_SESSION['coupon']['coupon_name'] = $value['name'];
						$_SESSION['coupon']['coupon_number'] = $value['coupon'];
						$_SESSION['coupon']['coupon_price'] = $value['coupon_price'];
						$_SESSION['coupon']['idcp'] = $value['id'];
						$alert = "<span class='success'>Sử dụng mã giảm giá " . $value['name'] . " thành công</span>";
						return $alert;
					} else {
						$alert = "<span class='error'>Bạn đã sử dụng mã giảm giá này rồi</span>";
						return $alert;
					}
				} else {
					$alert = "<span class='error'>Mã giảm giá đã hết thời gian sử dụng</span>";
					return $alert;
				}
			} else {
				$alert = "<span class='error'>Mã giảm giá đã hết lượt sử dụng</span>";
				return $alert;
			}
		} else {
			$alert = "<span class='error'>Mã giảm giá sai</span>";
			return $alert;
		}
	}
}
?>