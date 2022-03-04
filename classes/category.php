<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class category
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function all_category()
	{
	}
	public function insert_category($catName)
	{
		$catName = $this->fm->validation($catName);
		$catName = mysqli_real_escape_string($this->db->link, $catName);

		if (empty($catName)) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Không được để trống
				</div>";
			return $alert;
		} else {
			$query = "SELECT * FROM tbl_category WHERE catName = '$catName'";
			$result = $this->db->select($query);
			if (!$result) {
				$query2 = "INSERT INTO tbl_category(catName) VALUES('$catName')";
				$result2 = $this->db->insert($query2);
				if ($result2) {
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
			} else {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Đã tồn tại danh mục này
				</div>";
				return $alert;
			}
		}
	}
	public function show_category()
	{
		$query = "SELECT * FROM tbl_category order by catId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_category($catName, $id)
	{
		$catName = $this->fm->validation($catName);
		$catName = mysqli_real_escape_string($this->db->link, $catName);
		$id = mysqli_real_escape_string($this->db->link, $id);

		if (empty($catName)) {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Không được để trống
				</div>";
			return $alert;
		} else {
			$query = "SELECT * FROM tbl_category WHERE catName = '$catName'";
			$result = $this->db->select($query);
			if (!$result) {
				$query2 = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
				$result2 = $this->db->update($query2);
				if ($result2) {
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
			} else {
				$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Đã tồn tại danh mục này
				</div>";
				return $alert;
			}
		}
	}
	public function del_category($id)
	{
		$query = "SELECT * FROM tbl_product where catId = '$id'";
		$result = $this->db->select($query);
		if (!$result) {
			$query2 = "DELETE FROM tbl_category where catId = '$id'";
			$result = $this->db->delete($query2);
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
		} else {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Danh mục này đang có sản phẩm
				</div>";
			return $alert;
		}
	}
	public function getcatbyId($id)
	{
		$query = "SELECT * FROM tbl_category where catId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_category_fontend()
	{
		$query = "SELECT * FROM tbl_category order by catId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_product_by_cat($id)
	{
		$query = "SELECT * FROM tbl_product WHERE catId='$id' order by catId desc LIMIT 8";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_name_by_cat($id)
	{
		$query = "SELECT tbl_product.*,tbl_category.catName,tbl_category.catId FROM tbl_product,tbl_category WHERE tbl_product.catId=tbl_category.catId AND tbl_product.catId ='$id' LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}
}
?>