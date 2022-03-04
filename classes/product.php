<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php

class product
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function update_type_product($id, $type)
	{
		$type = mysqli_real_escape_string($this->db->link, $type);
		$query = "UPDATE tbl_product SET type = '$type' where productId='$id'";
		$result = $this->db->update($query);
		return $result;
	}
	public function update_active_product($id, $active)
	{
		$active = mysqli_real_escape_string($this->db->link, $active);
		$query = "UPDATE tbl_product SET active = '$active' where productId='$id'";
		$result = $this->db->update($query);
		return $result;
	}
	public function check_active_product($id)
	{
		$query = "SELECT * FROM tbl_product WHERE productId = '$id' AND active = '0' AND productQuantity > '0'";
		$result = $this->db->select($query);
		return $result;
	}
	public function insert_product($data, $files)
	{
		$con = mysqli_connect("localhost", "root", "", "website_mvc");
		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$category = mysqli_real_escape_string($this->db->link, $data['category']);
		$product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
		$price = mysqli_real_escape_string($this->db->link, $data['price']);
		$type = mysqli_real_escape_string($this->db->link, $data['type']);
		$productQuantity = mysqli_real_escape_string($this->db->link, $data['productQuantity']);
		//Kiem tra hình ảnh và lấy hình ảnh cho vào folder upload
		$permited  = array('jpg', 'jpeg', 'png', 'gif', 'webp');
		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "uploads/" . $unique_image;

		if (isset($_FILES['images'])) {
			$files = $_FILES['images'];
			$file_names = $files['name'];
			foreach ($file_names as $key => $value) {
				move_uploaded_file($files['tmp_name'][$key], 'uploads/' . $value);
			}
		}
		if ($productQuantity == "" || $file_names == "" || $productName == "" || $category == "" || $product_desc == "" || $price == "" || $type == "" || $file_name == "") {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Vui lòng điền đủ các trường
				</div>";
			return $alert;
		} else {
			if ($file_size > 506800) {
				$alert = "
					<div class='alert alert-danger alert-dismissiblee' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fa fa-times-circle'></i> Bạn chỉ có thể tải ảnh: " . implode(', ', $permited) . "
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
			$query = "INSERT INTO tbl_product(productName,catId,product_desc,price,type,image,productQuantity) 
			VALUES('$productName','$category','$product_desc','$price','$type','$unique_image','$productQuantity')";
			$result = mysqli_query($con, $query);
			$idpro = mysqli_insert_id($con);
			foreach ($file_names as $key => $value) {
				mysqli_query($con, "INSERT INTO tbl_imagesproduct(productId, image) VALUES('$idpro','$value')");
			}
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

	public function show_product()
	{
		$query = "SELECT tbl_product.*, tbl_category.catName
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
			order by tbl_product.productId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_product_list()
	{
		$query = "SELECT * FROM tbl_product order by productId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_product($data, $files, $id)
	{
		$con = mysqli_connect("localhost", "root", "", "website_mvc");
		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$category = mysqli_real_escape_string($this->db->link, $data['category']);
		$product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
		$price = mysqli_real_escape_string($this->db->link, $data['price']);
		$productQuantity = mysqli_real_escape_string($this->db->link, $data['productQuantity']);
		$permited  = array('jpg', 'jpeg', 'png', 'gif', 'webp');

		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		// $file_current = strtolower(current($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "uploads/" . $unique_image;

		if (isset($_FILES['images'])) {
			$files = $_FILES['images'];
			$file_names = $files['name'];
			if (!empty($file_names[0])) {
				mysqli_query($con, "DELETE FROM tbl_imagesproduct WHERE productId = '$id' ");
				foreach ($file_names as $key => $value) {
					move_uploaded_file($files['tmp_name'][$key], 'uploads/' . $value);
				}
				foreach ($file_names as $key => $value) {
					mysqli_query($con, "INSERT INTO tbl_imagesproduct(productId, image) VALUES('$id','$value')");
				}
			}
		}

		if ($productName == "" || $category == "" || $product_desc == "" || $price == "" || $productQuantity == "") {
			$alert = "
				<div class='alert alert-danger alert-dismissiblee' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<i class='fa fa-times-circle'></i> Vui lòng điền đủ các trường
				</div>";
			return $alert;
		} else {
			if (!empty($file_name)) {
				if ($file_size > 506800) {
					$alert = "
						<div class='alert alert-danger alert-dismissiblee' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<i class='fa fa-times-circle'></i> Bạn chỉ có thể tải ảnh: " . implode(', ', $permited) . "
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
				$query = "UPDATE tbl_product SET
					productName = '$productName',
					catId = '$category', 
					price = '$price', 
					image = '$unique_image',
					product_desc = '$product_desc',
					productQuantity = '$productQuantity'
					WHERE productId = '$id'";
			} else {
				$query = "UPDATE tbl_product SET
					productName = '$productName',
					catId = '$category', 
					price = '$price', 
					product_desc = '$product_desc',
					productQuantity = '$productQuantity'
					WHERE productId = '$id'";
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
	public function del_product($id)
	{
		$query = "DELETE FROM tbl_product where productId = '$id'";
		$query2 = "DELETE FROM tbl_imagesproduct where productId = '$id'";
		$result = $this->db->delete($query);
		$result2 = $this->db->delete($query2);
		if ($result && $result2) {
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
	public function getproductbyId($id)
	{
		$query = "SELECT * FROM tbl_product where productId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	//END BACKEND 
	public function getproduct_feathered()
	{
		$query = "SELECT * FROM tbl_product WHERE type = '0' AND active = '0' AND productQuantity>'0' order by RAND() LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function getproduct_new()
	{
		$query = "SELECT * FROM tbl_product WHERE active = '0' AND productQuantity>'0' order by productId desc LIMIT 8 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function getproduct_top()
	{
		$query = "SELECT * FROM tbl_product order by product_soldout desc LIMIT 5 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function getproduct_top2()
	{
		$query = "SELECT * FROM tbl_product order by product_soldout desc LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function getproduct_soldout()
	{
		$query = "SELECT * FROM tbl_product";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_all_product()
	{
		$query = "SELECT * FROM `tbl_product` WHERE `productQuantity`>'0'";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_details($id)
	{
		$query = "SELECT tbl_product.*, tbl_category.catName
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
			WHERE tbl_product.productId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_images($id)
	{
		$query = "SELECT * FROM tbl_imagesproduct WHERE productId = '$id' order by id asc LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_relate_to_product($id, $idcat)
	{
		$query = "SELECT tbl_product.* , tbl_category.catName
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
			WHERE tbl_product.productId != '$id' AND tbl_product.catId = '$idcat' order by RAND() LIMIT 4";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_wishlist($customer_id)
	{
		$query = "SELECT * FROM tbl_wishlist WHERE customer_id = '$customer_id' order by id desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function del_wlist($proid, $customer_id)
	{
		$query = "DELETE FROM tbl_wishlist where productId = '$proid' AND customer_id='$customer_id'";
		$result = $this->db->delete($query);
		return $result;
	}
	public function insertWishlist($catid, $productid, $customer_id)
	{
		$catid = mysqli_real_escape_string($this->db->link, $catid);
		$productid = mysqli_real_escape_string($this->db->link, $productid);
		$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

		$check_wlist = "SELECT * FROM tbl_wishlist WHERE productId = '$productid' AND customer_id ='$customer_id'";
		$result_check_wlist = $this->db->select($check_wlist);

		if ($result_check_wlist) {
			$msg = "<span class='error'>Product Already Added to Wishlist</span>";
			return $msg;
		} else {

			$query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
			$result = $this->db->select($query)->fetch_assoc();

			$productName = $result["productName"];
			$price = $result["price"];
			$image = $result["image"];

			$query_insert = "INSERT INTO tbl_wishlist(catId, productId,price,image,customer_id,productName) VALUES('$catid', '$productid','$price','$image','$customer_id','$productName')";
			$insert_wlist = $this->db->insert($query_insert);

			if ($insert_wlist) {
				$alert = "<span class='success'>Thêm vào danh sách yêu thích thành công</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Thêm vào danh sách yêu thích thất bạis</span>";
				return $alert;
			}
		}
	}
}
?>