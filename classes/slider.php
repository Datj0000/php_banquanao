<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php

class slider
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_slider($data, $files)
    {
        $sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
        $permited  = array('jpg', 'jpeg', 'png', 'gif');

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        // $file_current = strtolower(current($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($sliderName == "") {
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
                $query = "INSERT INTO tbl_slider(sliderName,slider_image) VALUES('$sliderName','$unique_image')";
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
    }
    public function show_slider()
    {
        $query = "SELECT * FROM tbl_slider where type='1' order by sliderId desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_slider_list()
    {
        $query = "SELECT * FROM tbl_slider order by sliderId desc LIMIT 3";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_type_slider($id, $type)
    {
        $type = mysqli_real_escape_string($this->db->link, $type);
        $query = "UPDATE tbl_slider SET type = '$type' where sliderId='$id'";
        $result = $this->db->update($query);
        return $result;
    }
    public function del_slider($id)
    {
        $query = "DELETE FROM tbl_slider where sliderId = '$id'";
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
    public function insert_brand($data, $files)
    {
        $brandname = mysqli_real_escape_string($this->db->link, $data['brandname']);
        $permited  = array('jpg', 'jpeg', 'png', 'gif');

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        // $file_current = strtolower(current($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($brandname == "") {
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
                $query = "INSERT INTO tbl_brand(title,image) VALUES('$brandname','$unique_image')";
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
    }
    public function show_brand()
    {
        $query = "SELECT * FROM tbl_brand where type='1' order by id desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_brand_list()
    {
        $query = "SELECT * FROM tbl_brand order by id desc LIMIT 5";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_type_brand($id, $type)
    {
        $type = mysqli_real_escape_string($this->db->link, $type);
        $query = "UPDATE tbl_brand SET type = '$type' where id='$id'";
        $result = $this->db->update($query);
        return $result;
    }
    public function del_brand($id)
    {
        $query = "DELETE FROM tbl_brand where id = '$id'";
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
}
