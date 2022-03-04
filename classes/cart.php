<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class cart
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function add_to_cart($size, $quantity, $id)
	{
		$size = $this->fm->validation($size);
		$size = mysqli_real_escape_string($this->db->link, $size);
		$quantity = $this->fm->validation($quantity);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$id = mysqli_real_escape_string($this->db->link, $id);
		$sId = session_id();
		$check_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId ='$sId'";
		$result_check_cart = $this->db->select($check_cart);
		if ($result_check_cart) {
			$msg = "<span class='error'>Sản phẩm đã có trong giỏ hàng</span>";
			return $msg;
		} else {
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$result = $this->db->select($query)->fetch_assoc();

			$image = $result["image"];
			$price = $result["price"];
			$productName = $result["productName"];

			$query_insert = "INSERT INTO tbl_cart(productId,quantity,sId,image,price,productName, size) 
			VALUES('$id','$quantity','$sId','$image','$price','$productName','$size')";
			$insert_cart = $this->db->insert($query_insert);
			if ($insert_cart) {
				$msg = "<span class='success'>Thêm sản phẩm thành công</span>";
				return $msg;
			}
		}
	}
	public function add_to_cart2($size, $quantity, $id)
	{
		$size = $this->fm->validation($size);
		$size = mysqli_real_escape_string($this->db->link, $size);
		$quantity = $this->fm->validation($quantity);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$id = mysqli_real_escape_string($this->db->link, $id);
		$sId = session_id();
		$check_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId ='$sId'";
		$result_check_cart = $this->db->select($check_cart);
		if ($result_check_cart) {
			header('Location: gio-hang.html');
		} else {
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$result = $this->db->select($query)->fetch_assoc();
			$image = $result["image"];
			$price = $result["price"];
			$productName = $result["productName"];
			$query_insert = "INSERT INTO tbl_cart(productId,quantity,sId,image,price,productName, size) 
			VALUES('$id','$quantity','$sId','$image','$price','$productName','$size')";
			$insert_cart = $this->db->insert($query_insert);
			if ($insert_cart) {
				header('Location: gio-hang.html');
			}
		}
	}
	public function get_product_cart()
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_quantity_cart($quantity, $cartId)
	{
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$cartId = mysqli_real_escape_string($this->db->link, $cartId);
		$query = "UPDATE tbl_cart SET

					quantity = '$quantity'

					WHERE cartId = '$cartId'";
		$result = $this->db->update($query);
		if ($result) {
			$msg = "<span class='error'>Cập nhật thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Cập nhật thất bại</span>";
			return $msg;
		}
	}
	public function update_size_cart($size, $cartId)
	{
		$size = mysqli_real_escape_string($this->db->link, $size);
		$cartId = mysqli_real_escape_string($this->db->link, $cartId);
		$query = "UPDATE tbl_cart SET

					size = '$size'

					WHERE cartId = '$cartId'";
		$result = $this->db->update($query);
		if ($result) {
			$msg = "<span class='success'>Cập nhật thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Cập nhật thất bại</span>";
			return $msg;
		}
	}
	public function del_product_cart($cartid)
	{
		$cartid = mysqli_real_escape_string($this->db->link, $cartid);
		$query = "DELETE FROM tbl_cart WHERE cartId = '$cartid'";
		$result = $this->db->delete($query);
		if ($result) {
			$msg = "<span class='success'>Xóa sản phẩm thành công</span>";
			return $msg;
		}
	}
	public function check_cart()
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function check_cart_login()
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function check_order($customer_id)
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function del_all_data_cart()
	{
		$sId = session_id();
		$query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->delete($query);
	}
	// ORDER//////////////////////////////////////////////////////////////////////
	public function insertOrder($customer_id, $note, $cart1, $subtotal)
	{
		$con = mysqli_connect("localhost", "root", "", "website_mvc");
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$get_product = $this->db->select($query);
		if ($get_product) {
			$coupon = $cart1['coupon_number'];
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			$ordercode = strtoupper(substr(md5(rand(0, 10000)), 0, 10));
			Session::set('ordercode', $ordercode);
			$note = mysqli_real_escape_string($this->db->link, $note);
			$query = "INSERT INTO tbl_order(ordercode, customer_id, note, coupon, price) 
				VALUES('$ordercode','$customer_id','$note', '$coupon', '$subtotal')";
			$result = mysqli_query($con, $query);
			$idorder = mysqli_insert_id($con);
			while ($result = $get_product->fetch_assoc()) {
				$productid = $result['productId'];
				$productName = $result['productName'];
				$quantity = $result['quantity'];
				$size = $result['size'];
				$price = $result['price'] * $quantity;
				$image = $result['image'];

				$query_order = "INSERT INTO tbl_orderdetail(order_id, productId,productName,quantity,price,image, size) 
				VALUES('$idorder', '$productid','$productName','$quantity','$price','$image', '$size')";
				$insert_order = $this->db->insert($query_order);
			}
			$idcp = $cart1['idcp'];
			$coupon = $cart1['coupon_used'];
			$coupon_used = $coupon . ',' . $customer_id;
			$querycoupon = "UPDATE tbl_coupon
				SET quantity = quantity - '1',
				coupon_used  = '$coupon_used'
				WHERE id = '$idcp' ";
			$updatecoupon = $this->db->update($querycoupon);
		}
	}
	public function insertOrder2($customer_id, $note, $subtotal)
	{
		$con = mysqli_connect("localhost", "root", "", "website_mvc");
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$get_product = $this->db->select($query);
		if ($get_product) {
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			$ordercode = strtoupper(substr(md5(rand(0, 10000)), 0, 10));
			Session::set('ordercode', $ordercode);
			$note = mysqli_real_escape_string($this->db->link, $note);
			$query = "INSERT INTO tbl_order(ordercode, customer_id, note, price) 
				VALUES('$ordercode','$customer_id','$note', '$subtotal')";
			$result = mysqli_query($con, $query);
			$idorder = mysqli_insert_id($con);
			$pricesum = 0;
			while ($result = $get_product->fetch_assoc()) {
				$productid = $result['productId'];
				$productName = $result['productName'];
				$quantity = $result['quantity'];
				$size = $result['size'];
				$price = $result['price'] * $quantity;
				$image = $result['image'];

				$query_order = "INSERT INTO tbl_orderdetail(order_id, productId,productName,quantity,price,image, size) 
				VALUES('$idorder', '$productid','$productName','$quantity','$price','$image', '$size')";
				$insert_order = $this->db->insert($query_order);
			}
		}
	}
	public function insertOrderOnline($customer_id, $note, $cart1, $subtotal)
	{
		$con = mysqli_connect("localhost", "root", "", "website_mvc");
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$get_product = $this->db->select($query);
		if ($get_product) {
			$coupon = $cart1['coupon_number'];
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			$ordercode = strtoupper(substr(md5(rand(0, 10000)), 0, 10));
			Session::set('ordercode', $ordercode);
			$note = mysqli_real_escape_string($this->db->link, $note);
			$query = "INSERT INTO tbl_order(ordercode, customer_id, note, coupon, price) 
				VALUES('$ordercode','$customer_id','$note', '$coupon', '$subtotal' )";
			$result = mysqli_query($con, $query);
			$idorder = mysqli_insert_id($con);
			while ($result = $get_product->fetch_assoc()) {
				$productid = $result['productId'];
				$productName = $result['productName'];
				$quantity = $result['quantity'];
				$size = $result['size'];
				$price = $result['price'] * $quantity;
				$image = $result['image'];

				$query_order = "INSERT INTO tbl_orderdetail(order_id, productId,productName,quantity,price,image, size) 
				VALUES('$idorder', '$productid','$productName','$quantity','$price','$image', '$size')";
				$insert_order = $this->db->insert($query_order);
			}
			$idcp = $cart1['idcp'];
			$coupon = $cart1['coupon_used'];
			$coupon_used = $coupon . ',' . $customer_id;
			$querycoupon = "UPDATE tbl_coupon
				SET quantity = quantity - '1',
				coupon_used  = '$coupon_used'
				WHERE id = '$idcp' ";
			$updatecoupon = $this->db->update($querycoupon);
			header('Location: vnpay/index.php?orderid=' . $idorder. '&total='.$subtotal. '&ordercode=' .$ordercode);
		}
	}
	public function insertOrderOnline2($customer_id, $note, $subtotal)
	{
		$con = mysqli_connect("localhost", "root", "", "website_mvc");
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$get_product = $this->db->select($query);
		if ($get_product) {
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			$ordercode = strtoupper(substr(md5(rand(0, 10000)), 0, 10));
			Session::set('ordercode', $ordercode);
			$note = mysqli_real_escape_string($this->db->link, $note);
			$query = "INSERT INTO tbl_order(ordercode, customer_id, note, price) 
				VALUES('$ordercode','$customer_id','$note', '$subtotal')";
			$result = mysqli_query($con, $query);
			$idorder = mysqli_insert_id($con);
			$pricesum = 0;
			while ($result = $get_product->fetch_assoc()) {
				$productid = $result['productId'];
				$productName = $result['productName'];
				$quantity = $result['quantity'];
				$size = $result['size'];
				$price = $result['price'] * $quantity;
				$image = $result['image'];

				$query_order = "INSERT INTO tbl_orderdetail(order_id, productId,productName,quantity,price,image, size) 
				VALUES('$idorder', '$productid','$productName','$quantity','$price','$image', '$size')";
				$insert_order = $this->db->insert($query_order);
			}
			header('Location: vnpay/index.php?orderid=' . $idorder. '&total='.$subtotal. '&ordercode=' .$ordercode);
		}
	}
	public function get_detail_order($idorder)
	{
		$query = "SELECT * FROM tbl_orderdetail WHERE order_id = '$idorder' ORDER BY id desc ";
		$get_inbox_cart = $this->db->select($query);
		return $get_inbox_cart;
	}
	public function get_cart_ordered($customer_id)
	{
		$query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id'";
		$get_cart_ordered = $this->db->select($query);
		return $get_cart_ordered;
	}
	public function get_inbox_cart()
	{
		$query = "SELECT * FROM tbl_order ORDER BY date_order desc";
		$get_inbox_cart = $this->db->select($query);
		return $get_inbox_cart;
	}
	public function get_inbox_cart_limit()
	{
		$query = "SELECT * FROM tbl_order ORDER BY date_order desc LIMIT 6";
		$get_inbox_cart = $this->db->select($query);
		return $get_inbox_cart;
	}
	//shift
	public function shifted($id)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$query = "UPDATE tbl_order SET
					status = '1'
					WHERE id = '$id'";
		$result = $this->db->update($query);
		if ($result) {
			$msg = "<span class='error'>Giao hàng thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Giao hàng thất bại</span>";
			return $msg;
		}
	}
	public function del_shifted($id)
	{
		$query = "DELETE FROM tbl_order WHERE id = '$id'";
		$query2 = "DELETE FROM tbl_orderdetail WHERE order_id = '$id'";
		$result = $this->db->delete($query);
		$result2 = $this->db->delete($query);
		if ($result && $result2) {
			$msg = "<span class='success'>Xoá thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Xoá thất bại</span>";
			return $msg;
		}
	}
	public function shifted_confirm($id)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$query = "UPDATE tbl_order SET
					status = '2',
					type = '1'
					WHERE id ='$id'";
		$ccc = $this->db->update($query);
		$query2 = "SELECT * FROM tbl_orderdetail WHERE order_id= '$id'";
		$get_order = $this->db->select($query2);
		if ($get_order) {
			while ($result = $get_order->fetch_assoc()) {
				$proid = $result['productId'];
				$quantity = $result['quantity'];
				$query2 = "UPDATE tbl_product SET
							productQuantity  = productQuantity - '$quantity',
							product_soldout  = product_soldout + '$quantity'
							WHERE productId = '$proid'
							";
				$result2 = $this->db->update($query2);
			}
		}
	}
	public function exchange($id)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$query = "UPDATE tbl_order SET
					status = '3'
					WHERE id ='$id'";
		$ccc = $this->db->update($query);
	}
	public function order_confirm()
	{
		$query = "SELECT * FROM tbl_order WHERE status ='2' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function order_confirm_mon($mon)
	{
		$query = "SELECT * FROM tbl_order WHERE status ='2' AND MONTH(`date_order`) = '$mon' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function order_confirm_year($year)
	{
		$query = "SELECT * FROM tbl_order WHERE status ='2' AND YEAR(`date_order`) = '$year' ";
		$result = $this->db->select($query);
		return $result;
	}
}
?>